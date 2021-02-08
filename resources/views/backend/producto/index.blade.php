@extends('layouts.app')

@section('script')
    <script src="{{ url('assets/js/script.js?=' . uniqid()) }}"></script>
@endsection

@section('content')
    <div class="container">
        <h3>Tus Productos</h3>
        <a class="btn btn-primary" href="{{ route('backend.producto.create') }}">Crear producto</a>
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
                @if (auth()->user()->admin)
                    <th scope="col">Usuario</th>
                @endif
                <th scope="col">ID #</th>
                <th scope="col">Nombre</th>
                <th scope="col">Precio</th>
                <th scope="col">Fecha</th>
                <th scope="col">Categoría</th>
                <th scope="col">Estado</th>
                <th scope="col">Ver</th>
                <th scope="col">Editar</th>
                <th scope="col">Borrar</th>
            </tr>
            @foreach ($productos as $producto)
                <tr>
                    @if (auth()->user()->admin)
                        <td scope="row">{{ $producto->user->id }}</td>
                    @endif
                    <td>{{ $producto->id }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->precio }}</td>
                    <td>{{ $producto->fecha }}</td>
                    <td>{{ $producto->categoria->nombre }}</td>
                    <td>{{ $producto->estado->nombre }}</td>
                    <td class="text-center"><a href="{{ route('backend.producto.show', $producto) }}">Ver</a>
                    </td>
                    <td class="text-center"><a href="{{ route('backend.producto.edit', $producto) }}">Editar</a></td>
                    <td class="text-center"><a href="#" data-id="{{ $producto->id }}"
                            data-content="{{ $producto->nombre }}" data-toggle="modal" data-target="#modalDelete"
                            class="launchModal">Delete</a></td>
                </tr>
            @endforeach

        </table>
        {{-- {{ $productos->links() }} --}}

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
                        <p>Are you sure you want to delete the post:
                            <strong>ID: <span id="objId"></span> - Title: <span id="objContent"></span></strong> ?
                        </p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" id="modalConfirmation" class="btn btn-primary">Delete</button>
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
    </div>
@endsection
