<?php

namespace App\Http\Controllers; 

use App\View;
use DB;
use Auth;
use App\Models\Account;
use App\Models\Expense;
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


    public function expenses()
    {
        $expenses = Expense::where('userId', Auth::user()->id)->orderBy('date','desc')->get();
        $data['expenses'] = $expenses;
        return view('expenses.index', $data);
    }

    public function expensesAdd()
    {
        date_default_timezone_set('America/Monterrey');
        $categories = ExpensesCategory::where('userId', Auth::user()->id)->orderBy('name','asc')->get();
        $accounts = Account::join('users_accounts', 'users_accounts.accountId', '=', 'accounts.id')->where('active',1)->where('users_accounts.userId', Auth::user()->id)->orderBy('name','asc')->get();

        $data['categories'] = $categories;
        $data['accounts'] = $accounts;

        return view('expenses.expensesAdd',$data);
    }

    public function expensesSave(Request $request){

        $expense = new Expense();
        $expense->name = $request->name;
        $expense->description = $request->description;
        $expense->store = $request->store;
        $expense->date = $request->date;
        $expense->amount = $request->amount;


        if(isset($request->category) ){
            $expense->categoryId = $request->category;
        }

        if(isset($request->account) ){
            $expense->accountId = $request->account;
        }

        $expense->userId = Auth::user()->id;
        $expense->save();

        return redirect('/expenses/index');
    }

   

}