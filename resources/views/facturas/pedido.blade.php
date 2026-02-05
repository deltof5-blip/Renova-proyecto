<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Factura pedido #{{ $pedido->id }}</title>
    <style>
        * { font-family: DejaVu Sans, sans-serif; }
        body { font-size: 12px; color: #1f2937; }
        .header { display: flex; justify-content: space-between; margin-bottom: 24px; }
        .brand { font-size: 20px; font-weight: 700; color: #9747ff; }
        .muted { color: #6b7280; }
        .box { border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        .table th, .table td { border-bottom: 1px solid #e5e7eb; padding: 8px; text-align: left; }
        .table th { background: #f9fafb; font-weight: 600; }
        .right { text-align: right; }
        .total { font-size: 16px; font-weight: 700; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <div class="brand">Renova</div>
            <div class="muted">Factura de pedido</div>
        </div>
        <div>
            <div><strong>Pedido:</strong> #{{ $pedido->id }}</div>
            <div><strong>Fecha:</strong> {{ $pedido->created_at?->format('d/m/Y H:i') }}</div>
        </div>
    </div>

    <div class="box">
        <strong>Datos de envío</strong><br>
        {{ $pedido->nombre }} {{ $pedido->apellidos }}<br>
        {{ $pedido->direccion }}<br>
        {{ $pedido->codigo_postal }} {{ $pedido->ciudad }} ({{ $pedido->provincia }})<br>
        Tel: {{ $pedido->telefono }}
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th class="right">Precio unitario</th>
                <th class="right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
                <tr>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->cantidad }}</td>
                    <td class="right">{{ number_format($producto->precio_unitario, 2) }} €</td>
                    <td class="right">{{ number_format($producto->precio_unitario * $producto->cantidad, 2) }} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 16px;" class="right">
        <div class="muted">IVA incluido</div>
        <div class="total">Total: {{ number_format($pedido->total, 2) }} €</div>
    </div>
</body>
</html>
