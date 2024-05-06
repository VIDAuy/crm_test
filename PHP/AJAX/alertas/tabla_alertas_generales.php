<?php
include_once '../../configuraciones.php';

$tabla["data"] = [];
$id_area = $_SESSION['id'];
$id_sub_usuario = isset($_SESSION['id_sub_usuario']) ? $_SESSION['id_sub_usuario'] : "";
$opcion = $_REQUEST['opcion'];



$option = $opcion == 1 ? 1 : 3;
$alertas_generales = obtener_todas_alertas_pendientes($option, $id_area, $id_sub_usuario);
if ($alertas_generales === false) devolver_error("Ocurrieron errores al obtener los registros por área");


while ($row = mysqli_fetch_assoc($alertas_generales)) {

    $id                   = $row['id'];
    $id_registro          = $row['id_registro'];
    $id_sub_registro      = $row['id_sub_registro'];
    $id_numero            = $id_sub_registro != 0 ? $id_sub_registro : $id_registro;
    $area_alerto          = ucfirst(obtener_datos_usuario($row['area_alerto'])['usuario']);
    $usuario_alerto       = $row['usuario_alerto'] != "0" ? obtener_nombre_sub_usuario($row['usuario_alerto']) : "-";
    $area_alertada        = ucfirst(obtener_datos_usuario($row['area_alertada'])['usuario']);
    $id_usuario_alertado  = $row['usuario_alertado'];
    $usuario_alertado     = $id_usuario_alertado != "" && $id_usuario_alertado != "0" ? obtener_nombre_sub_usuario($id_usuario_alertado) : "-";
    $id_usuario_asignador = $row['usuario_asignador'];
    $usuario_asignador    = $id_usuario_asignador != "" && $id_usuario_asignador != "0" ? obtener_nombre_sub_usuario($id_usuario_asignador) : "-";
    $id_funcionalidad     = $row['id_funcionalidad'];
    $texto_descripcion    = obtener_funcionalidad($id_funcionalidad)['nombre'];
    $descripcion          = $texto_descripcion . " - <span class='text-danger fw-bolder'>#$id_numero</span>";
    $fecha_registro       = date("d/m/Y H:i:s", strtotime($row['fecha_registro']));
    $btnVer = "<button class='btn btn-primary' onclick='alerta_leida(`" . $id . "`, `" . $id_registro . "`, `" . $id_funcionalidad . "`)'>Ver</button>";
    $textoBoton = $usuario_asignador != "-" ? "Reasignar" : "Asignar";
    $btnReasignar = "<button class='btn btn-warning' onclick='reasignar_alerta_general(true, `" . $id . "`, `" . $id_registro . "`, `" . $id_sub_registro . "`, `" . $area_alerto . "`, `" . $usuario_alerto . "`, `" . $area_alertada . "`, `" . $id_usuario_alertado . "`, `" . $usuario_alertado . "`, `" . $usuario_asignador . "`, `" . $texto_descripcion . "`)'>$textoBoton</button>";
    $acciones = $opcion == 1 ? $btnVer : $btnReasignar;


    $tabla["data"][] = [
        "id"                => $id,
        "area"              => $area_alerto,
        "usuario"           => $usuario_alerto,
        "descripcion"       => $descripcion,
        "fecha_registro"    => $fecha_registro,
        "usuario_asignado"  => $usuario_alertado,
        "usuario_asignador" => $usuario_asignador,
        "acciones"          => $acciones,
    ];
}



echo json_encode($tabla);
