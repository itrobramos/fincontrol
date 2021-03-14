<?php

namespace App\Http\Controllers;

use App\View;
use DB;
use Auth;
use App\Models\Broker;
use App\Models\Exchange;
use App\Models\Stock;
use App\Models\UserStock;
use Image;


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
        $myStocks = Stock::join('users_stocks','users_stocks.stockId', '=', 'stocks.Id')
                            ->join('brokers', 'brokers.id', '=', 'users_stocks.brokerId')
                            ->join('currencies', 'currencies.id', '=', 'users_stocks.currencyId')
                            ->where('users_stocks.UserId', '=', Auth::user()->id)
                            ->where('stocks.stockTypeId', '=', 1)
                            ->where('users_stocks.quantity', '>', 0)

                            ->select('users_stocks.*','users_stocks.id as iduserstock', 'brokers.name as broker','stocks.*','currencies.symbol as currency')
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

    public function edit($id)
    {
        date_default_timezone_set('America/Monterrey');
        $brokers = Broker::all();

        $UserStock = UserStock::find($id);
        $data['brokers'] = $brokers;
        $data['stock'] = $UserStock;

        return view('stocks.edit',$data);
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
            $StockDB->stockTypeId = 1;
            
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

    public function update(Request $request, $id){

        $stock = Stock::where('symbol', $request->symbol)->first();

        if($stock != null){

           $UserStockDB = UserStock::find($id);
           $UserStockDB->UserId = Auth::user()->id;
           $UserStockDB->StockId = $stock->id;
           $UserStockDB->Quantity = $request->quantity;
           $UserStockDB->averagePrice = $request->average;
           $UserStockDB->currencyId = $request->currency;
           $UserStockDB->brokerId = $request->broker;

           if($request->date != null)
               $UserStockDB->transactionDate = $request->date;

            if($file=$request->file('image')){
                $name=$file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename = 'public/uploads/images/' . strtolower(str_replace($request->symbol," ","")) . time() . '.' . strtolower($extension);
                $file->move('public/uploads/images/', $filename);
                
                $stock->imageUrl = $filename;
                $stock->save();
            }
            
           $UserStockDB->save();
        }
        else{
            $UserStockDB = UserStock::find($id);

            $StockDB = Stock::find($UserStockDB->stockId);
            $StockDB->symbol = $request->symbol;
            $StockDB->name = $request->name;
            $StockDB->verified= 0;

            if($file=$request->file('image')){
                $name=$file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename = 'public/uploads/images/' . strtolower(str_replace($request->symbol," ","")) . time() . '.' . strtolower($extension);
                $file->move('public/uploads/images/', $filename);
                
                $StockDB->imageUrl = $filename;
                $StockDB->save();            }

            $StockDB->save();

            //se registra al usuario 
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