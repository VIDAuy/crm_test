<?php
include_once '../../configuraciones.php';

$cedula = $_REQUEST['cedula'];


$tabla["data"] = [];


$patologias_socio = obtener_patologias_socio($cedula);

while ($row = mysqli_fetch_assoc($patologias_socio)) {

    $id                   = $row['id'];
    $patologia            = nombre_patologia($row['id_patologia']);
    $observacion          = $row['observacion'];
    $fecha                = $row['fecha'];

    $tabla["data"][] = [
        "id"          => $id,
        "patologia"   => $patologia,
        "observacion" => $observacion,
        "fecha"       => $fecha,
    ];
}



echo json_encode($tabla);







function obtener_patologias_socio($cedula)
{
    $conexion = connection(DB_ABMMOD);
    $tabla = TABLA_PATOLOGIAS_SOCIO;

    $sql = "SELECT * FROM {$tabla} WHERE documento_socio = '{$cedula}'";

    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}

function nombre_patologia($id_patologia)
{
    $conexion = connection(DB_COORDINACION);
    $tabla = TABLA_PATOLOGIAS;

    $sql = "SELECT patologia FROM {$tabla} WHERE id_patologia = '$id_patologia'";
    $consulta = mysqli_query($conexion, $sql);
    $resultado = mysqli_fetch_assoc($consulta);

    return $resultado['patologia'];
}
