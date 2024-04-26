<?php
include_once '../../configuraciones.php';

$tabla["data"] = [];

$opcion = $_REQUEST['opcion'];
$id_area = $_SESSION['id'];

$historial_crmessage = obtener_historial_crmessage($opcion, $id_area);

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
    $acciones = "$btnArchivos $btnMensajes";


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







function obtener_historial_crmessage($opcion, $id_area)
{
    $conexion = connection(DB);
    $tabla = TABLA_CONSULTA_TRANSAREA;

    $where = $opcion == 1 ? "area_consulta = '$id_area'" : "area_consultada = '$id_area'";

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
            {$tabla}
           WHERE 
            $where AND 
            activo = 1";
    $consulta = mysqli_query($conexion, $sql);

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
        registrar_errores($sql, "tabla_historial_crmessage.php", $error);
        return false;
    }
}


function obtener_imagenes($id)
{
    $conexion = connection(DB);
    $tabla = TABLA_ARCHIVOS_CRMESSAGE;

    $sql = "SELECT nombre_archivo FROM {$tabla} WHERE id_consulta = '$id' AND activo = 1";
    $consulta = mysqli_query($conexion, $sql);

    $imagenes = "";
    while ($row = mysqli_fetch_assoc($consulta)) {
        $imagenes .= $imagenes == "" ? $row['nombre_archivo'] : ", " . $row['nombre_archivo'];
    }

    return $imagenes;
}
