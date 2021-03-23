<?php

namespace App\Http\Controllers;

use App\View;
use DB;
use Auth;
use App\Models\Broker;
use App\Models\Dividend;
use App\Models\Exchange;
use App\Models\Stock;
use App\Models\Sector;
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
                            ->leftjoin('sectors', 'sectors.id', '=', 'stocks.sectorId')
                            ->where('users_stocks.UserId', '=', Auth::user()->id)
                            ->where('stocks.stockTypeId', '=', 1)
                            ->where('users_stocks.quantity', '>', 0)

                            ->select('users_stocks.*','users_stocks.id as iduserstock', 'brokers.name as broker','stocks.*','currencies.symbol as currency', 'sectors.name as sector')
                            ->orderBy('stocks.name')
                            ->get()
                            ;

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
                        "Imagen" => $stock->imageUrl,
                        "Sector" => $stock->sector
                        ];
        }
        
        $data['myStocks'] = $stocks;
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

    public function editsimple($id)
    {
        date_default_timezone_set('America/Monterrey');

        $UserStock = UserStock::find($id);
        $data['stock'] = $UserStock;

        return view('stocks.editsimple',$data);
    }

    public function updatesimple(Request $request, $id){

        $UserStockDB = UserStock::find($id);
        $UserStockDB->Quantity = $request->quantity;
        $UserStockDB->averagePrice = $request->average;
        $UserStockDB->currencyId = $request->currency;
        $UserStockDB->currencyId = $request->currency;
        $UserStockDB->save();

        return redirect('/stocks');
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

           if(isset($request->sector)){
                $sector = Sector::where('name', $request->sector)->first();

  
                if($sector!= null){
                    $stock->sectorId = $sector->id;
                }
                else{
                    $sector = new Sector();
                    $sector->name = $request->sector;
                    $sector->save();
                    $stock->sectorId = $sector->id;
                }
                $stock->save();
           }
           
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

            if(isset($request->sector)){
                $sector = Sector::where('name', $request->sector);

                if($sector != null){
                    $StockDB->sectorId = $sector->id;
                }
                else{
                    $sector = new Sector();
                    $sector->name = $request->sector;
                    $sector->save();
                    $StockDB->sectorId = $sector->id;
                }
            }

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


        return redirect('/stocks');
    }

    public function destroy($id)
    {
        UserStock::destroy($id);
        return redirect('stocks')->with('Message', 'Acción eliminada correctamente');
    }

    public function show($id){

        $UserStock = UserStock::find($id);

        $dividends = Dividend::join('stocks', 'dividends.referenceId', '=', 'stocks.id')
                    ->join('users_stocks', 'users_stocks.stockId', '=', 'stocks.id')
                    ->where('dividends.type','1')
                    ->where('users_stocks.id', $id)
                    ->where('dividends.userId', Auth::user()->id)
                    ->get(); 

        $recovery = Round($dividends->sum('amount') / ($UserStock->quantity * $UserStock->averagePrice) * 100,2);

        $data['userstock'] = $UserStock;
        $data['dividends'] = $dividends;
        $data['recovery'] = $recovery;

        return view('stocks.show', $data);

    }
}