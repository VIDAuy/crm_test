<?php
	include '../../conexiones/conexion2.php';
	$filial = $_GET['filial'];

	$q = "SELECT id, nombre_socio, cedula_socio, motivo_baja, estado 
			FROM bajas 
			WHERE filial_solicitud = $filial";
	$r = mysqli_query($conexion, $q);
	if (mysqli_num_rows($r) != 0)
	{
		while ($row = mysqli_fetch_assoc($r))
		{
			$f[] = $row;
		}
	}
	else $f = ['sinRegistros' => true];

	echo json_encode($f);