<?php
include_once '../../configuraciones.php';

$sector = $_SESSION['id'];


$tabla["data"] = [];


$alertas_pendientes = obtener_alertas_pendientes($sector);

while ($row = mysqli_fetch_assoc($alertas_pendientes)) {

    $id                   = $row['id'];
    $cedula               = $row['cedula'];
    $nombre               = $row['nombre'];
    $telefono             = $row['telefono'];
    $sector               = $row['sector'];
    $fecha_registro       = $row['fecha_registro'];
    $id_usuario_asignado  = $row['id_usuario_asignado'];
    $id_usuario_asignador = $row['id_usuario_asignador'];
    $usuario_asignado = $id_usuario_asignado == "" ? "-" : obtener_nombre_usuario($id_usuario_asignado);
    $usuario_asignador = $id_usuario_asignador == "" ? "-" : obtener_nombre_usuario($id_usuario_asignador);

    $tabla["data"][] = [
        "id"                => $id,
        "cedula"            => $cedula,
        "sector"            => $sector,
        "nombre"            => $nombre,
        "telefono"          => $telefono,
        "fecha_registro"    => date("d/m/Y H:i:s", strtotime($fecha_registro)),
        "usuario_asignado"  => $usuario_asignado,
        "usuario_asignador" => $usuario_asignador,
    ];
}



echo json_encode($tabla);







function obtener_alertas_pendientes($sector)
{
    $conexion = connection(DB);
    $tabla = TABLA_REGISTROS;

    $sql = "SELECT 
    id, 
    cedula, 
    nombre, 
    telefono, 
    sector, 
    fecha_registro,
    id_usuario_asignado, 
    id_usuario_asignador 
    FROM 
    {$tabla} 
    WHERE 
    activo = 0 AND 
    envioSector = $sector AND 
    cedula != ''
    ORDER BY id DESC
    LIMIT 1000";

    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}

function obtener_nombre_usuario($id_usuario)
{
    $conexion = connection(DB);
    $tabla = TABLA_SUB_USUARIOS;

    $sql = "SELECT nombre, apellido FROM {$tabla} WHERE id = '$id_usuario'";
    $consulta = mysqli_query($conexion, $sql);
    $resultado = mysqli_fetch_assoc($consulta);

    return $resultado['nombre'] . " " . $resultado['apellido'];
}
