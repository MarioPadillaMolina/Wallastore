<?php

namespace App\Http\Controllers;

use App\Models\Megusta;
use Illuminate\Http\Request;

class MegustaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $likes = Megusta::where('user_id', '=', auth()->user()->id)->get();
        return view('backend.producto.megusta', ['likes' => $likes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $megusta = new Megusta();
        $megusta->user_id = auth()->user()->id;
        $megusta->producto_id = $request->producto_id;

        try {
            $result = $megusta->save();
        } catch (\Exception $e) {
            $result = 0;
        }

        if ($megusta->id > 0) {
            $response = ['op' => 'megusta', 'r' => $result, 'id' => $megusta->producto_id];
            return back()->with($response);
        } else {
            return back()->withInput()->withErrors(['error' => 'Algo ha fallado']);
            //lo recojo con @errors
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Megusta  $megusta
     * @return \Illuminate\Http\Response
     */
    public function show(Megusta $megusta)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Megusta  $megusta
     * @return \Illuminate\Http\Response
     */
    public function edit(Megusta $megusta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Megusta  $megusta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Megusta $megusta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Megusta  $megusta
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $megusta = Megusta::find($id);
        try {
            $result = $megusta->delete();
        } catch (\Exception $ex) {
            $result = 0;
        }
        $response = ['op' => 'likedestroy', 'r' => $result, 'id' => $megusta->id];
        return back()->with($response);
    }
}
