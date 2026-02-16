<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Resguardo de Bienes Muebles</title>

<style>
@page {
    size: letter;
    margin: 6mm;
}

body {
    font-family: 'lato', sans-serif;
    font-size: 11px;
    color: #000;
}

/* =======================
   HEADER
======================= */

.header-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 15px;
}

.header-table td {
    border: none;
    vertical-align: middle;
}

.logo-cell {
    width: 90px;
    text-align: center;
}

.logo-left img {
    max-width: 110px;
}

.logo-right img {
    max-width: 55px;
    margin-left: 38px;
}

.header-text {
    text-align: center;
    font-size: 14px;
    font-family: 'lato', sans-serif;
}

.header-text .title1 {
    font-size: 14px;
    margin-top: 6px;
    font-weight: bold;
}
.header-text .title2 {
    font-size: 14px;
    font-weight: bold;
}

.header-text .title {
    margin-top: 8px;
    font-size: 14px;
    letter-spacing: 1px;
    font-family: 'lato', sans-serif;
    font-weight: bold;
}

/* =======================
   TABLAS GENERALES
======================= */

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 10px;
}

td, th {
    border: 0.7px solid #000;
    padding: 4px;
    vertical-align: top;
    padding-left: 10px;
}

th {
    text-align: left;
    font-family: 'lato', sans-serif;
    font-size: 13px;
}
td {
    font-family: 'lato', sans-serif;
    font-size: 12px;
    padding-left: 15px;
    height: 25px;
}


/* =======================
   ETIQUETAS
======================= */

.label {
    font-weight: bold;
    width: 25%;
}

/* =======================
   OBSERVACIONES
======================= */

.observaciones {
    height: 90px;
}


/* =======================
   FIRMAS
======================= */

.firmas {
    margin-top: 15px;
    width: 100%;
}

.firmas td {
    height: 75px;
    font-size: 10px;
    vertical-align: bottom;
}

.firmas th {
    font-size: 11px;
}

.nombre {
    text-align: left;
    margin-bottom: 20px;
}

.puesto {
    text-align: left;
    margin-bottom: 13px;
}

.firma-linea {
    text-align: left;
    margin-bottom: 5px;
}

.responsable{
    margin-bottom: 7px;
}

.responsable-nombre{
    margin-bottom: 26px;
}

/* =======================
   UTILIDADES
======================= */

.fecha {
    text-align: right;
    font-size: 12px;
    font-family: 'lato', sans-serif;
    margin-right: 25px;
}

.linea {
    display: inline-block;
    width: 30px;
}

.anio {
    width: 60px;
}

.footer {
    position: fixed;
    bottom: 5;
    width: 100%;
    align-items: center;
    text-align: center;
    font-size: 12px;
    font-family: 'lato', sans-serif;
    color: #363636;
}
.linea-footer {
    border: none;
    border-top: 0.5px solid #000;
    margin: 6px 0;
}

</style>
</head>

<body>

<table class="header-table">
    <tr>
        <td class="logo-cell logo-left">
            <img src="{{ public_path('images/logodif2025.svg') }}">
        </td>

        <td class="header-text">
            <div>SISTEMA PARA EL DESARROLLO INTEGRAL DE LA FAMILIA EN YUCATÁN</div>
            <div class="title1">DEPARTAMENTO DE SERVICIOS GENERALES</div>
            <div class="title2">ÁREA DE ACTIVOS FIJOS</div>
            <div class="title">RESGUARDOS DE BIENES MUEBLES</div>
        </td>

        <td class="logo-cell logo-right">
            <img src="{{ public_path('images/Escudo_yuc_dif.png') }}">
        </td>
    </tr>
</table>

<table>
    <tr>
        <th class="label">Departamento</th>
        <th class="label">Área</th> 
    </tr>
    <tr>
        <td>{{ $activo->departamento->descripcion ?? '' }}</td>
        <td>{{ $activo->subgerencia->descripcion ?? '' }}</td>
    </tr>
</table>


<table>
    <tr>
        <th class="label" style="width: 50%;">Descripción del Bien</th>
        <th class="label">No. de factura</th>
        <th class="label">Fecha de factura </th>
    </tr>
    <tr>
        <td style="width: 50%; height: 65px;">{{ $activo->descripcion_corta }}</td>
        <td style="height: 65px;">{{ $activo->numero_factura ?? '' }}</td>
        <td style="height: 65px;">{{ $activo->fecha_adquisicion ? \Carbon\Carbon::parse($activo->fecha_adquisicion)->format('d/m/Y') : '' }}</td>
    </tr>
</table>

<table>
    <tr>
        <th class="label">No. inventario</th>
        <th class="label">Marca del bien</th>
        <th class="label">Modelo del bien</th>
        <th class="label">No. de Serie</th>
    </tr>
    <tr>
        <td>{{ $activo->numero_inventario }}</td>
        <td>{{ $activo->marca ?? '' }}</td>
        <td>{{ $activo->modelo ?? '' }}</td>
        <td>{{ $activo->numero_serie ?? '' }}</td>
    </tr>
</table>

<table>
    <tr>
        <th class="label">Ubicación física del bien</th>
        <th class="label">Responsable del bien</th>
    </tr>
    <tr>
        <td>{{ $activo->edificio->descripcion }}</td>
        <td>{{ $activo->empleado->nombre ?? '' }}</td>
    </tr>
</table>

<table>
    <tr>
        <th class="label">Estado Físico del Bien</th>
        <th class="label">Importe sin I.V.A.</th>
    </tr>
    <tr>
        <td>{{ $activo->estadoBien->descripcion ?? '' }}</td>
        <td>${{ number_format($activo->costo, 2) }}</td>
    </tr>
</table>

<table>
    <tr>
        <th class="label">Nombre del Proveedor</td>
    </tr>
    <tr>
        <td>{{ $activo->proveedor->nomcorto ?? '' }}</td>
    </tr>
</table>

<table>
    <tr>
        <th class="label">Observaciones</th>
    </tr>
    <tr>
        <td class="observaciones" style="font-size: 12px;">{{ $activo->observaciones }}</td>
    </tr>
</table>

<p class="fecha">
    Mérida, Yuc., a 
    <span class="linea"></span> 
    de 
    <span class="linea"></span> 
    de 
    <span class="linea anio"></span>
</p>


<table class="firmas">
    <tr>
        <th class="center">Responsable del Resguardo del Activo Fijo</th>
        <th class="center">Autorizó Jefe de Área</th>
        <th class="center">Visto Bueno Dirección Administrativa</th>
    </tr>
    <tr>
        <td>
            <div class="nombre">Nombre</div>
            <div class="puesto">Puesto</div>
            <div class="firma-linea">Firma _______________________________</div>
        </td>
        <td>
            <div class="nombre">Nombre</div>
            <div class="puesto" style="color: #ffffff;">h</div>
            <div class="firma-linea">Firma _______________________________</div>
        </td>
        <td>
            <div class="responsable">Nombre</div>
            <div class="responsable-nombre">C.P. José Fernando Rojas Zavala </div>
            <div class="firma-linea">Firma _______________________________</div>
        </td>
    </tr>
</table>

<div class="footer">
    <hr class="linea-footer">
    <p class="center">
        Avenida Alemán No. 355 Col. Itzimná C.P. 97100 Mérida, Yucatán, México<br>
        Tel.: (999) 942 20 30 &nbsp; Fax: EXT.14361 &nbsp; Email: difadministrativa@yucatan.gob.mx
    </p>
</div>

</body>
</html>
