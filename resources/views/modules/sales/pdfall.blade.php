<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            width: 100%;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
            padding: 10px;
        }

        .Encabezado {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .table-container {
            max-width: 100%;
            overflow-x: auto;
        }

        .table {
            width: 100%;
            margin: 0 auto;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .table th,
        .table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
            word-wrap: break-word;
        }

        .thead-dark th {
            background-color: #92bddf !important;
            color: white;
            border-color: #92bddf !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="Encabezado">
            <img src="{{ public_path('assets/img/logohorizontal.png') }}" alt="Logo"
                style="width: 300px; height: 100px; margin:auto;">
        </div>

        <p class="h3" style="color: #4E64A6">{{ $title }}</p>
        <div style="display: flex; align-items: center;">
            <p class="h5" style="margin-right: 2px; color: #4E64A6;">Fecha de emisión:</p>
            <p style="color: #4E64A6">{{ $date }}</p>
        </div>

        @foreach ($sales as $sale)
            <h4>Venta #{{ $sale->id }}</h4>
            <div class="table-container">
                <table class="table">
                    <tr>
                        <th>Cliente</th>
                        <td>{{ $sale->customer->name }}</td>
                    </tr>
                    <tr>
                        <th>Empleado</th>
                        <td>{{ $sale->employee->name }}</td>
                    </tr>
                    <tr>
                        <th>Fecha</th>
                        <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Método de Pago</th>
                        <td>{{ $sale->payment_method }}</td>
                    </tr>
                    <tr>
                        <th>Comentarios</th>
                        <td>{{ $sale->comments }}</td>
                    </tr>
                </table>
            </div>

            <div class="table-container">
                <table class="table">
                    <thead class="thead-dark">
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
                <br>
                <h5>Total: ${{ number_format($sale->total, 2) }}</h5>
                <hr>
        @endforeach
    </div>
    </div>
</body>

</html>
