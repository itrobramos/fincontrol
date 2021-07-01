<?php

namespace App\Http\Controllers;

use App\View;
use App\Models\Fintech;
use App\Models\FintechPayment;
use Auth;
use DB;

use Illuminate\Http\Request;

class FintechController extends Controller
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
        $Fintechs = Fintech::where('active', 1)->get();
        $data['fintechs'] = $Fintechs;
        return view('fintech.index', $data);
    }

    public function incomes(){
         //Tabla
         $IncomesRedGirasol = FintechPayment::join('redgirasol_projects', 'fintech_payments.referenceId', '=', 'redgirasol_projects.id')->join('fintechs', 'fintechs.id', '=', 'fintech_payments.type')->where('fintech_payments.type','2')->where('fintech_payments.userId', Auth::user()->id)->select('fintech_payments.*','fintechs.name as fintech', 'fintechs.imageUrl as logoFintech', 'redgirasol_projects.*')->get(); 
         $IncomesMonific = FintechPayment::join('realestate_projects', 'fintech_payments.referenceId', '=', 'realestate_projects.id')->join('fintechs', 'fintechs.id', '=', 'realestate_projects.fintechId')->where('fintech_payments.type','1')->where('fintech_payments.userId', Auth::user()->id)->select('fintech_payments.*','fintechs.name as fintech', 'fintechs.imageUrl as logoFintech', 'realestate_projects.*')->get(); 
         $IncomesLeasing = FintechPayment::join('leasing_projects', 'fintech_payments.referenceId', '=', 'leasing_projects.id')->join('fintechs', 'fintechs.id', '=', 'fintech_payments.type')->where('fintech_payments.type','4')->where('fintech_payments.userId', Auth::user()->id)->select('fintech_payments.*','fintechs.name as fintech', 'fintechs.imageUrl as logoFintech', 'leasing_projects.*')->get(); 


         $IncomesAll = $IncomesRedGirasol;
         $IncomesAll = $IncomesRedGirasol->toBase()->merge($IncomesMonific)->toBase()->merge($IncomesLeasing)->toBase();

         //Grafico
         $PaymentsGraph = DB::select("SELECT YEAR(efectiveDate) year, MONTH(efectiveDate) month, SUM(Amount) amount FROM fintech_payments
         WHERE userId = " . Auth::user()->id . " 
         GROUP BY YEAR(efectiveDate), MONTH(efectiveDate);");
 
         //Indicadores
         $indicadores['history'] = FintechPayment::where('userId', Auth::user()->id)->sum('amount');
         $indicadores['year'] = FintechPayment::whereYear('efectiveDate', now()->year)->where('userId', Auth::user()->id)->sum('amount');
         $indicadores['month'] = FintechPayment::whereYear('efectiveDate', now()->year)->whereMonth('efectiveDate', now()->month)->where('userId', Auth::user()->id)->sum('amount');
 
         $data["incomes"] = $IncomesAll->sortByDesc('efectiveDate');
         $data["paymentGraph"] = $PaymentsGraph;

         $data["indicadores"] = $indicadores;
 
         return view('dividends.incomes', $data);
    }
}