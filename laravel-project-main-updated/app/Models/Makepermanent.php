<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Makepermanent extends Model
{
    //
    use HasFactory;
    protected $guarded = [];


    // Makepermanent.php

public function employee()
{
    return $this->belongsTo(Subu::class, 'employee_id');
}


}
