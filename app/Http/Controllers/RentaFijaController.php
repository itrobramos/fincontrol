<?php

namespace App\Http\Controllers;

use App\View;
use DB;
use Auth;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\UserAccount;
use App\Models\FixedRentPlatform;
use App\Models\FixedRentInvestments;
use App\Models\Movement;

class RentaFijaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $platforms = FixedRentPlatform::all();
        $data["platforms"] = $platforms;
        return view('rentafija.index', $data);
    }

    public function show($id){

        $platform = FixedRentPlatform::find($id);
        $investments = FixedRentInvestments::where('status', 1)->orderBy('endDate', 'asc')->where('fixed_rent_platformsId', $id)->where('userId', Auth::user()->id)->orderBy('endDate', 'asc')->get();
        //$investments = FixedRentInvestments::where('userId', Auth::user()->id)->orderBy('endDate', 'asc')->get();
        
        $diario = 0;
        foreach($investments as $inv){
            $diario = $diario + (($inv->amount * ($inv->rate / 100)) / 365);
        }

        $data["platform"] = $platform;
        $data["investments"] = $investments;
        $data["diario"] = round($diario,2);

        return view('rentafija.show', $data);
    }

    public function add($id)
    {
        date_default_timezone_set('America/Monterrey');
        $platform = FixedRentPlatform::find($id);
        $data["platform"] = $platform;
        return view('rentafija.add', $data);
    }

    public function reinvest($id)
    {
        date_default_timezone_set('America/Monterrey');
        $Investment = FixedRentInvestments::find($id);
        $data["Investment"] = $Investment;
        return view('rentafija.reinvest', $data);
    }

    public function close($id)
    {
        date_default_timezone_set('America/Monterrey');
        $Investment = FixedRentInvestments::find($id);
        $accounts = Account::join('users_accounts', 'users_accounts.accountId', '=', 'accounts.id')->where('active',1)->where('users_accounts.userId', Auth::user()->id)->orderBy('name','asc')->get();
       
        $data['accounts'] = $accounts;
        $data["Investment"] = $Investment;
        return view('rentafija.close', $data);
    }

    public function saveclose(Request $request)
    {
        date_default_timezone_set('America/Monterrey');

        //Se da de baja la inversión
        $Investment = FixedRentInvestments::find($request->id);
        $Investment->status=0;
        $Investment->save();

        //Se actualiza el monto de la cuenta
        $UserAccountDB = UserAccount::where('userId', Auth::user()->id)->where('accountId', $request->account)->first();
        $UserAccountDB->amount = ($Investment->amount + $Investment->totalEarnings);
        $UserAccountDB->save();

        //Se crea el moviemiento para bitacora
        $movement = new Movement();
        $movement->userId = Auth::user()->id;
        $movement->accountId = $request->account;
        $movement->type = 1;
        $movement->amount = $Investment->amount;
        $movement->transactionDate = date("Y-m-d");
        $movement->concept = "Fin de inversión " . $Investment->FixedRentPlatform->name;
        $movement->resultAmount = $movement->resultAmount + $request->amount;
        $movement->save();        

        return redirect('/rentafija/'. $Investment->fixed_rent_platformId);
    }


    public function save(Request $request){

    
        $Investment = new FixedRentInvestments();
        $Investment->amount = $request->amount;
        $Investment->rate = $request->rate;
        $Investment->term = $request->term;
        $Investment->totalEarnings= $request->earnings;
        $Investment->daysCount = $request->paidDay;
        $Investment->dayFixed = $request->fixedDay;
        $Investment->initialDate = $request->initialDate;
        $Investment->endDate = $request->endDate;
        $Investment->status = 1;

        if(isset($request->reinvest))
            $Investment->reinvest = $request->reinvest;
        else
            $Investment->reinvest = false;
    
        $Investment->fixed_rent_platformsId = $request->platformId;
        $Investment->userId = Auth::user()->id;
        $Investment->save();

        if(isset($request->reinvestment))
        {
            $InvestmentPrevious = FixedRentInvestments::find($request->reinvestment);
            $InvestmentPrevious->status=0;
            $InvestmentPrevious->save();
        }
        return redirect('/rentafija/'. $request->platformId);
    }

}