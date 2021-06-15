<?php

namespace App\Http\Controllers;

use App\View;
use DB;
use Auth;
use App\Models\ExpensesCategory;
use Image;


use Illuminate\Http\Request;

class ExpensesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login']]);
    }
   
    public function categories()
    {
        $categories = ExpensesCategory::where('userId', Auth::user()->id)->orderBy('name','asc')->get();
        $data['categories'] = $categories;
        return view('expenses.categories', $data);
    }

    public function categoriesAdd()
    {
        date_default_timezone_set('America/Monterrey');
        $categories = ExpensesCategory::where('parentCategoryId', null)->where('userId', Auth::user()->id)->orderBy('name','asc')->get();
        $data['categories'] = $categories;

        return view('expenses.categoriesAdd',$data);
    }

    public function categoriesSave(Request $request){

        $category = new ExpensesCategory();
        $category->name = $request->name;

        if(isset($request->parentCategory) && $request->parentCategory != 0 ){
            $category->parentCategoryId = $request->parentCategory;
        }

        $category->userId = Auth::user()->id;
        $category->save();

        return redirect('/expenses/categories');
    }


   

}