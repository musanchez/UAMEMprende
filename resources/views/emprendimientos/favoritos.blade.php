@extends('layouts.app')

@section('content')

<div class="container">
    <h2 class="mb-4" style="text-align: center">Emprendimientos Favoritos</h2>
    @if($emprendimientos->isEmpty())
    <p style="text-align: center;">No tienes emprendimientos favoritos aún.</p>
    @else
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($emprendimientos as $emprendimiento)
        <div class="col">
            <div class="card h-100">
                <img src="{{ $emprendimiento->imagen }}" class="card-img-top" alt="{{ $emprendimiento->nombre }}" style="width: 100%; height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $emprendimiento->nombre }}</h5>
                    <p class="card-text flex-grow-1">{{ \Illuminate\Support\Str::limit($emprendimiento->descripcion, 100, $end='...') }}</p>
                    <p class="card-text"><strong>Emprendedor:</strong> {{ $emprendimiento->emprendedor->nombre }}</p>
                    <p class="card-text"><strong>Teléfono:</strong> {{ $emprendimiento->emprendedor->celular }}</p>
                    <p class="card-text"><strong>Categoría:</strong> {{ $emprendimiento->categoria->nombre }}</p>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <a href="{{ route('emprendimientos.show', $emprendimiento->id) }}" class="btn btn-primary" style="background-color: #439FA5; border-color: #439FA5;">Ver más</a>
                        @auth
                        @php
                        $isFavorite = $emprendimiento->preferencias()->where('estudiante_id', auth()->id())->where('favorito', true)->exists();
                        @endphp
                        <button class="btn btn-link p-0" onclick="toggleFavorite('{{ $emprendimiento->id }}',this)">
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
        @endforeach
    </div>
    @endif
</div>

<script>
    function toggleFavorite(emprendimientoId, button) {
        const heartIcon = button.querySelector('i');
        const isFavorite = heartIcon.style.color === 'red';
        const url = isFavorite ? `/favorites/remove/${emprendimientoId}` : `/favorites/add/${emprendimientoId}`;

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
