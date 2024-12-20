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
    <h2 class="mb-4" style="text-align: center">Listado de Emprendimientos</h2>

    <div class="mb-4">
        <form action="{{ route('emprendimientos.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col">
                <input type="text" name="search" class="form-control" placeholder="Buscar por nombre o descripción"
                    value="{{ request()->query('search') }}" style="height: 40px;">
            </div>
            <div class="col">
                <select name="category" class="form-control" style="height: 40px;">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ request()->query('category') == $categoria->id ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto d-flex align-items-center">
                <button type="submit" class="btn btn-primary mx-2" style="background-color: #439FA5; border-color: #439FA5; height: 40px;">
                    Buscar
                </button>
                <a href="{{ route('emprendimientos.index') }}" class="btn mx-2" style="background-color: #FFD700; color: black; border: 1px solid #FFC107; height: 40px;">
                    Limpiar Filtros
                </a>
            </div>
        </form>
    </div>


    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($emprendimientosFiltrados as $emprendimiento)
        @if ($emprendimiento->estado_emp && $emprendimiento->estado_emp->nombre === 'VERIFICADO')
        <div class="col">
            <div class="card h-100">
                <img src="{{ asset('storage/' . $emprendimiento->imagen) }}" class="card-img-top" alt="{{ $emprendimiento->nombre }}"
                    style="width: 100%; height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $emprendimiento->nombre }}</h5>
                    <hr style="border-color: #000;"> <!-- Línea gris -->
                    <p class="card-text"><strong>Emprendedor:</strong> {{ $emprendimiento->emprendedor->nombre }} {{ $emprendimiento->emprendedor->apellido }}</p>
                    <p class="card-text"><strong>Carrera:</strong> {{ $emprendimiento->emprendedor->carrera->nombre }}</p>
                    <p class="card-text"><strong>Teléfono:</strong> {{ $emprendimiento->emprendedor->celular }}</p>
                    <p class="card-text"><strong>Categoría:</strong> {{ $emprendimiento->categoria->nombre }}</p>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="star-rating me-2">
                                @php
                                $promedioCalificacion = $emprendimiento->promedioCalificaciones();
                                $filledStars = floor($promedioCalificacion);
                                $halfStar = $promedioCalificacion - $filledStars >= 0.5;
                                @endphp
                                @for ($i = 0; $i < 5; $i++)
                                    @if ($i < $filledStars)
                                    <i class="fas fa-star"></i>
                                    @elseif ($i == $filledStars && $halfStar)
                                    <i class="fas fa-star-half-alt"></i>
                                    @else
                                    <i class="far fa-star"></i>
                                    @endif
                                    @endfor
                            </div>
                            <span>{{ number_format($promedioCalificacion, 1) }}</span>
                        </div>
                        <a href="{{ route('emprendimientos.show', $emprendimiento->id) }}" class="btn btn-primary"
                            style="background-color: #439FA5; border-color: #439FA5;">Ver más</a>
                        @auth
                        @php
                        $isFavorite = $emprendimiento->preferencias()->where('estudiante_id', auth()->id())->where('favorito', true)->exists();
                        @endphp
                        <button class="btn btn-link p-0" onclick="toggleFavorite('{{ $emprendimiento->id }}', this)">
                            @if ($isFavorite)
                            <i class="fas fa-heart fa-2x" style="color: red;"></i>
                            @else
                            <i class="fas fa-heart fa-2x" style="color: gray;"></i>
                            @endif
                        </button>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
</div>

<script>
    function toggleFavorite(emprendimientoId, button) {
        const heartIcon = button.querySelector('i');
        const isFavorite = heartIcon.style.color === 'red';
        const url = isFavorite ? `https://uamemprende.site/UAMEmprende/public/favorites/remove/${emprendimientoId}` : `https://uamemprende.site/UAMEmprende/public/favorites/add/${emprendimientoId}`;

        fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json())
            .then(data => {
                if (data.favorito) {
                    heartIcon.style.color = 'red';
                    alert('Emprendimiento añadido a favoritos!');
                } else {
                    heartIcon.style.color = 'gray';
                    alert('Emprendimiento eliminado de favoritos!');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Hubo un error al cambiar el estado de favorito.');
            });
    }
</script>

@endsection
