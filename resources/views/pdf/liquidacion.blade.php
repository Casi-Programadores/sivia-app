<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Liquidación de Viáticos</title>
    <link rel="stylesheet" href="{{ resource_path('css/liquidacion.css') }}">
</head>
<body>

    {{-- 1. ENCABEZADO --}}
    <div class="logos">
        <div class="logo-container">
             <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/escudo.gif'))) }}" width="45">
             <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo-vialidad.png'))) }}" width="45">
        </div>
        {{-- Texto --}}
        <br>Dirección Provincial De Vialidad<br>
        <span style="font-weight: normal; font-size: 9px;">
            Jujuy 599 - Tel 0370 - 4426048 - Fax: 0370 - 4426090<br>
            3600 - FORMOSA
        </span>
    </div>

    {{-- 2. AUTORIZACIÓN Y FECHA --}}
    <div class="autorizacion-box">
        AUTORIZADO POR RESOLUCIÓN Nº {{ $solicitud->detalle->resolucion->numero_resolucion ?? '____' }}
    </div>

    <div class="fecha-top">
        {{-- Fecha actual de generación del PDF --}}
        FORMOSA {{ now()->format('d/m/Y') }}
    </div>

    <div class="titulo-principal">LIQUIDACIÓN DE VIÁTICOS</div>

    {{-- 3. DEPARTAMENTO --}}
    <div class="dato-fila uppercase">
        <span class="label">DEPARTAMENTO:</span> 
        {{ $empleado->departamento->departamento ?? 'INGENIERÍA VIAL' }}
    </div>

    {{-- 4. TABLA GRILLA (Replicando la foto) --}}
    <table class="tabla-liq">
        <thead>
            <tr>
                <th width="15%">FECHA DE SALIDA</th>
                <th width="15%">FECHA DE ENTRADA</th>
                <th width="10%">TOTAL DE DÍAS</th>
                <th width="15%">IMPORTE POR DÍA</th>
                <th width="15%">TOTAL LIQUIDACIÓN</th>
            </tr>
        </thead>
<tbody>
    <tr>
        {{-- COLUMNA 1: FECHA DE SALIDA --}}
        <td style="padding: 0;"> {{-- Quitamos padding para que la tabla interna ocupe todo --}}
            <table width="100%" style="border: none; border-collapse: collapse;">
                <tr>
                    <td style="border: none; text-align: left; padding: 2px 5px;">DÍA:</td>
                    <td style="border: none; text-align: right; padding: 2px 5px;">
                        {{ $solicitud->created_at->format('d/m/Y') }}
                    </td>
                </tr>
                <tr>
                    <td style="border: none; text-align: left; padding: 2px 5px;">HORA:</td>
                    <td style="border: none; text-align: right; padding: 2px 5px;">
                        08:00
                    </td>
                </tr>
            </table>
        </td>
        
        {{-- COLUMNA 2: FECHA DE ENTRADA --}}
        <td style="padding: 0;">
            <table width="100%" style="border: none; border-collapse: collapse;">
                <tr>
                    <td style="border: none; text-align: left; padding: 2px 5px;">DÍA:</td>
                    <td style="border: none; text-align: right; padding: 2px 5px;">
                        {{ \Carbon\Carbon::parse($solicitud->fecha_fin)->format('d/m/Y') }}
                    </td>
                </tr>
                <tr>
                    <td style="border: none; text-align: left; padding: 2px 5px;">HORA:</td>
                    <td style="border: none; text-align: right; padding: 2px 5px;">
                        {{ \Carbon\Carbon::parse($solicitud->fecha_fin)->format('H:i') }}
                    </td>
                </tr>
            </table>
        </td>

        {{-- Días --}}
        <td style="font-size:12px; font-weight:bold;">{{ $solicitud->cantidad_dias }}</td>

        {{-- Importe Base --}}
        <td>{{ number_format($importeDiario, 2, ',', '.') }}</td>

        {{-- Total --}}
        <td class="bold">{{ number_format($totalLiquidacion, 2, ',', '.') }}</td>
    </tr>
    
    {{-- (El resto de las filas sigue igual...) --}}
    <tr>
        <td colspan="2" class="celda-provincia">
            <table width="100%" style="border: none;">
                <tr>
                    <td style="border: none; text-align: left; padding: 0;">REALIZADA EN LA PROVINCIA:</td>
                    <td style="border: none; text-align: right; padding: 0; padding-right: 20px;">
                        {{ !$solicitud->provincia ? 'X' : '' }}
                    </td>
                </tr>
            </table>
        </td>
        <td colspan="3" class="celda-provincia">
             <table width="100%" style="border: none;">
                <tr>
                    <td style="border: none; text-align: left; padding: 0;">FUERA DE LA PROVINCIA:</td>
                    <td style="border: none; text-align: right; padding: 0; padding-right: 20px;">
                        {{ $solicitud->provincia ? 'X' : '' }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</tbody>
    </table>

    {{-- 5. DATOS DEL AGENTE Y OBJETO --}}
    <div class="cuerpo-datos">
        
        {{-- Objeto: Cumplimentar arriba, detalle real abajo --}}
        <div>
            <span class="label">OBJETO DE LA COMISIÓN:</span> 
            <span class="dato-valor">{{ $solicitud->objeto_comision }}</span>
        </div>

        <div style="margin-left: 145px; font-size: 10px;">
            Cumplimentar Resolución Nº 
            <span class="bold" style="font-size: 14px; margin-left: 10px;">
                {{ $solicitud->detalle->resolucion->numero_resolucion ?? '____' }}
            </span>
        </div>
        
        <div style="margin-top: 20px;">
            <span class="label">APELLIDOS Y NOMBRES:</span>
            <span class="dato-valor bold">{{ $empleado->persona->apellido }}, {{ $empleado->persona->nombre }}</span>
        </div>

        <div style="margin-top: 10px;">
            <span class="label">CLASE:</span>
            <span class="dato-valor">{{ $empleado->clase->numero_clase ?? '______' }}</span>
        </div>

    </div>

    {{-- 6. FIRMA TRABAJADOR --}}
    <div class="firma-trabajador">
        <div style="height: 40px;"></div>
        <div class="firma-linea"></div>
        FIRMA DEL TRABAJADOR
    </div>

    {{-- 7. CERTIFICACIÓN INFERIOR (Footer) --}}
    <div class="footer-cert">
        <div class="cert-texto">
            CERTIFICO: que los datos consignados en la presente solicitud son exactos como asimismo, que 
            la comisión de que se trata se realizó por razones de servicios conforme a lo dispuesto por
        </div>

        <div class="resolucion-footer">
            RESOLUCIÓN Nº {{ $solicitud->detalle->resolucion->numero_resolucion ?? '____' }}
        </div>

        <div class="mb-20">
            FORMOSA {{ now()->format('d/m/Y') }}
        </div>

        <div class="firma-jefe-footer">
            <div style="display:inline-block; text-align:center; width: 200px;">
                <div class="firma-linea"></div>
                <strong>JEFE DE DEPARTAMENTO</strong>
            </div>
        </div>
    </div>

</body>
</html>