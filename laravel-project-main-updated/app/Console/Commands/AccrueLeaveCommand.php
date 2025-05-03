<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subu;
use App\Models\LeaveBalance;
use Carbon\Carbon;

class AccrueLeaveCommand extends Command
{
    protected $signature = 'leave:accrue'; // Clean signature for artisan command

    protected $description = 'Automatically accrue leave balances for permanent employees every month.';

    public function handle()
    {
        $employees = Subu::where('employment_type', 'permanent')->get();
        $currentYear = now()->year;
        $currentMonth = now()->month;
        $this->info("Found " . $employees->count() . " permanent employees");
        foreach ($employees as $employee) {
            if (!$employee->permanent_date) continue;

            $permanentDate = Carbon::parse($employee->permanent_date);

            // Skip if permanent date is in the future
            if ($permanentDate->isFuture()) continue;

            // Calculate prorated months
            $monthsRemaining = ($permanentDate->year == $currentYear)
                ? 12 - $permanentDate->month + 1
                : 12;

            $monthlyEntitlement = 1.5;
            $proRatedEntitlement = round($monthsRemaining * $monthlyEntitlement, 1);

            $leaveBalance = LeaveBalance::where('employee_id', $employee->id)
                ->where('year', $currentYear)
                ->first();

            if (!$leaveBalance) {
                LeaveBalance::create([
                    'employee_id' => $employee->id,
                    'year' => $currentYear,
                    'annual_leave_entitlement' => $proRatedEntitlement,
                    'total_leave_balance' => $monthlyEntitlement,
                    'pl_balance' => 1,
                    'sl_balance' => 0.5,
                    'lop_days' => 0,
                    'updated_at' => now(),
                ]);
                // $this->info("Created leave for: {$employee->id}");
            } else {
                if ($leaveBalance->updated_at->month !== $currentMonth) {
                    $leaveBalance->pl_balance = min($leaveBalance->pl_balance + 1, 15);
                    $leaveBalance->sl_balance = min($leaveBalance->sl_balance + 0.5, 3);
                    $leaveBalance->total_leave_balance = min(
                        $leaveBalance->total_leave_balance + $monthlyEntitlement,
                        $leaveBalance->annual_leave_entitlement
                    );
                    $leaveBalance->updated_at = now();
                    $leaveBalance->save();
                    // $this->info("Updated leave for: {$employee->id}");
                }
            }
        }

        $this->info('Leave accrual process completed successfully.');
    }
}
