@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <!-- Encabezado del Emprendimiento con Imagen -->
    <div class="row mb-4 text-center">
        <div class="col">
            <img src="{{ $emprendimiento->imagen }}" class="img-fluid mb-4" alt="{{ $emprendimiento->nombre }}" style="width: 100%; height: auto; max-height: 400px; object-fit: cover;">
            <h1 class="display-4"><strong>{{ $emprendimiento->nombre }}</strong></h1>
            <hr style="border: 2.5px solid #000; width: 70%; margin: 0 auto;">
            <br>
            <h5 style="max-width: 80%; margin: 0 auto; text-align: center; overflow-wrap: break-word;">{{ $emprendimiento->descripcion }}</h5>
        </div>
    </div>

    <!-- Información detallada del Emprendedor -->
    <div class="row mb-5">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2>Datos del Emprendedor</h2>
                </div>
                <div class="card-body">
                    <p><strong>Nombre:</strong> {{ $emprendimiento->emprendedor->nombre }}</p>
                    <p><strong>Email:</strong> {{ $emprendimiento->emprendedor->email }}</p>
                    <p><strong>Teléfono:</strong> {{ $emprendimiento->emprendedor->celular }}</p>
                    <!-- Agrega más campos según sea necesario -->
                </div>
            </div>
        </div>
    </div>

    <!-- Productos relacionados -->
    <div class="row mb-4">
        <div class="col text-center">
            <h2 class="mb-4">Productos</h2>
            <hr style="border: 2.0px solid #000; width: 50%; margin: 0 auto;">
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($productos as $producto)
            @if(!$producto->oculto)
                <div class="col mb-4">
                    <div class="card h-100">
                        <img src="{{ $producto->imagen }}" class="card-img-top" alt="{{ $producto->nombre }}" style="width: 100%; height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $producto->nombre }}</h5>
                            <p class="card-text flex-grow-1">{{ \Illuminate\Support\Str::limit($producto->descripcion, 100) }}</p>
                            <p class="card-text"><strong>Precio:</strong> C${{ $producto->precio }}</p>
                            <!-- No agregamos el botón "Ver más" ya que quieres mostrar todos los detalles aquí -->
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
@endsection
