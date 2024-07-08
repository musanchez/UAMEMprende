@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Editar Producto</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('editar.producto.update', ['emprendimiento' => $emprendimiento->id, 'producto' => $producto->id]) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
                                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ $producto->nombre }}" required autofocus>
                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="descripcion" class="form-label">{{ __('Descripción') }}</label>
                                <textarea id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" rows="4" required>{{ $producto->descripcion }}</textarea>
                                @error('descripcion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="imagen" class="form-label">{{ __('URL de la Imagen') }}</label>
                                <input id="imagen" type="url" class="form-control @error('imagen') is-invalid @enderror" name="imagen" value="{{ $producto->imagen }}" required>
                                @error('imagen')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="precio" class="form-label">{{ __('Precio') }}</label>
                                <input id="precio" type="number" class="form-control @error('precio') is-invalid @enderror" name="precio" value="{{ $producto->precio }}" required>
                                @error('precio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="oculto" class="form-label">{{ __('Oculto') }}</label>
                                <input type="hidden" name="oculto" value="0">
                                <input id="oculto" type="checkbox" class="form-check-input @error('oculto') is-invalid @enderror" name="oculto" value="1" {{ $producto->oculto ? 'checked' : '' }}>
                                @error('oculto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <br>
                                <br>
                                <button type="submit" class="btn btn-primary">{{ __('Actualizar Producto') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection