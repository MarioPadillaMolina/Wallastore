@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Reestablece tu correo:
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ url()->full() }}">
                            <!-- url()->full() devuelve la ruta actual-->
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-12">
                                    Se va a restablecer el correo {{ $email }} para el usuario {{ $nombre }}
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-primary" type="submit">Restablecer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
