<?php

namespace App\Http\Controllers;

use App\View;
use DB;
use Auth;
use App\Models\Broker;
use App\Models\Exchange;
use App\Models\Stock;
use App\Models\UserStock;

use Illuminate\Http\Request;

class StocksController extends Controller
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
        $myStocks = Stock::join('Users_Stocks','Users_Stocks.StockId', '=', 'Stocks.Id')
                            ->join('Brokers', 'Brokers.id', '=', 'Users_Stocks.brokerId')
                            ->join('Currencies', 'Currencies.id', '=', 'Users_Stocks.currencyId')
                            ->where('Users_Stocks.UserId', '=', Auth::user()->id)

                            ->select('Users_Stocks.*', 'Brokers.name as broker','Stocks.*','Currencies.symbol as currency')
                            ->get()
                            ;

        $exchange = Exchange::where('date', date('y-m-d'))
                    ->where('currencyIdDestiny', '=', 1)
                    ->get();           
       
        $data['myStocks'] = $myStocks;
        $data['exchanges'] = $exchange;
    
        
        return view('stocks.index', $data);
    }

    public function add()
    {
        date_default_timezone_set('America/Monterrey');
        $brokers = Broker::all();
        $data['brokers'] = $brokers;

        return view('stocks.add',$data);
    }

    public function save(Request $request){

        $stock = Stock::where('symbol', $request->symbol)->first();

        // dd(Auth::user()->id);

        if($stock != null){
           //se registra al usuario 
           $UserStockDB = new UserStock();
           $UserStockDB->UserId = Auth::user()->id;
           $UserStockDB->StockId = $stock->id;
           $UserStockDB->Quantity = $request->quantity;
           $UserStockDB->averagePrice = $request->average;
           $UserStockDB->currencyId = $request->currency;
           $UserStockDB->brokerId = $request->broker;

           if($request->date != null)
               $UserStockDB->transactionDate = $request->date;
            
           $UserStockDB->save();

        }
        else{
            $StockDB = new Stock();
            $StockDB->symbol = $request->symbol;
            $StockDB->name = $request->name;
            $StockDB->verified= 0;
            
            $StockDB->save();


            //se registra al usuario 
            $UserStockDB = new UserStock();
            $UserStockDB->UserId = Auth::user()->id;
            $UserStockDB->StockId = $StockDB->id;
            $UserStockDB->Quantity = $request->quantity;
            $UserStockDB->averagePrice = $request->average;
            $UserStockDB->currencyId = $request->currency;
            $UserStockDB->brokerId = $request->broker;

            if($request->date != null)
                $UserStockDB->transactionDate = $request->date;
            
           $UserStockDB->save();
        }


        return redirect('/stocks');
    }
}