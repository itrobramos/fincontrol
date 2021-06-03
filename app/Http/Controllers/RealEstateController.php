<?php

namespace App\Http\Controllers;

use App\View;
use DB;
use Auth;
use App\Models\Exchange;
use App\Models\RealEstateProject;
use App\Models\Fintech;
use App\Models\FintechPayment;
use Image;


use Illuminate\Http\Request;

class RealEstateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login']]);
    }

    public function index($name)
    {

        $Fintech = Fintech::where('name', $name)->first();

        $projects = RealEstateProject::where('userId', '=', Auth::user()->id)
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


        return view('realestate.index', $data);
    }

    public function add($name)
    {
        date_default_timezone_set('America/Monterrey');
        $Fintech = Fintech::where('name', $name)->first();
        $data['fintech'] = $Fintech;
        return view('realestate.add', $data);
    }

    public function save(Request $request, $name)
    {

        $Fintech = Fintech::where('name', $name)->first();

        $RealEstateProject = new RealEstateProject();
        $RealEstateProject->UserId = Auth::user()->id;

        $RealEstateProject->name = $request->name;
        $RealEstateProject->type = $request->type;
        $RealEstateProject->status = $request->status;
        $RealEstateProject->investment = $request->investment;
        $RealEstateProject->monthly_estimated = $request->monthly_estimated;
        $RealEstateProject->rate = $request->rate;
        $RealEstateProject->months = $request->months;
        $RealEstateProject->currencyId = $request->currency;
        $RealEstateProject->fintechId = $Fintech->id;
        $RealEstateProject->information = $request->information;


        if ($request->date != null)
            $RealEstateProject->transactionDate = $request->date;

        if ($file = $request->file('image')) {
            $name = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = 'uploads/images/' . strtolower(str_replace($request->rgid, " ", "")) . time() . '.' . strtolower($extension);
            $file->move('public/uploads/images/', $filename);

            $RealEstateProject->imageUrl = $filename;
        }


        $RealEstateProject->save();

        return redirect('/realestate/' . $Fintech->name);
    }

    public function edit($id)
    {
        date_default_timezone_set('America/Monterrey');
        $project = RealEstateProject::find($id);
        $data['project'] = $project;

        $Fintech = Fintech::where('id', $project->fintechId)->first();
        $data['fintech'] = $Fintech;
        return view('realestate.edit', $data);
    }

    public function update(Request $request, $id)
    {

        $RealEstateProject = RealEstateProject::find($id);
        $Fintech = Fintech::where('id', $RealEstateProject->fintechId)->first();

        $RealEstateProject->name = $request->name;
        $RealEstateProject->type = $request->type;
        $RealEstateProject->status = $request->status;
        $RealEstateProject->investment = $request->investment;
        $RealEstateProject->monthly_estimated = $request->monthly_estimated;
        $RealEstateProject->rate = $request->rate;
        $RealEstateProject->months = $request->months;
        $RealEstateProject->currencyId = $request->currency;
        $RealEstateProject->information = $request->information;

        if ($request->date != null)
            $RealEstateProject->transactionDate = $request->date;

        if ($file = $request->file('image')) {
            $name = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = 'uploads/images/' . strtolower(str_replace($request->rgid, " ", "")) . time() . '.' . strtolower($extension);
            $file->move('public/uploads/images/', $filename);

            $RealEstateProject->imageUrl = $filename;
        }

        $RealEstateProject->save();

        return redirect('/realestate/' . $Fintech->name);
    }


    public function show($name, $id)
    {
        $RealEstateProject = RealEstateProject::find($id);
        $Fintech = Fintech::where('name', $name)->first();

        $dividends = FintechPayment::join('realestate_projects', 'fintech_payments.referenceId', '=', 'realestate_projects.id')
            ->where('fintech_payments.type', $Fintech->id)
            ->where('fintech_payments.userId', Auth::user()->id)
            ->where('fintech_payments.referenceId', $id)
            ->get();

        $recovery = Round($dividends->sum('amount') / ($RealEstateProject->investment) * 100, 2);

        $data['project'] = $RealEstateProject;
        $data['dividends'] = $dividends;
        $data['recovery'] = $recovery;

        return view('realestate.show', $data);
    }


    public function payment($name, $id)
    {

        $RealEstateProject = RealEstateProject::find($id);
        $Fintech = Fintech::where('id', $RealEstateProject->fintechId)->first();

        $data['project'] = $RealEstateProject;
        $data['fintech'] = $Fintech;

        return view('realestate.payment', $data);
    }

    public function savePayment(Request $request, $id)
    {

        $RealEstateProject = RealEstateProject::find($id);
        $Fintech = Fintech::where('id', $RealEstateProject->fintechId)->first();

        $Payment = new FintechPayment();

        $Payment->paymentNo = $request->paymentNo;
        $Payment->type = $Fintech->id;
        $Payment->referenceId = $id;
        $Payment->efectiveDate = $request->date;
        $Payment->amount = $request->amount;
        $Payment->currencyId = $request->currency;
        $Payment->userId = Auth::user()->id;
        $Payment->save();


        return redirect('/realestate/'.$Fintech->name . '/'. $id);
    }
}
