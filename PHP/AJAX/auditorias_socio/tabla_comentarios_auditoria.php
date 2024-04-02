<?php
include_once '../../configuraciones.php';

$tabla["data"] = [];

$id = $_REQUEST['id'];
$comentarios_auditoria = obtener_comentarios_auditoria($id);

while ($row = mysqli_fetch_assoc($comentarios_auditoria)) {

    $id = $row['id'];
    $comentario = $row['comentario'];
    $fecha_registro = $row['fecha_registro'];

    $tabla["data"][] = [
        "id" => $id,
        "comentario" => $comentario,
        "fecha_registro" => date("d/m/Y H:i", strtotime($fecha_registro)),
    ];
}



echo json_encode($tabla);
