@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4" style="text-align: center">Productos: {{ $emprendimiento->nombre }}</h2>
    <div class="text-center">
        <a href="{{ route('crear.producto', $emprendimiento->id) }}" class="btn btn-lg custom-btn">Agregar Producto</a>
    </div>
    <div class="mb-4"></div>
    <!-- Botón de importar productos -->
    <div class="text-center mb-4">
        <form action="{{ route('importar.productos', $emprendimiento->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="input-group">
                <input type="file" name="archivo" class="form-control" accept=".xlsx, .xls" required>
                <button type="submit" class="btn btn-lg custom-btn">Importar Productos</button>
            </div>
        </form>
    </div>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($emprendimiento->productos as $producto)
            <div class="col mb-4">
                <div class="card h-100">
                    <!-- Mostrar la imagen del producto -->
                    <img src="{{ asset('storage/' . $producto->imagen) }}" class="card-img-top" alt="{{ $producto->nombre }}" style="width: 100%; height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $producto->nombre }}</h5>
                        <p class="card-text flex-grow-1">{{ \Illuminate\Support\Str::limit($producto->descripcion, 100) }}</p>
                        <p class="card-text"><strong>Precio:</strong> C${{ $producto->precio }}</p>
                        <a href="{{ route('editar.producto', ['emprendimiento' => $emprendimiento->id, 'producto' => $producto->id]) }}" class="btn btn-sm btn-secondary">Editar</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Estilos CSS -->
<style>
    .custom-btn {
        background-color: #439FA5;
        border-color: #439FA5;
        color: white; /* Asegura que el texto sea visible */
    }
    .custom-btn:hover {
        background-color: #367f85; /* Color más oscuro para hover */
        border-color: #367f85;
    }
</style>

@endsection
