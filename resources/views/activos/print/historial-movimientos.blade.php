<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Historial de Movimientos - {{ $activo->numero_inventario }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Lato', sans-serif;
            font-size: 11px;
            color: #000000;
            line-height: 1.4;
            padding: 10px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .logo {
            position: absolute;
            left: 0;
        }

        .logo img {
            width: 140px;
            height: auto;
            margin-left: 20px;
        }

        .titulo {
            text-align: center;
            margin-top: 90px;
            margin-left: 10px;
        }

        .header h1 {
            font-size: 14px;
            font-weight: bold;
            margin: 5px 0;
        }

        .header h2 {
            font-size: 12px;
            font-weight: bold;
            margin: 3px 0;
        }

        .tabla-check {
            border-collapse: collapse;
            float: right;
        }

     

        .tabla-check th {
            font-weight: normal;
            background-color: #f5f5f5;
        }

        .info-superior {
            margin: 15px 0;
            width: 100%;
        }

        .info-superior table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-superior td {
            padding: 5px 0;
        }

        .label {
            width: 250px;
            font-weight: bold;
        }


        .datos-bien {
            width: 100%;
            border-collapse: collapse;
        }

        .datos-bien td {
            padding: 6px 0;
            vertical-align: top;
        }

        .campo {
            font-weight: bold;
            width: 180px;
        }

        .tabla-movimientos {
            margin: 20px 0;
        }

        .tabla-movimientos h4 {
            font-size: 12px;
            font-weight: bold;
            margin: 10px 0;
            padding: 6px;
            background-color: #f5f5f5;
            text-align: center;
            border: 1px solid #dddddd;
        }

        .data-table {
            width: 90%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10px;
        }

        .data-table th {
            color: #000000;
            padding: 8px 6px;
            text-align: left;
        }

        .data-table td {
            padding: 6px;
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .float-right {
            float: right;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">
            <img src="{{ public_path('images/logodif2025.svg') }}">
        </div>
        <div class="titulo">
            <h1>SISTEMA PARA EL DESARROLLO INTEGRAL DE LA FAMILIA EN YUCATÁN</h1>
            <h2>HISTÓRICO DE MOVIMIENTO DE UN ACTIVO</h2>
        </div>
    </div>


    <div class="info-superior" style="display: flex; justify-content: center;">
        <table style="width: auto; margin: 0 auto; border-collapse: collapse;">
            <tr>
                <td style="padding: 2px 4px; white-space: nowrap;">
                    <strong>No. DE INVENTARIO:</strong>
                </td>
                <td style="padding: 4px 8px; white-space: nowrap;">
                    {{ $activo->numero_inventario }}
                </td>
                <td style="padding: 6px 10px;">
                    MÓDULO DE RECEPCIÓN
                </td>
            </tr>
        </table>
    </div>

    <div class="tabla-movimientos">
        <table class="data-table">
            <thead>
                <tr>
                    <th width="12%">FECHA MOV.</th>
                    <th width="20%">ORIGEN</th>
                    <th width="20%">DESTINO</th>
                    <th width="15%">SERIE</th>
                    <th width="33%">OBSERVACIONES</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movimientos as $mov)
                <tr>
                    <td align="center">{{ \Carbon\Carbon::parse($mov->fecha)->format('d/m/Y') }}</td>
                    <td>
                        @if($mov->origen_clave != '-')
                        <strong>{{ $mov->origen_clave }}</strong><br>
                        @endif
                        {{ $mov->origen }}
                    </td>
                    <td>
                        @if($mov->destino_clave != '-')
                        <strong>{{ $mov->destino_clave }}</strong><br>
                        @endif
                        {{ $mov->destino }}
                    </td>
                    <td align="center">{{ $mov->serie }}</td>
                    <td>{{ $mov->observaciones }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" align="center">No hay movimientos registrados para este activo</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>

</html>