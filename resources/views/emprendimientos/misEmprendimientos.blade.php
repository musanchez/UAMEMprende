@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4" style="text-align: center">Mis Emprendimientos</h2>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($emprendimientos as $emprendimiento)
                <tr>
                    <td>{{ $emprendimiento->nombre }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($emprendimiento->descripcion, 100, $end='...') }}</td>
                    <td>{{ $emprendimiento->categoria->nombre }}</td>
                    <td>
                        <a href="" class="btn btn-sm btn-secondary">Editar</a>
                        <form action="" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
