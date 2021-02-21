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

    <div class="row">
        <div class="col-12">
            <div class="card-deck">
                @foreach ($misProductos as $producto)
                <div class="card">
                    <img class="card-img-top mycard"
                        src="{{ asset('storage/' . [$producto->img_productos][0][0]['nombre'])}}" alt="Card image cap">
                    <div class="card-body">
                        <h2 class="card-title">{{ $producto->precio }}</h2>
                        <h5 class="card-subtitle">{{ $producto->nombre }}</h5>

                        <p class="card-text">{{$producto->descripcion }}</p>
                        <a href="{{ route('backend.producto.show', $producto) }}" class="btn btn-primary">Ver</a>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">
                            {{ $producto->user->provincia->nombre . " - " . $producto->categoria->nombre . " - " . $producto->uso->nombre }}
                            <br> {{ $producto->fecha }}
                        </small>
                    </div>
                </div>
                @endforeach
                @foreach ($restoProductos as $producto)
                <div class="card">
                    <img class="card-img-top mycard"
                        src="{{ asset('storage/' . [$producto->img_productos][0][0]['nombre'])}}" alt="Card image cap">
                    <div class="card-body">
                        <h2 class="card-title">{{ $producto->precio }}</h2>
                        <h5 class="card-subtitle">{{ $producto->nombre }}</h5>

                        <p class="card-text">{{$producto->descripcion }}</p>
                        <a href="{{ route('backend.producto.show', $producto) }}" class="btn btn-primary">Ver</a>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">
                            {{ $producto->user->provincia->nombre . " - " . $producto->categoria->nombre . " - " . $producto->uso->nombre }}
                            <br> {{ $producto->fecha }}
                        </small>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{ $misProductos->links() }}
    {{ $restoProductos->links() }}
</div>
@endsection