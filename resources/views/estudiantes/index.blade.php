@extends('layouts.app')

@section('content')

<div class="container">
    <h2 class="mb-4" style="text-align: center">Usuarios Estudiantes</h2>

    <!-- Barra de búsqueda -->
    <form action="{{ route('usuarios.buscar') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="cif" class="form-label">CIF:</label>
                <input type="text" class="form-control" id="cif" name="cif" value="{{ request()->input('cif') }}">
            </div>
            <div class="col-md-4">
                <label for="nombre" class="form-label">Nombre/Apellido:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ request()->input('nombre') }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary" style="background-color: #439FA5; border-color: #439FA5;">Buscar</button>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>CIF</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Carrera</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->cif }}</td>
                    <td>{{ $usuario->nombre }}</td>
                    <td>{{ $usuario->apellido }}</td>
                    <td>{{ $usuario->carrera ? $usuario->carrera->nombre : 'Sin asignar' }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>
                        <button type="button" class="btn {{ $usuario->status ? 'btn-danger' : 'btn-success' }}"
                                onclick="toggleStatus('{{ $usuario->id }}', this)">
                            {{ $usuario->status ? 'Desactivar' : 'Activar' }}
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<script>
    function toggleStatus(userId, button) {
        const url = button.classList.contains('btn-danger') ? `{{ route('estudiantes.desactivar', ':id') }}` : `{{ route('estudiantes.activar', ':id') }}`;
        const method = button.classList.contains('btn-danger') ? 'POST' : 'POST';
        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');

        fetch(url.replace(':id', userId), {
            method: method,
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                button.classList.toggle('btn-danger');
                button.classList.toggle('btn-success');
                button.textContent = data.message === 'Usuario activado correctamente' ? 'Desactivar' : 'Activar';
                alert(data.message);
            } else {
                alert('Hubo un error al cambiar el estado del usuario.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un error al cambiar el estado del usuario.');
        });
    }
</script>

@endsection
