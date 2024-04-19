<?php
include_once '../../configuraciones.php';
$conexion = connection(DB);

$sector = $_SESSION['id'];

if (isset($_POST['CI'])) {

	$cedula = $_POST['CI'];
	$id_registro = $_POST['idRegistro'];

	$q = "UPDATE registros SET activo='0' WHERE cedula='$cedula'";
	$r = mysqli_query($conexion, $q);
	$jsondata = array();
	$jsondata['message'] = "ok";

	// registra quien lee la alerta
	$query = "INSERT INTO historico_alerta(id, id_registro, sector) VALUES(null, $id_registro, '$sector')";
	mysqli_query($conexion, $query);

	echo json_encode($jsondata);
} else {
	$id_sub_usuario = isset($_SESSION['id_sub_usuario']) ? $_SESSION['id_sub_usuario'] : "";

	if ($id_sub_usuario != "") {
		$q 	= "SELECT sector, nombre, telefono, cedula, id FROM registros WHERE activo=1 AND envioSector = $sector AND cedula != '' AND id_usuario_asignado = '$id_sub_usuario'";
	} else {
		$q 	= "SELECT sector, nombre, telefono, cedula, id FROM registros WHERE activo=1 AND envioSector = $sector AND cedula != ''";
	}


	$r 	= mysqli_query($conexion, $q);
	$f = [];
	while ($row = mysqli_fetch_array($r)) {

		$f[] = array(
			'idRegistro' => $row['id'],
			'sector'	 => $row['sector'],
			'nombre'	 => $row['nombre'],
			'telefono'	 => corregirTelefono($row['telefono']),
			'cedula'	 => $row['cedula']
		);
	}

	echo json_encode($f);
}
