@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Editar Emprendimiento</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('actualizar.emprendimiento', $emprendimiento->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
                                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ $emprendimiento->nombre }}" required autofocus>
                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="descripcion" class="form-label">{{ __('Descripción') }}</label>
                                <textarea id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" rows="4" required>{{ $emprendimiento->descripcion }}</textarea>
                                @error('descripcion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="imagen" class="form-label">{{ __('Imagen del Emprendimiento') }}</label>
                                <input id="imagen" type="file" class="form-control @error('imagen') is-invalid @enderror" name="imagen" accept="image/*">
                                @if ($emprendimiento->imagen)
                                    <small class="form-text text-muted">
                                        Imagen actual: 
                                        <img src="{{ asset('storage/' . $emprendimiento->imagen) }}" alt="Imagen del emprendimiento" style="width: 100px; height: auto; display: block; margin-top: 10px;">
                                    </small>
                                @endif
                                @error('imagen')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="categoria_id" class="form-label">{{ __('Categoría') }}</label>
                                <select id="categoria_id" class="form-select @error('categoria_id') is-invalid @enderror" name="categoria_id" required>
                                    <option value="" disabled>Selecciona una categoría</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" {{ $emprendimiento->categoria_id == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categoria_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary custom-btn">{{ __('Actualizar Emprendimiento') }}</button>
                            </div>
                        </form>
                    </div>
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
