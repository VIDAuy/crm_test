<?php
include_once '../../../configuraciones.php';

$id_area = $_REQUEST['id_area'];
$nombre = $_REQUEST['nombre'];
$apellido = $_REQUEST['apellido'];
$cedula = $_REQUEST['cedula'];
$gestor = $_REQUEST['gestor'];


if ($id_area == "" || $nombre == "" || $apellido == "" || $cedula == "" || $gestor == "") devolver_error(ERROR_GENERAL);


$verificar_sub_usuario_existente = verificar_sub_usuario($id_area, $nombre, $apellido, $cedula, $gestor);
if ($verificar_sub_usuario_existente == false) devolver_error("Ocurrieron errores al verificar el menu");


if (mysqli_num_rows($verificar_sub_usuario_existente) > 0) devolver_error("El sub usuario ya pertenece al área seleccionada");


$agregar_sub_usuario = agregar_sub_usuario($id_area, $nombre, $apellido, $cedula, $gestor);
if ($agregar_sub_usuario == false) devolver_error("Ocurrieron errores al registrar el sub usuario");



$response['error'] = false;
$response['mensaje'] = "Se ha registrado con éxito";
echo json_encode($response);




function verificar_sub_usuario($id_area, $nombre, $apellido, $cedula, $gestor)
{
    $conexion = connection(DB);
    $tabla = TABLA_SUB_USUARIOS;

    try {
        $sql = "SELECT 
                 * 
                FROM 
                 {$tabla} 
                WHERE 
                 id_sector = '$id_area' AND 
                 nombre = '$nombre' AND 
                 apellido = '$apellido' AND 
                 cedula = '$cedula' AND 
                 activo = 1";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "agregar_sub_usuario.php", $error);
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
