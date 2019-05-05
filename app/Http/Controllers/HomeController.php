<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Models\Parcel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, Parcel $parcel)
    {
        return view('home')->with([ 'parcels' => $parcel->orderBy('created_at', 'desc')->simplePaginate(15) ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }

    public function profile(Request $request, User $user)
    {
        return response()->json($user->profile);
    }
}
