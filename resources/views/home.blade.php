@extends('layouts.app')
@section('modal')
    <div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="modalInfoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalInfoLabel">
                        @if (Session::has('verified'))
                            Verification
                        @endif
                        @if (Session::has('password'))
                            Password
                        @endif
                        @if (Session::has('userchange'))
                            User change
                        @endif
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if (Session::has('verified'))
                        Cuenta verificada correctamente, bienvenido.
                    @endif
                    @if (Session::has('password'))
                        Clave de acceso modificada correctamente.
                    @endif
                    @if (Session::has('userchange'))
                        Usuario modificado correctamente.
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        //para lanzar el modal
        if (document.getElementById('modal')) {
            $('#modalInfo').modal('show');
        }
    </script>
@endsection

@section('content')
    {{-- Para lanzar el modal --}}
    @if (Session::has('verified') || Session::has('password') || Session::has('userchange'))
    <div id="modal"></div>
    @endif

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <br>
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                    </div>
                </div>
                <br>


                <div class="card">
                    <div class="card-header">
                        Change Location
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('user.location.update' , $user->id) }}">
                            @csrf
                            @method('put')
                            <div class="form-group row">
                                <label for="provincia" class="col-md-4 col-form-label text-md-right">Provincia</label>
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <select required class="custom-select" id="provincia" name="provincia_id">
                                            <option disabled value="">Escoge una...</option>
                                            @foreach ($provincias as $provincia)
                                                @if ($provincia->id == $user->provincia_id)
                                                    <option selected value="{{ $provincia->id }}">
                                                        {{ $provincia->nombre }}</option>
                                                @else
                                                    <option value="{{ $provincia->id }}">{{ $provincia->nombre }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Change Location
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>




                <div class="card">
                    <div class="card-header">Change Password</div>
                    @error('passworderror')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.change') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="oldpassword" class="col-md-4 col-form-label text-md-right">Previous
                                    password</label>

                                <div class="col-md-6">
                                    <input id="oldpassword" type="password"
                                        class="form-control @error('oldpassword') is-invalid @enderror" name="oldpassword"
                                        required>

                                    @error('passwordold')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Change Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header">
                        Change Username and/or password
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('user.change') }}">
                            @csrf
                            <div class="form-group row">
                                @error('usererror')
                                    <div class="alert alert-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                <div class="col-md-6">
                                    <input id="name" value="{{ old('name', auth()->user()->name) }}" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name" required>

                                    @error('name')
                                        <div class="alert alert-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                                <div class="col-md-6">
                                    <input id="email" value="{{ old('email', auth()->user()->email) }}" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email">

                                    @error('email')
                                        <div class="alert alert-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Change Username
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
