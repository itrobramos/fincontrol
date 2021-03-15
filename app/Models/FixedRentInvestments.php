<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixedRentInvestments extends Model
{
    public $timestamps = true;
    protected $table = 'fixed_rent_investments';
    
    public function FixedRentPlatform()
    {
        return $this->belongsTo('App\Models\FixedRentPlatform','fixed_rent_platformsId','id');
    }

}
