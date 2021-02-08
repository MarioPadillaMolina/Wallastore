<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Producto;

class FrontendController extends Controller
{
    public function index()
    {
        $productos = Producto::where('estado_id', '=', '1')->orderBy('fecha', 'DESC')->paginate(10);
        return view('index', ['productos' => $productos]);
    }

}
