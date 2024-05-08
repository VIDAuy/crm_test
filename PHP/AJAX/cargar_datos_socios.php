<?php
include_once '../configuraciones.php';

$id_area = $_SESSION['id'];
$sucursales_inspira = ['1372', '1373', '1374', '1375', '1376'];
$mostrar_inspira = $_SESSION['id'] == 2 || $_SESSION['id'] == 34 ? true : false;

$cedula = $_GET['CI'];
$consulta_padron = datos_padron($cedula);
$datos_padron = mysqli_fetch_assoc($consulta_padron);

if ($datos_padron != "") {
	$datos_padron['fecha_afiliacion'] = (new DateTime($datos_padron['fecha_afiliacion']))->format('d/m/Y');
	$datos_padron['nombre'] = remplazarAcentos($datos_padron['nombre']);
}



if (mysqli_num_rows($consulta_padron) == 0) {

	$consulta_padron = datos_registros($cedula);
	if (mysqli_num_rows($consulta_padron)) {
		$f2 = mysqli_fetch_assoc($consulta_padron);

		$datos_padron = [
			'noSocioConRegistros' => true,
			'mensaje' 			  => "La cédula ingresada no pertenece a un socio pero ya tiene registros.\nSe le mostrará un formulario diferente.",
			'nombre' 			  => $f2["nombre"],
			'telefono' 			  => trim($f2['telefono']) == "" || trim($f2['telefono']) == 0 ? 0 : trim(corregirTelefono($f2['telefono'])),
		];
	} else {

		$datos_padron = [
			'noSocio' 	=> true,
			'mensaje' 	=> "De ser así, por favor, rellene los campos que se le solicitará a continuación o de lo contrario consulte un funcionario."
		];
	}
} else {

	$datos_padron['inspira'] = in_array($datos_padron['sucursal'], $sucursales_inspira) ? 'SI' : 'NO';
	$baja_procesada = tiene_baja_procesada($cedula);

	if (mysqli_num_rows($baja_procesada) == 1) {
		$consulta_registros = datos_registros($cedula);
		$datos_registros = mysqli_fetch_assoc($consulta_registros);
		$datos_padron = [
			'bajaProcesada'	=> true,
			'nombre' 		=> $datos_registros['nombre'],
			'telefono' 		=> $datos_registros['telefono'] == "" || $datos_registros['telefono'] == 0 ? 0 : corregirTelefono($datos_registros['telefono']),
			'mensaje'		=> "La cédula ingresada no pertenece a un socio pero ya tiene registros.\nSe le mostrará un formulario diferente."
		];
	} else {
		$datos_padron['tel'] = trim($datos_padron['tel']) == "" || trim($datos_padron['tel']) == 0 ? 0 : trim(corregirTelefono($datos_padron['tel']));
	}
}
$datos_padron['mostrar_inspira'] = $mostrar_inspira;



$contenido = [];
$permiso_contenido = comprobar_permisos(2, $id_area, null, 2);
if ($permiso_contenido === false) devolver_error("Ocurrieron errores al obtener los permisos");
if (mysqli_num_rows($permiso_contenido) > 0) {
	while ($row = mysqli_fetch_assoc($permiso_contenido)) {
		$id = $row['id'];
		array_push($contenido, $id);
	}
}
$datos_padron['todo_contenido'] = $contenido;



echo json_encode($datos_padron);




function datos_padron($cedula)
{
	include '../conexiones/conexion.php';
	$tabla1 = TABLA_PADRON_DATOS_SOCIO;
	$tabla2 = TABLA_PADRON_PRODUCTO_SOCIO;

	$sql = "SELECT 
		pds.nombre, 
		pds.tel, 
		pds.cedula, 
		pps.fecha_afiliacion, 
		pds.sucursal, 
		pds.radio
	  FROM 
	   {$tabla1} pds
	   INNER JOIN {$tabla2} pps ON pds.cedula = pps.cedula
  	  WHERE
	   pds.cedula = $cedula
  	  ORDER BY pds.id DESC
  	  LIMIT 1";

	$consulta = mysqli_query($conexion, $sql);

	return $consulta;
}

function tiene_baja_procesada($cedula)
{
	include '../conexiones/conexion.php';
	$tabla = TABLA_PADRON_DATOS_SOCIO;

	try {
		$sql = "SELECT abmactual, abm FROM {$tabla} WHERE cedula = '$cedula' AND abmactual = 1 AND abm = 'BAJA'";
		$consulta = mysqli_query($conexion, $sql);
	} catch (\Throwable $error) {
		registrar_errores($sql, "cargar_datos_socios.php", $error);
		$consulta = false;
	}

	return $consulta;
}

function datos_registros($cedula)
{
	include '../conexiones/conexion2.php';
	$tabla = TABLA_REGISTROS;

	try {
		$sql = "SELECT nombre, telefono FROM {$tabla} WHERE cedula = '$cedula'";
		$consulta = mysqli_query($conexion, $sql);
	} catch (\Throwable $error) {
		registrar_errores($sql, "cargar_datos_socios.php", $error);
		$consulta = false;
	}

	return $consulta;
}
