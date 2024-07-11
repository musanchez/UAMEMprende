@extends('layouts.app')

@section('content')

<div class="container">
    <h2 class="mb-4" style="text-align: center">Editar Perfil</h2>
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update', $user->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $user->nombre) }}" required>
                </div>

                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" value="{{ old('apellido', $user->apellido) }}" required>
                </div>

                <div class="mb-3">
                    <label for="carrera" class="form-label">Carrera</label>
                    <select class="form-select" id="carrera_id" name="carrera_id" required>
                        @foreach ($carreras as $carrera)
                            <option value="{{ $carrera->id }}" {{ old('carrera', $user->carrera_id) == $carrera->id ? 'selected' : '' }}>
                                {{ $carrera->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="current_password" class="form-label">Contraseña Actual</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                </div>

                <div class="mb-3">
                    <label for="new_password" class="form-label">Nueva Contraseña (Opcional)</label>
                    <input type="password" class="form-control" id="new_password" name="new_password">
                </div>

                <div class="mb-3">
                    <label for="new_password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
                </div>

                <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
            </form>
        </div>
    </div>
</div>

@endsection
