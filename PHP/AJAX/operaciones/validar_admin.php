<?php
include_once '../../configuraciones.php';

$password = $_REQUEST['password'];

if ($password == "") devolver_error(ERROR_GENERAL);


if ($password != PASSWORD_ADMIN) devolver_error("Contraseña incorrecta");


$response['error'] = false;
$response['mensaje'] = "Bienvenido Admin";
echo json_encode($response);
