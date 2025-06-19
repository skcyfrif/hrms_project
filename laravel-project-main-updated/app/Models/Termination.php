<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;


use Illuminate\Database\Eloquent\Model;

class Termination extends Model
{
    //
     use HasFactory;

    protected $fillable = [
        'employee_id',
        'reason'
    ];
    public function subu()
    {
        return $this->belongsTo(Subu::class, 'employee_id');
        // `terminations.employee_id` references `subus.id`
    }


}
