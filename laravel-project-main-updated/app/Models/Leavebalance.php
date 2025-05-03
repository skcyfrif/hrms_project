<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;


use Illuminate\Database\Eloquent\Model;

class Leavebalance extends Model
{
    //
    use HasFactory;
    protected $guarded = [];
    public function employee()
{
    return $this->belongsTo(Subu::class, 'employee_id', 'id');
    // `leave_balances.employee_id` references `subu.id`
}
}
