<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Expenseclaim extends Model
{
    //
    use HasFactory;
    protected $guarded = [];


    public function employeeclaimstatusinhrm()
        {
            return $this->belongsTo(Subu::class, 'employee_id', 'id');
        }
    // public function rmclaimstatusinhrm()
    //     {
    //         return $this->belongsTo(Subu::class, 'employee_id', 'id');
    //     }

    // public function hrheadclaimstatusinadmin()
    // {
    //     return $this->belongsTo(Subu::class, 'employee_id', 'id');
    // }


    public function claimstatusofemployee()
        {
            return $this->belongsTo(Subu::class, 'employee_id', 'id');
        }


// In Expenseclaim.php
    public function latestRejectionReason()
        {
            return $this->hasOne(ClaimRejection::class, 'claim_id', 'id')->latestOfMany();
        }

    public function subu()
    {
        return $this->belongsTo(Subu::class, 'employee_id');
    }




}
