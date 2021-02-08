@extends('layouts.app')

@section('script')
    <script src="{{ url('assets/js/script.js?=' . uniqid()) }}"></script>
@endsection

@section('content')
    <div class="container">


        <h3>Users backend</h3>
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
                <th scope="col">ID #</th>
                <th scope="col">Name</th>
                <th scope="col">Mail</th>
                <th scope="col">Role</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
            @foreach ($users as $user)
                <tr>
                    <td scope="row">{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->admin == 1 ? 'Admin' : 'User' }}</td>

                    <td><a href="{{ url('backend/user/' . $user->id . '/edit') }}">edit</a></td>
                    <td><a href="#" data-id="{{ $user->id }}"
                        data-content="{{ $user->name }}" data-toggle="modal" data-target="#modalDelete"
                        class="launchModal">Delete</a></td>
                </tr>
            @endforeach

        </table>
        {{-- {{ $users->links() }} --}}
        
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
                        <p>¿Estás seguro de que quiere eliminar a este usuario?:
                            <strong>ID: <span id="objId"></span> - Nombre: <span id="objContent"></span></strong> ?
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
        
        <form id="formDelete" action="{{ url('backend/user') }}" method="post">
            @method('delete')
            @csrf
        </form>
    </div>
@endsection
