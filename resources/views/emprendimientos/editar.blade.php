@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Editar Emprendimiento') }}</div>

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

                        <!-- Imagen del Emprendimiento -->
                        <div class="mb-3">
                            <label for="imagen" class="form-label">{{ __('Imagen del Emprendimiento') }}</label>
                            <div id="image-preview" class="mb-3">
                                @if ($emprendimiento->imagen && $emprendimiento->imagen !== 'productos/logo.png')
                                    <img src="{{ asset('storage/' . $emprendimiento->imagen) }}" alt="{{ $emprendimiento->nombre }}" class="img-fluid mb-2" style="max-height: 200px;">
                                    <button type="button" class="btn btn-danger btn-sm" id="remove-image">{{ __('Quitar imagen') }}</button>
                                @endif
                            </div>
                            <input 
                                id="imagen" 
                                type="file" 
                                class="form-control @error('imagen') is-invalid @enderror" 
                                name="imagen" 
                                accept="image/*" 
                                style="{{ $emprendimiento->imagen ? 'background-color: #d6d6d6;' : '' }}" 
                                {{ $emprendimiento->imagen ? 'disabled' : '' }}>
                            <small id="file-label" class="form-text text-muted">
                                {{ $emprendimiento->imagen ? basename($emprendimiento->imagen) : 'Ningún archivo seleccionado' }}
                            </small>
                            @error('imagen')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="categoria" class="form-label">{{ __('Categoría') }}</label>
                            <select id="categoria" class="form-select @error('categoria_id') is-invalid @enderror" name="categoria_id" required>
                                <option value="" disabled>Selecciona una categoría</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" {{ $emprendimiento->categoria_id == $categoria->id ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                                @endforeach
                            </select>
                            @error('categoria')
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('imagen');
        const fileLabel = document.getElementById('file-label');
        const removeButton = document.getElementById('remove-image');
        const previewContainer = document.getElementById('image-preview');

        // Cuando se selecciona un archivo
        fileInput.addEventListener('change', function () {
            if (fileInput.files.length > 0) {
                const fileName = fileInput.files[0].name;
                fileLabel.textContent = fileName;
                fileInput.style.backgroundColor = '#d6d6d6';
                fileInput.disabled = true;
            }
        });

        // Manejar la acción de quitar imagen
        if (removeButton) {
            removeButton.addEventListener('click', function () {
                previewContainer.innerHTML = ''; // Quitar la imagen del preview
                fileInput.disabled = false;
                fileInput.style.backgroundColor = '';
                fileLabel.textContent = 'Ningún archivo seleccionado';
            });
        }
    });
</script>

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
