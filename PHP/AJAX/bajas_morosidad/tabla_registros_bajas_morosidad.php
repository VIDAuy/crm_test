<?php
include_once '../../configuraciones.php';

$tabla["data"] = [];

$registros = obtener_bajas_morosidad();


while ($row = mysqli_fetch_assoc($registros)) {

    $id     = $row['id'];
    $cedula = $row['cedula'];


    $tabla["data"][] = [
        "id"     => $id,
        "cedula" => $cedula,
    ];
}



echo json_encode($tabla);




function obtener_bajas_morosidad()
{
    $conexion = connection(DB);
    $tabla = TABLA_BAJAS_MOROSIDAD;

    $sql = "SELECT * FROM {$tabla} WHERE activo = 1 LIMIT 100";

    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
