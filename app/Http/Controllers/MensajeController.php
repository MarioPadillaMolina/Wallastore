<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\URL;
use App\Mail\MailProducto;
use Illuminate\Support\Facades\Mail;

class MensajeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mensajes = DB::table('producto')
        ->join('Mensaje', 'producto.id', 'mensaje.producto_id')
        ->where('mensaje.emisor_id', auth()->user()->id)
        ->orWhere('mensaje.receptor_id', auth()->user()->id)->orderBy('mensaje.id', 'DESC')->paginate(5);
        // dd($mensajes);
        return view('backend.mensaje.index', ['mensajes' => $mensajes]);
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
        $mensaje = new Mensaje($request->all());
        try {
            $result = $mensaje->save();
            $this->enviarMensaje($mensaje);
        } catch (\Exception $th) {
            $result = 0;
        }

        if ($mensaje->id > 0) {
            $response = ['op' => 'create', 'r' => $result, 'id' => $mensaje->id];
            return redirect()->route('backend.mensaje.index')->with($response);
        } else {
            return back()->withInput()->withErrors(['error' => 'Algo ha fallado']);
            //lo recojo con @errors
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mensaje  $mensaje
     * @return \Illuminate\Http\Response
     */
    public function show(Mensaje $mensaje)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mensaje  $mensaje
     * @return \Illuminate\Http\Response
     */
    public function edit(Mensaje $mensaje)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mensaje  $mensaje
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mensaje $mensaje)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mensaje  $mensaje
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mensaje $mensaje)
    {
        //
    }

    public function enviarMensaje($mensaje){
        $link = URL::TemporarySignedRoute('backend.mensaje.index', now()->addDays(90), ['id' => $mensaje->receptor_id, 'producto' => $mensaje->producto->nombre]);
        $producto = $mensaje->producto->nombre;
        $cuerpo = $mensaje->mensaje;
        $correo = new MailProducto($link, $producto, $cuerpo);
        $user = User::find($mensaje->receptor_id);
        Mail::to($user)->send($correo);
    }
}
