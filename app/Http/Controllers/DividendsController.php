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
use Ramsey\Collection\Collection;


use Illuminate\Http\Request;

class DividendsController extends Controller
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
        //Tabla
        $dividendsSnowball = Dividend::join('snowball_proyects', 'dividends.referenceId', '=', 'snowball_proyects.id')->where('dividends.type','4')->where('dividends.userId', Auth::user()->id)->get(); 
        $dividendsFibras = Dividend::join('stocks', 'dividends.referenceId', '=', 'stocks.id')->where('dividends.type','3')->where('dividends.userId', Auth::user()->id)->get(); 
        $dividendsstocks = Dividend::join('stocks', 'dividends.referenceId', '=', 'stocks.id')->where('dividends.type','1')->where('dividends.userId', Auth::user()->id)->get(); 
        $dividendAll = $dividendsSnowball;
        $dividendAll = $dividendsSnowball->toBase()->merge($dividendsFibras)->toBase()->merge($dividendsstocks);

        //Grafico
        $DividendGraph = DB::select("SELECT YEAR(efectiveDate) year, MONTH(efectiveDate) month, SUM(Amount) amount FROM dividends
        WHERE userId = " . Auth::user()->id . " 
        GROUP BY YEAR(efectiveDate), MONTH(efectiveDate);");

        $PaymentsGraph = DB::select("SELECT YEAR(efectiveDate) year, MONTH(efectiveDate) month, SUM(Amount) amount FROM fintech_payments
        WHERE userId = " . Auth::user()->id . " 
        GROUP BY YEAR(efectiveDate), MONTH(efectiveDate);");

        $dividendallcollection = collect($dividendAll)->sortBy('name')->groupBy('name')->map(function ($row) {
            return $row->sum('amount') ;
        });

        $dividendCompaniesGraph = $dividendallcollection;

        //Indicadores
        $indicadores['history'] = Dividend::where('dividends.userId', Auth::user()->id)->sum('amount');
        $indicadores['year'] = Dividend::whereYear('efectiveDate', now()->year)->where('dividends.userId', Auth::user()->id)->sum('amount');
        $indicadores['month'] = Dividend::whereYear('efectiveDate', now()->year)->whereMonth('efectiveDate', now()->month)->where('dividends.userId', Auth::user()->id)->sum('amount');

        $data["dividends"] = $dividendAll->sortByDesc('efectiveDate');
        $data["dividendGraph"] = $DividendGraph;
        $data["paymentGraph"] = $PaymentsGraph;

        $data["dividendCompaniesGraph"] = $dividendCompaniesGraph;
        $data["indicadores"] = $indicadores;

        return view('dividends.index', $data);
    }

    public function add()
    {
        date_default_timezone_set('America/Monterrey');
        $fibras = Stock::join('users_stocks','users_stocks.stockId', '=', 'stocks.Id')
                        ->join('brokers', 'brokers.id', '=', 'users_stocks.brokerId')
                        ->join('currencies', 'currencies.id', '=', 'users_stocks.currencyId')
                        ->where('users_stocks.UserId', '=', Auth::user()->id)
                        ->where('stocks.stockTypeId', '=', 3)
                        ->orderBy('stocks.name', 'Asc')
                        ->select('users_stocks.*','users_stocks.id as iduserstock', 'brokers.name as broker','stocks.*','currencies.symbol as currency')
                        ->get()
                        ;

        $stocks = Stock::join('users_stocks','users_stocks.stockId', '=', 'stocks.Id')
                        ->join('brokers', 'brokers.id', '=', 'users_stocks.brokerId')
                        ->join('currencies', 'currencies.id', '=', 'users_stocks.currencyId')
                        ->where('users_stocks.UserId', '=', Auth::user()->id)
                        ->where('stocks.stockTypeId', '=', 1)
                        ->orderBy('stocks.name', 'Asc')
                        ->select('users_stocks.*','users_stocks.id as iduserstock', 'brokers.name as broker','stocks.*','currencies.symbol as currency')
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