@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $emprendimiento->nombre }}</div>

                <div class="card-body">
                    <p><strong>Descripción: </strong>{{ $emprendimiento->descripcion }}</p>
                    <p><strong>Categoría: </strong>{{ $emprendimiento->categoria }}</p>
                    <p><strong>Ubicación: </strong>{{ $emprendimiento->ubicacion }}</p>
                    <a href="{{ route('emprendimientos.edit', $emprendimiento->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('emprendimientos.destroy', $emprendimiento->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                    <a href="{{ route('emprendimientos.index') }}" class="btn btn-secondary btn-sm">Volver a la lista</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
