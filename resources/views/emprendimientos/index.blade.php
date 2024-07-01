@extends('layouts.app')

@section('content')

<div class="container">
    <h2 class="mb-4" style="text-align: center">Listado de Emprendimientos</h2>
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
                    <a href="#" class="btn btn-primary mt-auto" style="background-color: #439FA5; border-color: #439FA5;">Ver más</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
