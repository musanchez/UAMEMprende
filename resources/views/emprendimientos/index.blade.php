@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Listado de Emprendimientos</h2>
</div>
<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Imagen</th>
                <th>Emprendedor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($emprendimientos as $emp)
                <tr>
                    <td>{{ $emp->nombre }}</td>
                    <td>{{ $emp->descripcion }}</td>
                    <td>{{ $emp->imagen }}</td>
                    <td>{{ $emp->emprendedor_id }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection