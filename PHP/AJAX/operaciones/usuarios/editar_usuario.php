<?php
include_once '../../../configuraciones.php';

$id      = $_REQUEST['id'];
$usuario = $_REQUEST['usuario'];
$codigo  = $_REQUEST['codigo'];
$nivel   = $_REQUEST['nivel'];
$filial  = $_REQUEST['filial'];
$email   = $_REQUEST['email'];


if ($id == "" || $usuario == "" || $codigo == "" || $nivel == "" || $filial == "" || $email == "") devolver_error(ERROR_GENERAL);


$comprobar_existencia = comprobar_existencia($usuario);
if ($comprobar_existencia == false) devolver_error("Ocurrieron errores al comprobar la existencia del registro");

if (mysqli_num_rows($comprobar_existencia) > 0) {
    $result = mysqli_fetch_assoc($comprobar_existencia);
    $id_existe = $result['id'];

    if ($id != $id_existe) {
        devolver_error("Ya existe un usuario con el mismo nombre");
    } else {
        $editar_usuario = editar_usuario($id, $usuario, $codigo, $nivel, $email);
        if ($editar_usuario == false) devolver_error("Ocurrieron errores al modificar el registro");
    }
}

$editar_usuario = editar_usuario($id, $usuario, $codigo, $nivel, $email);
if ($editar_usuario == false) devolver_error("Ocurrieron errores al modificar el registro");



$response['error'] = false;
$response['mensaje'] = "Se modifico el registro con éxito";
echo json_encode($response);




function comprobar_existencia($usuario)
{
    $conexion = connection(DB);
    $tabla = TABLA_USUARIOS;


    try {
        $sql = "SELECT * FROM {$tabla} WHERE usuario = '$usuario' ORDER BY id DESC LIMIT 1";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "editar_usuario.php", $error);
        $consulta = false;
    }

    return $consulta;
}

function editar_usuario($id, $usuario, $codigo, $nivel, $email)
{
    $conexion = connection(DB);
    $tabla = TABLA_USUARIOS;

    try {
        $sql = "UPDATE {$tabla} SET usuario = '$usuario', codigo = '$codigo', nivel = '$nivel', email = '$email' WHERE id = '$id';";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "editar_usuario.php", $error);
    }

    return $consulta;
}
