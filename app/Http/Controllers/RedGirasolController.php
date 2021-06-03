<?php

namespace App\Http\Controllers;

use App\View;
use DB;
use Auth;
use App\Models\Exchange;
use App\Models\RedGirasolProject;
use App\Models\FintechPayment;
use Image;


use Illuminate\Http\Request;

class RedGirasolController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login']]);
    }

    public function index()
    {
        $projects = RedGirasolProject::where('userId', '=', Auth::user()->id)
                                ->where('investment', '>', 0)
                                ->get();

        $exchange = Exchange::where('date', DB::raw("(select max(`date`) from exchanges)"))
                            ->where('currencyIdDestiny', '=', 1)
                            ->where('currencyIdOrigin', '=', 2)
                            ->first()->price;    

        $RGprojects = [];
        
        foreach($projects as $project){

            if($project->currencyId == 1)
                $Inversion = $project->investment;
            else if($project->currencyId == 2)
                $Inversion = $project->investment *  $exchange;

            $RGprojects[] = ["Id" => $project->id,
                             "RGId" => $project->rgid,
                             "Tipo" => $project->type,
                             "Calificacion" => $project->qualification,
                             "Nombre" => $project->name,
                             "Estatus" => $project->status,
                             "Inversion" => Round($Inversion,2),
                             "Tasa" => $project->rate,
                             "Imagen" => $project->imageUrl
                        ];
        }
        

        $data['projects'] = $RGprojects;
    
        
        return view('redgirasol.index', $data);
    }

    public function add()
    {
        date_default_timezone_set('America/Monterrey');
        return view('redgirasol.add');
    }

    public function save(Request $request){

        
        $RedGirasolProject = new RedGirasolProject();
        $RedGirasolProject->UserId = Auth::user()->id;

        $RedGirasolProject->rgid = $request->id;
        $RedGirasolProject->name = $request->name;
        $RedGirasolProject->type = $request->type;
        $RedGirasolProject->qualification = $request->qualification;
        $RedGirasolProject->status = $request->status;
        $RedGirasolProject->investment = $request->investment;
        $RedGirasolProject->monthly_estimated = $request->monthly_estimated;
        $RedGirasolProject->rate = $request->rate;
        $RedGirasolProject->months = $request->months;
        $RedGirasolProject->currencyId = $request->currency;


        if($request->date != null)
            $RedGirasolProject->transactionDate = $request->date;
        
        if($file=$request->file('image')){
            $name=$file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = 'uploads/images/' . strtolower(str_replace($request->rgid," ","")) . time() . '.' . strtolower($extension);
            $file->move('public/uploads/images/', $filename);
            
            $RedGirasolProject->imageUrl = $filename;
        }

        
        $RedGirasolProject->save();

        return redirect('/redgirasol');
    }

    public function edit($id)
    {
        date_default_timezone_set('America/Monterrey');
        $project = RedGirasolProject::find($id);
        $data['project'] = $project;
        return view('redgirasol.edit',$data);
    }
  
    public function update(Request $request, $id){

        $RedGirasolProject = RedGirasolProject::find($id);

        $RedGirasolProject->rgid = $request->id;
        $RedGirasolProject->name = $request->name;
        $RedGirasolProject->type = $request->type;
        $RedGirasolProject->qualification = $request->qualification;
        $RedGirasolProject->status = $request->status;
        $RedGirasolProject->investment = $request->investment;
        $RedGirasolProject->monthly_estimated = $request->monthly_estimated;
        $RedGirasolProject->rate = $request->rate;
        $RedGirasolProject->months = $request->months;
        $RedGirasolProject->currencyId = $request->currency;

        if($request->date != null)
            $RedGirasolProject->transactionDate = $request->date;
        
        if($file=$request->file('image')){
            $name=$file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = 'uploads/images/' . strtolower(str_replace($request->rgid," ","")) . time() . '.' . strtolower($extension);
            $file->move('public/uploads/images/', $filename);
            
            $RedGirasolProject->imageUrl = $filename;
        }
        
        $RedGirasolProject->save();

        return redirect('/redgirasol');
    }


    public function show($id){

        $RedGirasolProject = RedGirasolProject::find($id);

         $dividends = FintechPayment::join('redgirasol_projects', 'fintech_payments.referenceId', '=', 'redgirasol_projects.id')
                     ->where('fintech_payments.type','2')
                     ->where('fintech_payments.userId', Auth::user()->id)
                     ->where('fintech_payments.referenceId', $id)
                     ->get(); 

         $recovery = Round($dividends->sum('amount') / ($RedGirasolProject->investment) * 100,2);

        $data['project'] = $RedGirasolProject;
        $data['dividends'] = $dividends;
        $data['recovery'] = $recovery;

        return view('redgirasol.show', $data);

    }


    public function payment($id){

        $RedGirasolProject = RedGirasolProject::find($id);

        $data['project'] = $RedGirasolProject;

        return view('redgirasol.payment', $data);
    }

    public function savePayment(Request $request, $id){
        
        $RedGirasolProject = RedGirasolProject::find($id);

        $Payment = new FintechPayment();

        $Payment->paymentNo = $request->paymentNo;
        $Payment->type = 1;
        $Payment->referenceId = $id;
        $Payment->efectiveDate = $request->date;
        $Payment->amount = $request->amount;
        $Payment->currencyId = $request->currency;
        $Payment->userId = Auth::user()->id;
        $Payment->save();
        

        return redirect('/redgirasol/'.$id);
    }
}