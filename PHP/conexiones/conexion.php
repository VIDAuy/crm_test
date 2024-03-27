<?
date_default_timezone_set('America/Argentina/Buenos_Aires');
$dbhost		= "localhost";	// host del MySQL (generalmente localhost)
$dbusuario	= "root";		// aqui debes ingresar el nombre de usuario
$dbpassword	= "root";		// password de acceso para el usuario de la
$db			= "abmmod";		// Seleccionamos la base con la cual
$conexion	= mysqli_connect($dbhost, $dbusuario, $dbpassword, $db);
// mysqli_set_charset($conexion,'utf-8');
if (!$conexion) {
	echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
	echo "error de depuración: " . mysqli_connect_errno() . PHP_EOL;
	echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
	exit;
}
