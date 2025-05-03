<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    //
    protected $fillable = [
        'employee_id',  // Add 'employee_id' here
        'name',
        'designation',
        'department',
        'leave_from',
        'leave_to',
        'total_days',
        'reason',
        'rm_status',
        'm_status',
        'hr_status',
        'admin_status',
        'upload',
        'PL',
        'SL',
        'LOP'
    ];

// for leave status of employees in hr manager portal
    public function employeeleavestatusinhrm()
    {
        return $this->belongsTo(Subu::class, 'employee_id', 'id');
    }
    public function headleavestatusinadmin()
    {
        return $this->belongsTo(Subu::class, 'employee_id', 'id');
    }

    public function rmleavestatusinhrm()
    {
        return $this->belongsTo(Subu::class, 'employee_id', 'id');
    }

// for leave status of all employees in hr portal
    public function allemployeeleavestatus()
    {
        return $this->belongsTo(Subu::class, 'employee_id', 'id'); // employee_id in attendance and id in subu table
    }
// for leave status  of hrm in hr manager portal
    public function leavestatusofhrm()
    {
        return $this->belongsTo(Subu::class, 'employee_id', 'id');
    }

    public function leavestatusofemployee()
    {
        return $this->belongsTo(Subu::class, 'employee_id', 'id');
    }
    public function leavestatusofrm()
    {
        return $this->belongsTo(Subu::class, 'employee_id', 'id');
    }
    public function leavestatusofhrhead()
    {
        return $this->belongsTo(Subu::class, 'employee_id', 'id');
    }


    // Define the relationship to the employee (Subu model)
    public function employeeleavestatusinrm()
    {
        return $this->belongsTo(Subu::class, 'employee_id', 'id');  // Assuming employee_id is the foreign key
    }


//     public function rmRejectionReason()
// {
//     return $this->hasOne(LeaveRejection::class, 'leave_id', 'id')
//                 ->where('rejected_by', 'rm') // assuming there's a 'rejected_by' column
//                 ->latestOfMany();
// }

// public function managerRejectionReason()
// {
//     return $this->hasOne(LeaveRejection::class, 'leave_id', 'id')
//                 ->where('rejected_by', 'm') // assuming 'm' stands for Manager
//                 ->latestOfMany();
// }

public function latestLeaveRejectionReason()
        {
            return $this->hasOne(LeaveRejection::class, 'leave_id', 'id')->latestOfMany();
        }




}
