@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $emprendimiento->nombre }}</h1>
    <p>{{ $emprendimiento->descripcion }}</p>
    
    <!-- Información detallada del emprendedor -->
    <h2>Datos del Emprendedor</h2>
    <p>Nombre: {{ $emprendimiento->emprendedor->nombre }}</p>
    <p>Email: {{ $emprendimiento->emprendedor->email }}</p>
    <p>Teléfono: {{ $emprendimiento->emprendedor->celular }}</p>
    <!-- Agrega más campos según sea necesario -->

    <!-- Productos relacionados -->
    <h2>Productos</h2>
    <div class="row">
        @foreach($productos as $producto)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $producto->nombre }}</h5>
                        <p class="card-text">{{ Str::limit($producto->descripcion, 100) }}</p>
                        <p class="card-text">Precio: C${{ $producto->precio }}</p>
                        <!-- No agregamos el botón "Ver más" ya que quieres mostrar todos los detalles aquí -->
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
