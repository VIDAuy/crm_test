<?php
include_once '../configuraciones.php';

$id_area = $_SESSION['id'];
$estatus = 404;

$comprobar_sub_usuarios = comprobar_sub_usuarios($id_area);
if ($comprobar_sub_usuarios == false) devolver_error("Ocurrieron errores al comprobar sub usuarios");


if (mysqli_num_rows($comprobar_sub_usuarios) > 0) $estatus = 200;



$response['error'] = false;
$response['estatus'] = $estatus;
echo json_encode($response);




function comprobar_sub_usuarios($id_area)
{
    $conexion = connection(DB);
    $tabla = TABLA_SUB_USUARIOS;

    $sql = "SELECT * FROM {$tabla} WHERE id_sector = '$id_area' AND activo = 1";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
