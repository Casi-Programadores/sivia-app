<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitud de Viático Nº {{ $solicitud->id }}</title>
    
    {{-- Vinculación al CSS externo usando public_path para DomPDF --}}
    <link rel="stylesheet" href="{{ resource_path('css/solicitud.css') }}">
    
</head>

<body>
<div class="hoja">

    {{-- ENCABEZADO --}}
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

    {{-- TÍTULO PRINCIPAL --}}
    <div class="titulo-principal">
        <h1>NOTA INTERNA Nº {{ $solicitud->numeroNotaInterna->numero ?? '____' }}</h1>
        <h2>SOLICITUD DE COMISIÓN DE SERVICIOS</h2>
    </div>

    {{-- FECHA Y LUGAR --}}
    <div class="fecha-lugar">
        FORMOSA, {{ $solicitud->created_at->format('d') }} DE {{ \Carbon\Carbon::parse($solicitud->created_at)->locale('es')->monthName }} DE {{ $solicitud->created_at->format('Y') }}
    </div>

    {{-- TEXTO INTRODUCTORIO --}}
    <div class="intro-texto">
        Se solicita gestionar ante la Superioridad la autorización para Comisión de Servicios de los agentes mencionados seguidamente:
    </div>

    {{-- TABLA --}}
    <table>
        <thead>
        <tr>
            <th width="30%">Nombre y Apellido</th>
            <th>N° Leg</th>
            <th>Asiento</th>
            <th>Cant.<br>días</th>
            <th>%</th>
            <th>Monto</th>
            <th>Destino</th>
            <th>Fecha<br>salida</th>
        </tr>
        </thead>

        <tbody>
        @php
            $cantidad = $solicitud->empleados->count();
            $montoInd = $cantidad > 0 ? ($solicitud->monto_total / $cantidad) : 0;
        @endphp

        @foreach($solicitud->empleados as $empleado)
            <tr>
                <td class="text-left uppercase">{{ $empleado->persona->apellido }}, {{ $empleado->persona->nombre }}</td>
                <td>{{ $empleado->numero_legajo }}</td>
                <td>SEDE</td>
                <td>{{ $solicitud->cantidad_dias }}</td>
                <td>{{ $solicitud->porcentaje->porcentaje ?? 100 }}</td>
                <td>$ {{ number_format($montoInd, 2, ',', '.') }}</td>
                <td class="uppercase" style="font-size: 8px;">
                    @if($solicitud->provincia)
                        {{ Str::limit($solicitud->provincia, 15) }}
                    @else
                        {{ $solicitud->distrito->distrito ?? '-' }}
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($solicitud->created_at)->format('d/m/Y') }}</td>
            </tr>
        @endforeach

        {{-- Relleno de filas --}}
        @for($i = 0; $i < (3 - $cantidad); $i++)
            <tr>
                <td style="height: 20px;"></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
        @endfor

        <tr>
            <td colspan="5" class="text-right" style="background-color: #f0f0f0;"><strong>TOTAL</strong></td>
            <td style="background-color: #f0f0f0;"><strong>$ {{ number_format($solicitud->monto_total, 2, ',', '.') }}</strong></td>
            <td colspan="2" style="background-color: #fff; border: none;"></td>
        </tr>
        </tbody>
    </table>

    {{-- CAMPOS DE TEXTO --}}
    <div class="campo-texto">
        <strong>SON PESOS:</strong> <span class="linea-completar">{{ $montoEnLetras }} .---</span>
    </div>

    <div class="campo-texto">
        <strong>OBJETO DE LA COMISIÓN:</strong> 
        <span class="linea-completar">
            {{ $solicitud->objeto_comision }} - 
            LOCALIDAD: {{ $solicitud->localidad->nombre_localidades ?? '-' }} - 
            DISTRITO: {{ $solicitud->distrito->distrito ?? '-' }}.-
        </span>
    </div>

    <div class="observaciones">
        <strong>OBSERVACIONES:</strong> {{ $solicitud->observacion ?? '------------------------------------------------' }}
    </div>

    {{-- FIRMAS --}}
    <table class="tabla-firmas">
        <tr>
            <td>
                <div class="firma-linea">VºBº - INGENIERO JEFE</div>
            </td>
            <td>
                <div class="firma-linea">FIRMA DEL SOLICITANTE</div>
            </td>
        </tr>
    </table>

    {{-- PIE DE PÁGINA --}}
    <div class="visto-considerando">
    <div class="footer-texto">
        DIRECCIÓN PROVINCIAL DE VIALIDAD, .......... de ............................. de 2025
    </div>

        <p>
            <strong>VISTO:</strong> estas actuaciones por las que se tramita la realización de una Comisión Oficial de Servicios solicitada por el Jefe del <strong>DEPARTAMENTO INGENIERÍA VIAL</strong>, y;

    
            <strong>CONSIDERANDO:</strong> que el procedimiento utilizado se ajusta al régimen implantado en la Repartición y demás Normas aplicables para el efecto.
            
            EL ADMINISTRADOR GENERAL DE LA DIRECCIÓN PROVINCIAL DE VIALIDAD
            RESUELVE
        
            Ratificar lo actuado para la realización de la Comisión Oficial de Servicios, tramitada en autos por el Jefe del <strong>DEPARTAMENTO INGENIERÍA VIAL</strong>, conforme a las constancias precedentes. Regístrase y dése intervención a quienes corresponda, cumplido ARCHÍVESE.-
        </p>
    </div>

    <div class="resolucion">
        RESOLUCIÓN Nº ______________
    </div>

</div>
</body>
</html>