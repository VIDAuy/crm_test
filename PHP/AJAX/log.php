<?php
include '../conexiones/conexion2.php';

if (isset($_SESSION['usuario'])) session_destroy();

session_start();

$usuario 	= $_POST['usuario'];
$password 	= $_POST['password'];

$q = "SELECT id, nivel, filial
			FROM usuarios
			WHERE usuario = '$usuario'
				AND codigo = '$password'";
$r = mysqli_query($conexion, $q);

if (mysqli_num_rows($r) != 1) {
	$respuesta = array('result' => false, 'error' => true, 'message' => 'Usuario o contraseña incorrecta.');
} else {
	$f = mysqli_fetch_assoc($r);
	$_SESSION['usuario'] 	= ucfirst(strtolower($usuario));
	$_SESSION['nivel'] 		= $f['nivel'];
	$_SESSION['filial'] 	= $f['filial'];
	$_SESSION['id']			= $f['id'];
	$respuesta = array('result' => true);
}

echo json_encode($respuesta);
