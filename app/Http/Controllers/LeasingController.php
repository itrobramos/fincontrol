<?php

namespace App\Http\Controllers;

use App\View;
use DB;
use Auth;
use App\Models\Exchange;
use App\Models\LeasingProject;
use App\Models\Fintech;
use App\Models\FintechPayment;
use Image;


use Illuminate\Http\Request;

class LeasingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login']]);
    }

    public function index($name)
    {

        $Fintech = Fintech::where('name', $name)->first();

        $projects = LeasingProject::where('userId', '=', Auth::user()->id)
            ->where('fintechId', $Fintech->id)
            ->where('investment', '>', 0)
            ->get();

        $exchange = Exchange::where('date', DB::raw("(select max(`date`) from exchanges)"))
            ->where('currencyIdDestiny', '=', 1)
            ->where('currencyIdOrigin', '=', 2)
            ->first()->price;

        $REprojects = [];

        foreach ($projects as $project) {

            if ($project->currencyId == 1)
                $Inversion = $project->investment;
            else if ($project->currencyId == 2)
                $Inversion = $project->investment *  $exchange;

            $REprojects[] = [
                "Id" => $project->id,
                "Tipo" => $project->type,
                "Nombre" => $project->name,
                "Estatus" => $project->status,
                "Inversion" => Round($Inversion, 2),
                "Tasa" => $project->rate,
                "Imagen" => $project->imageUrl
            ];
        }


        $data['projects'] = $REprojects;
        $data['fintech'] = $Fintech;


        return view('leasing.index', $data);
    }

    public function add($name)
    {
        date_default_timezone_set('America/Monterrey');
        $Fintech = Fintech::where('name', $name)->first();
        $data['fintech'] = $Fintech;
        return view('leasing.add', $data);
    }

    public function save(Request $request, $name)
    {

        $Fintech = Fintech::where('name', $name)->first();

        $LeasingProject = new LeasingProject();
        $LeasingProject->UserId = Auth::user()->id;

        $LeasingProject->name = $request->name;
        $LeasingProject->type = $request->type;
        $LeasingProject->status = $request->status;
        $LeasingProject->investment = $request->investment;
        $LeasingProject->monthly_estimated = $request->monthly_estimated;
        $LeasingProject->rate = $request->rate;
        $LeasingProject->months = $request->months;
        $LeasingProject->currencyId = $request->currency;
        $LeasingProject->fintechId = $Fintech->id;
        $LeasingProject->information = $request->information;


        if ($request->date != null)
            $LeasingProject->transactionDate = $request->date;

        if ($file = $request->file('image')) {
            $name = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = 'uploads/images/' . strtolower(str_replace($request->rgid, " ", "")) . time() . '.' . strtolower($extension);
            $file->move('public/uploads/images/', $filename);

            $LeasingProject->imageUrl = $filename;
        }


        $LeasingProject->save();

        return redirect('/leasing/' . $Fintech->name);
    }

    public function edit($id)
    {
        date_default_timezone_set('America/Monterrey');
        $project = LeasingProject::find($id);
        $data['project'] = $project;

        $Fintech = Fintech::where('id', $project->fintechId)->first();
        $data['fintech'] = $Fintech;
        return view('leasing.edit', $data);
    }

    public function update(Request $request, $id)
    {

        $LeasingProject = LeasingProject::find($id);
        $Fintech = Fintech::where('id', $LeasingProject->fintechId)->first();

        $LeasingProject->name = $request->name;
        $LeasingProject->type = $request->type;
        $LeasingProject->status = $request->status;
        $LeasingProject->investment = $request->investment;
        $LeasingProject->monthly_estimated = $request->monthly_estimated;
        $LeasingProject->rate = $request->rate;
        $LeasingProject->months = $request->months;
        $LeasingProject->currencyId = $request->currency;
        $LeasingProject->information = $request->information;

        if ($request->date != null)
            $LeasingProject->transactionDate = $request->date;

        if ($file = $request->file('image')) {
            $name = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = 'uploads/images/' . strtolower(str_replace($request->rgid, " ", "")) . time() . '.' . strtolower($extension);
            $file->move('public/uploads/images/', $filename);

            $LeasingProject->imageUrl = $filename;
        }

        $LeasingProject->save();

        return redirect('/leasing/' . $Fintech->name);
    }


    public function show($name, $id)
    {
        $LeasingProject = LeasingProject::find($id);
        $Fintech = Fintech::where('name', $name)->first();

        $dividends = FintechPayment::join('leasing_projects', 'fintech_payments.referenceId', '=', 'leasing_projects.id')
            ->where('fintech_payments.type', $Fintech->id)
            ->where('fintech_payments.userId', Auth::user()->id)
            ->where('fintech_payments.referenceId', $id)
            ->get();

        $recovery = Round($dividends->sum('amount') / ($LeasingProject->investment) * 100, 2);

        $data['project'] = $LeasingProject;
        $data['dividends'] = $dividends;
        $data['recovery'] = $recovery;

        return view('leasing.show', $data);
    }


    public function payment($name, $id)
    {

        $LeasingProject = LeasingProject::find($id);
        $Fintech = Fintech::where('id', $LeasingProject->fintechId)->first();

        $data['project'] = $LeasingProject;
        $data['fintech'] = $Fintech;

        return view('leasing.payment', $data);
    }

    public function savePayment(Request $request, $name, $id)
    {

        $LeasingProject = LeasingProject::find($id);
        $Fintech = Fintech::where('id', $LeasingProject->fintechId)->first();

        $Payment = new FintechPayment();

        $Payment->paymentNo = $request->paymentNo;
        $Payment->type = $Fintech->id;
        $Payment->referenceId = $id;
        $Payment->efectiveDate = $request->date;
        $Payment->amount = $request->amount;
        $Payment->currencyId = $request->currency;
        $Payment->userId = Auth::user()->id;
        $Payment->save();


        return redirect('/leasing/'.$Fintech->name . '/'. $id);
    }
}
