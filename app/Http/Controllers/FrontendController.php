<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Producto;
use App\Models\ImgProducto;
use Illuminate\Pagination\Paginator;
use DB;

class FrontendController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user) {
            //$productos = Producto::where('estado_id', '=', '1')->orderBy('fecha', 'DESC')->paginate(10);

            //$provincia_id = $user->provincia_id;
            $provincia_id = $user->provincia_id;

            /* no funciona el orderBy  */
            // $restoProductos = Producto::join('users', 'producto.user_id', 'users.id')
            //     ->join('provincia', 'users.provincia_id', 'provincia.id')
            //     ->where('provincia.id', '!=', $provincia_id)
            //     ->groupBy('producto.id')
            //     ->select('producto.*')->orderBy('producto.fecha', 'desc');
            // //dd($restoProductos);
            // $productos = Producto::join('users', 'producto.user_id', 'users.id')
            //     ->join('provincia', 'users.provincia_id', 'provincia.id')
            //     ->where('provincia.id', $provincia_id)
            //     ->groupBy('producto.id')
            //     ->orderBy('producto.id', 'desc')->union($restoProductos)->select('producto.*')->paginate(10);

            // dd($productos);
            $restoProductos = Producto::
                join('users', 'producto.user_id', 'users.id')
              ->join('provincia', 'users.provincia_id', 'provincia.id')
              ->where('provincia.id', '!=', $provincia_id)
              ->groupBy('producto.id')
              ->select('producto.*')->orderBy('producto.fecha', 'desc')->get();
            //dd($restoProductos);
            $misProductos = Producto::
                join('users', 'producto.user_id', 'users.id')
              ->join('provincia', 'users.provincia_id', 'provincia.id')
              ->where('provincia.id', $provincia_id)
              ->groupBy('producto.id')
              ->select('producto.*')->orderBy('producto.fecha', 'desc')->get();

            $productos = $misProductos->merge($restoProductos)->paginate(10);


            // // ********CONSULTAS SQL**********
            // $misProductos = DB::select(
            //     "select p.*, cat.nombre, prov.nombre, uso.nombre, img.nombre url from producto p, users u, uso, categoria cat, provincia prov, img_producto img
            //     where p.user_id = u.id 
            //     and p.categoria_id = cat.id
            //     and p.uso_id = uso.id
            //     and u.provincia_id = prov.id
            //     and p.id = img.producto_id
            //     and prov.id = $provincia_id
            //     and p.estado_id = 1
            //     group by p.id
            //     order by p.id desc"
            // );

            // $restoProductos = DB::select(
            //     "select p.*, cat.nombre, prov.nombre, uso.nombre, img.nombre url from producto p, users u, uso, categoria cat, provincia prov, img_producto img
            //     where p.user_id = u.id 
            //     and p.categoria_id = cat.id
            //     and p.uso_id = uso.id
            //     and u.provincia_id = prov.id
            //     and p.id = img.producto_id
            //     and prov.id != $provincia_id
            //     and p.estado_id = 1
            //     group by p.id
            //     order by p.id desc"
            // );

            /* a partir de IDS */
            //dd($productos);
            //dd($idProductos);
            //$ids = [];
            // foreach ($idProductos as $idProducto) {
            //     array_push($ids, $idProducto->id);
            // }
            // $nums = [2, 9, 10, 74];
            // //dd($nums);
            // $ids = array_values($ids);
            // //dd($nums, $ids);
            // $productos = Producto::whereIn('id', $nums)->paginate(10);
            // //dd($productos);
            //return view('index2', ['misProductos' => $misProductos, 'restoProductos' => $restoProductos]);

        } else {
            $productos = Producto::where('estado_id', '=', '1')->orderBy('fecha', 'DESC')->paginate(10);
        }
        return view('index', ['productos' => $productos]);
    }
}
