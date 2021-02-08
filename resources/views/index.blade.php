@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Catálogo</h3>
        @if (session()->has('op'))
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-success" role="alert">
                        Operation: {{ session()->get('op') }}. Id: {{ session()->get('id') }}. Result:
                        {{ session()->get('r') }}
                    </div>
                </div>
            </div>
        @endif

        <table class="table table-hover">
            <tr>
                <th scope="col">Usuario</th>
                <th scope="col">Nombre</th>
                <th scope="col">Precio</th>
                <th scope="col">Uso</th>
                <th scope="col">Categoría</th>
                <th scope="col">Fecha</th>
                <th scope="col">Ver</th>
            </tr>
            @foreach ($productos as $producto)
                <tr>
                    <td>{{ $producto->user->name }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->precio }}</td>
                    <td>{{ $producto->uso->nombre }}</td>
                    <td>{{ $producto->categoria->nombre }}</td>
                    <td>{{ $producto->fecha }}</td>
                    <td class="text-center"><a href="{{ route('backend.producto.show', $producto) }}">Ver</a>
                    </td>
                </tr>

            @endforeach

        </table>
        {{ $productos->links() }}
    </div>
@endsection
