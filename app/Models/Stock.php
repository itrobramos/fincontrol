<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    public $timestamps = true;

    public function Sector()
    {
        return $this->belongsTo('App\Sector','sectorId','id');
    }
}
