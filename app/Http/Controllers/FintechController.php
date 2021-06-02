<?php

namespace App\Http\Controllers;

use App\View;
use App\Models\Fintech;
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
}