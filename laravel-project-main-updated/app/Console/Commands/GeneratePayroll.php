<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Subu;
use App\Models\Leave;
use App\Models\Holiday;
use App\Models\Employeeattendance;
use App\Models\Payrolls;

class GeneratePayroll extends Command
{
    protected $signature = 'payroll:generate {year_month?}';
    protected $description = 'Generate payroll for all employees for a given month';

    public function handle()
    {
        $year_month = $this->argument('year_month') ?? now()->format('Y-m');

        $carbonDate = Carbon::parse($year_month);
        $year = $carbonDate->year;
        $month = $carbonDate->format('m');

        $employees = Subu::whereHas('user', function ($query) {
            $query->whereIn('role', ['user', 'head', 'manager', 'reportmanager']);
        })->latest()->get();

        $payrollData = [];

        foreach ($employees as $employee) {
            $total_days = $carbonDate->daysInMonth;

            $holidays = Holiday::whereMonth('date', $month)->whereYear('date', $year)->count();

            $sundays = collect(range(1, $total_days))->filter(function ($day) use ($carbonDate) {
                return Carbon::parse($carbonDate->format('Y-m') . '-' . $day)->isSunday();
            })->count();

            $working_days = $total_days - ($holidays + $sundays);

            $approvedLeaves = Leave::where('employee_id', $employee->id)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->where('rm_status', 'rmapprove')
                ->where('m_status', 'mapprove')
                ->get();

            $pl_days = $approvedLeaves->sum(fn($leave) => (int) $leave->PL);
            $sl_days = $approvedLeaves->sum(fn($leave) => (int) $leave->SL);
            $lop_days = $approvedLeaves->sum(fn($leave) => (int) $leave->LOP);

            $present_days = Employeeattendance::where('employee_id', $employee->id)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->where('status', 'Present')
                ->count() + $pl_days + $sl_days;

            $daily_salary = $employee->basic_salary / $total_days;
            $total_salary = $present_days * $daily_salary;

            $payrollData[] = [
                'employee_id' => $employee->id,
                'month' => $month,
                'year' => $year,
                'total_days' => $total_days,
                'working_days' => $working_days,
                'holidays' => $holidays,
                'sundays' => $sundays,
                'days_present' => $present_days,
                'lop_days' => $lop_days,
                'paid_leave_days' => $pl_days,
                'sick_leave_days' => $sl_days,
                'gross_salary' => $total_salary,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        foreach ($payrollData as $data) {
            $existingPayroll = Payrolls::where('employee_id', $data['employee_id'])
                ->where('year', $data['year'])
                ->where('month', $data['month'])
                ->first();

            if ($existingPayroll) {
                $existingPayroll->update($data);
            } else {
                Payrolls::create($data);
            }
        }

        $this->info('Payroll generated successfully for ' . $year_month);
    }
}
