<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos Pendientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Pedidos Pendientes</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Emprendimiento</th>
                <th>Solicitante</th>
                <th>Mensaje</th>
                <th>Fecha de Creación</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedidos as $pedido)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $pedido->emprendimiento->nombre }}</td>
                    <td>{{ $pedido->estudiante->nombre }} {{ $pedido->estudiante->apellido }}</td>
                    <td>{{ $pedido->mensaje }}</td>
                    <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
