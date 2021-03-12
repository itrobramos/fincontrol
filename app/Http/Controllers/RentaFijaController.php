<?php

namespace App\Http\Controllers;

use App\View;
use DB;

use Illuminate\Http\Request;
use App\Models\FixedRentPlatform;

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
}