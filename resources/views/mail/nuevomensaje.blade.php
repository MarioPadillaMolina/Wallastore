@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    Tiene un nuevo mensaje de otro usuario.
                </div>
                <div class="card-body">
                    <p>{{$cuerpo}}</p>
                </div>
                <div class="card-footer">
                    Puede responderle accediendo a nuestra web a través de <strong><a href="{{ $link }}">este
                            enlace</a></strong>.
                </div>
            </div>

        </div>
    </div>

@endsection
