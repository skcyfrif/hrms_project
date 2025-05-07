<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employeeattendance extends Model
{
    //
    protected $fillable = [
        'employee_id',
        'name',
        'check_in_time',
        'check_out_time',
        'date',
        'work_hours',
        'status',
        'approve_by_manager',
        'manager_approval_status',
        'remarks'
    ];

    protected $attributes = [
        'approve_by_manager' => null,
        // 'work_hours' => null,
        'manager_approval_status' => null,
        // 'check_out_time' => null
    ];

    // Automatically cast check_in_time and check_out_time to Carbon instances
    protected $casts = [
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime',
    ];



   // attendance status in hrm
    public function employeeattendancestatusinhrm()
{
    return $this->belongsTo(Subu::class, 'employee_id');
}


    public function ssss()
    {
        return $this->belongsTo(Subu::class, 'employee_id', 'id');
    }

    public function allemployeeattendancestatus()
    {
        return $this->belongsTo(Subu::class, 'employee_id', 'id');
    }

}
