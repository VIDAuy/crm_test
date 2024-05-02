<?php
include_once '../../configuraciones.php';

$tabla["data"] = [];
$id_area = $_SESSION['id'];
$id_sub_usuario = isset($_SESSION['id_sub_usuario']) ? $_SESSION['id_sub_usuario'] : "";
$id_funcionalidades = $_REQUEST['id_funcionalidad'];


if ($id_funcionalidades == "") devolver_error(ERROR_GENERAL);


$array_id_string = explode(",", $id_funcionalidades);
foreach ($array_id_string as $id_funcionalidad) {

    $alertas_por_area = obtener_todas_alertas_pendientes(1, $id_area, $id_sub_usuario, $id_funcionalidad);
    if ($alertas_por_area === false) devolver_error("Ocurrieron errores al obtener los registros por área");


    while ($row = mysqli_fetch_assoc($alertas_por_area)) {

        $id              = $row['id'];
        $id_registro     = $row['id_registro'];
        $id_sub_registro = $row['id_sub_registro'];
        $id_numero       = $id_sub_registro != 0 ? $id_sub_registro : $id_registro;
        $area            = ucfirst(obtener_datos_usuario($row['area_alerto'])['usuario']);
        $id_usuario      = $row['usuario_alerto'];
        $usuario         = $id_usuario != "0" ? obtener_nombre_sub_usuario($id_usuario) : "-";
        $descripcion     = obtener_funcionalidad($row['id_funcionalidad'])['nombre'] . " - <span class='text-danger fw-bolder'>#$id_numero</span>";
        $fecha_registro  = $row['fecha_registro'];
        $acciones        = "<button class='btn btn-primary' onclick='alerta_leida(`" . $id . "`, `" . $id_registro . "`, `" . $id_funcionalidades . "`)'>Ver</button>";


        $tabla["data"][] = [
            "id"             => $id,
            "area"           => $area,
            "usuario"        => $usuario,
            "descripcion"    => $descripcion,
            "fecha_registro" => $fecha_registro,
            "acciones"       => $acciones,
        ];
    }


    $alertas_por_usuario = obtener_todas_alertas_pendientes(2, $id_area, $id_sub_usuario, $id_funcionalidad);
    if ($alertas_por_usuario === false) devolver_error("Ocurrieron errores al obtener los registros por usuario");


    while ($row = mysqli_fetch_assoc($alertas_por_usuario)) {

        $id              = $row['id'];
        $id_registro     = $row['id_registro'];
        $id_sub_registro = $row['id_sub_registro'];
        $id_numero       = $id_sub_registro != 0 ? $id_sub_registro : $id_registro;
        $area            = ucfirst(obtener_datos_usuario($row['area_alerto'])['usuario']);
        $id_usuario      = $row['usuario_alerto'];
        $usuario         = $id_usuario != "0" ? obtener_nombre_sub_usuario($id_usuario) : "-";
        $descripcion     = obtener_funcionalidad($row['id_funcionalidad'])['nombre'] . " - <span class='text-danger fw-bolder'>#$id_numero</span>";
        $fecha_registro  = $row['fecha_registro'];
        $acciones        = "<button class='btn btn-primary' onclick='alerta_leida(`" . $id . "`, `" . $id_registro . "`, `" . $id_funcionalidades . "`)'>Ver</button>";


        $tabla["data"][] = [
            "id"             => $id,
            "area"           => $area,
            "usuario"        => $usuario,
            "descripcion"    => $descripcion,
            "fecha_registro" => $fecha_registro,
            "acciones"       => $acciones,
        ];
    }
}


echo json_encode($tabla);
