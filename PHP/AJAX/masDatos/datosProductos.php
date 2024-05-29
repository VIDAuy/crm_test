<?php
include_once '../../configuraciones.php';
$sector = $_SESSION['usuario'];
$cedula = $_REQUEST['cedula'];
$opcion = $_REQUEST['opcion'];

$datos_productos = obtener_productos($cedula);


if ($opcion == 1 && mysqli_num_rows($datos_productos) <= 0) {
	$response['error'] = true;
	$response['mensaje'] = "Ha ocurrido un error al tratar de mostrar los productos.";
	die(json_encode($response));
}

if ($opcion == 2 && mysqli_num_rows($datos_productos) > 0) {
	$response["data"] = [];

	while ($row = mysqli_fetch_assoc($datos_productos)) {
		$nroServicio      = $row['nro_servicio'];
		$servicio 	      = $row['servicio'];
		$horas 		      = $row['hora'];
		$importe 	      = $row['importe'];
		$cod_promo        = $row['cod_promo'];
		$fecha_afiliacion = $row['fecha_afiliacion'];
		$count            = $row['count'];
		$keepprice        = $row['keepprice1'];


		if ($sector == "Calidad" || $sector == "Bajas") {
			$response["data"][] = [
				'nroServicio'      => $nroServicio,
				'servicio' 	       => $servicio,
				'horas' 	       => $horas,
				'importe' 	       => "$$importe",
				'cod_promo'        => $cod_promo,
				'fecha_afiliacion' => $fecha_afiliacion,
				'count'            => $count,
				'keepprice'        => $keepprice,
			];
		} else {
			$response["data"][] = [
				'nroServicio' => $nroServicio,
				'servicio' 	  => $servicio,
				'horas' 	  => $horas,
				'importe' 	  => "$$importe"
			];
		}
	}
}



$response['error'] = false;
$response['mensaje'] = "Esta persona tiene productos registrados.";
echo json_encode($response);




function obtener_productos($cedula)
{
	include '../../conexiones/conexion.php';
	$tabla1 = TABLA_PADRON_PRODUCTO_SOCIO;
	$tabla2 = TABLA_SERVICIOS_CODIGOS;

	$sql = "SELECT 
		pps.servicio AS nro_servicio, 
		sc.servicio, 
		pps.hora, 
		pps.importe,
		pps.cod_promo,
		pps.fecha_afiliacion,
		pps.count,
		pps.keepprice1
	  FROM 
		{$tabla1} pps 
		INNER JOIN {$tabla2} sc ON pps.servicio = sc.nro_servicio 
	  WHERE 
		cedula = $cedula";
	$consulta = mysqli_query($conexion, $sql);

	return $consulta;
}
