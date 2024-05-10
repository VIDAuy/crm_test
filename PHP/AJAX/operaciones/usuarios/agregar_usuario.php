<?php
include_once '../../../configuraciones.php';

$usuario = $_REQUEST['usuario'];
$codigo  = $_REQUEST['codigo'];
$nivel   = $_REQUEST['nivel'];
$filial  = $_REQUEST['filial'];
$email   = $_REQUEST['email'];


if ($usuario == "" || $codigo == "" || $nivel == "") devolver_error(ERROR_GENERAL);


$comprobar_existencia = comprobar_existencia($usuario);
if ($comprobar_existencia == false) devolver_error("Ocurrieron errores al comprobar la existencia del registro");

if (mysqli_num_rows($comprobar_existencia) > 0) {
    $result = mysqli_fetch_assoc($comprobar_existencia);
    $id = $result['id'];
    $activo = $result['activo'];

    if ($id != "" && $activo == 1) devolver_error("Ya existe un usuario con este nombre");

    if ($id != "" && $activo == 0) {
        $reactivar_contenido = reactivar_contenido(TABLA_USUARIOS, $id);
        if ($reactivar_contenido == false) devolver_error("Ocurrieron errores al reactivar el item");
    }
} else {

    $usuario = ucfirst($usuario);
    $agregar_usuario = agregar_usuario($usuario, $codigo, $nivel, $filial, $email);
    if ($agregar_usuario == false) devolver_error("Ocurrieron errores al registrar el usuario");
}



$response['error'] = false;
$response['mensaje'] = "Se ha registrado el usuario con éxito";
echo json_encode($response);




function comprobar_existencia($usuario)
{
    $conexion = connection(DB);
    $tabla = TABLA_USUARIOS;


    try {
        $sql = "SELECT * FROM {$tabla} WHERE usuario = '$usuario' ORDER BY id DESC LIMIT 1";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "agregar_usuario.php", $error);
        $consulta = false;
    }

    return $consulta;
}

function agregar_usuario($usuario, $codigo, $nivel, $filial, $email)
{
    $conexion = connection(DB);
    $tabla = TABLA_USUARIOS;

    try {
        $sql = "INSERT INTO {$tabla} (usuario, codigo, nivel, filial, email) VALUES ('$usuario', '$codigo', '$nivel', '$filial', '$email')";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "agregar_usuario.php", $error);
        $consulta = false;
    }

    return $consulta;
}
