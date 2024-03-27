<?php
include '../conexiones/conexion2.php';

$id = $_REQUEST['id'];


$obtener_imagenes = obtener_imagenes($id);

$imagenes = [];
while ($row = mysqli_fetch_assoc($obtener_imagenes)) {
    array_push($imagenes, $row['nombre_imagen']);


}




$response['error'] = false;
$response['datos'] = $imagenes;


echo json_encode($response);





function obtener_imagenes($id)
{
    global $conexion;

    $sql = "SELECT nombre_imagen FROM imagenes_registro WHERE id_registro = '$id' AND activo = 1";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
