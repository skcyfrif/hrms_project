<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class ClaimRejection extends Model
{
    //
    use HasFactory;

    protected $fillable = ['claim_id', 'employee_id', 'rejected_by', 'status', 'reason'];

    public function claim()
    {
        return $this->belongsTo(Expenseclaim::class);
    }

    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }
}
