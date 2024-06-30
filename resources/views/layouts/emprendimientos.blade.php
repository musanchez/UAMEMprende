@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header" style="font-size: larger; text-align: center">{{ __('Crear Emprendimiento') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Ubicación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($emprendimientos as $emprendimiento)
                                <tr>
                                    <td>{{ $emprendimiento->nombre }}</td>
                                    <td>{{ $emprendimiento->categoria }}</td>
                                    <td>{{ $emprendimiento->ubicacion }}</td>
                                    <td>
                                        <a href="{{ route('emprendimientos.show', $emprendimiento->id) }}" class="btn btn-info btn-sm">Ver</a>
                                        <a href="{{ route('emprendimientos.edit', $emprendimiento->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        <form action="{{ route('emprendimientos.destroy', $emprendimiento->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
