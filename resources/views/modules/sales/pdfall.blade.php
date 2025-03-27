<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h2>Reporte de Ventas</h2>

    @foreach ($sales as $sale)
        <h3>Venta #{{ $sale->id }}</h3>
        <p><strong>Cliente:</strong> {{ $sale->customer->name }}</p>
        <p><strong>Empleado:</strong> {{ $sale->employee->name }}</p>
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y H:i') }}</p>
        <p><strong>Método de Pago:</strong> {{ $sale->payment_method }}</p>
        <p><strong>Comentarios:</strong> {{ $sale->comments }}</p>

        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sale->saleDetails as $detail)
                    <tr>
                        <td>{{ $detail->product->name }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>${{ number_format($detail->unit_price, 2) }}</td>
                        <td>${{ number_format($detail->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h4>Total: ${{ number_format($sale->total, 2) }}</h4>
        <hr>
    @endforeach
</body>
</html>
