<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>FRM-23 - Altas de Activos</title>

<style>
@page {
    size: letter;
    margin: 6mm;
}

body {
    font-family: 'lato', sans-serif;
    font-size: 12px;
    color: #000;
}

.header {
    text-align: center;
    line-height: 1.4;
}
.logo img{
    width: 140px;
    height: auto;
 }
.titulo {
    text-align: center;
    font-weight: bold;
    margin-top: -100px;
    margin-bottom: 25px;
}

.titulo h2 {
    margin: 0;
    font-size: 12px;
    letter-spacing: 1px;
    font-family:'lato', sans-serif;
    font-weight: lighter;
}

.titulo h3 {
    margin: 4px 0 0 0;
    font-size: 14px;
    letter-spacing: 1px;
    font-family:'lato', sans-serif;
    font-weight: bold;
}

.info-superior {
    margin-bottom: 30px;
    margin-top: 35px;
    padding-left: 15%;
    padding-right: 15%;
}

.info-superior span {
    display: inline-block;
    width: 48%;
}

.numero {
    margin-bottom: 18px;
    margin-left: 7%;
    letter-spacing: .5px;
}

.numero span.label {
    font-weight: bold;
    margin-left: 10px;
}

.donacion {
    margin-bottom: 10px;
    margin-left: 20px;
}
.donacion span.label {
    letter-spacing: 1px;
}

.linea {
    display: inline-block;
    border-bottom: 1px solid #000;
    width: 250px;
    height: 14px;
}

.linea-corta {
    display: inline-block;
    border-bottom: 1px solid #000;
    width: 120px;
    height: 14px;
}

.firmas {
    margin-top: 60px;
    width: 100%;
    text-align: center;
}

.firma-bloque {
    width: 45%;
    display: inline-block;
    vertical-align: top;
}

.firma-linea {
    margin-top: 60px;
    border-top: 1px solid #000;
    padding-top: 5px;
    font-size: 11px;
}

.footer {
    position: fixed;
    bottom: 5mm;
    left: 20mm;
    right: 20mm;
    text-align: center;
    font-size: 10px;
}

.footer h4 {
    font-size: 10px;
    font-weight: bold;
    letter-spacing: 2px;
    margin-bottom: 10px;
}
.footer h5 {
    font-size: 10px;
    font-weight: lighter;
    letter-spacing: 2px;
    margin: 0;
}
</style>
</head>

<body>

<table style="margin-bottom:20px;">
    <tr>
        <td class="logo">
            <img src="{{ public_path('images/logodif2025.svg') }}">
        </td>
    </tr>
</table>


<div class="titulo">
    <h2>DEPARTAMENTO DE SERVICIOS GENERALES</h2>
    <h2>ÁREA DE ACTIVOS FIJOS</h2><br>
    <h3>ALTAS DE ACTIVOS</h3>
    <h3>FRM/23</h3>
</div>

<div class="info-superior">
    <span>FECHA DE ALTA: {{ $activo->created_at ? $activo->created_at->format('d/m/Y') : '' }}
</span>
    <span style="text-align:right;" >No. DE INVENTARIO: {{ $activo->numero_inventario ?? '________' }}</span>
</div>

<div class="numero"><strong>1.</strong> <span class="label">Descripción:</span> {{ $activo->descripcion_corta ?? '' }}</div>
<div class="numero"><strong>2.</strong> <span class="label">Marca:</span> {{ $activo->marca ?? '' }}</div>
<div class="numero"><strong>3.</strong> <span class="label">Modelo:</span> {{ $activo->modelo ?? '' }}</div>
<div class="numero"><strong>4.</strong> <span class="label">No. de Serie:</span> {{ $activo->numero_serie ?? '' }}</div>
<div class="numero"><strong>5.</strong> <span class="label">Proveedor:</span> {{ $activo->proveedor->nomcorto ?? '' }}</div>
<div class="numero"><strong>6.</strong> <span class="label">No. de Factura:</span> {{ $activo->numero_factura ?? '' }} </div>
<div class="numero"><strong>7.</strong> <span class="label">Costo del Bien:</span> ${{ number_format($activo->costo ?? 0, 2) }}</div>
<div class="numero"><strong>8.</strong> <span class="label">Fecha de Recepción:</span> {{ $activo->created_at ? $activo->created_at->format('d/m/Y') : '' }}
</div>
<div class="numero"><strong>9.</strong> <span class="label">Número de folio de Entrada a Almacén:</span> {{ $activo->folio }}</div>
<div class="numero"><strong>10.</strong> <span class="label">Estado físico del Bien:</span> {{ $activo->estadoBien->descripcion ?? '' }}</div>

<br>

<div class="donacion"><span class="label">Donación:</span> {{ $activo->es_donacion ? 'SI' : 'NO' }}</div>
<div class="donacion"><span class="label">1. Datos del Donante:</span> {{ $activo->donante ?? '' }}</div>
<div class="donacion"><span class="label">Observaciones:</span> {{ $activo->observaciones }}</div>
<br><br>

<div class="firmas">
    <div class="firma-bloque">
        Elaboró
        
        <div class="firma-linea">
            TSU. CARLOS ALBERTO QUINTAL ROSADO<br>
            Responsable de Control de Activos Fijos
        </div>
    </div>

    <div class="firma-bloque">
        Vo.Bo.
        <div class="firma-linea">
            L.A. SHARA ELENA ROMERO CRUZ<br>
            Jefa de Depto. de Recursos Materiales,
            Control Vehicular y Almacén
        </div>
    </div>
</div>

<div class="footer">
    <h4>SISTEMA PARA EL DESARROLLO INTEGRAL DE LA FAMILIA EN YUCATÁN</strong></h4><strong>
    <h5>Avenida Alemán No. 355 Col. Itzimná C.P. 97100 Mérida, Yucatán, México</h5>
    <h5>Tel.: (999) 942 20 30 Fax: EXT.14361 Email: difadministrativa@yucatan.gob.mx</h5>
</div>
</body>
</html>
