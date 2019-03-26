<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use Illuminate\Http\Request;

class BikeController extends Controller
{
    public function index(Request $request, Bike $bikes)
    {
        return view('bike.index')->with(['bikes'=>$bikes->all()]);
    }

    public function add(Request $request, Bike $bike)
    {
        $this->validate($request, [
            'make'  => 'required',
            'model'  => 'required',
            'condition'  => 'required',
            'licence'  => 'required',
        ]);

        $addBike = $bike->create([
            'make'      => $request->make,
            'model'     => $request->model,
            'licence'   => $request->licence,
            'condition' => $request->condition,
        ]);

        if ( $addBike ){
            return response()->json(true, 200);
        } else {
            return response()->json(false, 200);
        }
    }

    public function getBikes(Request $request, Bike $bikes)
    {
        if ( $request->ajax() ){
            return response()->json($bikes->all(), 200);
        }
    }
}
