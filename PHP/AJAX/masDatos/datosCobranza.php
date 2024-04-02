<?php
include_once '../../configuraciones.php';
$cedula = $_REQUEST['cedula'];
$opcion = $_REQUEST['opcion'];

$consulta_cobranza = datos_cobranza($cedula);


if ($opcion == 1 && mysqli_num_rows($consulta_cobranza) <= 0) {
	$response['error'] = true;
	$response['mensaje'] = "Esta persona no tiene registros en cobranzas.";
	die(json_encode($response));
}

if ($opcion == 2 && mysqli_num_rows($consulta_cobranza) > 0) {
	$response["data"] = [];

	while ($row = mysqli_fetch_assoc($consulta_cobranza)) {
		$mes         = $row['MES'];
		$ano         = $row['ANO'];
		$importe     = $row['IMPORTE'];
		$mes_cobrado = $row['COBRADO_EN_EL_MES'];

		$response["data"][] = [
			'mes' 	  => $mes = strlen($mes) == 1 ? "0$mes" : $mes,
			'anho' 	  => $ano,
			'importe' => "$$importe",
			'cobrado' => $mes_cobrado,
		];
	}
}



$response['error'] = false;
$response['mensaje'] = "Esta persona tiene registros en cobranzas.";
echo json_encode($response);




function datos_cobranza($cedula)
{
	include '../../conexiones/conexion4.php';
	$tabla = TABLA_COBRADO;

	$sql = "SELECT 
		MES,
		ANO,
		IMPORTE,
		COBRADO_EN_EL_MES 
	  FROM 
		{$tabla} 
	  WHERE 
		CEDULA = '$cedula' 
	  ORDER BY ANO DESC";
	$consulta = mysqli_query($conexion, $sql);

	return $consulta;
}
