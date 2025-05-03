<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveRejection extends Model
{
    //
    use HasFactory;

    protected $fillable = ['leave_id', 'employee_id', 'rejected_by', 'status', 'reason'];

    public function leave()
    {
        return $this->belongsTo(Leave::class);
    }

    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }
}
