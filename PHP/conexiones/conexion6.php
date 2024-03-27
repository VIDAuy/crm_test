<?
$conexion_acompanantes = conexion('192.168.250.11', 'root', 'sist.2k8', 'status');
$conexion_coordinacomp = conexion('192.168.1.250', 'root', 'sist.2k8', 'coordinacomp');
$conexion_coordinacion = conexion('192.168.250.11', 'root', 'sist.2k8', 'coordinacion');


function conexion($dbhost, $dbusuario, $dbpassword, $db)
{
	$conexion = mysqli_connect($dbhost, $dbusuario, $dbpassword, $db);

	if (!$conexion) {
		$response = "Error: No se pudo conectar a MySQL." . PHP_EOL;
		$response = "error de depuración: " . mysqli_connect_errno() . PHP_EOL;
		$response = "error de depuración: " . mysqli_connect_error() . PHP_EOL;
		return $response;
		exit;
	} else {
		return $conexion;
	}
}
