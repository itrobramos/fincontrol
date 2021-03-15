<?php

namespace App\Http\Controllers;

use App\View;
use DB;
use Auth;
use App\Models\Account;
use Image;


use Illuminate\Http\Request;

class AccountsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth', ['except' => ['welcome']]);
    // }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $accounts = Account::orderBy('name','asc')->get();
        $data['accounts'] = $accounts;
        return view('accounts.index', $data);
    }

    public function add()
    {
        date_default_timezone_set('America/Monterrey');
        return view('accounts.add');
    }

    public function save(Request $request){

        $account = new Account();
        $account->name = $request->name;
        $account->color = $request->color;

        if($file=$request->file('image')){
            $name=$file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = 'uploads/images/accounts/' . strtolower(str_replace($request->symbol," ","")) . time() . '.' . strtolower($extension);
            $file->move('public/uploads/images/accounts/', $filename);
            $account->imageUrl = $filename;            
        }
        $account->save();
        return redirect('/accounts');
    }


    public function edit($id)
    {
        date_default_timezone_set('America/Monterrey');
        $account = Account::find($id);
        $data['account'] = $account;
        return view('accounts.edit',$data);
    }

    public function update(Request $request, $id){

        $account = Account::find($id);
        $account->name = $request->name;
        $account->color = $request->color;

        if($file=$request->file('image')){
            $name=$file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = 'public/uploads/images/accounts/' . strtolower(str_replace($request->symbol," ","")) . time() . '.' . strtolower($extension);
            $file->move('public/uploads/images/accounts/', $filename);
            $account->imageUrl = $filename;            
        }
        
        $account->save();
        return redirect('/accounts');
    }
}