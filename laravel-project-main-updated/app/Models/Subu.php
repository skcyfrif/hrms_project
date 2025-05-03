<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subu extends Model
{
    //
    protected $fillable = [
        'employee_id',  // Add 'employee_id' here
        'user_id',  // Add 'employee_id' here
        'name',
        'photo',
        'email',
        'phone_number',
        'dob',
        'gender',

        // Contact Information

        // 'permanent_address',
        'permanent_address_line1',
        'permanent_address_line2',
        'permanent_city',
        'permanent_district',
        'permanent_state',
        'permanent_pin',

        // Current Address fields
        'current_address_line1',
        'current_address_line2',
        'current_city',
        'current_district',
        'current_state',
        'current_pin',


        // 'current_address',
        'emergency_contact',

        // Employment Details
        'designation',
        'department',
        'work_location',
        'doj',
        'employment_type',
        'created_by',

        // Bank Details
        'account_number',
        'ifsc_code',
        'bank_name',
        'branch_name',



        // Compensation Details
        'types',
        'pay_cycle',
        'total_leave_allowed',
        'basic_salary',
        'house_rent_allowance' ,
        'conveyance_allowance',
        'lunch_allowance',
        'personal_pay',
        'medical_allowance',
        'other_allowance',
        'leave_travel_allowance',
        'total_ammount',
        'professional_tax',
        'esic',
        'net_salary_payable',


// System Access
        'user_role',
        'username',
        'password',
        'assigned_to',


    ];

    // for employee directory in manager portal(show only employees)
    public function user()
{
    return $this->belongsTo(User::class);
}
public function attendances()
{
    return $this->hasMany(Employeeattendance::class, 'employee_id', 'id');
}

// for leave status of employees in manager portal
// public function leaves()
// {
//     return $this->hasMany(Leave::class, 'employee_id', 'employee_id');
// }
public function payroll()
{
    return $this->hasOne(Payrolls::class, 'employee_id', 'id');
    // `payrolls` table `employee_id` references `subu` table `id`
}
public function payrolls()
    {
        return $this->hasMany(Payrolls::class, 'employee_id', 'id');
    }

public function leaves()
    {
        return $this->hasMany(Leave::class);
    }
    public function leaveBalances()
    {
        return $this->hasMany(Leavebalance::class, 'employee_id', 'id');
        // `leave_balances.employee_id` references `subu.id`
    }

    // to see all employee attendance status in admin portal
    public function attendance()
    {
        // Assuming there's a field `employee_id` in both `Subu` and `EmployeeAttendance` models
        return $this->hasMany(Employeeattendance::class, 'employee_id');
    }

    public function leave()
    {
        // Assuming there's a field `employee_id` in both `Subu` and `EmployeeAttendance` models
        return $this->hasOne(Leave::class, 'employee_id');
    }

    public function claim()
{
    return $this->hasOne(Expenseclaim::class, 'employee_id', 'id');
}


    public function reportingManager()
{
    return $this->belongsTo(Subu::class, 'reporting_manager_id');
}

public function creator()
{
    // created_by → user_id of the manager
    return $this->belongsTo(Subu::class, 'created_by', 'user_id');
}
public function createdByAdmin()
{
    return $this->belongsTo(User::class, 'created_by', 'id');
}

// Subu.php
public function supervisor()
{
    return $this->belongsTo(Subu::class, 'assigned_to');
}

//



}
