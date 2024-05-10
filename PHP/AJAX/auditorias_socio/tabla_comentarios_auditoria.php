<?php
include_once '../../configuraciones.php';

$tabla["data"] = [];

$id = $_REQUEST['id'];
$area = ucfirst(obtener_datos_usuario($_SESSION['id'])['usuario']);


$comentarios_auditoria = obtener_comentarios_auditoria($id);

while ($row = mysqli_fetch_assoc($comentarios_auditoria)) {

    $id = $row['id'];
    $comentario = $row['comentario'];
    $area_registro = $row['area_registro'] != "" ? ucfirst(obtener_datos_usuario($row['area_registro'])['usuario']) : "-";
    $usuario_registro = obtener_nombre_sub_usuario($row['usuario_registro']);
    $fecha_registro = $row['fecha_registro'];
    $archivos_del_comentario = imagenes_comentario($id);
    $acciones = "";
    if (strlen($archivos_del_comentario) > 0)
        $acciones .= "<button class='btn btn-sm btn-info me-2' onclick='modal_ver_mp3(`" . URL_DOCUMENTOS_AUDITORIA . "`, `" . $archivos_del_comentario . "`);'>📑</button>";
    if (in_array($area, ["Auditoria"]))
        $acciones .= "<button class='btn btn-sm btn-primary' onclick='editar_comentario_auditoria(true, `" . $id . "`, `" . $comentario . "`)'>✏</button>";

    if (strlen($comentario) > 20) {
        $br  = array("<br />", "<br>", "<br/>");
        $comentario = str_ireplace($br, "\r\n", $comentario);

        $comentario_sin_editar = $comentario;
        $comentario = substr($comentario, 0, 50) . " ...<button class='btn btn-link' onclick='verMasTabla(`" . $comentario_sin_editar . "`);'>Ver Más</button>";
        $comentario = mb_convert_encoding($comentario, 'UTF-8', 'UTF-8');
    }


    $tabla["data"][] = [
        "id"               => $id,
        "comentario"       => $comentario,
        "usuario_registro" => $usuario_registro,
        "fecha_registro"   => date("d/m/Y H:i", strtotime($fecha_registro)),
        "acciones"         => $acciones,
    ];
}



echo json_encode($tabla);




function imagenes_comentario($id_comentario)
{
    $conexion = connection(DB);
    $tabla = TABLA_ARCHIVOS_AUDITORIAS;

    $sql = "SELECT * FROM {$tabla} WHERE id_comentario_auditoria = '$id_comentario' AND activo = 1 LIMIT 100";
    $consulta = mysqli_query($conexion, $sql);

    $archivos = "";
    while ($row = mysqli_fetch_assoc($consulta)) {
        $archivos .= $archivos == "" ? $row['nombre_archivo'] : ", " . $row['nombre_archivo'];
    }

    return $archivos;
}
