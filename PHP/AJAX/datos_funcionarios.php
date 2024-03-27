<?php
session_start();

include '../conexiones/conexion2.php';

$cedula = $_REQUEST['cedula'];
$nombre_completo = mb_convert_case($_REQUEST['nombre'], MB_CASE_UPPER, "UTF-8");
$tel = str_replace(' ', '', $_REQUEST['tel']);
$sector = $_SESSION['usuario'];
$observacion = mysqli_real_escape_string($conexion, $_REQUEST['observacion']);
$envioSector = $_REQUEST['avisar'];


$consulta = mysqli_query($conexion, "INSERT INTO registros_funcionarios(cedula, nombre, telefono, fecha_registro, sector, observaciones, envioSector, activo)
	VALUES('$cedula', '$nombre_completo', '$tel', NOW(), '$sector', '$observacion', '$envioSector', 1)");



if ($consulta === false) {
	$response['error'] = true;
	$response['mensaje'] = "Error, consulte al administrador";
	die(json_encode($response));
}


$response['error'] = false;
$response['mensaje'] = "Ingreso satisfactorio";


//log
//file_put_contents('../../logs/registros.log', "[$fecha] SOCIO: $cedula - USUARIO: " . $_SESSION['usuario'] . " SECTOR: $sector" . " QUERY: $consulta\n", FILE_APPEND);

mysqli_close($conexion);
header('Content-type: application/json; charset=utf-8');
die(json_encode($response));
