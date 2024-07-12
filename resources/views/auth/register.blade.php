@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registro') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="cif" class="form-label">{{ __('CIF') }}</label>
                            <input id="cif" type="text" class="form-control @error('cif') is-invalid @enderror"
                                name="cif" value="{{ old('cif') }}" required autofocus>
                            @error('cif')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
                            <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror"
                                name="nombre" value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="apellido" class="form-label">{{ __('Apellido') }}</label>
                            <input id="apellido" type="text"
                                class="form-control @error('apellido') is-invalid @enderror" name="apellido"
                                value="{{ old('apellido') }}" required>
                            @error('apellido')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="celular" class="form-label">{{ __('Celular') }}</label>
                            <input id="celular" type="text" class="form-control @error('celular') is-invalid @enderror"
                                name="celular" value="{{ old('celular') }}" required>
                            @error('celular')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Correo Electrónico') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">{{ __('Confirmar Contraseña') }}</label>
                            <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" required>
                        </div>

                        <div class="mb-3">
                            <label for="carrera_id" class="form-label">{{ __('Carrera') }}</label>
                            <select id="carrera_id" name="carrera_id" class="form-control">
                                @foreach($carreras as $carrera)
                                    <option value="{{ $carrera->id }}" {{ (old('carrera_id') == $carrera->id) ? 'selected' : '' }}>{{ $carrera->nombre }}</option>
                                @endforeach
                            </select>
                            @error('carrera_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary"
                            style="background-color: #439FA5;">{{ __('Registrar') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection