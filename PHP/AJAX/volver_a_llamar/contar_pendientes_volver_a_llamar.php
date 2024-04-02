<?php
include_once '../../configuraciones.php';

$area = $_REQUEST['area'];
$area = obtener_area($area);
$id_sub_usuario = $_REQUEST['id_sub_usuario'];


$tabla["data"] = [];

$consulta = consulta_general($area, $id_sub_usuario);


$response['error'] = false;
$response['cantidad'] = $consulta['cantidad'];


echo json_encode($response);







function obtener_area($area)
{
    $conexion = connection(DB);
    $tabla = TABLA_USUARIOS;

    $sql = "SELECT id FROM {$tabla} WHERE usuario = '$area' ORDER BY id DESC LIMIT 1";
    $consulta = mysqli_query($conexion, $sql);

    return mysqli_fetch_assoc($consulta)['id'];
}

function consulta_general($area, $id_sub_usuario)
{
    $conexion = connection(DB);
    $tabla = TABLA_AGENDA_VOLVER_A_LLAMAR;

    $sql = "SELECT
    count(id) AS 'cantidad',
    fecha_hora
    FROM
    {$tabla}
    WHERE
    NOW() >= DATE_SUB( fecha_hora, INTERVAL 1 HOUR ) AND
    mostrar = 1 AND
    activo = 1 AND
    area = '$area' AND
    id_sub_usuario = '$id_sub_usuario'";
    $consulta = mysqli_query($conexion, $sql);

    return mysqli_fetch_assoc($consulta);
}
