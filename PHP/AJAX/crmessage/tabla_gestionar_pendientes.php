<?php
include_once '../../configuraciones.php';

$tabla["data"] = [];

$id_area = $_SESSION['id'];
$opcion = $_REQUEST['opcion'];


/** Obtener tabla de todos los pendientes de CRMessage **/
if ($opcion == 1) {
    $historial_crmessage = obtener_historial_crmessage($id_area);

    while ($row = mysqli_fetch_assoc($historial_crmessage)) {

        $id = $row['id'];
        $area_consulta = $row['area_consulta'] != "" ? ucfirst(obtener_datos_usuario($row['area_consulta'])['usuario']) : "";
        $usuario_consulto = $row['usuario_consulto'] != "" ?  " ➡ " . obtener_nombre_sub_usuario($row['usuario_consulto']) : "";
        $area_consultada = $row['area_consultada'] != "" ? ucfirst(obtener_datos_usuario($row['area_consultada'])['usuario']) : "-";
        $usuario_consultado = $row['usuario_consultado'] != "" ?  " ➡ " . obtener_nombre_sub_usuario($row['usuario_consultado']) : "";
        $area_y_usuario_consulta = $area_consulta . $usuario_consulto;
        $area_y_usuario_consultado = $area_consultada . $usuario_consultado;
        $consulta = obtener_datos_mensajes($id)['mensaje'];
        $consulta = $consulta != false ? $consulta : "-";
        $cedula_socio = $row['cedula_socio'];
        $fecha_consulta = $row['fecha_consulta'];
        $estado = $row['estado'] == 1 ? "En Proceso" : "Terminado";
        $archivos = obtener_imagenes($id);
        $btnArchivos = strlen($archivos) > 0 ? "<button class='btn btn-sm btn-info' onclick='modal_ver_imagen_registro(`" . URL_DOCUMENTOS_CRMESSAGE . "`, `" . $archivos . "`);'>Ver Archivos</button>" : "";
        $btnMensajes = "<button class='btn btn-sm btn-primary' onclick='mostrar_mensajes_consulta($id)'>Ver Mensajes</button>";
        $btnReasignar = "<button class='btn btn-sm btn-warning' onclick='reasignar_crmessage(true, `" . $id . "`, `" . $row['usuario_consultado'] . "`, `" . obtener_nombre_sub_usuario($row['usuario_consultado']) . "`)'>Reasignar</button>";
        $acciones = "$btnArchivos $btnMensajes $btnReasignar";


        $tabla["data"][] = [
            "id" => $id,
            "area_y_usuario_consulta" => $area_y_usuario_consulta,
            "area_y_usuario_consultado" => $area_y_usuario_consultado,
            "consulta" => $consulta,
            "cedula_socio" => $cedula_socio,
            "fecha_consulta" => $fecha_consulta,
            "estado" => $estado,
            "acciones" => $acciones,
        ];
    }

    echo json_encode($tabla);
}
/** End obtener tabla de todos los pendientes de CRMessage **/


/** Obtener la cantidad de consultas pendientes de CRMessage **/
if ($opcion == 2) {
    $historial_crmessage = obtener_historial_crmessage($id_area);

    $cantidad = mysqli_num_rows($historial_crmessage);

    $response['error'] = false;
    $response['cantidad'] = $cantidad;
    echo json_encode($response);
}
/** End obtener la cantidad de consultas pendientes de CRMessage **/




function obtener_historial_crmessage($id_area)
{
    $conexion = connection(DB);
    $tabla = TABLA_CONSULTA_TRANSAREA;

    try {
        $sql = "SELECT
                id,
                area_consulta,
                usuario_consulto,
                area_consultada,
                usuario_consultado,
                cedula_socio,
                fecha_consulta,
                estado 
               FROM
                {$tabla} ct 
               WHERE
                area_consultada = '$id_area' AND 
                estado = 1 AND 
                activo = 1";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "tabla_gestionar_pendientes.php", $error);
        $consulta = false;
    }

    return $consulta;
}


function obtener_datos_mensajes($id)
{
    $conexion = connection(DB);
    $tabla = TABLA_MENSAJES_CONSULTA_TRANSAREA;

    try {
        $sql = "SELECT * FROM {$tabla} WHERE id_consulta_transarea = '$id' AND activo = 1 ORDER BY id ASC LIMIT 1";
        $consulta = mysqli_query($conexion, $sql);
        $resultado = mysqli_fetch_assoc($consulta);
        return $resultado;
    } catch (\Throwable $error) {
        registrar_errores($sql, "tabla_gestionar_pendientes.php", $error);
        return false;
    }
}


function obtener_imagenes($id)
{
    $conexion = connection(DB);
    $tabla = TABLA_ARCHIVOS_CRMESSAGE;

    try {
        $sql = "SELECT nombre_archivo FROM {$tabla} WHERE id_consulta = '$id' AND activo = 1";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "tabla_gestionar_pendientes.php", $error);
        $consulta = false;
    }

    $imagenes = "";
    if ($consulta != false) {
        while ($row = mysqli_fetch_assoc($consulta)) {
            $imagenes .= $imagenes == "" ? $row['nombre_archivo'] : ", " . $row['nombre_archivo'];
        }
    }

    return $imagenes;
}
