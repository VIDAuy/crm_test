<?php
include_once '../../configuraciones.php';

$id = $_REQUEST['id'];
$comentario = $_REQUEST['comentario'];
$id_area = $_SESSION['id'];
$id_sub_usuario = isset($_SESSION['id_sub_usuario']) ? $_SESSION['id_sub_usuario'] : "";


if ($id == "" || $comentario == "" || $id_area == "") devolver_error(ERROR_GENERAL);


$editar_comentario_auditoria = editar_comentario_auditoria($id, $comentario, $id_area, $id_sub_usuario);
if ($editar_comentario_auditoria === false) devolver_error("Ocurrieron errores al editar el comentario");


$registros_auditoria = registros_auditoria($id);
if ($registros_auditoria === false) devolver_error("Ocurrieron errores al obtener los datos de la auditoría");
$cedula_auditoria = mysqli_fetch_assoc($registros_auditoria)['cedula'];


$response['error'] = false;
$response['mensaje'] = "Se edito el comentario con éxito";
$response['datos'] = [
    "cedula" => $cedula_auditoria,
];
echo json_encode($response);




function editar_comentario_auditoria($id, $comentario, $id_area, $id_sub_usuario)
{
    $conexion = connection(DB);
    $tabla = TABLA_COMENTARIO_AUDITORIAS_SOCIO;

    try {
        $sql = "UPDATE {$tabla} SET comentario = '$comentario', area_edito = '$id_area', usuario_edito = '$id_sub_usuario', fecha_edicion = NOW() WHERE id = '$id'";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "editar_comentario_auditoria.php", $error);
        $consulta = false;
    }

    return $consulta;
}

function registros_auditoria($id_comentario)
{
    $conexion = connection(DB);
    $tabla1 = TABLA_AUDITORIAS_SOCIO;
    $tabla2 = TABLA_COMENTARIO_AUDITORIAS_SOCIO;

    try {
        $sql = "SELECT
	            ads.cedula 
               FROM
	            {$tabla1} ads
	            INNER JOIN {$tabla2} cads ON ads.id = cads.id_auditoria_socio 
               WHERE
	            cads.id = '$id_comentario'";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "editar_comentario_auditoria.php", $error);
        $consulta = false;
    }

    return $consulta;
}
