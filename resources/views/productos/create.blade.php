@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Crear Producto') }}</div>

                <div class="card-body">
                    <!-- Aseguramos que enctype está presente -->
                    <form method="POST" action="{{ route('crear.producto.store', $emprendimiento->id) }}" enctype="multipart/form-data">
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
                            <label for="precio" class="form-label">{{ __('Precio') }}</label>
                            <input id="precio" type="number" min="0" step="0.01" class="form-control @error('precio') is-invalid @enderror" name="precio" value="{{ old('precio') }}" required>
                            @error('precio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="oculto" class="form-label">{{ __('Oculto') }}</label>
                            <input type="hidden" name="oculto" value="0">
                            <input id="oculto" type="checkbox" class="form-check-input @error('oculto') is-invalid @enderror" name="oculto" value="1">
                            @error('oculto')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary custom-btn">{{ __('Crear Producto') }}</button>
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

<style>
    .custom-btn {
        background-color: #439FA5;
        border-color: #439FA5;
        color: white;
    }

    .custom-btn:hover {
        background-color: #367f85;
        border-color: #367f85;
    }
</style>

@endsection
