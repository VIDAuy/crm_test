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
    $observaciones        = $row['observaciones'];
    $fecha_registro       = $row['fecha_registro'];
    $id_usuario_asignado  = $row['id_usuario_asignado'];
    $id_usuario_asignador = $row['id_usuario_asignador'];
    $usuario_asignado     = $id_usuario_asignado == "" ? "-" : obtener_nombre_usuario($id_usuario_asignado);
    $usuario_asignador    = $id_usuario_asignador == "" ? "-" : obtener_nombre_usuario($id_usuario_asignador);

    if (strlen($observaciones) > 20) {
        $br  = array("<br />", "<br>", "<br/>");
        $observaciones = str_ireplace($br, "\r\n", $observaciones);

        $observaciones_sin_editar = $observaciones;
        $observaciones = substr($observaciones, 0, 20) . " ...<button class='btn btn-link' onclick='verMasTabla(`" . $observaciones_sin_editar . "`);'>Ver Más</button>";
        $observaciones = mb_convert_encoding($observaciones, 'UTF-8', 'UTF-8');
    }

    $tabla["data"][] = [
        "id"                => $id,
        "cedula"            => $cedula,
        "sector"            => $sector,
        "observaciones"     => $observaciones,
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
    include '../../conexiones/conexion2.php';
    $tabla = TABLA_REGISTROS;

    $sql = "SELECT 
    id, 
    cedula, 
    nombre, 
    telefono, 
    sector, 
    observaciones,
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
