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
                    <th>Estado</th> <!-- Nueva columna para Estado -->
                    <th class="text-center">Acciones</th> <!-- Añadida clase 'text-center' -->
                </tr>
            </thead>
            <tbody>
                @foreach ($emprendimientos as $emprendimiento)
                <tr style="height: 80px;">
                    <td style="vertical-align: middle;">{{ $emprendimiento->nombre }}</td>
                    <td style="vertical-align: middle;">{{ \Illuminate\Support\Str::limit($emprendimiento->descripcion, 100, $end='...') }}</td>
                    <td style="vertical-align: middle;">{{ $emprendimiento->categoria->nombre }}</td>
                    <td style="vertical-align: middle;">{{ $emprendimiento->estado_emp->nombre }}</td> <!-- Aquí se muestra el estado del emprendimiento -->
                    <td style="vertical-align: middle; padding-left: 10px;">
                        <div class="action-buttons">
                            <a href="{{ route('editar.emprendimiento', $emprendimiento->id) }}" class="btn custom-btn btn-secondary">Editar</a>
                            <a href="{{ route('emprendimiento.productos', $emprendimiento->id) }}" class="btn custom-btn btn-primary">Gestionar Productos</a> <!-- Aplicación de la clase 'custom-btn' solo aquí -->
                            <form action="{{ route('eliminar.emprendimiento', $emprendimiento->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn custom-btn btn-danger">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Agrega este estilo CSS al final del archivo o en tu archivo CSS principal -->
<style>
    .action-buttons {
        display: flex;
        gap: 10px; /* Separación uniforme entre botones */
    }
    .custom-btn {
        white-space: nowrap; /* Evita que el texto de los botones se divida en varias líneas */
        border-color: #439FA5; /* Color del borde */
        color: white; /* Color del texto */
    }
    .btn-secondary {
        flex: 1.2; /* Aumenta el ancho del botón Editar */
    }
    .btn-danger {
        flex: 1.2; /* Aumenta el ancho del botón Eliminar */
    }
    .btn-primary {
        flex: 1; /* Mantiene el ancho original del botón Gestionar Productos */
        background-color: #439FA5; /* Color de fondo personalizado para el botón Gestionar Productos */
    }
    .btn-primary:hover {
        background-color: #367f85; /* Color de fondo ligeramente más oscuro al pasar el cursor */
        border-color: #367f85;
    }
    .text-center {
        text-align: center; /* Centra el texto en el encabezado de la columna */
    }
</style>

@endsection
