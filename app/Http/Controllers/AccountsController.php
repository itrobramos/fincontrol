<?php

namespace App\Http\Controllers;

use App\View;
use DB;
use Auth;
use App\Models\Account;
use App\Models\Movement;
use App\Models\UserAccount;
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
        $accounts = Account::join('users_accounts', 'users_accounts.accountId', '=', 'accounts.id')->where('active',1)->where('users_accounts.userId', Auth::user()->id)->orderBy('name','asc')->get();
        $data['accounts'] = $accounts;
        return view('accounts.index', $data);
    }

    public function register($id)
    {
        date_default_timezone_set('America/Monterrey');
        $account = Account::find($id);
        $data["account"] = $account;
        return view('accounts.register', $data);
    }

    public function savemovement(Request $request){
        
        $UserAccountDB = UserAccount::where('userId', Auth::user()->id)->where('accountId', $request->accountId)->first();

        $Movement = new Movement();
        $Movement->userId = Auth::user()->id;
        $Movement->type = $request->type;
        $Movement->accountId = $request->accountId;
        $Movement->concept = $request->concept;
        $Movement->amount = $request->amount;
        $Movement->transactionDate = $request->transactionDate;

        if($file=$request->file('image')){
            $name=$file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = 'uploads/images/accounts/' . strtolower(str_replace($request->symbol," ","")) . time() . '.' . strtolower($extension);
            $file->move('public/uploads/images/accounts/', $filename);
            $Movement->receiptUrl = $filename;            
        }

        if($request->type == 1){
            $Movement->resultAmount = $UserAccountDB->amount + $request->amount;
        }
        else{
            $Movement->resultAmount = $UserAccountDB->amount - $request->amount;
        }
        
        $Movement->save();
        $UserAccountDB->amount = $Movement->resultAmount;
        $UserAccountDB->save();

   
        $account = Account::join('users_accounts', 'accounts.id', '=', 'users_accounts.accountid')->where('userId', Auth::user()->id)->find($id);
        $movements = Movement::where('userId', Auth::user()->id)->where('accountId',$id)->get();

        $data["account"] = $account;
        $data["movements"] = $movements;
        
        return view('accounts.show', $data);
   


    }

    public function configure(){
        date_default_timezone_set('America/Monterrey');
        $accounts = Account::orderBy('name','asc')->get();

        foreach($accounts as $account){
            $hasAccount = Auth::user()->accounts()->where('accountid', $account->id)->where('active',true)->exists();
            $account->selected = $hasAccount;
        }

        $data['accounts'] = $accounts;
        return view('accounts.configure', $data);
    }

    public function saveconfiguration(Request $request){

      
        DB::table('users_accounts')
            ->where('userId', Auth::user()->id)
            ->update(['active' => 0]);
        
        if(isset($request->account)){
            foreach($request->account as $account){

                $UserAccountDB = UserAccount::where('userId', Auth::user()->id)->where('accountId', $account)->first();
    
                if($UserAccountDB != null){
                    $UserAccountDB->userId = Auth::user()->id;
                    $UserAccountDB->accountId = $account;
                    $UserAccountDB->active = true;
                    $UserAccountDB->save();
                }
                else{
                    $UserAccountDB = new UserAccount();
                    $UserAccountDB->userId = Auth::user()->id;
                    $UserAccountDB->accountId = $account;
                    $UserAccountDB->active = true;
                    $UserAccountDB->save();
                }
            }
        }


        return redirect('accounts');
    }

    public function show($id){
        $account = Account::join('users_accounts', 'accounts.id', '=', 'users_accounts.accountid')->where('userId', Auth::user()->id)->find($id);
        $movements = Movement::where('userId', Auth::user()->id)->where('accountId',$id)->get();


        $data["account"] = $account;
        $data["movements"] = $movements;
        
        return view('accounts.show', $data);
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
            $filename = 'uploads/images/accounts/' . strtolower(str_replace($request->symbol," ","")) . time() . '.' . strtolower($extension);
            $file->move('public/uploads/images/accounts/', $filename);
            $account->imageUrl = $filename;            
        }
        
        $account->save();
        return redirect('/accounts');
    }
}