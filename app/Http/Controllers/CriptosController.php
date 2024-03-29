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

class CriptosController extends Controller
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
        $myStocks = Stock::join('users_stocks','users_stocks.stockId', '=', 'stocks.Id')
                            ->join('brokers', 'brokers.id', '=', 'users_stocks.brokerId')
                            ->join('currencies', 'currencies.id', '=', 'users_stocks.currencyId')
                            ->where('users_stocks.UserId', '=', Auth::user()->id)
                            ->where('stocks.stockTypeId', '=', 4)
                            ->select('users_stocks.*','users_stocks.id as iduserstock', 'brokers.name as broker','stocks.*','currencies.symbol as currency')
                            ->orderBy('stocks.name')
                            ->get();


        $exchange = Exchange::where('date', DB::raw("(select max(`date`) from exchanges)"))
        ->where('currencyIdDestiny', '=', 1)
        ->where('currencyIdOrigin', '=', 2)
        ->first()->price;    

        $montoInversion = 0;
        $stocks = [];

        
        foreach($myStocks as $stock){
            if($stock->currencyId == 1)
                $montoInversion += $stock->quantity * $stock->averagePrice;
            else if($stock->currencyId == 2)
                $montoInversion += $stock->quantity * $stock->averagePrice *  $exchange;
        }

        
        foreach($myStocks as $stock){

            if($stock->currencyId == 1)
                $Inversion = $stock->quantity * $stock->averagePrice;
            else if($stock->currencyId == 2)
                $Inversion = $stock->quantity * $stock->averagePrice *  $exchange;

            $stocks[] = ["Id" => $stock->iduserstock,
                        "Nombre" => $stock->name,
                        "Acciones" => $stock->quantity,
                        "Inversion" => Round($Inversion,2),
                        "Porcentaje" => Round($Inversion / $montoInversion * 100 ,2),
                        "Imagen" => $stock->imageUrl
                        ];
        }
        
        $data['myStocks'] = $stocks;
        return view('criptos.index', $data);
    }

    public function add()
    {
        date_default_timezone_set('America/Monterrey');
        $brokers = Broker::all();
        $data['brokers'] = $brokers;

        return view('criptos.add',$data);
    }

    public function edit($id)
    {
        date_default_timezone_set('America/Monterrey');
        $brokers = Broker::all();

        $UserStock = UserStock::find($id);
        $data['brokers'] = $brokers;
        $data['stock'] = $UserStock;

        return view('criptos.edit',$data);
    }

    public function editsimple($id)
    {
        date_default_timezone_set('America/Monterrey');

        $UserStock = UserStock::find($id);
        $data['stock'] = $UserStock;

        return view('criptos.editsimple',$data);
    }

    public function updatesimple(Request $request, $id){

        $UserStockDB = UserStock::find($id);
        $UserStockDB->Quantity = $request->quantity;
        $UserStockDB->averagePrice = $request->average;
        $UserStockDB->currencyId = $request->currency;
        $UserStockDB->currencyId = $request->currency;
        $UserStockDB->save();

        return redirect('/criptos');
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
            $StockDB->stockTypeId = 4;
            
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


        return redirect('/criptos');
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
                $filename = 'uploads/images/' . strtolower(str_replace($request->symbol," ","")) . time() . '.' . strtolower($extension);
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
                $filename = 'uploads/images/' . strtolower(str_replace($request->symbol," ","")) . time() . '.' . strtolower($extension);
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


        return redirect('/criptos');
    }

    public function destroy($id)
    {
        UserStock::destroy($id);
        return redirect('criptos')->with('Message', 'Criptomoneda eliminada correctamente');
    }
}