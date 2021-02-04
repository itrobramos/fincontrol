<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Exchange;
use App\Models\Stock;
use App\Models\UserStock;




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

        $myStocks = Stock::join('Users_Stocks','Users_Stocks.StockId', '=', 'Stocks.Id')
                            ->join('Brokers', 'Brokers.id', '=', 'Users_Stocks.brokerId')
                            ->join('Currencies', 'Currencies.id', '=', 'Users_Stocks.currencyId')
                            ->where('Users_Stocks.UserId', '=', Auth::user()->id)
                            ->select('Users_Stocks.*', 'Brokers.name as broker','Stocks.*','Currencies.symbol as currency')
                            ->get();

        $exchange = Exchange::where('date', date('y-m-d'))
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