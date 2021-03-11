<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SnowballODI extends Model
{

    protected $table = 'snowball_odis';
    public $timestamps = true;

    public function SnowballProject()
    {
        return $this->belongsTo('App\Models\SnowballProject','snowballProjectId','id');
    }


    
}
