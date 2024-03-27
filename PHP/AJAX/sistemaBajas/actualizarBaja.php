<?php
session_start();
include '../../conexiones/conexion2.php';

use PHPMailer\PHPMailer\PHPMailer;

require '../../lib/PHPMailer/src/PHPMailer.php';
require '../../lib/PHPMailer/src/SMTP.php';
require '../../lib/PHPMailer/src/Exception.php';



if ($_REQUEST) {
	$idrelacion 			= $_REQUEST['idrelacion'];
	$fechaInicioGestion 	= date('Y-m-d');
	$estado 				= $_REQUEST['estado'];
	$motivoNoOtorgada 		= (isset($_REQUEST['motivo'])) ? $_REQUEST['motivo'] : null;
	$nombreFuncionarioFinal = mb_convert_case($_REQUEST['nombreFuncionarioFinal'], MB_CASE_TITLE, 'UTF-8');
	$motivo                 = $motivoNoOtorgada == "" ? "" : "- $motivoNoOtorgada";
	$observacionFinal 		= "Baja $estado $motivo: " . mysqli_real_escape_string($conexion, $_REQUEST['observacionFinal']);
	$areaFinGestion         = $_REQUEST['usuario'];
	$id_sub_usuario         = $_REQUEST['id_sub_usuario'];
	$avisar_a_elite         = $_REQUEST['avisar_a_elite'] == "true" ? true : false;
	$alertar_elite          = $avisar_a_elite == true ? "envioSector = '65', activo = 1" : 'activo = 0';




	if (in_array($areaFinGestion, array('40479176', '48458544', '53220928', '63737983', '20053746', '49203790'))) {
		$sector = 'Coordinacion';
	} else if (in_array($areaFinGestion, array('19585073', '50709395'))) {
		$sector = 'Bajas';
	} else {
		$sector = $areaFinGestion;
	}


	$fechaFinGestion = date('Y-m-d');
	$q 		    	 = "SELECT fecha_inicio_gestion FROM bajas WHERE idrelacion = '$idrelacion' LIMIT 1";
	$r 				 = mysqli_query($conexion, $q);
	$f 				 = mysqli_fetch_assoc($r);
	$enGestion 		 = ($f['fecha_inicio_gestion'] != null) ? true : false;
	$q 				 = "SELECT cedula_socio, nombre_socio, telefono_contacto, celular_contacto FROM bajas WHERE idrelacion = '$idrelacion' ORDER BY id DESC LIMIT 1";
	$r 				 = mysqli_query($conexion, $q);
	$f 				 = mysqli_fetch_assoc($r);
	$nombre 		 = mb_convert_case($f['nombre_socio'], MB_CASE_TITLE, "UTF-8");
	$cedula 		 = $f['cedula_socio'];
	$telefono 		 = $f['telefono_contacto'] . ' ' . $f['celular_contacto'];
	$fecha 			 = date('Y-m-d H:i:s');

	$q = ($estado != 'Otorgada') ?
		"INSERT INTO registros SET cedula = '$cedula', nombre = '$nombre', telefono = '$telefono', fecha_registro = '$fecha', sector = '$sector', observaciones = '$observacionFinal', socio = 1, baja = 1, id_sub_usuario = '$id_sub_usuario', $alertar_elite"
		:
		"INSERT INTO registros SET cedula = '$cedula', nombre = '$nombre', telefono = '$telefono', fecha_registro = '$fecha', sector = '$sector', observaciones = '$observacionFinal', socio = 0, baja = 1, id_sub_usuario = '$id_sub_usuario', $alertar_elite";
	mysqli_query($conexion, $q);

	if ($enGestion) {
		$q = ($estado == 'En gestión') ?
			"UPDATE bajas SET estado = '$estado', motivo_no_otorgada = '$motivoNoOtorgada', nombre_funcionario_final = '$nombreFuncionarioFinal', observacion_final = '$observacionFinal', area_fin_gestion = '$sector', activo = 1 WHERE idrelacion = '$idrelacion'"
			:
			"UPDATE bajas SET estado = '$estado', motivo_no_otorgada = '$motivoNoOtorgada', nombre_funcionario_final = '$nombreFuncionarioFinal', observacion_final = '$observacionFinal', area_fin_gestion = '$sector', fecha_fin_gestion = '$fechaFinGestion', activo = 0 WHERE idrelacion = '$idrelacion'";
	} else {
		$q = ($estado == 'En gestión') ?
			"UPDATE bajas SET fecha_inicio_gestion = '$fechaInicioGestion', estado = '$estado', motivo_no_otorgada = '$motivoNoOtorgada', nombre_funcionario_final = '$nombreFuncionarioFinal', observacion_final = '$observacionFinal', area_fin_gestion = '$sector', activo = 1 WHERE idrelacion = '$idrelacion'"
			:
			"UPDATE bajas SET fecha_inicio_gestion = '$fechaInicioGestion', estado = '$estado', motivo_no_otorgada = '$motivoNoOtorgada', nombre_funcionario_final = '$nombreFuncionarioFinal', observacion_final = '$observacionFinal', area_fin_gestion = '$sector', fecha_fin_gestion = '$fechaFinGestion', activo = 0 WHERE idrelacion = '$idrelacion'";
	}

	mysqli_query($conexion, $q);

	if ($estado == 'Otorgada') {
		mysqli_close($conexion);

		include '../../conexiones/conexion.php';
		$observacion = mysqli_real_escape_string($conexion, $_REQUEST['observacionFinal']);
		if (strlen($observacion) > 300) $observacion = substr($observacion, 0, 290) . '...';
		$q = "UPDATE padron_datos_socio SET abmactual = 1, abm = 'baja', observaciones = '$observacion' WHERE cedula = $cedula";
		mysqli_query($conexion, $q);
		$q = "UPDATE padron_producto_socio SET abmactual = 1, abm = 'baja' WHERE cedula = $cedula";
		mysqli_query($conexion, $q);
	}
	$respuesta = array(
		'correcto' => true,
		'mensaje' => 'El registro se ha actualizado de forma exitosa.'
	);



	if ($avisar_a_elite == true) {
		$envioSector = 65; //Elite
		$datos_sector_avisar = obtener_datos_envio_sector($envioSector);

		$sql_derivacion_elite = "INSERT INTO derivacion_bajas (id_relacion) VALUES ('$idrelacion')";
		$registrar_derivacion_elite = mysqli_query($conexion, $sql_derivacion_elite);

		if ($registrar_derivacion_elite == true) {
			//Enviar Mail
			$texto = [
				"titulo" => "Nueva alerta",
				"cabecera" => ucfirst($sector) . " ha cargado una nueva alerta.",
				"detalle1" => "Por favor corroboré los registros en su CRM,",
				"informacion" => "Muchas gracias!"
			];
			$bodyHtml = htmlBodyEmail($texto);
			$email = EnviarMail($sector, $datos_sector_avisar, $bodyHtml);
		} else {
			$respuesta = array(
				'error' => true,
				'mensaje' => 'Ha ocurrido un error al registrar la derivación a Elite.'
			);
		}
	}
} else {
	$respuesta = array(
		'error' => true,
		'mensaje' => 'Ha ocurrido un error, por favor dirígase al administrador.'
	);
}

