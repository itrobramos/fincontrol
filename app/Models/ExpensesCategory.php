<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpensesCategory extends Model
{
    public $timestamps = true;
    protected $table = 'expenses_categories';
    
    public function category()
    {
        return $this->belongsTo('App\Models\ExpensesCategory','parentCategoryId','id');
    }
}
