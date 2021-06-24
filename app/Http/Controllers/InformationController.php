<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Exchange;
use App\Models\Stock;
use App\Models\UserAccount;
use App\Models\FixedRentInvestments;
use App\Models\SnowballODI;
use DB;

class InformationController extends Controller
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
    public function portafolio()
    {
         ///PORTAFOLIO
         $myStocks = Stock::join('users_stocks','users_stocks.stockId', '=', 'stocks.Id')
                            ->join('brokers', 'brokers.id', '=', 'users_stocks.brokerId')
                            ->join('currencies', 'currencies.id', '=', 'users_stocks.currencyId')
                            ->join('stock_types', 'stock_types.id', '=', 'stocks.stockTypeId')
                            ->where('users_stocks.userId', '=', Auth::user()->id)
                            ->select('users_stocks.*', 'brokers.name as broker','stocks.*','currencies.symbol as currency','stock_types.name as type','stock_types.color')
                            ->get();

        $exchange = Exchange::where('date', DB::raw("(select max(`date`) from exchanges)"))
                ->where('currencyIdDestiny', '=', 1)
                ->get();           

        $VariableTotalAccount = 0;

        foreach($myStocks as $stock){
            if($stock->currency == "MXN"){
                $VariableTotalAccount = $VariableTotalAccount + $stock->quantity * $stock->averagePrice;
            }
            else if($stock->currency == "USD"){
                $VariableTotalAccount = $VariableTotalAccount + $stock->quantity * $stock->averagePrice * $exchange[0]['price'];
            }
            else if($stock->currency == "EUR"){
                $VariableTotalAccount = $VariableTotalAccount + $stock->quantity * $stock->averagePrice * $exchange[1]['price']; 
            }
        }

        $amountOdis = DB::select("SELECT SUM(o.ODIPrice * quantity) investment 
                    FROM snowball_odis o INNER JOIN snowball_proyects p ON o.snowballProjectId = p.id 
                    WHERE o.userId = ". Auth::user()->id );

        $VariableTotalAccount = $VariableTotalAccount + $amountOdis[0]->investment;
 
 
         $Portafolio = [];
    
         if($amountOdis > 0)
             $Portafolio[] = ["Snowball",  $amountOdis[0]->investment, '#1663FD'];
     
         foreach(UserAccount::where('userId', Auth::user()->id)->where('active', true)->get() as $useraccount){
             if($useraccount->amount > 0)
                 $Portafolio[] = [$useraccount->account->name . " (Cuenta)",  $useraccount->amount, $useraccount->account->color];
         }
 
         $InversionesRentaFija = DB::select("SELECT name, color, sum(amount) amount
                                             FROM fixed_rent_investments i
                                             INNER JOIN fixed_rent_platforms p on i.fixed_rent_platformsId = p.id 
                                             WHERE i.status = 1 AND i.userId = ". Auth::user()->id . 
                                             " GROUP BY name, color");
 
         foreach($InversionesRentaFija as $investment){
             if($investment->amount > 0)
                 $Portafolio[] = [$investment->name,  $investment->amount, $investment->color];
         } 
 
         $VariableTotalFibra = 0;
         $VariableTotalAcciones = 0;
         $VariableTotalETF = 0;
         $VariableTotalCriptos = 0;
         $colorFibra = "";
         $colorAcciones = "";
         $colorETF = "";
         $colorCripto = "";
 
         foreach($myStocks as $stock){
             if($stock->type == "Fibra"){
                 $colorFibra = $stock->color;
                 if($stock->currency == "MXN")
                     $VariableTotalFibra = $VariableTotalFibra + $stock->quantity * $stock->averagePrice;
                 else if($stock->currency == "USD")
                     $VariableTotalFibra = $VariableTotalFibra + $stock->quantity * $stock->averagePrice * $exchange[0]['price'];
                 else if($stock->currency == "EUR")
                     $VariableTotalFibra = $VariableTotalFibra + $stock->quantity * $stock->averagePrice * $exchange[1]['price']; 
             }
             else if($stock->type == "Acción"){
                 $colorAcciones = $stock->color;
                 if($stock->currency == "MXN")
                     $VariableTotalAcciones = $VariableTotalAcciones + $stock->quantity * $stock->averagePrice;
                 else if($stock->currency == "USD")
                     $VariableTotalAcciones = $VariableTotalAcciones + $stock->quantity * $stock->averagePrice * $exchange[0]['price'];
                 else if($stock->currency == "EUR")
                     $VariableTotalAcciones = $VariableTotalAcciones + $stock->quantity * $stock->averagePrice * $exchange[1]['price']; 
             }
             else if($stock->type == "ETF"){
                 $colorETF = $stock->color;
                 if($stock->currency == "MXN")
                     $VariableTotalETF = $VariableTotalETF + $stock->quantity * $stock->averagePrice;
                 else if($stock->currency == "USD")
                     $VariableTotalETF = $VariableTotalETF + $stock->quantity * $stock->averagePrice * $exchange[0]['price'];
                 else if($stock->currency == "EUR")
                     $VariableTotalETF = $VariableTotalETF + $stock->quantity * $stock->averagePrice * $exchange[1]['price']; 
             }
             else if($stock->type == "Criptomonedas"){
                 $colorCripto = $stock->color;
                 if($stock->currency == "MXN")
                     $VariableTotalCriptos = $VariableTotalCriptos + $stock->quantity * $stock->averagePrice;
                 else if($stock->currency == "USD")
                     $VariableTotalCriptos = $VariableTotalCriptos + $stock->quantity * $stock->averagePrice * $exchange[0]['price'];
                 else if($stock->currency == "EUR")
                     $VariableTotalCriptos = $VariableTotalCriptos + $stock->quantity * $stock->averagePrice * $exchange[1]['price']; 
             }
         }
 
         if($VariableTotalFibra> 0)
             $Portafolio[] = ['Fibras',  Round($VariableTotalFibra,2), $colorFibra];
         if($VariableTotalCriptos> 0)
             $Portafolio[] = ['Criptomonedas',  Round($VariableTotalCriptos,2), $colorCripto];
         if($VariableTotalETF> 0)
             $Portafolio[] = ['ETF',  Round($VariableTotalETF,2), $colorETF];
         if($VariableTotalAcciones> 0)
             $Portafolio[] = ['Acciones',  Round($VariableTotalAcciones,2), $colorAcciones];
             
         
        $data["Portafolio"] = $Portafolio;
 
        return view('info.portafolio', $data);
    }

    public function efectivo()
    {
         ///PORTAFOLIO
        $EfectivoTotalAccount = UserAccount::where('userId', Auth::user()->id)->sum('amount');
        $data["EfectivoTotal"] = round($EfectivoTotalAccount,2);       


        $Portafolio = [];
    
        foreach(UserAccount::where('userId', Auth::user()->id)->where('active', true)->get() as $useraccount){
            if($useraccount->amount > 0)
                $Portafolio[] = [$useraccount->account->name,  $useraccount->amount, $useraccount->account->color];
        }
        
        $data["Portafolio"] = $Portafolio;
 
        return view('info.efectivo', $data);
    }

    public function rentaVariable()
    {
         ///PORTAFOLIO
         $myStocks = Stock::join('users_stocks','users_stocks.stockId', '=', 'stocks.Id')
                            ->join('brokers', 'brokers.id', '=', 'users_stocks.brokerId')
                            ->join('currencies', 'currencies.id', '=', 'users_stocks.currencyId')
                            ->join('stock_types', 'stock_types.id', '=', 'stocks.stockTypeId')
                            ->where('users_stocks.userId', '=', Auth::user()->id)
                            ->select('users_stocks.*', 'brokers.name as broker','stocks.*','currencies.symbol as currency','stock_types.name as type','stock_types.color')
                            ->get();

        $exchange = Exchange::where('date', DB::raw("(select max(`date`) from exchanges)"))
                ->where('currencyIdDestiny', '=', 1)
                ->get();           

        $VariableTotalAccount = 0;

        foreach($myStocks as $stock){
        if($stock->currency == "MXN"){
        $VariableTotalAccount = $VariableTotalAccount + $stock->quantity * $stock->averagePrice;
        }
        else if($stock->currency == "USD"){
        $VariableTotalAccount = $VariableTotalAccount + $stock->quantity * $stock->averagePrice * $exchange[0]['price'];
        }
        else if($stock->currency == "EUR"){
        $VariableTotalAccount = $VariableTotalAccount + $stock->quantity * $stock->averagePrice * $exchange[1]['price']; 
        }
        }

        $amountOdis = DB::select("SELECT SUM(o.ODIPrice * quantity) investment 
                    FROM snowball_odis o INNER JOIN snowball_proyects p ON o.snowballProjectId = p.id 
                    WHERE o.userId = ". Auth::user()->id );

        $VariableTotalAccount = $VariableTotalAccount + $amountOdis[0]->investment;
 
        $Portafolio = [];
    
        if($amountOdis > 0)
             $Portafolio[] = ["Snowball",  $amountOdis[0]->investment, '#1663FD'];

         $VariableTotalFibra = 0;
         $VariableTotalAcciones = 0;
         $VariableTotalETF = 0;
         $VariableTotalCriptos = 0;
         $colorFibra = "";
         $colorAcciones = "";
         $colorETF = "";
         $colorCripto = "";
 
         foreach($myStocks as $stock){
             if($stock->type == "Fibra"){
                 $colorFibra = $stock->color;
                 if($stock->currency == "MXN")
                     $VariableTotalFibra = $VariableTotalFibra + $stock->quantity * $stock->averagePrice;
                 else if($stock->currency == "USD")
                     $VariableTotalFibra = $VariableTotalFibra + $stock->quantity * $stock->averagePrice * $exchange[0]['price'];
                 else if($stock->currency == "EUR")
                     $VariableTotalFibra = $VariableTotalFibra + $stock->quantity * $stock->averagePrice * $exchange[1]['price']; 
             }
             else if($stock->type == "Acción"){
                 $colorAcciones = $stock->color;
                 if($stock->currency == "MXN")
                     $VariableTotalAcciones = $VariableTotalAcciones + $stock->quantity * $stock->averagePrice;
                 else if($stock->currency == "USD")
                     $VariableTotalAcciones = $VariableTotalAcciones + $stock->quantity * $stock->averagePrice * $exchange[0]['price'];
                 else if($stock->currency == "EUR")
                     $VariableTotalAcciones = $VariableTotalAcciones + $stock->quantity * $stock->averagePrice * $exchange[1]['price']; 
             }
             else if($stock->type == "ETF"){
                 $colorETF = $stock->color;
                 if($stock->currency == "MXN")
                     $VariableTotalETF = $VariableTotalETF + $stock->quantity * $stock->averagePrice;
                 else if($stock->currency == "USD")
                     $VariableTotalETF = $VariableTotalETF + $stock->quantity * $stock->averagePrice * $exchange[0]['price'];
                 else if($stock->currency == "EUR")
                     $VariableTotalETF = $VariableTotalETF + $stock->quantity * $stock->averagePrice * $exchange[1]['price']; 
             }
             else if($stock->type == "Criptomonedas"){
                 $colorCripto = $stock->color;
                 if($stock->currency == "MXN")
                     $VariableTotalCriptos = $VariableTotalCriptos + $stock->quantity * $stock->averagePrice;
                 else if($stock->currency == "USD")
                     $VariableTotalCriptos = $VariableTotalCriptos + $stock->quantity * $stock->averagePrice * $exchange[0]['price'];
                 else if($stock->currency == "EUR")
                     $VariableTotalCriptos = $VariableTotalCriptos + $stock->quantity * $stock->averagePrice * $exchange[1]['price']; 
             }
         }
 
         if($VariableTotalFibra> 0)
             $Portafolio[] = ['Fibras',  Round($VariableTotalFibra,2), $colorFibra];
         if($VariableTotalCriptos> 0)
             $Portafolio[] = ['Criptomonedas',  Round($VariableTotalCriptos,2), $colorCripto];
         if($VariableTotalETF> 0)
             $Portafolio[] = ['ETF',  Round($VariableTotalETF,2), $colorETF];
         if($VariableTotalAcciones> 0)
             $Portafolio[] = ['Acciones',  Round($VariableTotalAcciones,2), $colorAcciones];
             
         
        $data["Portafolio"] = $Portafolio;
 
        return view('info.rentaVariable', $data);
    }

    public function rentaFija()
    {
         ///PORTAFOLIO
         $Portafolio = [];
    
         $InversionesRentaFija = DB::select("SELECT name, color, sum(amount) amount
                                             FROM fixed_rent_investments i
                                             INNER JOIN fixed_rent_platforms p on i.fixed_rent_platformsId = p.id 
                                             WHERE i.status = 1 AND i.userId = ". Auth::user()->id . 
                                             " GROUP BY name, color");
 

         foreach($InversionesRentaFija as $investment){
             if($investment->amount > 0)
                 $Portafolio[] = [$investment->name,  $investment->amount, $investment->color];
         } 
          

        $amountRedGirasol = DB::select("SELECT SUM(rg.investment) investment 
                                FROM redgirasol_projects rg 
                                WHERE rg.userId = ". Auth::user()->id );

        $amountLendera = DB::select("SELECT SUM(rg.investment) investment 
                            FROM leasing_projects rg 
                            WHERE fintechId = 4 AND rg.userId = ". Auth::user()->id );

        $amountCumplo = DB::select("SELECT SUM(rg.investment) investment 
                            FROM leasing_projects rg 
                            WHERE fintechId = 5 AND rg.userId = ". Auth::user()->id );

        $amountMonific = DB::select("SELECT SUM(rg.investment) investment 
                            FROM realestate_projects rg 
                            WHERE fintechId = 1 AND rg.userId = ". Auth::user()->id );

        if($amountRedGirasol > 0)
            $Portafolio[] = ["Red Girasol",  $amountRedGirasol[0]->investment, '#FAAE3D'];
        
        if($amountLendera > 0)
            $Portafolio[] = ["Lendera",  $amountLendera[0]->investment, '#D23942'];
        
        if($amountMonific > 0)
            $Portafolio[] = ["Monific",  $amountMonific[0]->investment, '#136176'];

        if($amountCumplo > 0)
            $Portafolio[] = ["Cumplo",  $amountCumplo[0]->investment, '#3cba68'];


        $data["Portafolio"] = $Portafolio;
 
        return view('info.rentaFija', $data);
    }

}