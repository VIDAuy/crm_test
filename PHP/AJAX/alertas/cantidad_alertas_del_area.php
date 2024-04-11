<?php
include_once '../../configuraciones.php';
$sector = $_SESSION['id'];

$cantidad = obtener_cantidad_alertas($sector);

$response = ['message' => $cantidad];
die(json_encode($response));



function obtener_cantidad_alertas($sector)
{
    $conexion = connection(DB);
    $tabla = TABLA_REGISTROS;

    $sql = "SELECT cedula FROM {$tabla} WHERE envioSector = '$sector' AND activo = 1 AND cedula != ''";
    $consulta = mysqli_query($conexion, $sql);
    $resultados = mysqli_num_rows($consulta);

    return $resultados;
}
