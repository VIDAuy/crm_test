<?php
include_once '../../configuraciones.php';

$tabla["data"] = [];

$usuario = $_SESSION['usuario'];
$filtroSector = $_SESSION['nivel'] != 3  ? "AND r.sector = '$usuario'"  : '';
$cedula = $_REQUEST['cedula'];


$lista_registros = obtener_registros($cedula, $filtroSector);

while ($row = mysqli_fetch_assoc($lista_registros)) {

	$id = $row['id'];
	$cedula = $row['cedula'];
	$nombre = $row['nombre'];
	$telefono = $row['telefono'];
	$fecha_registro = date("d/m/Y H:i:s", strtotime($row['fecha_registro']));
	$sector = $row['sector'];
	$observacion = $row['observaciones'];
	$resumen_observacion = strlen($row['observaciones']) > 29 ? $row['observaciones'] = mb_substr($row['observaciones'], 0, 40) . ' ' . '(...)' : $row['observaciones'];
	$socio = $row['socio'] == 1 ? "Si" : "<span class='text-danger'>No</span>";
	$baja = $row['baja'] == 1 ? "<span class='text-danger'>Si</span>" : "No";
	$envioSector = $row['envioSector'] != "" ? obtener_datos_usuario($row['envioSector'])['usuario'] : "-";
	$id_sub_usuario = $row['sub_usuario'];
	$imagenes = obtener_imagenes($id);
	$btnImagen = strlen($imagenes) > 0 ? "<button class='btn btn-sm btn-info' onclick='modal_ver_imagen_registro(`" . URL_DOCUMENTOS . "`, `" . $imagenes . "`);'>Ver Archivos</button>" : "-";
	$btnMasInfo = "<button class='btn btn-sm btn-primary' onclick='abrir_modal_ver_mas_registro(`" . $id . "`, `" . $cedula . "`, `" . $nombre . "`, `" . $telefono . "`, `" . $fecha_registro . "`, `" . $sector . "`, `" . $observacion . "`, `" . $row['socio'] . "`, `" . $row['baja'] . "`);'>Más Info</button>";


	if (in_array($sector, ['Audit1', 'Audit2', 'Audit3'])) {
		$usuario = ($sector == "Audit1") ? "Nathalia Horvat" : (($sector == "Audit2") ? "Andrea Horvat" : (($sector == "Audit3") ? "Tatiana Landa" : ""));
	} else {
		$usuario = $id_sub_usuario != "" ? @utf8_encode($id_sub_usuario) : "-";
	}

	$tabla["data"][] = [
		'id'			=> $id,
		'fecha' 		=> $fecha_registro,
		'sector' 		=> $sector,
		'usuario'       => $usuario,
		'socio' 		=> $socio,
		'baja' 			=> $baja,
		'observacion'	=> $resumen_observacion,
		'avisar_a'	    => $envioSector,
		'imagen' 	    => $btnImagen,
		'mas_info'      => $btnMasInfo,
	];
}



echo json_encode($tabla);




function obtener_registros($cedula, $filtroSector)
{
	include '../../conexiones/conexion2.php';
	$tabla1 = TABLA_REGISTROS;
	$tabla2 = TABLA_SUB_USUARIOS;

	$sql = "SELECT 
			r.id, 
			r.cedula, 
			r.nombre, 
			r.telefono, 
			r.fecha_registro, 
			r.sector, 
			r.observaciones, 
			r.socio, 
			r.baja, 
			r.envioSector, 
			r.id_sub_usuario,
			CONCAT(su.nombre, ' ', su.apellido) AS sub_usuario 
		   FROM 
			{$tabla1} r
			LEFT JOIN {$tabla2} su ON r.id_sub_usuario = su.id
		   WHERE 
			r.cedula = $cedula $filtroSector 
			AND r.eliminado = 0";
	$consulta = mysqli_query($conexion, $sql);

	return $consulta;
}

function obtener_imagenes($id)
{
	$conexion = connection(DB);
	$tabla = TABLA_IMAGENES_REGISTROS;

	$sql = "SELECT nombre_imagen FROM {$tabla} WHERE id_registro = '$id' AND activo = 1";
	$consulta = mysqli_query($conexion, $sql);

	$imagenes = "";
	while ($row = mysqli_fetch_assoc($consulta)) {
		$imagenes .= $imagenes == "" ? $row['nombre_imagen'] : ", " . $row['nombre_imagen'];
	}

	return $imagenes;
}
