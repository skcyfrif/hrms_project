<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class AccountUpdateRequest extends Model
{
    //use HasFactory;
    protected $guarded = [];
protected $casts = [
    'requested_data' => 'array',
];

    public function account()
{
    return $this->belongsTo(Subu::class, 'employee_id');
}

}
