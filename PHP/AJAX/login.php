<?php
include_once '../configuraciones.php';

if (isset($_SESSION['usuario'])) session_destroy();

$usuario  = $_REQUEST['usuario'];
$password = $_REQUEST['password'];


$consultar_usuario = verificar_usuario($usuario, $password);


if (mysqli_num_rows($consultar_usuario) <= 0) {
	$respuesta = array('result' => false, 'error' => true, 'message' => 'Usuario o contraseña incorrecta.');
} else {
	$datos_usuario = mysqli_fetch_assoc($consultar_usuario);
	$_SESSION['usuario'] = ucfirst(strtolower($usuario));
	$_SESSION['nivel'] 	 = $datos_usuario['nivel'];
	$_SESSION['filial']  = $datos_usuario['filial'];
	$_SESSION['id']		 = $datos_usuario['id'];
	$respuesta = array('result' => true);
}



echo json_encode($respuesta);




function verificar_usuario($usuario, $password)
{
	$conexion = connection(DB);
	$tabla = TABLA_USUARIOS;

	$sql = "SELECT 
			id, 
			nivel, 
			filial
		   FROM 
			{$tabla}
		   WHERE 
			usuario = '$usuario' AND 
			codigo = '$password'";
	$consulta = mysqli_query($conexion, $sql);

	return $consulta;
}
