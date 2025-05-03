<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aeemployee extends Model
{
    //

    protected $fillable = [
        'employee_id',  // Add 'employee_id' here
        'Full_name',
        'photo',
        'email',
        'phone',
        'dob',
        'doj'
        // 'status',
    ];
}
