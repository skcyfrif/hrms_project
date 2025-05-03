<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payrolls extends Model
{
    //
    use HasFactory;
    protected $guarded = [];

    public function subu()
    {
        return $this->belongsTo(Subu::class, 'employee_id', 'id');
        // `employee_id` in payrolls references `id` in subus
    }

    public function payrool()
{
    return $this->belongsTo(Subu::class, 'employee_id', 'id');
}

}

