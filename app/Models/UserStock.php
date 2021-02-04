<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStock extends Model
{
    protected $table = 'users_stocks';
    public $timestamps = true;

    public function Broker()
    {
        return $this->belongsTo('App\Models\Broker','brokerId','id');
    }


    public function Stock()
    {
        return $this->belongsTo('App\Models\Stock','stockId','id');
    }


    public function User()
    {
        return $this->belongsTo('App\Models\User','userId','id');
    }

    public function Currency()
    {
        return $this->belongsTo('App\Models\Currency','currencyId','id');
    }

}
