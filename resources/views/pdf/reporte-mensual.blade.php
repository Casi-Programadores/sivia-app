<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Mensual de Liquidaciones</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 16px; text-transform: uppercase; }
        .header p { margin: 2px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #999; padding: 5px; text-align: left; }
        th { background-color: #eee; font-weight: bold; text-transform: uppercase; font-size: 9px; }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-row td { font-weight: bold; background-color: #e0e0e0; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Dirección Provincial de Vialidad</h1>
        <p>Reporte de Liquidaciones de Viáticos</p>
        <p><strong>Período: {{ $mes }}</strong></p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="10%">Fecha</th>
                <th width="10%">Nota Nº</th>
                <th width="10%">Legajo</th>
                <th width="30%">Agente</th>
                <th width="20%">Destino</th>
                <th width="5%" class="text-center">Días</th>
                <th width="15%" class="text-right">Monto Liquidado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($filasReporte as $fila)
                <tr>
                    <td>{{ $fila['fecha'] }}</td>
                    <td>{{ $fila['nota'] }}</td>
                    <td>{{ $fila['legajo'] }}</td>
                    <td>{{ $fila['empleado'] }}</td>
                    <td>{{ $fila['destino'] }}</td>
                    <td class="text-center">{{ $fila['dias'] }}</td>
                    <td class="text-right">$ {{ number_format($fila['monto'], 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="6" class="text-right">TOTAL GENERAL</td>
                <td class="text-right">$ {{ number_format($totalMontoGlobal, 2, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 20px; font-size: 9px; color: #555;">
        Reporte generado el {{ now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>