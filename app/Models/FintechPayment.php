<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FintechPayment extends Model
{
    public $timestamps = true;
    protected $table = 'fintech_payments';
    
    public function fintech()
    {
        return $this->belongsTo('App\Models\Fintech','type','id');
    }
}
