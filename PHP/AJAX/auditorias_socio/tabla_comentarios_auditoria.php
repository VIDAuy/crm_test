<?php
include_once '../../configuraciones.php';

$tabla["data"] = [];

$id = $_REQUEST['id'];
$comentarios_auditoria = obtener_comentarios_auditoria($id);

while ($row = mysqli_fetch_assoc($comentarios_auditoria)) {

    $id = $row['id'];
    $comentario = $row['comentario'];
    $fecha_registro = $row['fecha_registro'];
    $archivos_del_comentario = imagenes_comentario($id);
    $btnArchivos = strlen($archivos_del_comentario) > 0 ? "<button class='btn btn-sm btn-info' onclick='modal_ver_mp3(`" . URL_DOCUMENTOS_AUDITORIA . "`, `" . $archivos_del_comentario . "`);'>Ver Archivos</button>" : "-";


    $tabla["data"][] = [
        "id" => $id,
        "comentario" => $comentario,
        "fecha_registro" => date("d/m/Y H:i", strtotime($fecha_registro)),
        "acciones" => $btnArchivos,
    ];
}



echo json_encode($tabla);




function imagenes_comentario($id_comentario)
{
    $conexion = connection(DB);
    $tabla = TABLA_ARCHIVOS_AUDITORIAS;

    $sql = "SELECT * FROM {$tabla} WHERE id_comentario_auditoria = '$id_comentario' AND activo = 1";
    $consulta = mysqli_query($conexion, $sql);

    $archivos = "";
    while ($row = mysqli_fetch_assoc($consulta)) {
        $archivos .= $archivos == "" ? $row['nombre_archivo'] : ", " . $row['nombre_archivo'];
    }

    return $archivos;
}
