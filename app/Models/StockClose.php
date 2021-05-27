<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockClose extends Model
{
    public $timestamps = true;

    public function Stock()
    {
        return $this->belongsTo('App\Stock','stockId','id');
    }
}
