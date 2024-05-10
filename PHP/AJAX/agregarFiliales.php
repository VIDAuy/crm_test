<?php
include_once '../configuraciones.php';

if (!isset($_SESSION['id'])) header('location: ../../');


$consulta_usuarios = obtener_areas();
while ($row = mysqli_fetch_assoc($consulta_usuarios)) {
    $row['usuario'] = strtolower($row['usuario']);
    $row['usuario'] = ucfirst($row['usuario']);
    $f[] = $row;
}

$respuesta['datos'] = $f;
echo json_encode($respuesta);



function obtener_areas()
{
    $conexion = connection(DB);
    $tabla = TABLA_USUARIOS;

    $sql = "SELECT id, usuario FROM {$tabla} WHERE id != 43 AND activo = 1 ORDER BY usuario ASC";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
