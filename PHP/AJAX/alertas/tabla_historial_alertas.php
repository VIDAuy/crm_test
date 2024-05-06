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
    $observacion        = $row['observaciones'];
    $fecha_registro       = $row['fecha_registro'];
    $id_usuario_asignado  = $row['id_usuario_asignado'];
    $id_usuario_asignador = $row['id_usuario_asignador'];
    $usuario_asignado     = $id_usuario_asignado == "" ? "-" : obtener_nombre_sub_usuario($id_usuario_asignado);
    $usuario_asignador    = $id_usuario_asignador == "" ? "-" : obtener_nombre_sub_usuario($id_usuario_asignador);


    if (strlen($observacion) > 20) {
        $br  = array("<br />", "<br>", "<br/>");
        $observacion = str_ireplace($br, "\r\n", $observacion);

        $observacion_sin_editar = $observacion;
        $observacion = substr($observacion, 0, 20) . " ...<button class='btn btn-link' onclick='verMasTabla(`" . $observacion_sin_editar . "`);'>Ver Más</button>";
        $observacion = mb_convert_encoding($observacion, 'UTF-8', 'UTF-8');
    }


    $tabla["data"][] = [
        "id"                => $id,
        "cedula"            => $cedula,
        "sector"            => $sector,
        "observaciones"     => $observacion,
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
    envioSector = '$sector' AND 
    cedula != ''
    ORDER BY id DESC
    LIMIT 100";

    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
