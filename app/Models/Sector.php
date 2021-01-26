<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    public $timestamps = true;

    public function stocks()
    {
        return $this->hasMany('App\Stocks','sectorId','id');
    }
}
