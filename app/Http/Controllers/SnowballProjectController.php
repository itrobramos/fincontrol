<?php

namespace App\Http\Controllers;

use App\View;
use DB;
use Auth;
use App\Models\SnowballProject;
use Image;


use Illuminate\Http\Request;

class SnowballProjectController extends Controller
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
        $projects = SnowballProject::orderBy('name','asc')->get();
        $data['projects'] = $projects;
        return view('snowballprojects.index', $data);
    }

    public function add()
    {
        date_default_timezone_set('America/Monterrey');
        return view('snowballprojects.add');
    }

    public function save(Request $request){

        $SnowballProject = new SnowballProject();
        $SnowballProject->name = $request->name;
        $SnowballProject->ODIPrice = $request->price;
        $SnowballProject->estimatedDividend= $request->estimatedDividend;
        $SnowballProject->dividendPeriod= $request->dividendPeriod;
        $SnowballProject->offering= $request->offering;
        $SnowballProject->shares= $request->shares;

        if($file=$request->file('image')){
            $name=$file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = 'uploads/images/snowball/' . strtolower(str_replace($request->symbol," ","")) . time() . '.' . strtolower($extension);
            $file->move('public/uploads/images/snowball/', $filename);
            $SnowballProject->imageUrl = $filename;            
        }
        $SnowballProject->save();
        return redirect('/snowballprojects');
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
            $filename = 'uploads/images/snowball/' . strtolower(str_replace($request->symbol," ","")) . time() . '.' . strtolower($extension);
            $file->move('public/uploads/images/snowball/', $filename);
            $SnowballProject->imageUrl = $filename;            
        }
        
        $SnowballProject->save();
        return redirect('/snowballprojects');
    }
}