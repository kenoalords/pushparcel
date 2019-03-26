<?php

namespace App\Http\Controllers;

use App\Models\Biker;
use Illuminate\Http\Request;

class BikerController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function index(Request $request, Biker $bikers)
    {
        $all_bikers = $bikers->get();
        return view('biker.index')->with([ 'bikers' => $all_bikers ]);
    }

    public function add(Request $request, Biker $biker)
    {
        $this->validate($request, [
            'fullname' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'age' => 'required',
            'bike' => 'required',
        ]);

        $addBiker = $biker->create([
            'fullname'  => ucwords( strtolower($request->fullname) ),
            'address'   => $request->address,
            'phone'     => $request->phone,
            'age'       => $request->age,
            'bike'      => $request->bike,
        ]);

        // $addBiker->bike()->attach($request->bike);

        if ( $addBiker ){
            return response()->json(true, 200);
        }
    }
}
