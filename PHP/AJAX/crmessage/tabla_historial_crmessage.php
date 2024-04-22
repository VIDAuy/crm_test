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
    $consulta = $row['mensaje'];
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
    $tabla1 = TABLA_CONSULTA_TRANSAREA;
    $tabla2 = TABLA_MENSAJES_CONSULTA_TRANSAREA;

    $where = $opcion == 1 ? "ct.area_consulta = '$id_area'" : "ct.area_consultada = '$id_area'";

    $sql = "SELECT 
            ct.id,
            ct.area_consulta,
            ct.usuario_consulto,
            ct.area_consultada,
            ct.usuario_consultado,
            mct.mensaje,
            ct.cedula_socio,
            ct.fecha_consulta,
            ct.estado
            FROM 
            {$tabla1} ct
            INNER JOIN {$tabla2} mct ON ct.id = mct.id_consulta_transarea
            WHERE 
            $where AND 
            ct.activo = 1";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
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
