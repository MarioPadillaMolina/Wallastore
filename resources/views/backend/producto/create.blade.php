@extends('layouts.app')

@section('content')
    <div class="container">
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
            <div class="col-md-8 mx-auto">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            Crea un nuevo producto
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('backend.producto.store') }}" method="post" id="createProductoForm"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <input type="hidden" name="estado_id" id="estado" value="1" required>
                            <div class="form-group">
                                <label for="nombre">Qué vendes</label>
                                <input type="text" maxlength="200" minlength="10" class="form-control" name="nombre"
                                    id="nombre" placeholder="Nombre del producto" value="{{ old('nombre') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea class="form-control" rows="6" minlength="20" id="descripcion" name="descripcion"
                                    required> {{ old('descripcion') }} </textarea>
                            </div>
                            <div class="form-group">
                                <label for="categoria">Categoria</label>
                                <div class="input-group mb-3">
                                    <select required class="custom-select" id="categoria_id" name="categoria_id">
                                        <option disabled value="">Escoge una...</option>
                                        @foreach ($categorias as $categoria)
                                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
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
                                            <option value="{{ $uso->id }}">{{ $uso->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="precio">Precio</label>
                                <input type="number" step="0.01" class="form-control" name="precio" id="precio"
                                    value="{{ old('precio') }}" required>
                            </div>
                            <h5>Inserta al menos una imagen que identifique el producto</h5>
                            <div class="form-group">
                                <label for="img1">Foto1</label>
                                <input type="file" class="form-control" id="img1" name="img[]">
                            </div>
                            <div class="form-group">
                                <label for="img2">Foto2</label>
                                <input type="file" class="form-control" id="img2" name="img[]">
                            </div>
                            <div class="form-group">
                                <label for="img3">Foto3</label>
                                <input type="file" class="form-control" id="img3" name="img[]">
                            </div>
                            <div class="form-group">
                                <label for="img4">Foto4</label>
                                <input type="file" class="form-control" id="img4" name="img[]">
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Crear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
