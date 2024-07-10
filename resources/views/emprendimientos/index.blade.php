@extends('layouts.app')

@section('content')

<div class="container">
    <h2 class="mb-4" style="text-align: center">Listado de Emprendimientos</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($emprendimientos as $emprendimiento)
        <div class="col">
            <div class="card h-100 position-relative">
                <img src="{{ $emprendimiento->imagen }}" class="card-img-top" alt="{{ $emprendimiento->nombre }}" style="width: 100%; height: 200px; object-fit: cover;">
                @auth
                <button class="btn btn-outline-danger position-absolute top-0 end-0 m-2 p-2 rounded-circle" style="background-color: rgba(255, 255, 255, 0.7);" onclick="addToFavorites({{ $emprendimiento->id }})">
                    <i class="fas fa-heart"></i>
                </button>
                @endauth
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $emprendimiento->nombre }}</h5>
                    <p class="card-text flex-grow-1">{{ \Illuminate\Support\Str::limit($emprendimiento->descripcion, 100, $end='...') }}</p>
                    <p class="card-text"><strong>Emprendedor:</strong> {{ $emprendimiento->emprendedor->nombre }}</p>
                    <p class="card-text"><strong>Teléfono:</strong> {{ $emprendimiento->emprendedor->celular }}</p>
                    <p class="card-text"><strong>Categoría:</strong> {{ $emprendimiento->categoria->nombre }}</p>
                    <a href="{{ route('emprendimientos.show', $emprendimiento->id) }}" class="btn btn-primary mt-auto" style="background-color: #439FA5; border-color: #439FA5;">Ver más</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    function addToFavorites(emprendimientoId) {
        // Lógica para añadir el emprendimiento a la lista de favoritos
        fetch(`/favorites/add/${emprendimientoId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                alert('Emprendimiento añadido a favoritos!');
            } else {
                alert('Hubo un error al añadir el emprendimiento a favoritos.');
            }
        });
    }
</script>

@endsection
