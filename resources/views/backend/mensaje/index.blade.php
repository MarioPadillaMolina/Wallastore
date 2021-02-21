@extends('layouts.app')

@section('script')
    <script src="{{ url('assets/js/script.js?=' . uniqid()) }}"></script>
@endsection

@section('content')
    <div class="container">
        <h3>Mensajes</h3>
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
        <div class="row mt-5">
            <table class="table table-hover">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Emisor</th>
                    <th scope="col">Receptor</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Mensaje</th>
                    <th scope="col">Responder</th>
                    <th scope="col">Leído</th>

                    {{-- <th scope="col">Dueño Producto</th> --}}
                </tr>
                @foreach ($mensajes as $mensaje)
                    @if ($mensaje->leido == 0 && $mensaje->emisor_id != auth()->user()->id)
                        <tr style="background-color: #ff52004f">
                        @else
                        <tr>
                    @endif
                    <td>{{ $mensaje->id }}</td>
                    <td>{{ \App\Models\User::find($mensaje->emisor_id)->name }}</td>
                    <td>{{ \App\Models\User::find($mensaje->receptor_id)->name }}</td>
                    <td><a
                            href="{{ url('backend/producto/' . $mensaje->producto_id . 'show') }}">{{ $mensaje->nombre }}</a>
                    </td>
                    <td>{{ $mensaje->created_at }}</td>
                    <td>{{ $mensaje->mensaje }}</td>
                    <td><a class="mensaje btn btn-success" href="#" data-toggle="modal" data-target="#mensajeModal" @if ($mensaje->emisor_id == auth()->user()->id) data-emisor="{{ $mensaje->emisor_id }}" 
                                        data-receptor="{{ $mensaje->receptor_id }}"
                            @else
                                        data-receptor="{{ $mensaje->emisor_id }}" 
                                        data-emisor="{{ $mensaje->receptor_id }}" @endif
                            data-productoid="{{ $mensaje->producto_id }}"
                            data-productonombre="{{ $mensaje->nombre }}">
                            Responder</a>
                    </td>
                    <td>
                        @if ($mensaje->receptor_id == auth()->user()->id && $mensaje->leido == 0)
                        <form method="post" action="{{ route('backend.mensaje.update', $mensaje->id) }}">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-info">Leído</button>
                        </form>
                        @endif
                    </td>
                    </tr>
                @endforeach
            </table>
        </div>
        {{ $mensajes->links() }}

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
                            {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
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
