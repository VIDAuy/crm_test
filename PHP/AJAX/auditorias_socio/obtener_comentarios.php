<?php
include '../configuraciones.php';


$id = $_REQUEST['id_auditoria_socio'];


$comentarios_auditoria = obtener_comentarios_auditoria($id);

if ($comentarios_auditoria === false) {
    $response['error'] = false;
    $response['mensaje'] = "Ocurrieron errores al obtener los comentarios";
    die(json_encode($response));
}


$datos = [];

while ($row = mysqli_fetch_assoc($comentarios_auditoria)) {

    $comentario = $row['comentario'];
    $area_registro = $row['area_registro'];
    $usuario_registro = obtener_nombre_sub_usuario($row['usuario_registro']);
    $fecha_registro = date("d/m/Y H:i:s", strtotime($row['fecha_registro']));

    $html = "<div class='list-group-item list-group-item-action'>
            <div class='d-flex w-100 justify-content-between'>
                <h5 class='mb-1'>$area_registro</h5>
                <small class='text-body-secondary'>$fecha_registro</small>
            </div>
            <p class='mb-1'>$comentario</p>
            <small class='text-body-secondary'>$usuario_registro</small>
         </div>";

    $datos[] = $html;
}



$response['error'] = false;
$response['datos'] = $datos;

echo json_encode($response);
