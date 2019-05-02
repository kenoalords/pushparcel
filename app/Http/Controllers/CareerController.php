<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Career;
use App\Http\Requests\CareerRequest;
use Illuminate\Support\Str;

class CareerController extends Controller
{
    public function add(Request $request, Career $career)
    {
        if ( $request->isMethod('get') ){
            return view('careers.add');
        }

        if ( $request->isMethod('post') ){
            $this->validate($request, [
                'title'             => 'required',
                'description'       => 'required',
                'metadescription'   => 'required',
                'expiry'            => 'required',
            ]);

            $insert = $career->create([
                'title'             => $request->title,
                'slug'              => Str::slug( $request->title ),
                'description'       => $request->description,
                'metadescription'   => $request->metadescription,
                'expires'           => $request->expiry,
                'status'            => $request->status,
            ]);

            $status = ( $request->status === 'publish' ) ? 'published' : 'saved to draft';

            if ( $insert ){
                return redirect()->route('add_career')->with(['status' => 'Career was ' . $status . ' sucessfully', 'career' => $insert->slug]);
            }
        }
    }

    public function view(Request $request, Career $career)
    {
        return view('careers.view')->with(['career'=>$career]);
    }
}
