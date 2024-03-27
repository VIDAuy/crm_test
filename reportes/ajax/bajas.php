<?php
require '../_conexion.php';

$response = ['data' => [], 'success' => true];
$motivoBaja = mysqli_real_escape_string($mysqli, $_GET['motivoBaja']);
$fechas = mysqli_real_escape_string($mysqli, $_GET['fechas']);
$fechas = explode(' / ', $fechas);
$fechaInicio = date('Y-m-d', strtotime($fechas[0]));
$fechaFin = date('Y-m-d', strtotime($fechas[1]));

$motivoBaja = $motivoBaja != '' ? " AND motivo_baja='$motivoBaja'" : '';
$query = "SELECT * FROM bajas WHERE fecha_ingreso_baja BETWEEN '$fechaInicio' AND '$fechaFin' $motivoBaja";
$res = mysqli_query($mysqli, $query);

while ($row = mysqli_fetch_assoc($res)) {
    $response['data'][] = [
        'id' => $row['id'],
        'cedula' => $row['cedula_socio'],
        'nombre' => $row['nombre_socio'],
        'telefono' => $row['telefono_contacto'],
        'fechaIngresoBaja' => date('d-m-Y', strtotime($row['fecha_ingreso_baja'])),
        'motivoBaja' => $row['motivo_baja'],
        'estado' => $row['estado'],
        'observacionFinal' => $row['observacion_final'],
        'sector' => $row['area_fin_gestion']
    ];
}

die(json_encode($response));