<?php

include '../../conexiones/conexion2.php';
$data 		= array_map('stripslashes', $_POST);
$response 	= array('result' => false, 'message' => 'error');

if ($data) {
	$fechaIngresoBaja 		= date('Y-m-d');
	$idrelacion 			= $data['idrelacion'];
	$nombreFuncionario 		= mb_convert_case(mysqli_real_escape_string($conexion, $data['nombre_funcionario']), MB_CASE_TITLE, 'UTF-8');
	$filialSolicitud 		= $data['filial_solicitud'];
	$estado 				= 'Pendiente';
	$observaciones 			= ucfirst(mb_strtolower(mysqli_real_escape_string($conexion, $data['observaciones'])));
	$nombreSocio 			= $data['nombre_socio'];
	$cedulaSocio 			= $data['cedula_socio'];
	$filialSocio 			= $data['filial_socio'];
	$servicioContratado 	= $data['nroServicio0'];
	$horasContratadas 		= $data['horas0'];
	$importe 				= $data['importe0'];
	$i = 1;
	while (isset($data['horas' . $i])) {
		$servicioContratado 	= $servicioContratado . ', ' . $data['nroServicio' . $i];
		$horasContratadas 		= $horasContratadas . ', ' . $data['horas' . $i];
		$importe 				= $importe . ', ' . $data['importe' . $i];
		$i++;
	}
	$motivoBaja 			= $data['motivo_baja'];
	$nombreContacto 		= mb_convert_case(mysqli_real_escape_string($conexion, $data['nombre_contacto']), MB_CASE_TITLE, 'UTF-8');
	$apellidoContacto 		= mb_convert_case(mysqli_real_escape_string($conexion, $data['apellido_contacto']), MB_CASE_TITLE, 'UTF-8');
	$telefonoContacto 		= (isset($data['telefono_contacto']) && strlen($data['telefono_contacto']) === 8)
		? $data['telefono_contacto']
		: null;
	$celularContacto 		= (isset($data['celular_contacto']) && strlen($data['celular_contacto']) === 9)
		? $data['celular_contacto']
		: null;

	$sector = $_GET['sector'];
	$id_sub_usuario = $_GET['id_sub_usuario'];

	if (in_array($_GET['sector'], array('19585073', '50709395'))) {
		$sector = 'Bajas';
	}

	$q = "SELECT activo FROM bajas WHERE idrelacion = '$idrelacion' AND activo = 1";
	$r = mysqli_query($conexion, $q);

	if (mysqli_num_rows($r) != 0) $response = array('registroActivo' => true, 'message' => 'Ya se está gestionando una baja para esa persona.');
	else {
		$qSelect = "SELECT COUNT(`telefono_contacto`) AS `cantidad` FROM `bajas` WHERE `telefono_contacto` = '{$telefonoContacto}' GROUP BY `telefono_contacto`";
		$select = mysqli_query($conexion, $q);
		$cantidadDeUsosTelefono = mysqli_num_rows($select) != 0 ? mysqli_fetch_assoc($select)['cantidad'] : 0;


		$qSelect = "SELECT COUNT(`celular_contacto`) AS `cantidad` FROM `bajas` WHERE `celular_contacto` = '{$celularContacto}' GROUP BY `celular_contacto`";
		$select = mysqli_query($conexion, $q);
		$cantidadDeUsosCelular = mysqli_num_rows($select) != 0 ? mysqli_fetch_assoc($select)['cantidad'] : 0;

		if ($cantidadDeUsosTelefono > 0)
			$observaciones .= "\nADVERTENCIA, EL TELÉFONO DE CONTACTO {$telefonoContacto} SE HA UTILIZADO {$cantidadDeUsosTelefono} VECES.";
		if ($cantidadDeUsosCelular > 0)
			$observaciones .= "\nADVERTENCIA, EL CELULAR DE CONTACTO {$celularContacto} SE HA UTILIZADO {$cantidadDeUsosCelular} VECES.";

		$q = "INSERT INTO
		bajas
		(fecha_ingreso_baja, idrelacion, nombre_funcionario, filial_solicitud, estado, observaciones, nombre_socio, cedula_socio, filial_socio,
		servicio_contratado, horas_contratadas, importe, motivo_baja, nombre_contacto, apellido_contacto, telefono_contacto, celular_contacto)
		VALUES
		('$fechaIngresoBaja', '$idrelacion', '$nombreFuncionario', $filialSolicitud, '$estado', '$observaciones', '$nombreSocio', '$cedulaSocio', $filialSocio,
		'$servicioContratado', '$horasContratadas', '$importe', '$motivoBaja', '$nombreContacto', '$apellidoContacto', '$telefonoContacto', '$celularContacto')";
		$r = mysqli_query($conexion, $q);

		$fechaIngresoBaja 		= date('Y-m-d H:i:s');
		$observaciones 			= 'Solicitud de baja: ' . $observaciones;

		$q = "INSERT INTO registros (cedula, nombre, telefono, fecha_registro, sector, observaciones, socio, baja, id_sub_usuario)
			VALUES ('$cedulaSocio', '$nombreSocio', '$telefonoContacto', '$fechaIngresoBaja', '$sector', '$observaciones', 1, 1, '$id_sub_usuario')";
		$r = mysqli_query($conexion, $q);

		if ($r) {
			$mensaje = 'Los registros se han ingresado de forma exitosa.';
			if ($cantidadDeUsosTelefono > 0)
				$mensaje .= "\nADVERTENCIA, EL TELÉFONO DE CONTACTO {$telefonoContacto} SE HA UTILIZADO {$cantidadDeUsosTelefono} VECES.";
			if ($cantidadDeUsosCelular > 0)
				$mensaje .= "\nADVERTENCIA, EL CELULAR DE CONTACTO {$celularContacto} SE HA UTILIZADO {$cantidadDeUsosCelular} VECES.";
			$response 	= array(
				'result' => true,
				'message' => $mensaje,
				'telefono' => $telefonoContacto,
				'reiteraciones_telefono' => $cantidadDeUsosTelefono,
				'celular' => $celularContacto,
				'reiteraciones_celular' => $cantidadDeUsosCelular
			);
		} else {
			$response 	= array('result' => false, 'message' => 'Ha ocurrido un error al ingresar los registros.');
		}
	}
}
echo json_encode($response);
