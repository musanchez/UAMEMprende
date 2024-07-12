@extends('layouts.app')

@section('content')

<div class="container">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
</div>

<div class="container">
    <h2 class="mb-4" style="text-align: center">Emprendimientos Pendientes de Validación</h2>

    <!-- Barra de búsqueda y filtro de categorías -->
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <form action="{{ route('emprendimientos.pendientes') }}" method="GET" class="d-flex w-100">
            <input type="text" name="search" class="form-control me-2" placeholder="Buscar por nombre o descripción"
                value="{{ request()->query('search') }}">
            <select name="category" class="form-control me-2">
                <option value="">Todas las categorías</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ request()->query('category') == $categoria->id ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary"
                style="background-color: #439FA5; border-color: #439FA5;">Buscar</button>
        </form>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($emprendimientos as $emprendimiento)
            @if ($emprendimiento->estado_emp && $emprendimiento->estado_emp->nombre === 'PENDIENTE')
                <div class="col">
                    <div class="card h-100">
                        <img src="{{ $emprendimiento->imagen }}" class="card-img-top" alt="{{ $emprendimiento->nombre }}"
                            style="width: 100%; height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column align-items-center">
                            <h5 class="card-title">{{ $emprendimiento->nombre }}</h5>
                            <p class="card-text flex-grow-1">
                                {{ \Illuminate\Support\Str::limit($emprendimiento->descripcion, 100, $end = '...') }}
                            </p>
                            <p class="card-text"><strong>Emprendedor:</strong> {{ $emprendimiento->emprendedor->nombre }}</p>
                            <p class="card-text"><strong>Teléfono:</strong> {{ $emprendimiento->emprendedor->celular }}</p>
                            <p class="card-text"><strong>Categoría:</strong> {{ $emprendimiento->categoria->nombre }}</p>
                            <p class="card-text"><strong>Estado:</strong> {{ $emprendimiento->estado_emp->nombre }}</p>
                            <div class="mt-auto">
                                <form action="{{ route('emprendimientos.validar', $emprendimiento->id) }}" method="POST" class="mb-2">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-primary"
                                        style="width: 100%; background-color: #439FA5; border-color: #439FA5;">Validar</button>
                                </form>
                                <form action="{{ route('emprendimientos.rechazar', $emprendimiento->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger" style="width: 100%;">Rechazar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

</div>

@endsection
