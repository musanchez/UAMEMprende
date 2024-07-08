@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4" style="text-align: center">Productos: {{ $emprendimiento->nombre }}</h2>
    <div class="text-center">
        <a href="{{ route('crear.producto', $emprendimiento->id) }}" class="btn btn-lg btn-primary">Agregar Producto</a>
    </div>
    <div class="mb-4"></div> <!-- added a margin bottom to separate the button from the cards -->
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($emprendimiento->productos as $producto)
            <div class="col mb-4">
                <div class="card h-100">
                    <img src="{{ $producto->imagen }}" class="card-img-top" alt="{{ $producto->nombre }}" style="width: 100%; height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $producto->nombre }}</h5>
                        <p class="card-text flex-grow-1">{{ \Illuminate\Support\Str::limit($producto->descripcion, 100) }}</p>
                        <p class="card-text"><strong>Precio:</strong> C${{ $producto->precio }} </p>
                        <a href="{{ route('editar.producto', ['emprendimiento' => $emprendimiento->id, 'producto' => $producto->id]) }}" class="btn btn-sm btn-secondary">Editar</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection