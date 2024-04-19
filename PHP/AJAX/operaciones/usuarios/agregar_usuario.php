<?php
include_once '../../../configuraciones.php';

$usuario = $_REQUEST['usuario'];
$codigo  = $_REQUEST['codigo'];
$nivel   = $_REQUEST['nivel'];
$filial  = $_REQUEST['filial'];
$email   = $_REQUEST['email'];


if ($usuario == "" || $codigo == "" || $nivel == "") devolver_error(ERROR_GENERAL);


$verificar_usuario_existente = verificar_usuario($usuario);
if ($verificar_usuario_existente == false) devolver_error("Ocurrieron errores al verificar el usuario");


if (mysqli_num_rows($verificar_usuario_existente) > 0) devolver_error("Ya existe el usuario");


$agregar_usuario = agregar_usuario($usuario, $codigo, $nivel, $filial, $email);
if ($agregar_usuario == false) devolver_error("Ocurrieron errores al registrar el usuario");



$response['error'] = false;
$response['mensaje'] = "Se ha registrado el usuario con éxito";
echo json_encode($response);




function verificar_usuario($usuario)
{
    $conexion = connection(DB);
    $tabla = TABLA_USUARIOS;

    $sql = "SELECT * FROM {$tabla} WHERE usuario = '$usuario' AND activo = 1";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}

function agregar_usuario($usuario, $codigo, $nivel, $filial, $email)
{
    $conexion = connection(DB);
    $tabla = TABLA_USUARIOS;

    $sql = "INSERT INTO {$tabla} (usuario, codigo, nivel, filial, email) VALUES ('$usuario', '$codigo', '$nivel', '$filial', '$email')";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
