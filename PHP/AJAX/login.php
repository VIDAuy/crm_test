<?php
include_once '../configuraciones.php';

if (isset($_SESSION['usuario'])) {
	$array_variables_sesion = ["usuario", "nivel", "filial", "id", "id_sub_usuario", "id_sector", "sector", "cedula", "nombre", "apellido", "gestor"];
	foreach ($array_variables_sesion as $variable_sesion) {
		unset($_SESSION[$variable_sesion]);
	}
}

$usuario  = $_REQUEST['usuario'];
$password = $_REQUEST['password'];


$consultar_usuario = verificar_usuario($usuario, $password);


if (mysqli_num_rows($consultar_usuario) <= 0) {
	$respuesta = array('result' => false, 'error' => true, 'message' => 'Usuario o contraseña incorrecta.');
} else {

	$modificar_fecha_ultima_sesion = modificar_ultima_fecha_sesion($usuario);

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
	include_once '../conexiones/conexion2.php';
	$tabla = TABLA_USUARIOS;

	$sql = "SELECT 
			id, 
			nivel, 
			filial
		   FROM 
			{$tabla}
		   WHERE 
			usuario = '$usuario' AND 
			codigo = '$password' AND
			activo = 1";
	$consulta = mysqli_query($conexion, $sql);

	return $consulta;
}


function modificar_ultima_fecha_sesion($usuario)
{
	$conexion = connection(DB);
	$tabla = TABLA_USUARIOS;

	$sql = "UPDATE {$tabla} SET fecha_ultima_sesion = NOW() WHERE usuario = '$usuario' AND activo = 1";
	$consulta = mysqli_query($conexion, $sql);

	return $consulta;
}
