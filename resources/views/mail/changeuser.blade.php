@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        Se ha modificado la cuenta de correo de tu
        cuenta en nuestro sitio Wallapop. Si has sido tú
        no te tienes que preocupar.
        En caso contrario puedes utilizar este enlace para
        reestablecer tu cuenta de correo anterior:
        <a href="{{ $enlace }}">enlace</a>.<br><br><br>
        <a href="{{ $enlace }}">{{ $enlace }}</a>.
    </div>
</div>

@endsection