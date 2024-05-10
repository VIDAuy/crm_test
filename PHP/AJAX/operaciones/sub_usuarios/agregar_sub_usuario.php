<?php
include_once '../../../configuraciones.php';

$id_area = $_REQUEST['id_area'];
$nombre = $_REQUEST['nombre'];
$apellido = $_REQUEST['apellido'];
$cedula = $_REQUEST['cedula'];
$gestor = $_REQUEST['gestor'];


if ($id_area == "" || $nombre == "" || $apellido == "" || $cedula == "" || $gestor == "") devolver_error(ERROR_GENERAL);


$comprobar_existencia = comprobar_existencia($id_area, $nombre, $apellido, $cedula);
if ($comprobar_existencia == false) devolver_error("Ocurrieron errores al comprobar la existencia del registro");

if (mysqli_num_rows($comprobar_existencia) > 0) {
    $result = mysqli_fetch_assoc($comprobar_existencia);
    $id = $result['id'];
    $activo = $result['activo'];

    if ($id != "" && $activo == 1) devolver_error("Ya existe un usuario en el área con la misma cédula, nombre y apellido");

    if ($id != "" && $activo == 0) {
        $reactivar_contenido = reactivar_contenido(TABLA_SUB_USUARIOS, $id);
        if ($reactivar_contenido == false) devolver_error("Ocurrieron errores al reactivar el item");
    }
} else {

    $usuario = ucfirst($usuario);
    $apellido = ucfirst($apellido);
    $agregar_sub_usuario = agregar_sub_usuario($id_area, $nombre, $apellido, $cedula, $gestor);
    if ($agregar_sub_usuario == false) devolver_error("Ocurrieron errores al registrar el sub usuario");
}



$response['error'] = false;
$response['mensaje'] = "Se ha registrado con éxito";
echo json_encode($response);




function comprobar_existencia($id_area, $nombre, $apellido, $cedula)
{
    $conexion = connection(DB);
    $tabla = TABLA_SUB_USUARIOS;


    try {
        $sql = "SELECT * FROM {$tabla} WHERE id_sector = '$id_area' AND nombre = '$nombre' AND apellido = '$apellido' AND cedula = '$cedula' ORDER BY id DESC LIMIT 1";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "agregar_sub_usuario.php", $error);
        $consulta = false;
    }

    return $consulta;
}

function agregar_sub_usuario($id_area, $nombre, $apellido, $cedula, $gestor)
{
    $conexion = connection(DB);
    $tabla = TABLA_SUB_USUARIOS;

    try {
        $sql = "INSERT INTO {$tabla} (id_sector, nombre, apellido, cedula, gestor) VALUES ('$id_area', '$nombre', '$apellido', '$cedula', '$gestor')";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "agregar_sub_usuario.php", $error);
    }

    return $consulta;
}
