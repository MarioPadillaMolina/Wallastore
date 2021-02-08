@extends('layouts.app')

@section('script')
    <script src="{{ url('assets/js/script.js?=' . uniqid()) }}"></script>
@endsection

@section('content')
    <div class="container">
        <h3>Tus productos deseados</h3>
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
                    <td scope="row">#ID-like</td>
                @endif
                <th scope="col">Producto</th>
                <th scope="col">Precio</th>
                <th scope="col">Categoría</th>
                <th scope="col">Estado</th>
                <th scope="col">Usuario</th>
                <th scope="col">Fecha</th>
                <th scope="col">Ver</th>
                <th scope="col">Dejar de seguir</th>
            </tr>
            @foreach ($likes as $like)
                <tr>
                    @if (auth()->user()->admin)
                        <td scope="row">{{ $like->id }}</td>
                    @endif
                    <td>{{ $like->producto->nombre }}</td>
                    <td>{{ $like->producto->precio }}</td>
                    <td>{{ $like->producto->categoria->nombre }}</td>
                    <td>{{ $like->producto->estado->nombre }}</td>
                    <td>{{ $like->producto->user->name }}</td>
                    <td>{{ $like->producto->fecha }}</td>
                    <td><a href="{{ route('backend.producto.show', $like->producto) }}">Ver</a>
                    </td>
                    <td><a href="#" data-id="{{ $like->id }}" data-content="{{ $like->producto->nombre }}"
                            data-toggle="modal" data-target="#modalDelete" class="launchModal">Dejar de seguir</a></td>
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
                        <p>¿Seguro que quiere dejar de seguir el producto?:
                            <strong>ID: <span id="objId"></span> - Nombre: <span id="objContent"></span></strong> ?
                        </p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="modalConfirmation" class="btn btn-primary">Dejar de seguir</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <form id="formDelete" action="{{ url('backend/megusta') }}" method="post">
            @method('delete')
            @csrf
        </form>
    </div>
@endsection
