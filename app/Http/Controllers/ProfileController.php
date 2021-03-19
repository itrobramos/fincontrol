<?php

namespace App\Http\Controllers;

use App\View;
use DB;
use Auth;
use App\Models\User;


use Illuminate\Http\Request;

class ProfileController extends Controller
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
        return view('profile.index');
    }

    public function update(Request $request){

        $user = User::find(Auth::user()->id);
        $user->name=$request->name;

        if($file=$request->file('image')){
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = 'public/uploads/userimages/' . strtolower(str_replace($request->symbol," ","")) . time() . '.' . strtolower($extension);
            $file->move('public/uploads/userimages/', $filename);
            $user->imageUrl = $filename;
        }
        
        $user->save();

        return redirect('/profile');
    }
}