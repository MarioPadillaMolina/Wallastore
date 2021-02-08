@extends('layouts.app')

@section('script')
    <script src="{{ url('assets/js/script.js?=' . uniqid()) }}"></script>
@endsection

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
                        <a href="{{ route('backend.producto.index') }}" class="btn btn-primary">Ver productos</a>
                    </div>
                </div>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            Edita el producto
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('backend.producto.update', $producto) }}" method="post" id="createProductoForm"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nombre">Qué vendes</label>
                                <input type="text" maxlength="200" minlength="10" class="form-control" name="nombre"
                                    id="nombre" placeholder="Nombre del producto"
                                    value="{{ old('nombre', $producto->nombre) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea class="form-control" rows="6" minlength="20" id="descripcion" name="descripcion"
                                    required> {{ old('descripcion', $producto->descripcion) }} </textarea>
                            </div>
                            <div class="form-group">
                                <label for="categoria">Categoria</label>
                                <div class="input-group mb-3">
                                    <select required class="custom-select" id="categoria_id" name="categoria_id">
                                        <option disabled value="">Escoge una...</option>
                                        @foreach ($categorias as $categoria)
                                            @if ($categoria->id == $producto->categoria_id)
                                                <option selected value="{{ $categoria->id }}">
                                                    {{ $categoria->nombre }}
                                                </option>
                                            @else
                                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}
                                                </option>
                                            @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="uso">Está usado?</label>
                                <div class="input-group mb-3">
                                    <select required class="custom-select" id="uso_id" name="uso_id">
                                        <option disabled value="">Escoge una...</option>
                                        @foreach ($usos as $uso)
                                            @if ($uso->id == $producto->uso_id)
                                                <option selected value="{{ $uso->id }}">{{ $uso->nombre }}</option>
                                            @else
                                                <option value="{{ $uso->id }}">{{ $uso->nombre }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="precio">Precio</label>
                                <input type="number" step="0.01" class="form-control" name="precio" id="precio"
                                    value="{{ old('precio', $producto->precio) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <div class="input-group mb-3">
                                    <select required class="custom-select" id="estado_id" name="estado_id">
                                        <option disabled value="">Escoge una...</option>
                                        @foreach ($estados as $estado)
                                            @if ($estado->id == $producto->estado_id)
                                                <option selected value="{{ $estado->id }}">{{ $estado->nombre }}
                                                </option>
                                            @else
                                                <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <h5>Inserta al menos una imagen que identifique el producto</h5>
                            <div class="form-group">
                                <label for="img0">Foto1</label>
                                @if (isset($imgproductos[0]))
                                    <img src="{{ asset('storage/' . $imgproductos[0]->nombre) }}" alt="imagen"
                                        width="100" height="100">
                                    <a href="#" data-id="{{ $imgproductos[0]->id }}"
                                        data-content="{{ $imgproductos[0]->nombre }}" data-toggle="modal"
                                        data-target="#modalDelete" class="launchModal">borrar</a>
                                    <input type="hidden" class="form-control" id="imgup1" name="imgup[]" value="1">
                                @else
                                    <input type="file" class="form-control" id="img0" name="img[]">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="img1">Foto2</label>
                                @if (isset($imgproductos[1]))
                                    <img src="{{ asset('storage/' . $imgproductos[1]->nombre) }}" alt="imagen"
                                        width="100" height="100">
                                    <a href="#" data-id="{{ $imgproductos[1]->id }}"
                                        data-content="{{ $imgproductos[1]->nombre }}" data-toggle="modal"
                                        data-target="#modalDelete" class="launchModal">borrar</a>
                                @else
                                    <input type="file" class="form-control" id="img1" name="img[]">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="img2">Foto3</label>
                                @if (isset($imgproductos[2]))
                                    <img src="{{ asset('storage/' . $imgproductos[2]->nombre) }}" alt="imagen"
                                        width="100" height="100">
                                    <a href="#" data-table="user" data-id="{{ $imgproductos[2]->id }}"
                                        data-name="{{ $imgproductos[2]->nombre }}" class="enlaceBorrar">borrar</a>
                                @else
                                    <input type="file" class="form-control" id="img2" name="img[]">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="img3">Foto4</label>
                                @if (isset($imgproductos[3]))
                                    <img src="{{ asset('storage/' . $imgproductos[3]->nombre) }}" alt="imagen"
                                        width="100" height="100">

                                    <a href="#" data-id="{{ $imgproductos[3]->id }}"
                                        data-content="{{ $imgproductos[3]->nombre }}" data-toggle="modal"
                                        data-target="#modalDelete" class="launchModal">borrar</a>
                                @else
                                    <input type="file" class="form-control" id="img3" name="img[]">
                                @endif
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Editar</button>
                        </div>
                    </form>
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
        {{-- <form id="formDelete" action="{{ url('backend/producto') }}" method="post">
            @method('delete')
            @csrf
        </form> --}}
        <form id="formDelete" action="{{ url('backend/imgproducto') }}" method="post">
            @method('delete')
            @csrf
        </form>
    </div>

@endsection
