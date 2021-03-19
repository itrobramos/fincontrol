<?php

namespace App\Http\Controllers;

use App\View;
use DB;
use Auth;
use App\Models\Dividend;
use App\Models\SnowballODI;
use App\Models\SnowballProject;
use Image;


use Illuminate\Http\Request;

class SnowballController extends Controller
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
        $odis = DB::select("SELECT p.id, p.name Name, p.imageUrl, SUM(quantity) quantity, o.ODIPrice * SUM(quantity) investment
        FROM snowball_odis o INNER JOIN snowball_proyects p ON o.snowballProjectId = p.id WHERE o.userId = " . Auth::user()->id . " GROUP BY p.name, p.imageUrl ORDER BY p.name asc");


        $data['odis'] = $odis;
        return view('snowball.index', $data);
    }

    public function add()
    {
        date_default_timezone_set('America/Monterrey');
        $projects = SnowballProject::orderBy('name','asc')->get();
        $data['projects'] = $projects;
        return view('snowball.add', $data);
    }

    public function save(Request $request){


        $SnowballODI = new SnowballODI();
        $SnowballODI->snowballProjectId = $request->projectId;
        $SnowballODI->ODIPrice = $request->price;
        $SnowballODI->quantity= $request->shares;
        $SnowballODI->transationDate= $request->transactiondate;
        $SnowballODI->efectiveDate = $request->efectivedate;
        $SnowballODI->userId = Auth::user()->id;


        if($file=$request->file('pdf')){
            $name=$file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = 'public/uploads/pdf/snowball/' . strtolower(str_replace($request->symbol," ","")) . time() . '.' . strtolower($extension);
            $file->move('public/uploads/pdf/snowball/', $filename);
            $SnowballODI->pdfURL = $filename;            
        }
        $SnowballODI->save();
        return redirect('/snowball');
    }

    public function show($id){

        $odis = DB::select("SELECT p.id, p.name Name, p.imageUrl, SUM(quantity) quantity, o.ODIPrice * SUM(quantity) investment
                            FROM snowball_odis o INNER JOIN snowball_proyects p ON o.snowballProjectId = p.id 
                            WHERE p.id = ". $id . " AND o.userId = " . Auth::user()->id . " GROUP BY p.name, p.imageUrl");

        $shares = SnowballODI::where('userId', Auth::user()->id)->where('snowballprojectid',$odis[0]->id)->get();
        $dividends = Dividend::join('snowball_proyects', 'dividends.referenceId', '=', 'snowball_proyects.id')->where('dividends.type','4')->where('snowball_proyects.id', $id)->where('userId', Auth::user()->id)->get(); 
        $recovery = Round($dividends->sum('amount') / $odis[0]->investment * 100,2);

        $data['odi'] = $odis[0];
        $data['shares'] = $shares;
        $data['dividends'] = $dividends;
        $data['recovery'] = $recovery;

        return view('snowball.show', $data);

    }

    public function edit($id)
    {
        date_default_timezone_set('America/Monterrey');
        $project = SnowballProject::find($id);
        $data['project'] = $project;
        return view('snowballprojects.edit',$data);
    }

    public function update(Request $request, $id){

        $SnowballProject = SnowballProject::find($id);
        $SnowballProject->name = $request->name;
        $SnowballProject->ODIPrice = $request->price;
        $SnowballProject->estimatedDividend= $request->estimatedDividend;
        $SnowballProject->dividendPeriod= $request->dividendPeriod;
        $SnowballProject->offering= $request->offering;
        $SnowballProject->shares= $request->shares;

        if($file=$request->file('image')){
            $name=$file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = 'public/uploads/images/snowball/' . strtolower(str_replace($request->symbol," ","")) . time() . '.' . strtolower($extension);
            $file->move('public/uploads/images/snowball/', $filename);
            $SnowballProject->imageUrl = $filename;            
        }
        
        $SnowballProject->save();
        return redirect('/snowballprojects');
    }

    public function destroy($id)
    {
        SnowballODI::destroy($id);
        return redirect('/snowball')->with('Message', 'ODI(s) eliminada(s) correctamente');

    }
}