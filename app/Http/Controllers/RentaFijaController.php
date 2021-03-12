<?php

namespace App\Http\Controllers;

use App\View;
use DB;
use Auth;
use Illuminate\Http\Request;
use App\Models\FixedRentPlatform;
use App\Models\FixedRentInvestments;

class RentaFijaController extends Controller
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
        $platforms = FixedRentPlatform::all();
        $data["platforms"] = $platforms;
        return view('rentafija.index', $data);
    }

    public function show($id){

        $platform = FixedRentPlatform::find($id);
        $investments = FixedRentInvestments::where('fixed_rent_platformsId', $id)->where('userId', Auth::user()->id)->get();
        
        $diario = 0;
        foreach($investments as $inv){
            $diario = $diario + (($inv->amount * ($inv->rate / 100)) / 365);
        }

        $data["platform"] = $platform;
        $data["investments"] = $investments;
        $data["diario"] = round($diario,2);


        return view('rentafija.show', $data);
    }

    public function add($id)
    {
        date_default_timezone_set('America/Monterrey');
        $platform = FixedRentPlatform::find($id);
        $data["platform"] = $platform;
        return view('rentafija.add', $data);
    }

    public function save(Request $request){


        $Investment = new FixedRentInvestments();
        $Investment->amount = $request->amount;
        $Investment->rate = $request->rate;
        $Investment->term = $request->term;
        $Investment->totalEarnings= $request->earnings;
        $Investment->daysCount = $request->paidDay;
        $Investment->dayFixed = $request->fixedDay;
        $Investment->initialDate = $request->initialDate;
        $Investment->endDate = $request->endDate;

        if(isset($request->reinvest))
            $Investment->reinvest = $request->reinvest;
        else
            $Investment->reinvest = false;
    
        $Investment->fixed_rent_platformsId = $request->platformId;
        $Investment->userId = Auth::user()->id;
        $Investment->save();

        return redirect('/rentafija/'. $request->platformId);
    }

}