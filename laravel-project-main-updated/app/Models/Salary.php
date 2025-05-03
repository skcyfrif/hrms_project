<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    //
    use HasFactory;
    protected $guarded = [];


    public function employeesalarystructureinhrm()
    {
        return $this->belongsTo(Subu::class, 'employee_id', 'id');
    }
}
