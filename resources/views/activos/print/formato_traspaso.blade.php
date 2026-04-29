<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>FRM-24 - TRASPASO DE ACTIVOS</title>

    <style>
        @page {
            size: letter;
            margin: 8mm;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .logo {
            position: absolute;
            left: 0;
        }

        .titulo {
            text-align: center;
        }

        body {
            font-family: 'Lato', sans-serif;
            font-size: 12px;
            color: #000;
            line-height: 1.5;
        }

        .logo img {
            width: 140px;
            height: auto;
        }

        .titulo h1 {
            font-size: 14px;
            font-weight: bold;
            margin: 0;
            letter-spacing: 1px;
        }

        .titulo h2 {
            font-size: 12px;
            font-weight: bold;
            margin: 5px 0 0 0;
        }

        .titulo h3 {
            font-size: 11px;
            font-weight: bold;
            margin: 5px 0 0 0;
        }

        .info-superior {
            margin-bottom: 10px;
            margin-top: 10px;
        }

        .info-superior table {
            width: 100%;
        }

        .info-superior td {
            padding: 3px 0;
        }

        .info-superior .label {
            font-weight: lighter;
            width: 510px;
        }

        .linea {
            border-bottom: 1px solid #000;
            min-width: 200px;
            display: inline-block;
            margin-left: 5px;
        }

        .linea-larga {
            border-bottom: 1px solid #000;
            width: 100%;
            height: 18px;
            margin-top: 5px;
        }

        .seccion {
            margin-bottom: 20px;
        }

        .seccion h4 {
            font-size: 13px;
            font-weight: bold;
            margin: 15px 0 10px 0;
            padding-bottom: 3px;
            text-align: center;
        }

        .datos-bien {
            width: 100%;
            border-collapse: collapse;
        }

        .datos-bien td {
            padding: 4px 0;
            vertical-align: top;
        }

        .datos-bien .campo {
            font-weight: bold;
            width: 510px;
        }

        .firmas {
            margin-top: 30px;
            width: 100%;
            text-align: center;
        }

        .firma-bloque {
            width: 28%;
            display: inline-block;
            vertical-align: top;
            margin: 0 2%;
        }

        .firma-linea {
            margin-top: 50px;
            text-align: center;
        }

        .nombre {
            font-weight: bolder;
            margin-bottom: 8px;
            font-size: 9px;
        }

        .linea-firma {
            border-top: 1px solid #000;
            width: 80%;
            margin: 0 auto;
        }

        .cargo {
            margin-top: 5px;
            font-size: 10px;
        }

        .nota {
            margin-top: 45px;
            font-size: 10px;
            text-align: left;
            color: #555;
            padding: 0 20px;
            width: 400px;
        }

        .footer {
            position: fixed;
            bottom: 5mm;
            left: 15mm;
            right: 15mm;
            text-align: center;
            font-size: 10px;
            letter-spacing: 1px;
        }

        .footer p {
            margin: 2px 0;
            font-weight: normal;
        }

        .footer strong {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="logo">
            <img src="{{ public_path('images/logodif2025.svg') }}">
        </div>

        <div class="titulo">
            <h3>DEPARTAMENTO DE SERVICIOS GENERALES</h3>
            <h3>ÁREA DE ACTIVOS FIJOS</h3><br>

            <h1>MOVIMIENTOS DE ACTIVOS FIJOS</h1>
            <h2>FRM/24</h2>
        </div>
    </div>
    <table style="width: 60%; margin: 15px auto; margin-top:25px;">
        <tr>
            <td style="width: 50%; vertical-align: middle;">
                <h4 style="margin: 0; font-weight: lighter;">TIPO DE MOVIMIENTO:</h4>
            </td>

            <td style="width: 50%; text-align: right;">
                <table style="border-collapse: collapse; margin-left: auto;">
                    <tr>
                        <th style="border: 1px solid black; border-bottom: none; padding: 5px 10px; font-weight: lighter;">BAJA</th>
                        <th style="border: 1px solid black; border-bottom: none; padding: 5px 10px; font-weight: lighter;">TRASPASO</th>
                        <th style="border: 1px solid black; border-bottom: none; padding: 5px 10px; font-weight: lighter;">ASIGNACIÓN</th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; border-top: none;"></td>
                        <td style="border: 1px solid black; border-top: none; text-align: center; font-weight: bold; font-size:15px;">X</td>
                        <td style="border: 1px solid black; border-top: none;"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div class="info-superior">
        <table>
            <tr>
                <td class="label" style="font-size: 13px; font-weight: lighter;">DEPARTAMENTO:</td>
            </tr>
            <tr>
                <td class="label">
                    <span>Nombre del Departamento Resguardante:</span>
                    <span>
                        {{ $departamentoOrigen?->descripcion ?? 'SIN ASIGNACIÓN PREVIA' }}
                    </span>
                </td>

            </tr>
            <tr>
                <td class="label">
                    <span>Nuevo Departamento Resguardante:</span>
                    <span>{{ $departamentoDestino->descripcion ?? 'NO ASIGNADO' }}</span>
                </td>
            </tr>
            <tr>
                <td class="label">
                    <span>Fecha de Movimiento:</span>
                    <span style="margin-left: 10px;">
                        {{ \Carbon\Carbon::parse($activo->fecha_traspaso)->format('d/m/Y') }}
                    </span>
                </td>
            </tr>
        </table>
    </div>

    <div class="seccion">
        <h4>Datos Generales del Bien</h4>
        <table class="datos-bien">
            <tr>
                <td class="campo" style="font-weight: lighter;">
                    <span>No. De Inventario:</span>
                    <span style="margin-left: 10px;">
                        {{ $activo->numero_inventario }}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="campo">
                    <span>Descripción:</span>
                    <span style="margin-left: 10px; font-weight: lighter;">
                        {{ $activo->descripcion_corta }}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="campo">
                    <span>Marca:</span>
                    <span style="margin-left: 10px; font-weight: lighter;">
                        {{ $activo->marca ?? 'SIN MARCA' }}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="campo">
                    <span>Modelo:</span>
                    <span style="margin-left: 10px; font-weight: lighter;">
                        {{ $activo->modelo ?? 'SIN MODELO' }}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="campo">
                    <span>No. de Serie:</span>
                    <span style="margin-left: 10px; font-weight: lighter;">
                        {{ $activo->numero_serie ?? 'S/N SERIE' }}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="campo">
                    <span>Estado Físico del Bien:</span>
                    <span style="margin-left: 10px; font-weight: lighter;">
                        {{ $activo->estadoBien->descripcion ?? 'REGULAR' }}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="campo">
                    <span>Observaciones: (motivo del movimiento)</span><br>
                </td>
            </tr>
            <tr>
                <td>
                    <span style="margin-left: 10px; font-weight: lighter;">
                        {{ $activo->motivo_traspaso ?? 'Sin motivo especificado' }}
                    </span>
                </td>
            </tr>
        </table>
    </div>

    <div class="firmas">
        <div class="firma-bloque">
            <div class="firma-linea">
                <div class="nombre">
                    {{ $vobo->nombre_completo ?? '-' }}
                </div>
                <div class="linea-firma"></div>
                <div class="cargo">
                    Jefa de Depto. de Recursos Materiales,<br>
                    Control Vehicular y Almacén
                </div>
            </div>
        </div>
        <div class="firma-bloque">
            <div class="firma-linea">
                <div class="nombre">
                    {{ $elaboro->nombre_completo ?? '-' }}
                </div>
                <div class="linea-firma"></div>
                <div class="cargo">
                    Autorización Dirección Administrativa
                </div>
            </div>
        </div>

        <div class="firma-bloque">
            <div class="firma-linea">
                <div class="nombre">
                    {{ $empleadoDestino->nombre ?? '-' }}
                </div>
                <div class="linea-firma"></div>
                <div class="cargo">
                    Recibido por
                </div>
            </div>
        </div>
    </div>
    <div class="firma-bloque" style="text-align: center; margin-left: 26px; margin-right: auto; margin-top: -15px">
        <div class="firma-linea" style="text-align: center;">
            <div class="nombre" style="text-align: center;">
                {{ $empleadoOrigen->nombre ?? $activo->empleado_old ?? 'SIN ASIGNACIÓN PREVIA' }}
            </div>
            <div class="linea-firma" style=" width: 80%;">
            </div>
            <div class="cargo" style="text-align: center;">
                Entregó equipo
            </div>
        </div>
    </div>


    <div class="nota">
        Nota: Se firmará de entrega cuando el movimiento se trate de traspaso y baja o si el bien será depositado en algún almacén del Sistema o baja definitiva.
    </div>

    <div class="footer">
        <p><strong>SISTEMA PARA EL DESARROLLO INTEGRAL DE LA FAMILIA EN YUCATÁN</strong></p>
        <p>Avenida Alemán No. 355 Col. Itzimná C.P. 97100 Mérida, Yucatán, México</p>
        <p>Tel.: (999) 942 20 30 Fax: EXT.14361 Email: difadministrativa@yucatan.gob.mx</p>
    </div>
</body>

</html>