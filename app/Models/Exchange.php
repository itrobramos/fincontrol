<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    public $timestamps = true;

    public function OriginCurrency()
    {
        return $this->belongsTo('App\Currency','currencyIdOrigin','id');
    }
    
    public function DestinyCurrency()
    {
        return $this->belongsTo('App\Currency','currencyIdDestiny','id');
    }

}
