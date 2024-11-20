@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Crear Emprendimiento') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('guardar.emprendimiento') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
                            <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required autofocus>
                            @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">{{ __('Descripción') }}</label>
                            <textarea id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" rows="4" required>{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="imagen" class="form-label">{{ __('Imagen del Producto') }}</label>
                            <!-- Aseguramos que el input es de tipo file -->
                            <input id="imagen" type="file" class="form-control @error('imagen') is-invalid @enderror" name="imagen" accept="image/*">
                            @error('imagen')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="categoria" class="form-label">{{ __('Categoría') }}</label>
                            <select id="categoria" class="form-select @error('categoria_id') is-invalid @enderror" name="categoria_id" required>
                                <option value="" disabled selected>Selecciona una categoría</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                @endforeach
                            </select>
                            @error('categoria')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <br>
                            <br>
                            <button type="submit" class="btn btn-primary custom-btn">{{ __('Crear Emprendimiento') }}</button> <!-- Aplicación de la clase 'custom-btn' -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Agrega este estilo CSS al final del archivo o en tu archivo CSS principal -->
<style>
    .custom-btn {
        background-color: #439FA5; /* Color de fondo personalizado */
        border-color: #439FA5; /* Color del borde */
    }

    .custom-btn:hover {
        background-color: #367f85; /* Color de fondo ligeramente más oscuro al pasar el cursor */
        border-color: #367f85;
    }
</style>

@endsection
