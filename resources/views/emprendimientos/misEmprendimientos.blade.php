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
                <tr style="height: 80px;"> <!-- increased row height -->
                    <td style="vertical-align: middle;">{{ $emprendimiento->nombre }}</td> <!-- centered text -->
                    <td style="vertical-align: middle;">{{ \Illuminate\Support\Str::limit($emprendimiento->descripcion, 100, $end='...') }}</td> <!-- centered text -->
                    <td style="vertical-align: middle;">{{ $emprendimiento->categoria->nombre }}</td> <!-- centered text -->
                    <td style="padding-left: 10px;"> <!-- added padding to separate buttons -->
                        <div style="display: flex; flex-direction: column;">
                            <a href="{{ route('editar.emprendimiento', $emprendimiento->id) }}" class="btn btn-sm btn-secondary mb-1">Editar</a>
                            <a href="{{ route('emprendimiento.productos', $emprendimiento->id) }}" class="btn btn-sm btn-primary mb-1">Gestionar Productos</a>
                            <form action="{{ route('eliminar.emprendimiento', $emprendimiento->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection