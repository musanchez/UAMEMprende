@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <!-- Encabezado del Emprendimiento con Imagen -->
    <div class="row mb-4 text-center">
        <div class="col">
            <img src="{{ $emprendimiento->imagen }}" class="img-fluid mb-4" alt="{{ $emprendimiento->nombre }}" style="width: 100%; height: auto; max-height: 400px; object-fit: cover;">
            <h1 class="display-4" style="background-color: #439FA5; color: white; padding: 10px;"><strong>{{ $emprendimiento->nombre }}</strong></h1>
            <hr style="border: 2.5px solid #000; width: 70%; margin: 0 auto;">
            <br>
            <h5 style="max-width: 80%; margin: 0 auto; text-align: center; overflow-wrap: break-word;">{{ $emprendimiento->descripcion }}</h5>
        </div>
    </div>

    <!-- Información detallada del Emprendedor -->
    <div class="row mb-5">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header" style="background-color: #439FA5;">
                    <h2 class="text-white">Datos del Emprendedor</h2>
                </div>
                <div class="card-body" style="border: 2px solid #439FA5; border-radius: 8px; background-color: #F0F0F0;">
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
            <h2 class="mb-4" style="color: #000; font-size: 2.5rem;">Productos</h2>
            <hr style="border: 2.0px solid #000; width: 50%; margin: 0 auto;">
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse($productos as $producto)
            @if(!$producto->oculto)
                <div class="col mb-4">
                    <div class="card h-100" style="border: 1px solid #ddd;">
                        <img src="{{ $producto->imagen }}" class="card-img-top" alt="{{ $producto->nombre }}" style="width: 100%; height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column" style="background-color: #F0F0F0;">
                            <h5 class="card-title" style="color: #439FA5;">{{ $producto->nombre }}</h5>
                            <p class="card-text flex-grow-1">{{ \Illuminate\Support\Str::limit($producto->descripcion, 100) }}</p>
                            <p class="card-text"><strong>Precio:</strong> C${{ $producto->precio }}</p>
                            <!-- No agregamos el botón "Ver más" ya que quieres mostrar todos los detalles aquí -->
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div class="col-md-8 offset-md-2 text-center">
                <p>No hay productos disponibles para mostrar en este emprendimiento.</p>
            </div>
        @endforelse
    </div>

    <!-- Sección de Comentarios -->
    <div class="row mb-5">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header" style="background-color: #439FA5;">
                    <h2 class="text-white">Comentarios</h2>
                </div>
                <div class="card-body" style="border: 2px solid #439FA5; border-radius: 8px; background-color: #F0F0F0;">
                    <!-- Formulario para añadir comentarios -->
                    @auth
                        <form action="{{ route('comentarios.store') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="comentario" class="form-label">Añadir un comentario:</label>
                                <textarea class="form-control" id="comentario" name="comentario" rows="3" required></textarea>
                                <input type="hidden" name="estudiante_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="emprendimiento_id" value="{{ $emprendimiento->id }}">
                            </div>
                            <button type="submit" class="btn btn-primary" style="background-color: #439FA5; border-color: #439FA5;">Enviar</button>
                        </form>
                    @endauth

                    <!-- Mostrar mensajes de autenticación -->
                    @guest
                        <p class="text-muted">Inicia sesión para añadir un comentario.</p>
                    @endguest

                    <!-- Listado de comentarios -->
                    <hr>
                    @foreach($emprendimiento->comentarios as $comentario)
                        <div class="media mb-4">
                            <img class="mr-3 rounded-circle" src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($comentario->estudiante->email))) }}?d=mp&s=64" alt="{{ $comentario->estudiante->nombre }}">
                            <div class="media-body">
                                <h5 class="mt-0">{{ $comentario->estudiante->nombre }} <small class="text-muted">{{ $comentario->created_at->diffForHumans() }}</small></h5>
                                <p>{{ $comentario->comentario }}</p>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Calificación -->
    <div class="row mb-5">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header" style="background-color: #439FA5;">
                    <h2 class="text-white">Calificación</h2>
                </div>
                <div class="card-body" style="border: 2px solid #439FA5; border-radius: 8px; background-color: #F0F0F0;">
                    <!-- Formulario para añadir calificación -->
                    @auth
                        <form action="{{ route('calificar.emprendimiento' )}}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="calificacion" class="form-label">Calificación (0 al 10):</label>
                                <input type="number" class="form-control" id="calificacion" name="calificacion" min="0" max="10" required>
                                <input type="hidden" name="estudiante_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="emprendimiento_id" value="{{ $emprendimiento->id }}">
                            </div>
                            <button type="submit" class="btn btn-primary" style="background-color: #439FA5; border-color: #439FA5;">Enviar Calificación</button>
                        </form>
                    @endauth

                    <!-- Mostrar mensaje de autenticación -->
                    @guest
                        <p class="text-muted">Inicia sesión para dejar una calificación.</p>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
