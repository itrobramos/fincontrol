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
     public function __construct()
     {
         $this->middleware('auth', ['except' => ['login']]);
     }


    public function index()
    {
        $odis = DB::select("SELECT p.id, p.name Name, p.imageUrl, SUM(quantity) quantity, o.ODIPrice * SUM(quantity) investment
        FROM snowball_odis o INNER JOIN snowball_proyects p ON o.snowballProjectId = p.id WHERE o.userId = " . Auth::user()->id . " GROUP BY p.name, p.imageUrl ORDER BY p.name asc");

        $paids = DB::select("SELECT DATE_ADD(MAKEDATE(year(now()), day(efectiveDate) + 5), INTERVAL (month(now()))-1 MONTH) date, p.name
                FROm snowball_odis o inner join snowball_proyects p on o.snowballProjectId = p.id
                WHERE o.userId = " . Auth::user()->id . "
                GROUP BY year(now()), month(now()) , day(efectiveDate) + 5");

        $data['paids'] = $paids;


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
            $filename = 'uploads/pdf/snowball/' . strtolower(str_replace($request->symbol," ","")) . time() . '.' . strtolower($extension);
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

        $DividendGraph = DB::select("SELECT YEAR(efectiveDate) year, MONTH(efectiveDate) month, SUM(Amount) amount, 1 as Type
        FROM dividends
        WHERE userId = " . Auth::user()->id . " 
        AND type = 4 
        AND referenceId = " . $id . "
        GROUP BY YEAR(efectiveDate), MONTH(efectiveDate);");

        $LastMonth = null;
        $DividendGraphCopy = [];

        foreach($DividendGraph as $Div ){
            if($LastMonth != null){
                if($LastMonth < 12){
                    while($LastMonth + 1 != $Div->month){
                        $DividendGraphCopy[] = ["year" => $Div->year, "month" => $LastMonth + 1, "amount" => 0];
                        $LastMonth++;
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

        $shares = SnowballODI::where('userId', Auth::user()->id)->where('snowballprojectid',$odis[0]->id)->get();
        $dividends = Dividend::join('snowball_proyects', 'dividends.referenceId', '=', 'snowball_proyects.id')->where('dividends.type','4')->where('snowball_proyects.id', $id)->where('userId', Auth::user()->id)->get(); 
        $recovery = Round($dividends->sum('amount') / $odis[0]->investment * 100,2);

        $data['odi'] = $odis[0];
        $data['shares'] = $shares;
        $data['dividends'] = $dividends;
        $data['dividendGraph'] = $DividendGraphCopy;//LISTO
        $data['recovery'] = $recovery;

        return view('snowball.show', $data);

    }

    public function edit($id)
    {
        date_default_timezone_set('America/Monterrey');
        $ODI = SnowballODI::find($id);
        $data['ODI'] = $ODI;
        return view('snowball.edit',$data);
    }

    public function update(Request $request, $id){

        $SnowballODI = SnowballODI::find($id);
        $SnowballODI->dividend = $request->dividend;
        $SnowballODI->bono = $request->bono;
        $SnowballODI->frequency = $request->frequency;
        
        $SnowballODI->ODIPrice = $request->price;
        $SnowballODI->quantity= $request->quantity;
        $SnowballODI->efectiveDate = $request->efectiveDate;

        if($file=$request->file('pdf')){
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = 'uploads/pdf/snowball/' . strtolower(str_replace($request->symbol," ","")) . time() . '.' . strtolower($extension);
            $file->move('public/uploads/pdf/snowball/', $filename);
            $SnowballODI->pdfURL = $filename;            
        }
        
        $SnowballODI->save();
        return redirect('/snowball/'. $SnowballODI->snowballProjectId  );
    }

    public function destroy($id)
    {
        SnowballODI::destroy($id);
        return redirect('/snowball')->with('Message', 'ODI(s) eliminada(s) correctamente');

    }
}