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
use App\Models\FixedRentPaid;
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
     
        $paids = DB::select("SELECT date fecha, color, sum(p.amount) monto
        FROM fixed_rent_paids p inner join fixed_rent_investments i ON p.fixedRentInvestmentId = i.id
        inner join fixed_rent_platforms pl ON i.fixed_rent_platformsId = pl.id
        where (month(date) = " . date('m'). "  AND YEAR(date) = " . date('Y'). ") OR date <= " . date('Y-m-d') . "
        AND i.userId = " . Auth::user()->id . " 
        group by date, color
        order by date");

        $data['paids'] = $paids;
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


    public function details($id)
    {
        date_default_timezone_set('America/Monterrey');
        $Investment = FixedRentInvestments::find($id);

        $Paids = [];
        
        if($Investment->daysCount > 0){

            $date1  = $Investment->initialDate;
            $date2  = $Investment->endDate;        
            $time   = strtotime($date1);
            $last   = date('Y-m', strtotime($date2));
            $cont   = 0;
            $months = $Investment->term / 30;
            $valuePerDay = $Investment->totalEarnings / 360;
            $lastPayDate = $date1;
            $diasasumar  = 0;

            do {
                $month = date('Y-m', $time);
                $payDate = date('Y-m-d', $time);

                if($payDate > $date1){

                    if(date('D', strtotime($payDate)) == 'Sat')
                        $payDate = strtotime('+2 days', strtotime($payDate));
                    else if(date('D', strtotime($payDate)) == 'Sun')
                        $payDate = strtotime('+1 days', strtotime($payDate));
                    else
                        $payDate = strtotime($payDate);

                    $diff = abs($payDate - strtotime($lastPayDate));
                    $days = round(floor($diff / (60*60*24)),0);

                    $Paids[] = [
                        'payDay' => date('Y-m-d',$payDate),
                        'number' => $cont,
                        'amount' => Round($days * $valuePerDay,2), 
                        'percent' => Round($cont / $months * 100, 2),
                    ];  
                    
                    $lastPayDate = date('Y-m-d',$payDate);
                }
 
                if(date('m', $time) == 1 && (date('d',$time) >= 28) ){
                    $diasasumar = date('t',$time) - date('d', $time) + date('t',strtotime(date('Y',$time).'-02'));
                    $time = strtotime('+' . $diasasumar . ' days', $time);
                }
                else{
                    if($diasasumar > 0){
                        $diasasumar = date('t',$time) -1 - date('d', $time) + date('t',strtotime(date('Y',$time).'-03'));;
                        $time = strtotime('+' . $diasasumar . ' days', $time);
                        $diasasumar = 0;
                    }
                    else{
                        $time = strtotime('+ 1month', $time);
                    }
                }
                $cont++;
            } while ($month != $last);
            
            
        }

        if($Investment->dayFixed > 0){
            $date1  = $Investment->initialDate;
            $time   = strtotime($date1);
            $valuePerDay = $Investment->totalEarnings / $Investment->dayFixed;
            $payDate = date('Y-m-d', $time);

            $payDate = strtotime('+ ' . $Investment->dayFixed . ' days', strtotime($payDate));

            $diff = abs($payDate - strtotime($date1));
            $days = round(floor($diff / (60*60*24)),0);


            $Paids[] = [
                'payDay' => date('Y-m-d',$payDate),
                'number' => 1,
                'amount' => Round($days * $valuePerDay,2), 
                'percent' => Round($days / 28 * 100, 2),
            ];  
            
        }

        $data["paids"] = $Paids;
        $data['investment'] = $Investment;
        return view('rentafija.details', $data);
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

    public function saveAllPaids(){
        date_default_timezone_set('America/Monterrey');
        $Investments = FixedRentInvestments::where('endDate', '>', date('Y-m-d'))->where('id','>',57)->get();

        $Paids = [];
        
        foreach($Investments as $Investment)
        {
        
            if($Investment->daysCount > 0){
    
                $date1  = $Investment->initialDate;
                $date2  = $Investment->endDate;        
                $time   = strtotime($date1);
                $last   = date('Y-m', strtotime($date2));
                $cont   = 0;
                $months = $Investment->term / 30;
                $valuePerDay = $Investment->totalEarnings / 360;
                $lastPayDate = $date1;
                $diasasumar  = 0;
    
                do {
                    $month = date('Y-m', $time);
                    $payDate = date('Y-m-d', $time);
    
                    if($payDate > $date1){
    
                        if(date('D', strtotime($payDate)) == 'Sat')
                            $payDate = strtotime('+2 days', strtotime($payDate));
                        else if(date('D', strtotime($payDate)) == 'Sun')
                            $payDate = strtotime('+1 days', strtotime($payDate));
                        else
                            $payDate = strtotime($payDate);
    
                        $diff = abs($payDate - strtotime($lastPayDate));
                        $days = round(floor($diff / (60*60*24)),0);
    
                        $Paids[] = [
                            'investmentId' => $Investment->id, 
                            'payDay' => date('Y-m-d',$payDate),
                            'number' => $cont,
                            'amount' => Round($days * $valuePerDay,2), 
                            'percent' => Round($cont / $months * 100, 2),
                        ];  
                        
                        $lastPayDate = date('Y-m-d',$payDate);
                    }
     
                    if(date('m', $time) == 1 && (date('d',$time) >= 28) ){
                        $diasasumar = date('t',$time) - date('d', $time) + date('t',strtotime(date('Y',$time).'-02'));
                        $time = strtotime('+' . $diasasumar . ' days', $time);
                    }
                    else{
                        if($diasasumar > 0){
                            $diasasumar = date('t',$time) -1 - date('d', $time) + date('t',strtotime(date('Y',$time).'-03'));;
                            $time = strtotime('+' . $diasasumar . ' days', $time);
                            $diasasumar = 0;
                        }
                        else{
                            $time = strtotime('+ 1month', $time);
                        }
                    }
                    $cont++;
                } while ($month != $last);
                
                
            }
    
            if($Investment->dayFixed > 0){
                $date1  = $Investment->initialDate;
                $time   = strtotime($date1);
                $valuePerDay = $Investment->totalEarnings / $Investment->dayFixed;
                $payDate = date('Y-m-d', $time);
    
                $payDate = strtotime('+ ' . $Investment->dayFixed . ' days', strtotime($payDate));
    
                $diff = abs($payDate - strtotime($date1));
                $days = round(floor($diff / (60*60*24)),0);
    
    
                $Paids[] = [
                    'investmentId' => $Investment->id, 
                    'payDay' => date('Y-m-d',$payDate),
                    'number' => 1,
                    'amount' => Round($days * $valuePerDay,2), 
                    'percent' => Round($days / 28 * 100, 2),
                ];  
                
            }
    
        }


        foreach($Paids as $Paid){

            

            $FRPaid = new FixedRentPaid();
            
            $FRPaid->fixedRentInvestmentId = $Paid['investmentId'];
            $FRPaid->date = $Paid['payDay'];
            $FRPaid->number = $Paid['number'];
            $FRPaid->amount = $Paid['amount'];
            $FRPaid->percent = $Paid['percent'];
            $FRPaid->save();
            
        }
    }

    public function calendar(){

        $paids = DB::select("SELECT date fecha, color, sum(p.amount) monto
                FROM fixed_rent_paids p inner join fixed_rent_investments i ON p.fixedRentInvestmentId = i.id
                inner join fixed_rent_platforms pl ON i.fixed_rent_platformsId = pl.id
                where month(date) = " . date('m'). "  AND YEAR(date) = " . date('Y'). "
                AND i.userId = " . Auth::user()->id . " 
                group by date, color
                order by date");

        $data['paids'] = $paids;

        return view('rentafija.calendar',$data);
    }    
}