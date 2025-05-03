<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{

    protected $fillable = [
        'employee_id',  // Add 'employee_id' here
        'name',
        'check_in_time',
        'check_out_time',
        'date',
        'work_hours',
        'status',
        'remarks'
    ];

    // use HasFactory;
    // protected $guarded = [];
}
