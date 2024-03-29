<?php

namespace App\Http\Controllers;

use App\View;
use DB;
use Auth;
use App\Models\Broker;
use App\Models\Dividend;
use App\Models\Exchange;
use App\Models\Stock;
use App\Models\UserStock;
use Image;


use Illuminate\Http\Request;

class FibrasController extends Controller
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
                            ->where('users_stocks.userId', '=', Auth::user()->id)
                            ->where('stocks.stockTypeId', '=', 3)
                            ->where('users_stocks.quantity', '>', 0)
                            ->select('users_stocks.*','users_stocks.id as iduserstock', 'brokers.name as broker','stocks.*','currencies.symbol as currency')
                            ->get()
                            ;

        $exchange = Exchange::where('date', DB::raw("(select max(`date`) from exchanges)"))
        ->where('currencyIdDestiny', '=', 1)
        ->where('currencyIdOrigin', '=', 2)
        ->first()->price;    

        $montoInversion = 0;
        $stocks = [];

        
        foreach($myStocks as $fibra){
            if($fibra->currencyId == 1)
                $montoInversion += $fibra->quantity * $fibra->averagePrice;
            else if($fibra->currencyId == 2)
                $montoInversion += $fibra->quantity * $fibra->averagePrice *  $exchange;
        }

        foreach($myStocks as $fibra){

            if($fibra->currencyId == 1)
                $Inversion = $fibra->quantity * $fibra->averagePrice;
            else if($fibra->currencyId == 2)
                $Inversion = $fibra->quantity * $fibra->averagePrice *  $exchange;

            $stocks[] = ["Id" => $fibra->iduserstock    ,
                        "Nombre" => $fibra->name,
                         "Acciones" => $fibra->quantity,
                         "Inversion" => Round($Inversion,2),
                         "Porcentaje" => Round($Inversion / $montoInversion * 100 ,2),
                         "Imagen" => $fibra->imageUrl
                        ];
        }
        

        $data['myStocks'] = $stocks;
    
        
        return view('fibras.index', $data);
    }

    public function add()
    {
        date_default_timezone_set('America/Monterrey');
        $brokers = Broker::all();
        $data['brokers'] = $brokers;

        return view('fibras.add',$data);
    }

    public function edit($id)
    {
        date_default_timezone_set('America/Monterrey');
        $brokers = Broker::all();

        $UserStock = UserStock::find($id);
        $data['brokers'] = $brokers;
        $data['stock'] = $UserStock;

        return view('fibras.edit',$data);
    }

    public function editsimple($id)
    {
        date_default_timezone_set('America/Monterrey');

        $UserStock = UserStock::find($id);
        $data['stock'] = $UserStock;

        return view('fibras.editsimple',$data);
    }

    public function updatesimple(Request $request, $id){

        $UserStockDB = UserStock::find($id);
        $UserStockDB->Quantity = $request->quantity;
        $UserStockDB->averagePrice = $request->average;
        $UserStockDB->currencyId = $request->currency;
        $UserStockDB->currencyId = $request->currency;
        $UserStockDB->save();

        return redirect('/fibras');
    }

    public function save(Request $request){

        $stock = Stock::where('symbol', $request->symbol)->first();
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
            $StockDB->stockTypeId = 3;
            
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


        return redirect('/fibras');
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


        return redirect('/fibras');
    }


    public function show($id){

        $UserStock = UserStock::find($id); 



        $dividends = Dividend::join('stocks', 'dividends.referenceId', '=', 'stocks.id')
                    ->join('users_stocks', 'users_stocks.stockId', '=', 'stocks.id')
                    ->where('dividends.type','3')
                    ->where('users_stocks.id', $id)
                    ->where('dividends.userId', Auth::user()->id)
                    ->get(); 

            
        
        $DividendGraph = DB::select("SELECT YEAR(efectiveDate) year, MONTH(efectiveDate) month, SUM(Amount) amount
        FROM dividends 
        INNER JOIN users_stocks ON dividends.referenceId = users_stocks.stockid
        WHERE dividends.userId = " . Auth::user()->id . "
        AND dividends.type = 3 
        AND users_stocks.Id = " . $id . "
        GROUP BY YEAR(dividends.efectiveDate), MONTH(dividends.efectiveDate);");

        
        $LastMonth = null;
        $DividendGraphCopy = [];

        foreach($DividendGraph as $Div ){
            if($LastMonth != null){
                if($LastMonth < 12){
                    while($LastMonth + 1 != $Div->month){
                        if($LastMonth == 12)
                            $DividendGraphCopy[] = ["year" => $Div->year, "month" => 1, "amount" => 0];
                        else
                            $DividendGraphCopy[] = ["year" => $Div->year, "month" => $LastMonth + 1, "amount" => 0];

                        $LastMonth++;
                        if($LastMonth == 13)
                            $LastMonth = 1;
                    }
                    $DividendGraphCopy[] = ["year" => $Div->year, "month" => $LastMonth + 1, "amount" => $Div->amount];
                }
                else{
                    $DividendGraphCopy[] = ["year" => $Div->year, "month" => 1, "amount" => $Div->amount];
                }
            }
            else{
                $DividendGraphCopy[] = ["year" => $Div->year, "month" => $Div->month, "amount" => $Div->amount];
            }

            if($LastMonth == 12)
                $LastMonth = 1;
            else
                $LastMonth = $Div->month;
        }

        $recovery = Round($dividends->sum('amount') / ($UserStock->quantity * $UserStock->averagePrice) * 100,2);

        $data['userstock'] = $UserStock;
        $data['dividends'] = $dividends;
        $data['recovery'] = $recovery;
        $data['dividendGraph'] = $DividendGraphCopy;//LISTO


        return view('fibras.show', $data);

    }
}