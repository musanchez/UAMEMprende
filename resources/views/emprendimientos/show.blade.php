@extends('layouts.app')

@section('content')
<style>
    .star-rating {
        direction: rtl;
        display: flex;
        justify-content: flex-start;
        font-size: 2rem;
        gap: 0.2rem;
    }
    .star-rating input {
        display: none;
    }
    .star-rating label {
        color: #ccc;
        cursor: pointer;
    }
    .star-rating input:checked ~ label {
        color: #FFD700;
    }
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #FFD700;
    }
</style>

<div class="container mt-5">
    <!-- Encabezado del Emprendimiento con Imagen -->
    <div class="row mb-4 text-center">
        <div class="col">
            <img src="{{ asset('storage/' . $emprendimiento->imagen) }}" class="img-fluid mb-4" alt="{{ $emprendimiento->nombre }}" style="width: 100%; height: auto; max-height: 400px; object-fit: cover;">
            <h1 class="display-4" style="background-color: #439FA5; color: white; padding: 10px;"><strong>{{ $emprendimiento->nombre }}</strong></h1>
            <hr style="border: 2.5px solid #000; width: 70%; margin: 0 auto;">
            <br>
            <h5 style="max-width: 80%; margin: 0 auto; text-align: center; overflow-wrap: break-word;">{{ $emprendimiento->descripcion }}</h5>
        </div>
    </div>

    <!-- Botón para Crear Pedido -->
    @auth
        @if (auth()->user()->id !== $emprendimiento->emprendedor_id)
            <div class="text-center mb-4">
                <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#crearPedidoForm" aria-expanded="false" aria-controls="crearPedidoForm" style="background-color: #439FA5; border-color: #439FA5;">
                    Solicitar Pedido
                </button>
            </div>

            <!-- Formulario para Crear Pedido (Desplegable) -->
            <div class="collapse mb-5" id="crearPedidoForm">
                <div class="card card-body" style="border: 2px solid #439FA5; border-radius: 8px; background-color: #F0F0F0;">
                    <form action="{{ route('pedidos.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="mensaje" class="form-label">Detalles del pedido:</label>
                            <textarea class="form-control" id="mensaje" name="mensaje" rows="3" required></textarea>
                            <input type="hidden" name="estudiante_id" value="{{ auth()->user()->id }}">
                            <input type="hidden" name="emprendimiento_id" value="{{ $emprendimiento->id }}">
                        </div>
                        <button type="submit" class="btn btn-primary" style="background-color: #439FA5; border-color: #439FA5;">Enviar Pedido</button>
                    </form>
                </div>
            </div>
        @endif
    @endauth

    @guest
        <p class="text-muted text-center">Inicia sesión para solicitar un pedido.</p>
    @endguest


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

    <!-- Barra de búsqueda -->
    <div class="row mb-4">
        <div class="col-md-8 offset-md-2">
            <form action="{{ route('emprendimientos.buscarProductos', $emprendimiento->id) }}" method="GET" class="row g-2 align-items-center">
                <div class="col">
                    <input type="text" name="search" class="form-control" placeholder="Buscar por nombre o descripción..."
                        value="{{ request()->query('search') }}" style="height: 40px;">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mx-2" style="background-color: #439FA5; border-color: #439FA5; height: 40px;">
                        Buscar
                    </button>
                    <a href="{{ route('emprendimientos.buscarProductos', $emprendimiento->id) }}" class="btn mx-2" style="background-color: #FFD700; color: black; border: 1px solid #FFC107; height: 40px;">
                        Limpiar Filtros
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse($productos as $producto)
            @if(!$producto->oculto)
                <div class="col mb-4">
                    <div class="card h-100" style="border: 1px solid #ddd;">
                        <img src="{{ asset('storage/' . $producto->imagen) }}" class="card-img-top" alt="{{ $producto->nombre }}" style="width: 100%; height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column" style="background-color: #F0F0F0;">
                            <h5 class="card-title" style="color: #439FA5;">{{ $producto->nombre }}</h5>
                            <p class="card-text flex-grow-1">{{ \Illuminate\Support\Str::limit($producto->descripcion, 100) }}</p>
                            <p class="card-text"><strong>Precio:</strong> C${{ $producto->precio }}</p>
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
    </div>

    <div class="row mb-5">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header" style="background-color: #439FA5;">
                    <h2 class="text-white">Calificación</h2>
                </div>
                <div class="card-body" style="border: 2px solid #439FA5; border-radius: 8px; background-color: #F0F0F0;">
                    <!-- Formulario para añadir calificación con estrellas -->
                    @auth
                        <form action="{{ route('calificar.emprendimiento') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="form-label">Calificación:</label>
                                <div class="star-rating">
                                    <input type="radio" id="star5" name="calificacion" value="5">
                                    <label for="star5" title="5 estrellas">★</label>
                                    <input type="radio" id="star4" name="calificacion" value="4">
                                    <label for="star4" title="4 estrellas">★</label>
                                    <input type="radio" id="star3" name="calificacion" value="3">
                                    <label for="star3" title="3 estrellas">★</label>
                                    <input type="radio" id="star2" name="calificacion" value="2">
                                    <label for="star2" title="2 estrellas">★</label>
                                    <input type="radio" id="star1" name="calificacion" value="1">
                                    <label for="star1" title="1 estrella">★</label>
                                </div>
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
                        @if (auth()->user()->status)
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
                        @else
                            <p class="text-muted">Tu cuenta ha sido deshabilitada. No puedes añadir comentarios.</p>
                        @endif
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
                                <h5 class="mt-0">{{ $comentario->estudiante->nombre }} {{ $comentario->estudiante->apellido }} <small class="text-muted">{{ $comentario->created_at->diffForHumans() }}</small></h5>
                                <p>{{ $comentario->comentario }}</p>

                                <!-- Botones para editar y eliminar -->
                                @auth
                                    @if((auth()->user()->id == $comentario->estudiante_id || auth()->user()->admin) && auth()->user()->status)
                                        <div class="d-flex justify-content-end">
                                            <!-- Botón para editar -->
                                            @if (auth()->user()->id == $comentario->estudiante_id)
                                                <button class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editCommentModal{{ $comentario->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            @endif

                                            <!-- Botón para eliminar -->
                                            <form action="{{ route('comentarios.destroy', $comentario->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este comentario?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                        <hr>

                        <!-- Modal para editar comentario -->
                        <div class="modal fade" id="editCommentModal{{ $comentario->id }}" tabindex="-1" aria-labelledby="editCommentModalLabel{{ $comentario->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editCommentModalLabel{{ $comentario->id }}">Editar comentario</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('comentarios.update', $comentario->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="form-group mb-3">
                                                <label for="comentario{{ $comentario->id }}" class="form-label">Comentario:</label>
                                                <textarea class="form-control" id="comentario{{ $comentario->id }}" name="comentario" rows="3" required>{{ $comentario->comentario }}</textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary" style="background-color: #439FA5; border-color: #439FA5;">Actualizar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.star-rating input').forEach((star) => {
        star.addEventListener('change', () => {
            console.log(`Calificación seleccionada: ${star.value}`);
        });
    });
</script>

@endsection
