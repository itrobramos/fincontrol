<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    protected $table = 'users_accounts';
    public $timestamps = true;


    public function Account()
    {
        return $this->belongsTo('App\Models\Account','accountId','id');
    }


    public function User()
    {
        return $this->belongsTo('App\Models\User','userId','id');
    }


}
