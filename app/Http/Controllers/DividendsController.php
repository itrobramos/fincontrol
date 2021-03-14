<?php

namespace App\Http\Controllers;

use App\View;
use DB;
use Auth;
use App\Models\Dividend;
use App\Models\Stock;
use App\Models\UserStock;
use App\Models\SnowballODI;
use App\Models\SnowballProject;


use Illuminate\Http\Request;

class DividendsController extends Controller
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
        //Tabla
        $dividendsSnowball = Dividend::join('snowball_proyects', 'dividends.referenceId', '=', 'snowball_proyects.id')->where('dividends.type','4')->where('dividends.userId', Auth::user()->id)->get(); 
        $dividendsFibras = Dividend::join('stocks', 'dividends.referenceId', '=', 'stocks.id')->where('dividends.type','3')->where('dividends.userId', Auth::user()->id)->get(); 
        $dividendsStocks = Dividend::join('stocks', 'dividends.referenceId', '=', 'stocks.id')->where('dividends.type','1')->where('dividends.userId', Auth::user()->id)->get(); 
        $dividendAll = $dividendsSnowball;
        $dividendAll = $dividendsSnowball->toBase()->merge($dividendsFibras)->toBase()->merge($dividendsStocks);

        //Grafico
        $DividendGraph = DB::select("SELECT YEAR(efectiveDate) year, MONTH(efectiveDate) month, SUM(Amount) amount FROM dividends
        WHERE userId = " . Auth::user()->id . " 
        GROUP BY YEAR(efectiveDate), MONTH(efectiveDate);");

        //Indicadores
        $indicadores['history'] = Dividend::sum('amount');
        $indicadores['year'] = Dividend::whereYear('efectiveDate', now()->year)->sum('amount');
        $indicadores['month'] = Dividend::whereYear('efectiveDate', now()->year)->whereMonth('efectiveDate', now()->month)->sum('amount');

        
        $data["dividends"] = $dividendAll->sortBy('efectiveDate');
        $data["dividendGraph"] = $DividendGraph;
        $data["indicadores"] = $indicadores;


        return view('dividends.index', $data);
    }

    public function add()
    {
        date_default_timezone_set('America/Monterrey');
        $fibras = Stock::join('Users_Stocks','Users_Stocks.StockId', '=', 'Stocks.Id')
                        ->join('Brokers', 'Brokers.id', '=', 'Users_Stocks.brokerId')
                        ->join('Currencies', 'Currencies.id', '=', 'Users_Stocks.currencyId')
                        ->where('Users_Stocks.UserId', '=', Auth::user()->id)
                        ->where('Stocks.stockTypeId', '=', 3)
                        ->orderBy('Stocks.name', 'Asc')
                        ->select('Users_Stocks.*','Users_Stocks.id as iduserstock', 'Brokers.name as broker','Stocks.*','Currencies.symbol as currency')
                        ->get()
                        ;

        $stocks = Stock::join('Users_Stocks','Users_Stocks.StockId', '=', 'Stocks.Id')
                        ->join('Brokers', 'Brokers.id', '=', 'Users_Stocks.brokerId')
                        ->join('Currencies', 'Currencies.id', '=', 'Users_Stocks.currencyId')
                        ->where('Users_Stocks.UserId', '=', Auth::user()->id)
                        ->where('Stocks.stockTypeId', '=', 1)
                        ->orderBy('Stocks.name', 'Asc')
                        ->select('Users_Stocks.*','Users_Stocks.id as iduserstock', 'Brokers.name as broker','Stocks.*','Currencies.symbol as currency')
                        ->get()
                        ;

        $odis = DB::select("SELECT p.id, p.name Name, p.imageUrl, SUM(quantity) quantity, o.ODIPrice * SUM(quantity) investment
                            FROM snowball_odis o INNER JOIN snowball_proyects p ON o.snowballProjectId = p.id GROUP BY p.name, p.imageUrl ORDER BY p.name asc");
                                

        $data['fibras'] = $fibras;
        $data['stocks'] = $stocks;
        $data['odis'] = $odis;


        return view('dividends.add',$data);
    }

    public function save(Request $request){

        $type = $request->type;

        $Dividend = new Dividend();
        $Dividend->type = $type;

        if($type == 1)
            $Dividend->referenceId = $request->stock;
        else if($type == 2)
            $Dividend->referenceId = $request->etf;
        else if($type == 3)
            $Dividend->referenceId = $request->fibra;
        else if($type == 4)
            $Dividend->referenceId = $request->odi;

        $Dividend->efectiveDate = $request->date;
        $Dividend->amount = $request->amount;
        $Dividend->stocksCount = $request->stockCount;
        $Dividend->currencyId = $request->currency;
        $Dividend->UserId = Auth::user()->id;

        $Dividend->save();

        return redirect('/dividends');
    }


}