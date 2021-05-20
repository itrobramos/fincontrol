<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixedRentPaid extends Model
{
    public $timestamps = true;
    protected $table = 'fixed_rent_paids';
    
    public function FixedRentInvestment()
    {
        return $this->belongsTo('App\Models\FixedRentInvestments','fixed_rent_investmentId','id');
    }

}
