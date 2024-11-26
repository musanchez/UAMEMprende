<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Pedido Recibido</title>
</head>
<body>
    <h1>Has recibido un nuevo pedido para tu emprendimiento {{ $pedido->emprendimiento->nombre }}</h1>
    <p><strong>Mensaje del pedido:</strong></p>
    <p>{{ $pedido->mensaje }}</p>
    <p>Por favor, revisa la solicitud y acepta o rechaza el pedido desde tu cuenta en UAMEmprende.</p>
</body>
</html>
