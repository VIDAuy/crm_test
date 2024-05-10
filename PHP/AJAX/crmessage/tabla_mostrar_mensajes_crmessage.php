<?php
include_once '../../configuraciones.php';

$tabla["data"] = [];

$id = $_REQUEST['id'];
$estado_consulta = "";
$contador = 1;


$mensajes_crmessage = obtener_respuestas($id);


while ($row = mysqli_fetch_assoc($mensajes_crmessage)) {

    $id                    = $row['id'];
    $datos_consulta        = obtener_datos_consulta($row['id_consulta_transarea']);
    $area_consulta         = ucfirst(obtener_datos_usuario($datos_consulta['area_consulta'])['usuario']);
    $area_consultada       = ucfirst(obtener_datos_usuario($datos_consulta['area_consultada'])['usuario']);
    $usuario               = $row['id_sub_usuario'] != "" && $row['id_sub_usuario'] != null ? ucfirst(obtener_nombre_sub_usuario(($row['id_sub_usuario']))) : "";
    $mensajes              = $row['mensaje'];
    $cedula_socio          = $datos_consulta['cedula_socio'];
    $cedula_socio          = $cedula_socio != "" && $contador == 1 ? $cedula_socio : "-";
    $fecha_respuesta       = $row['fecha_registro'] != "" ? date("d/m/Y H:i:s", strtotime($row['fecha_registro'])) : "-";
    $estado                = $datos_consulta['estado'] == 1 ? "En Proceso" : "Terminado";
    if ($contador == 1) $area_consultada = $area_consulta;
    $tipo = $contador == 1 ? "<span class='text-warning fw-bolder'>Consulta</span>" : "<span class='text-success fw-bolder'>Respuesta</span>";


    $tabla["data"][] = [
        "id" => $id,
        "area" => $area_consultada,
        "usuario" => $usuario,
        "mensaje" => $mensajes,
        "cedula_socio" => $cedula_socio,
        "fecha_registro" => $fecha_respuesta,
        "tipo" => $tipo,
    ];


    $contador++;
}



echo json_encode($tabla);




function obtener_respuestas($id)
{
    $conexion = connection(DB);
    $tabla = TABLA_MENSAJES_CONSULTA_TRANSAREA;

    try {
        $sql = "SELECT * FROM {$tabla} WHERE id_consulta_transarea = '$id' AND activo = 1 ORDER BY id ASC LIMIT 100";
        $consulta = mysqli_query($conexion, $sql);
        return $consulta;
    } catch (\Throwable $error) {
        registrar_errores($sql, "tabla_mostrar_mensajes_crmessage.php", $error);
        return false;
    }
}

function obtener_datos_consulta($id_consulta_transarea)
{
    $conexion = connection(DB);
    $tabla = TABLA_CONSULTA_TRANSAREA;

    try {
        $sql = "SELECT * FROM {$tabla} WHERE id = '$id_consulta_transarea' AND activo = 1 LIMIT 100";
        $consulta = mysqli_query($conexion, $sql);
        $resultado = mysqli_fetch_assoc($consulta);
        return $resultado;
    } catch (\Throwable $error) {
        registrar_errores($sql, "tabla_mostrar_mensajes_crmessage.php", $error);
        return false;
    }
}
