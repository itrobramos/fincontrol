<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    public $timestamps = true;
    protected $table = 'expenses';
    
    public function category()
    {
        return $this->belongsTo('App\Models\ExpensesCategory','categoryId','id');
    }
}
