<?php
include '../configuraciones.php';

$id_auditoria_socio = $_REQUEST['id'];
$comentario = $_REQUEST['comentario'];
$id_sub_usuario = isset($_SESSION['id_sub_usuario']) ? $_SESSION['id_sub_usuario'] : "";
$usuario = $_SESSION['usuario'];


if ($id_auditoria_socio == "" || $comentario == "") {
    $response['error'] = true;
    $response['mensaje'] = ERROR_GENERAL;
    die(json_encode($response));
}


$registro = registrar_comentario($id_auditoria_socio, $comentario, $usuario, $id_sub_usuario);

if ($registro === false) {
    $response['error'] = true;
    $response['mensaje'] = "Ocurrieron errores al registrar el comentario";
    die(json_encode($response));
}



$response['error'] = false;
$response['mensaje'] = EXITO_AL_REGISTRAR;


echo json_encode($response);




function registrar_comentario($id_auditoria_socio, $comentario, $usuario, $id_sub_usuario)
{
    $conexion = connection(DB);
    $tabla = TABLA_COMENTARIO_AUDITORIAS_SOCIO;

    $sql = "INSERT INTO {$tabla} (id_auditoria_socio, comentario, area_registro, usuario_registro, fecha_registro) VALUES ('$id_auditoria_socio', '$comentario', '$usuario', '$id_sub_usuario', NOW())";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
