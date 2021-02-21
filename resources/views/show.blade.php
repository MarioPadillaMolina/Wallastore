@extends('layouts.app')

@section('script')
<script src="{{ url('assets/js/script.js?=' . uniqid()) }}"></script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-1 mx-auto mb-3">
            <a class="btn btn-primary text-center" href="{{ URL::previous() }}">Back</a>
        </div>
    </div>
    <div class="row">
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
        <div class="col-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($imgproductos as $key => $imgproducto)
                            <div class="carousel-item {{ $key == 0 ? 'active' : ""}}">
                                <img class="d-block w-100 imgcardshow" src="{{ asset('storage/' . $imgproducto->nombre) }}"
                                    alt="image">
                            </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                            data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button"
                            data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10">
                            <h4 class="card-title"><strong>{{ $producto->nombre }}</strong></h4>
                            <p class="card-text">{{ $producto->descripcion }}.</p>
                            <p>{{ $producto->user->provincia->nombre }}</p>
                            <p><strong>Estado:</strong> {{ $producto->uso->nombre }} - <strong>Categoría:</strong> {{ $producto->categoria->nombre }}
                            </p>
                        </div>
                        <div class="col-md-2">
                            <h3>{{ $producto->precio }} €</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">

                        <div class="col-6">
                            <strong>Usuario: </strong> {{ $producto->user->name }}
                            - <strong>Fecha:</strong> {{ $producto->fecha }}
                        </div>
                        <div class="col-6 text-right">
                            <div class="megusta" style="display: inline-block">
                                @auth
                                @if ($producto->user->id != auth()->user()->id)
                                @if (!$liked)
                                <form action="{{ route('backend.megusta.store') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                                    <button type="submit" class="btn btn-info">Me gusta</button>
                                </form>
                                @else
                                <a href="#" data-id="{{ $liked->id }}" data-content="{{ $producto->nombre }}"
                                    data-like="formDeleteLike" data-toggle="modal" data-target="#modalDelete"
                                    class="launchModal btn btn-warning">Dejar de seguir</a>
                                @endif
                                @endif
                            </div>
                            @if (auth()->user()->admin || $producto->user->id == auth()->user()->id)
                            <a href="#" data-id="{{ $producto->id }}" data-content="{{ $producto->nombre }}"
                                data-toggle="modal" data-target="#modalDelete" class="launchModal btn btn-danger">Borrar
                                Producto</a>
                            @endif
                            @if (auth()->user()->id != $producto->user->id)
                            <a class="mensaje btn btn-success" href="#" data-toggle="modal" data-target="#mensajeModal"
                                data-emisor="{{ auth()->user()->id }}" data-receptor="{{ $producto->user_id }}"
                                data-productoid="{{ $producto->id }}"
                                data-productonombre="{{ $producto->nombre }}">Contactar</a>
                            @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal alert -->
    <div class="modal fade" id="modalDelete" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Alert!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de que desea eliminar el producto?:
                        <strong>ID: <span id="objId"></span> - Nombre: <span id="objContent"></span></strong> ?
                    </p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="modalConfirmation" class="btn btn-primary">Eliminar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <form id="formDelete" action="{{ url('backend/producto') }}" method="post">
        @method('delete')
        @csrf
    </form>
    <form id="formDeleteLike" action="{{ url('backend/megusta') }}" method="post">
        @method('delete')
        @csrf
    </form>

    {{-- Modal para enviar mensajes --}}

    <div class="modal fade" id="mensajeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo mensaje</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('backend.mensaje.store') }}" method="post" id="mensajeForm">
                    <div class="modal-body">
                        @csrf
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <input type="hidden" name="emisor_id" id="emisor_id">
                        <input type="hidden" name="receptor_id" id="receptor_id">
                        <input type="hidden" name="producto_id" id="producto_id">
                        <div class="mb-3">
                            <label for="mensaje" class="col-form-label">Mensaje:</label>
                            <textarea class="form-control" id="mensaje" name="mensaje"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>
@endsection