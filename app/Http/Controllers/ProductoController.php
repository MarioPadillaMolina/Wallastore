<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\ImgProducto;
use App\Models\Categoria;
use App\Models\Uso;
use App\Models\Estado;
use Illuminate\Http\Request;
use App\Http\Requests\ProductoRequest;
use Storage;

use Auth;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $user = auth()->user();
        if ($user->admin) {
            $productos = Producto::all()->orderBy('fecha', 'DESC');
        } else {
            $productos =  Producto::where('user_id', $user->id)->orderBy('fecha', 'DESC')->get();
        }
        return view('backend.producto.index', ['productos' => $productos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::all();
        $usos = Uso::all();
        return view('backend.producto.create', ['categorias' => $categorias, 'usos' => $usos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductoRequest $request)
    {
        $resProd = 0;
        $resImg = 0;
        //producto
        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->descripcion = $request->descripcion;
        $producto->uso_id = $request->uso_id;
        $producto->categoria_id = $request->categoria_id;
        $producto->user_id = auth()->user()->id;
        $producto->estado_id = $request->estado_id;
        try {
            $resProd = $producto->save(); //ProductoRequest ya me obliga a que haya al menos una foto, así que si guarda es porque la hay
        } catch (\Exception $e) {
            $resProd = 0;
        }
        //fotos
        if ($resProd != 0) { //si el producto es válido
            $images = $request->img; //arrray de imagenes
            foreach ($images as $image) {
                if ($image->isValid()) {
                    $imgProducto = new ImgProducto();
                    $ruta = 'img/productos/' . auth()->user()->id . '/' . $producto->id;

                    $path = $image->store($ruta);

                    $imgProducto->nombre = $path;
                    $imgProducto->producto_id = $producto->id;

                    $resImg = $imgProducto->save();
                    try {
                    } catch (\Exception $e) {
                        $resImg = 0;
                    };
                }
            }
        }

        if ($producto->id > 0 && $imgProducto->id > 0) {
            $response = ['op' => 'create', 'resprod' => $resProd, 'resimg' => $resImg, 'id' => $producto->id];
            return redirect()->route('backend.producto.index')->with($response);
        } else {
            return back()->withInput()->withErrors(['error' => 'Algo ha fallado']);
            //lo recojo con @errors
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        $liked = \App\Models\Megusta::where('user_id', '=', auth()->user()->id)->where('producto_id', '=', $producto->id)->first();
        $imgproductos = ImgProducto::where('producto_id', '=', $producto->id)->get();
        return view('show', ['producto' => $producto, 'imgproductos' => $imgproductos, 'liked' => $liked]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        $usos = Uso::all();
        $estados = Estado::all();
        $imgproductos = ImgProducto::where('producto_id', '=', $producto->id)->get();
        return view('backend.producto.edit', ['producto' => $producto, 'categorias' => $categorias, 'usos' => $usos, 'imgproductos' => $imgproductos, 'estados' => $estados]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(ProductoRequest $request, Producto $producto)
    {
        $resProd = 0;
        $resImg = 0;
        //producto
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->descripcion = $request->descripcion;
        $producto->uso_id = $request->uso_id;
        $producto->categoria_id = $request->categoria_id;
        $producto->user_id = auth()->user()->id;
        $producto->estado_id = $request->estado_id;
        try {
            $resProd = $producto->save(); //ProductoRequest ya me obliga a que haya al menos una foto, así que si guarda es porque la hay
        } catch (\Exception $e) {
            $resProd = 0;
        }
        //fotos
        if ($resProd != 0) { //si el producto es válido
            $images = $request->img; //arrray de imagenes
            if ($images) {
                foreach ($images as $image) {
                    if ($image->isValid()) {
                        $imgProducto = new ImgProducto();
                        $ruta = 'img/productos/' . auth()->user()->id . '/' . $producto->id;

                        $path = $image->store($ruta);

                        $imgProducto->nombre = $path;
                        $imgProducto->producto_id = $producto->id;

                        $resImg = $imgProducto->save();
                        try {
                        } catch (\Exception $e) {
                            $resImg = 0;
                        };
                    }
                }
            }
        }

        if ($producto->id > 0) {
            $response = ['op' => 'create', 'resprod' => $resProd, 'resimg' => $resImg, 'id' => $producto->id];
            return redirect()->route('backend.producto.index')->with($response);
        } else {
            return back()->withInput()->withErrors(['error' => 'Algo ha fallado']);
            //lo recojo con @errors
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        // $result = $producto->delete();

        try {
            $result = $producto->delete();
        } catch (\Exception $ex) {
            $result = 0;
        }
        $response = ['op' => 'destroy', 'r' => $result, 'id' => $producto->id];
        return redirect()->route('backend.producto.index')->with($response);
    }

    public function imgdestroy($id)
    {
        $imgproducto = ImgProducto::find($id);

        // $result = $imgproducto->delete();
        try {
            $result = $imgproducto->delete();
        } catch (\Exception $ex) {
            $result = 0;
        }
        $response = ['op' => 'destroy', 'r' => $result, 'id' => $id];
        return redirect()->route('backend.producto.index')->with($response);
    }
}
 