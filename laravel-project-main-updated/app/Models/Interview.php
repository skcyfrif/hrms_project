<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;


use Illuminate\Database\Eloquent\Model;


class Interview extends Model
{
    //
    use HasFactory;
    protected $guarded = [];

     // Inverse relationship to Apply
     public function candidate()
     {
         return $this->belongsTo(Apply::class, 'candidate_id');
     }
}