echo json_encode($respuesta);





function obtener_datos_envio_sector($id_sector)
{
	global $conexion;

	$sql = "SELECT * FROM usuarios WHERE id = '{$id_sector}'";
	$consulta = mysqli_query($conexion, $sql);

	return mysqli_fetch_assoc($consulta);
}

function htmlBodyEmail($texto)
{
	$html = '
    <!DOCTYPE html>
		<html lang="es">
		<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<meta name="x-apple-disable-message-reformatting">
		<style>
			table, td, div, h1, p {font-family: Arial, sans-serif;}
		</style>
		</head>
		<body style="margin:0;padding:0;">
		<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
			<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
				<tr>
					<td align="center" style="padding:40px 0 30px 0;background:#304689;">
					<img src="https://i.ibb.co/WkqgSFv/111-fotor-bg-remover-2023051092030.png" alt="" width="300" style="height:auto;display:block;" />
					</td>
				</tr>
				<tr>
					<td style="padding:36px 30px 42px 30px;">
					<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
						<tr>
						<td style="padding:0 0 36px 0;color:#153643;">
							<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">' . @utf8_decode($texto["titulo"]) . '</h1>
							<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">' . @utf8_decode($texto["cabecera"]) . '</p>
							<p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">' . @utf8_decode($texto["detalle1"]) . '</p>
							<p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">' . @utf8_decode($texto["informacion"]) . '</p>
						</td>
						</tr>
					</table>
					</td>
				</tr>
				<tr>
					<td style="padding:30px;background: #942f4a !important;">
					
					</td>
				</tr>
				</table>
			</td>
			</tr>
		</table>
		</body>
		</html>
    ';
	return $html;
}

function EnviarMail($sector, $datos_sector_avisar, $bodyHtml, $ccs = null)
{
	$configuracion = [
		"host" => "smtp.gmail.com",
		"port" => 587,
		"username" => "no-responder@vida.com.uy",
		"password" => "2k8.vida",
		"from" => "no-responder@vida.com.uy",
		"fromname" => @utf8_decode(ucfirst($sector)),
	];

	$datos = [
		"email" => $datos_sector_avisar['email'],
		"nombre" => @utf8_decode(ucfirst($datos_sector_avisar['usuario']))
	];

	$asunto = "Usted tiene una nueva alerta en CRM";

	$mail = new PHPMailer();
	$mail->isSMTP();
	$mail->Host = $configuracion["host"];
	$mail->SMTPAuth = true;
	$mail->Username = $configuracion["username"];
	$mail->Password = $configuracion["password"];
	$mail->SMTPSecure = 'tls';
	$mail->Port = $configuracion["port"];
	$mail->Subject = $asunto;
	$mail->isHTML(true);
	$mail->setFrom($configuracion["from"], $configuracion["fromname"]);
	//$mail->addReplyTo($configuracion["from"], $configuracion["fromname"]);
	$mail->addAddress($datos["email"], @utf8_decode(ucfirst($datos["nombre"])));
	if ($ccs != null) {
		foreach ($ccs as $cc) {
			$mail->addCC($cc["email"], @utf8_decode(ucfirst($cc["nombre"])));
		}
	}
	$mail->Body = $bodyHtml;

	if ($mail->send()) {
		return true;
	} else {
		return $mail->ErrorInfo;
	}
}
