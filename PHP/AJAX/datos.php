<?php
session_start();
include '../conexiones/conexion2.php';


use PHPMailer\PHPMailer\PHPMailer;

require '../lib/PHPMailer/src/PHPMailer.php';
require '../lib/PHPMailer/src/SMTP.php';
require '../lib/PHPMailer/src/Exception.php';



$area = $_SESSION['usuario'];
$nombre = mb_convert_case($_REQUEST['nombre'], MB_CASE_UPPER, "UTF-8");
$tel = $_REQUEST['telefono'];
$observacion = mysqli_real_escape_string($conexion, $_REQUEST['observacion']);
$cedula = $_REQUEST['cedulas'];
$envioSector = $_REQUEST['ensec'];
$socio = $_REQUEST['socio'];
$sector = $_REQUEST['sector'];
$id_sub_usuario = !isset($_SESSION['id_sub_usuario']) ? $_SESSION['id_sub_usuario'] : "";


if ($area == "" || $nombre == "" || $observacion == "" || $cedula == "" || $socio == "" || $sector == "") {
	$respuesta['error'] = true;
	$respuesta['message'] = "Ha ocurrido un error, contacte al administrador";
	die(json_encode($respuesta));
}


if (in_array($_REQUEST['sector'], array('19585073', '50709395'))) $sector = 'Bajas';


if (count($_FILES) > 0) {
	$imagen = $_FILES['imagen'];

	if (controlarExtension($imagen, array("png", "jpeg", "jpg", "pdf")) <= 0) {
		$respuesta['error'] = true;
		$respuesta['message'] = "Los archivos cargados solo pueden ser de tipo .jpg, .jpeg, .png o .pdf";
		die(json_encode($respuesta));
	}

	$archivo = insert_registro_con_imagen($imagen, $cedula, $nombre, $tel, $sector, $observacion, $envioSector, $socio, $id_sub_usuario);

	if ($archivo === false) {
		$respuesta['error'] = true;
		$respuesta['message'] = "Error al cargar el registro";
		die(json_encode($respuesta));
	}
} else {
	$insert = insert_registro($cedula, $nombre, $tel, $sector, $observacion, $envioSector, $socio, $id_sub_usuario);

	if ($insert === false) {
		$respuesta['error'] = true;
		$respuesta['message'] = "Error al cargar el registro";
		die(json_encode($respuesta));
	}
}


if ($envioSector != "") {
	$datos_sector_avisar = obtener_datos_envio_sector($envioSector);
	$usuario_enviar_mail = $datos_sector_avisar['usuario'];

	//Enviar Mail
	$texto = [
		"titulo" => "Nueva alerta",
		"cabecera" => ucfirst($sector) . " ha cargado una nueva alerta.",
		"detalle1" => "Por favor corroboré los registros en su CRM,",
		"informacion" => "Muchas gracias!"
	];
	$bodyHtml = htmlBodyEmail($texto);
	$email = EnviarMail($sector, $datos_sector_avisar, $bodyHtml);

	if ($email === true) {
		$respuesta['error'] = false;
		$respuesta['email'] = true;
		$respuesta['message'] = 'Se ha cargado el registro para la cédula <span class="text-danger"><strong>' . $cedula . '</strong></span>';
		$respuesta['area'] = $area;
	} else {
		$respuesta['error'] = true;
		$respuesta['email'] = false;
		$respuesta['emailError'] = $email;
		$respuesta['message'] = 'Se ha cargado el registro para la cédula <span class="text-danger"><strong>' . $cedula . '</strong></span> pero ocurrieron errores al enviar el email';
		$respuesta['area'] = $area;
	}
} else {
	$respuesta['error'] = false;
	$respuesta['message'] = 'Se ha cargado el registro para la cédula <span class="text-danger"><strong>' . $cedula . '</strong></span>';
	$respuesta['area'] = $area;
}



echo json_encode($respuesta);




function insert_registro_con_imagen($documento, $cedula, $nombre, $telefono, $sector, $observacion, $envioSector, $socio, $id_sub_usuario)
{
	global $conexion;
	$errores = 0;

	$id_insert = insert_registro($cedula, $nombre, $telefono, $sector, $observacion, $envioSector, $socio, $id_sub_usuario);

	if ($id_insert === false) {
		$respuesta['error'] = true;
		$respuesta['message'] = "Error al cargar el registro";
		die(json_encode($respuesta));
	}

	for ($i = 0; $i < count($documento["name"]); $i++) {

		$extension_archivo = strtolower(pathinfo(basename($documento["name"][$i]), PATHINFO_EXTENSION));
		$nombre_archivo =  generarHash(20) . '.' . $extension_archivo;
		$ruta_origen = $documento["tmp_name"][$i];

		$destino = "../../assets/documentos/registros/" . $nombre_archivo;

		if (move_uploaded_file($ruta_origen, $destino)) {
			$insert_imagenes = "INSERT INTO imagenes_registro (id_registro, nombre_imagen) VALUES ('$id_insert', '$nombre_archivo')";
			$respuesta = mysqli_query($conexion, $insert_imagenes) == true ? $errores : $errores++;
		} else {
			$respuesta['error'] = true;
			$respuesta['message'] = "Error al cargar el archivo";
			die(json_encode($respuesta));
		}
	}

	return $errores > 0 ? false : true;
}

function insert_registro($cedula, $nombre, $telefono, $sector, $observacion, $envioSector, $socio, $id_sub_usuario)
{
	global $conexion;

	$sql = "INSERT INTO registros (cedula, nombre, telefono, fecha_registro, sector, observaciones, envioSector, activo, socio, id_sub_usuario)
	VALUES('{$cedula}', '{$nombre}', '{$telefono}', NOW(), '{$sector}', '{$observacion}', '{$envioSector}', 1, {$socio}, '{$id_sub_usuario}')";
	$consulta = mysqli_query($conexion, $sql);

	return $consulta == true ? mysqli_insert_id($conexion) : false;
}

function generarHash($largo)
{
	$caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyz';
	return substr(str_shuffle($caracteres_permitidos), 0, $largo);
}

function controlarExtension($files, $tipo)
{
	$validar_extension = $tipo;
	$valido = 0;
	for ($i = 0; $i < count($files["name"]); $i++) {
		$extension_archivo = strtolower(pathinfo(basename($files["name"][$i]), PATHINFO_EXTENSION));

		if (in_array($extension_archivo, $validar_extension)) {
			$valido++;
		} else {
			$valido = 0;
		}
	}
	return $valido;
}

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
							<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">' . $texto["titulo"] . '</h1>
							<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">' . $texto["cabecera"] . '</p>
							<p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">' . $texto["detalle1"] . '</p>
							<p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">' . $texto["informacion"] . '</p>
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
		</html>';

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
		"fromname" => ucfirst($sector),
	];

	$datos = [
		"email" => $datos_sector_avisar['email'],
		"nombre" => ucfirst($datos_sector_avisar['usuario'])
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
	$mail->addAddress($datos["email"], ucfirst($datos["nombre"]));
	if ($ccs != null) {
		foreach ($ccs as $cc) {
			$mail->addCC($cc["email"], ucfirst($cc["nombre"]));
		}
	}
	$mail->Body = $bodyHtml;

	if ($mail->send()) {
		return true;
	} else {
		return $mail->ErrorInfo;
	}
}
