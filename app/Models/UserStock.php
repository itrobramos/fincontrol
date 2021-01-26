<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStock extends Model
{
    protected $table = 'users_stocks';
    public $timestamps = true;

    public function Broker()
    {
        return $this->belongsTo('App\Broker','brokerId','id');
    }
}
