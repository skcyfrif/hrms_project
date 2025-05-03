<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apply extends Model
{
    //
    protected $fillable = [
        'name',  // Add 'employee_id' here
        'email',
        'mobile',
        'applied_for',
        'applied_date',
        'resume',
    ];
    protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        // Get the maximum ID from the existing records and increment it by 1
        $nextId = self::max('id') + 1;

        // Generate a unique applicant ID with three digits (e.g., 001, 002, 003)
        $model->applicant_id = 'CYFTECH-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
    });

}




}
