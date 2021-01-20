<?php

namespace App\Http\Controllers;

use App\View;
use DB;

use Illuminate\Http\Request;

class FibrasController extends Controller
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
        return view('fibras');//Client dashboard
    }
}