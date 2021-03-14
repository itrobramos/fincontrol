<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Exchange;
use App\Models\Stock;
use App\Models\UserStock;
use DB;




class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $myStocks = Stock::join('users_stocks','users_stocks.stockId', '=', 'stocks.Id')
                            ->join('brokers', 'brokers.id', '=', 'users_stocks.brokerId')
                            ->join('currencies', 'currencies.id', '=', 'users_stocks.currencyId')
                            ->where('users_stocks.userId', '=', Auth::user()->id)
                            ->select('users_stocks.*', 'brokers.name as broker','stocks.*','currencies.symbol as currency')
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

        $data["VariableTotal"] = round($VariableTotalAccount,2);
        return view('home', $data);
    }
}