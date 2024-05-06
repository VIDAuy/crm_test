<?php
include_once '../../configuraciones.php';

$opcion = $_REQUEST['opcion'];
$sector = isset($_SESSION['id']) ? $_SESSION['id'] : "";
$id_sub_usuario = isset($_SESSION['id_sub_usuario']) ? $_SESSION['id_sub_usuario'] : "";


/** Tabla **/
if ($opcion == 1) {
    $tabla["data"] = [];

    $alertas_pendientes = obtener_alertas_pendientes($sector);

    while ($row = mysqli_fetch_assoc($alertas_pendientes)) {

        $id                   = $row['id'];
        $cedula               = $row['cedula'];
        $nombre               = $row['nombre'];
        $telefono             = $row['telefono'];
        $sector               = $row['sector'];
        $observaciones        = $row['observaciones'];
        $id_usuario_asignado  = $row['id_usuario_asignado'];
        $id_usuario_asignador = $row['id_usuario_asignador'];

        if ($id_usuario_asignado == "" && $id_usuario_asignador == "") {
            $usuario_asignado  = "-";
            $usuario_asignador = "-";
            $acciones          = "<button class='btn btn-primary' onclick='abrir_asignar_alerta(true, `" . $id . "`, `" . $cedula . "`, `" . $nombre . "`, `" . $telefono . "`, `" . $sector . "`, `" . $id_sub_usuario . "`)'>Asignar</button>";
        } else {
            $usuario_asignado = obtener_nombre_sub_usuario($id_usuario_asignado);
            $usuario_asignador = obtener_nombre_sub_usuario($id_usuario_asignador);
            $acciones          = "<button class='btn btn-warning' onclick='abrir_asignar_alerta(true, `" . $id . "`, `" . $cedula . "`, `" . $nombre . "`, `" . $telefono . "`, `" . $sector . "`, `" . $id_sub_usuario . "`, `" . $id_usuario_asignado . "`, `" . $id_usuario_asignador . "`, `" . $usuario_asignado . "`, `" . $usuario_asignador . "` )'>Reasignar</button>";
        }

        $observaciones = strlen(trim($observaciones)) > 20 ?
            substr($observaciones, 0, 20) . " ...<button class='btn btn-link' onclick='verMasTabla(`" . $observaciones . "`);'>Ver Más</button>" :
            $observaciones;

        $tabla["data"][] = [
            "id"                => $id,
            "cedula"            => $cedula,
            "sector"            => $sector,
            "observaciones"     => $observaciones,
            "nombre"            => $nombre,
            "telefono"          => $telefono,
            "usuario_asignado"  => $usuario_asignado,
            "usuario_asignador" => $usuario_asignador,
            "acciones"          => $acciones,
        ];
    }


    echo json_encode($tabla);
}


/** Cantidad **/
if ($opcion == 2) {
    $datos = obtener_alertas_pendientes($sector);
    $cantidad = mysqli_num_rows($datos);

    $response['error'] = false;
    $response['cantidad'] = $cantidad;
    echo json_encode($response);
}



function obtener_alertas_pendientes($sector)
{
    include '../../conexiones/conexion2.php';
    $tabla = TABLA_REGISTROS;

    $sql = "SELECT * FROM {$tabla} WHERE activo = 1 AND envioSector = '$sector' AND cedula != '' AND eliminado = 0";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
