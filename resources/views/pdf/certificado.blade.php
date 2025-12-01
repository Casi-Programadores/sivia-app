<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Certificación de Servicios</title>
    <link rel="stylesheet" href="{{ resource_path('css/certificado.css') }}">
</head>
<body>

    {{--1. ENCABEZADO --}}
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
    {{-- 2. TÍTULO --}}
    <div class="titulo-certificacion">CERTIFICACIÓN</div>

    {{-- 3. CUERPO DEL CERTIFICADO --}}
    <div class="cuerpo-texto text-justify">
        CERTIFICO, que el Agente <strong>{{ $empleado->persona->apellido }}, {{ $empleado->persona->nombre }}</strong> 
        dependiente del Departamento <strong>{{ $empleado->departamento->departamento ?? '_______' }}</strong> y PROYECTOS
        DOC: C.I / L.E / D.N.I. Nº <strong>{{ number_format($empleado->persona->dni, 0, '.', '.') }}</strong> 
        ha realizado tareas inherentes a sus funciones desde: 
        <strong>{{ \Carbon\Carbon::parse($solicitud->created_at)->format('d/m/Y') }}</strong> en esta Jurisdicción .-
        <br>
        Se expide la presente en cumplimiento de la Acordada Nº 26/84 de la Comisión Paritaria Provincial, 
        ratificada por Acuerdo Nº 146/84, del Organismo.-
    </div>

    {{-- 4. FIRMA DEL JEFE --}}
    <div class="firma-jefe-container">
        <div class="firma-jefe-box">
            <div style="height: 40px;"></div>
            <div class="firma-linea"></div>
            <strong>FIRMA JEFE</strong>
        </div>
    </div>

    {{-- 5. FECHA CENTRAL --}}
    <div class="fecha-central">
        FORMOSA {{ now()->format('d/m/Y') }}
    </div>

    {{-- 6. PLANILLA DE MOVIMIENTOS --}}
    <div class="tabla-contenedor">
        <div class="tabla-titulo">PLANILLA DE MOVIMIENTO DE VIATICOS</div>
        <div class="tabla-subtitulo uppercase">
            RESIDENCIA HABITUAL DEL TRABAJADOR: SEDE CENTRAL
        </div>
        <div class="tabla-mes-anio uppercase">
            <table width="100%">
                <tr>
                    <td style="border:none; text-align:left;">MES: {{ \Carbon\Carbon::parse($solicitud->created_at)->locale('es')->monthName }}</td>
                    <td style="border:none; text-align:right;">AÑO: {{ \Carbon\Carbon::parse($solicitud->created_at)->format('Y') }}</td>
                </tr>
            </table>
        </div>

        <table class="grilla">
            <thead>
                <tr>
                    <th rowspan="2" width="10%">DIA</th>
                    <th colspan="2" width="30%">MOVIMIENTO</th>
                    <th colspan="2" width="20%">HORA DE</th>
                    <th rowspan="2" width="15%">MEDIO DE<br>TRANSPORTE</th>
                    <th rowspan="2" width="10%">PORCENTAJE</th>
                    <th rowspan="2" width="15%">OBJETO DE<br>LA COMISIÓN</th>
                </tr>
                <tr>
                    <th>DE:</th>
                    <th>A:</th>
                    <th>SALIDA</th>
                    <th>LLEGADA</th>
                </tr>
            </thead>
            <tbody>
                {{-- Fila con los datos reales --}}
                <tr>
                    <td>{{ \Carbon\Carbon::parse($solicitud->created_at)->format('d/m/Y') }}</td>
                    <td colspan="2" class="uppercase">COMISIÓN DE SERVICIOS</td>
                    <td></td> 
                    <td></td> 
                    <td></td> 
                    <td>{{ $solicitud->porcentaje->porcentaje }}%</td>
                    
                    {{-- CAMBIO AQUÍ: Objeto de comisión agregado --}}
                    <td class="uppercase texto-chico" style="padding: 2px;">
                        {{ Str::limit($solicitud->objeto_comision, 50) }}
                    </td>
                </tr>

                {{-- Filas vacías de relleno --}}
                @for($i=0; $i<10; $i++)
                <tr>
                    <td>&nbsp;</td>
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>

    {{-- 7. DECLARACIÓN JURADA (PIE) --}}
    <div class="declaracion-titulo">DECLARACIÓN JURADA</div>

    <div class="cuerpo-texto text-justify" style="font-size: 10px;">
        Señor Jefe: <strong>INGENIERÍA VIAL</strong><br><br>
        
        El que suscribe <strong>{{ $empleado->persona->apellido }}, {{ $empleado->persona->nombre }}</strong>, 
        Trabajador dependiente del Departamento <strong>{{ $empleado->departamento->departamento ?? '_______' }}</strong> 
        declara bajo juramento y con pleno conocimiento de las sanciones y penalidades que corresponden al que incurra 
        en la falsedad en una Declaración Jurada, que durante el cumplimiento de la Comisión Oficial de Servicios dispuesta 
        por la <strong>RESOLUCIÓN Nº {{ $solicitud->detalle->resolucion->numero_resolucion ?? '____' }}</strong> 
        se efectuó la liquidación del {{ $solicitud->porcentaje->porcentaje }}%.
    </div>

    {{-- 8. FIRMA TRABAJADOR --}}
    <div class="firma-trabajador-container">
        <div style="display: inline-block; text-align: center; width: 150px;">
            <div style="height: 30px;"></div>
            <div class="firma-linea"></div>
            Firma del trabajador
        </div>
    </div>

</body>
</html>