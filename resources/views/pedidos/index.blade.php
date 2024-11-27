@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-center" style="color: #439FA5;">Mis Pedidos</h1>

        <!-- Botón para Exportar a PDF con Icono -->
        <a href="{{ route('pedidos.exportar.pdf') }}" class="btn btn-outline-primary d-flex align-items-center" style="border-radius: 8px;">
            <i class="fas fa-file-pdf me-2"></i> Exportar Pedidos Pendientes a PDF
        </a>
    </div>

    <!-- Mensaje aclaratorio sobre la exportación -->
    <p class="text-muted text-center mb-4">Nota: Solo se exportarán los pedidos en estado <strong>pendiente</strong>.</p>

    @if($pedidos->isEmpty())
        <div class="alert alert-info text-center">No tienes pedidos pendientes.</div>
    @else
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="text-white" style="background-color: #439FA5;">
                    <tr>
                        <th>#</th>
                        <th>Emprendimiento</th>
                        <th>Solicitante</th>
                        <th>Estado</th>
                        <th>Mensaje</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedidos as $pedido)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pedido->emprendimiento->nombre }}</td>
                            <td>{{ $pedido->estudiante->nombre }} {{ $pedido->estudiante->apellido }}</td>
                            <td>
                                <span class="badge
                                    @if($pedido->estado == 'pendiente') bg-warning text-dark
                                    @elseif($pedido->estado == 'aceptado') bg-success
                                    @elseif($pedido->estado == 'rechazado') bg-danger
                                    @endif">
                                    {{ ucfirst($pedido->estado) }}
                                </span>
                            </td>
                            <td>{{ $pedido->mensaje }}</td>
                            <td class="text-center">
                                @if($pedido->estado == 'pendiente')
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updatePedidoModal{{ $pedido->id }}" style="background-color: #439FA5; border-color: #439FA5; border-radius: 8px;">
                                        Actualizar
                                    </button>
                                @endif
                                <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#pedidoModal{{ $pedido->id }}" style="background-color: #6C757D; border-color: #6C757D; border-radius: 8px;">
                                    Ver Detalles
                                </button>
                            </td>
                        </tr>

                        <!-- Modal para actualizar el pedido -->
                        <div class="modal fade" id="updatePedidoModal{{ $pedido->id }}" tabindex="-1" aria-labelledby="updatePedidoModalLabel{{ $pedido->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color: #439FA5;">
                                        <h5 class="modal-title text-white" id="updatePedidoModalLabel{{ $pedido->id }}">Actualizar Pedido</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="background-color: #F0F0F0;">
                                        <form action="{{ route('pedidos.update', $pedido->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="form-group mb-3">
                                                <label for="estado" class="form-label">Estado del Pedido:</label>
                                                <select name="estado" id="estado" class="form-control" required>
                                                    <option value="aceptado">Aceptar</option>
                                                    <option value="rechazado">Rechazar</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="razon" class="form-label">Razón (opcional):</label>
                                                <textarea class="form-control" id="razon" name="razon" rows="3"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary" style="background-color: #439FA5; border-color: #439FA5;">Actualizar Pedido</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal para detalles del pedido -->
                        <div class="modal fade" id="pedidoModal{{ $pedido->id }}" tabindex="-1" aria-labelledby="pedidoModalLabel{{ $pedido->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color: #6C757D;">
                                        <h5 class="modal-title text-white" id="pedidoModalLabel{{ $pedido->id }}">Detalles del Pedido</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="background-color: #F0F0F0;">
                                        <h5><strong>Emprendimiento:</strong> {{ $pedido->emprendimiento->nombre }}</h5>
                                        <p><strong>Solicitante:</strong> {{ $pedido->estudiante->nombre }} {{ $pedido->estudiante->apellido }}</p>
                                        <p><strong>Correo:</strong> {{ $pedido->estudiante->email }}</p>
                                        <p><strong>Teléfono:</strong> {{ $pedido->estudiante->celular }}</p>
                                        <p><strong>Mensaje:</strong> {{ $pedido->mensaje }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
