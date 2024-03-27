<?php
include '../conexiones/conexion2.php';

const PRODUCCION = false; // para definir si es test o produccion la APP
const URL_DOCUMENTOS = PRODUCCION ? 'http://192.168.1.250:82/crm/assets/documentos/registros' : 'http://192.168.1.250:82/crm_test/assets/documentos/registros';



if (isset($_GET['ID'])) {
	$id = $_GET['ID'];

	$q = "SELECT id, cedula, nombre, telefono, fecha_registro, sector, observaciones, socio, baja FROM registros WHERE id = $id";
	$r = mysqli_query($conexion, $q);
	$f = mysqli_fetch_assoc($r);

	//MODIFICAR LOS RESULTADOS PARA MEJOR LECTURA

	$f['fecha_registro'] = new DateTime($f['fecha_registro']);
	$f['fecha_registro'] = $f['fecha_registro']->format('Y/m/d H:i:s');
	$f['telefono'] 	= corregirTelefono($f['telefono']);
	$f['socio'] = ($f['socio'] == 1) ? 'Sí' : 'No';
	$f['baja'] = ($f['baja'] == 1) ? 'Sí' : 'No';

	$f['observaciones'] = $f['observaciones'];
} else {
	if (!isset($_SESSION)) session_start();

	$cedula = $_GET['CI'];
	$usuario = $_SESSION['usuario'];
	$sector = $_SESSION['nivel'] != 3  ? "AND sector='$usuario'"  : '';
	$q = "SELECT id, fecha_registro, sector, observaciones, socio, baja, envioSector, id_sub_usuario FROM registros WHERE cedula = $cedula $sector";
	$r = mysqli_query($conexion, $q);
	if (mysqli_num_rows($r) != 0) {
		while ($row = mysqli_fetch_assoc($r)) {

			//MODIFICAR LOS RESULTADOS PARA MEJOR LECTURA

			$row['fecha_registro'] = new DateTime($row['fecha_registro']);
			$row['fecha_registro'] = $row['fecha_registro']->format('Y/m/d H:i:s');
			$row['socio'] = ($row['socio'] == 1) ? 'Sí' : 'No';
			$row['baja'] = ($row['baja'] == 1) ? 'Sí' : 'No';
			if (strlen($row['observaciones']) > 29) $row['observaciones'] = mb_substr($row['observaciones'], 0, 40) . ' ' . '(...)';


			$id = $row['id'];
			$socio = $row['socio'];
			$socio = $socio == 'SI' ? "<span>$socio</span>" : "<span class='text-danger'>$socio</span>";
			$baja = $row['baja'];
			$baja = $baja == 'SI' ? "<span class='text-danger'>$baja</span>" : "<span>$baja</span>";

			$imagenes = obtener_imagenes($id);
			$imagen = count($imagenes) > 0 ? "<button class='btn btn-sm btn-info' onclick='modal_ver_imagen_registro(`" . URL_DOCUMENTOS . "`, `" . $id . "`);'>Ver Archivos</button>" : "";

			$id_avisar_a = $row['envioSector'];

			$avisar_a = $id_avisar_a != "" ? obtener_area_avisada($id_avisar_a) : "";
			$observaciones = $row['observaciones'];
			$id_sub_usuario = $row['id_sub_usuario'];
			$sector = $row['sector'];

			if ($sector == "Audit1" || $sector == "Audit2" || $sector == "Audit3") {
				$usuario = ($sector == "Audit1") ? "Nathalia Horvat" : (($sector == "Audit2") ? "Andrea Horvat" : (($sector == "Audit3") ? "Tatiana Landa" : ""));
			} else {
				$nombre_sub_usuario = $id_sub_usuario != "" ? @utf8_encode(obtener_nombre_sub_usuario($id_sub_usuario)) : "";
				$usuario = $nombre_sub_usuario == "" || $id_sub_usuario == "" ? "-" : $nombre_sub_usuario;
			}

			$f[] = array(
				'id'			=> $row['id'],
				'fecha' 		=> date("d/m/Y H:i:s", strtotime($row['fecha_registro'])),
				'sector' 		=> $row['sector'],
				'usuario'       => $usuario,
				'observacion'	=> $observaciones,
				'avisar_a'	    => ucfirst($avisar_a),
				'socio' 		=> $socio,
				'baja' 			=> $baja,
				'imagen' 	    => $imagen,
				'mas_info'      => "<button class='btn btn-sm btn-primary' onclick='modalHistoriaComunicacionDeCedula(`" . $id . "`);'>Más Info</button>",
			);
		}
	} else $f = ['noRegistros' => true];
}



echo json_encode($f);






function corregirTelefono($var)
{
	if ($var == 0) return '';
	// CORRECCIÓN Y ASIGNACIÓN DE TELÉFONO

	//EN CASO DE QUE EL TELÉFONO EMPIECE CON '0' Y UN ESPACIO LOS QUITA DE LA VARIABLE
	if (mb_substr($var, 0, 2) == '0 ') $var = mb_substr($var, 2, 20);

	//REEMPLAZA TODOS LOS ESPACIOS QUE TENGA LA VARIABLE
	$var = str_replace(' ', '', $var);

	if ($var[0] == 9) $var = 0 . $var;

	//EN CASO DE QUE EL NÚMERO EMPIECE CON 09 Y TENGA MÁS DE 8 CARACTÉRES SE LE ASIGNA ESE VALOR A LA VARIABLE CELULAR
	if (mb_substr($var, 0, 2) == '09' && strlen($var) > 8) {
		if (strlen($var) == 10) {
			$celularFuncion = mb_substr($var, 0, 10);
		} else {
			$celularFuncion = mb_substr($var, 0, 9);
		}
	}

	///EN CASO DE QUE EL NÚMERO EMPIECE CON 2 O 4 Y TENGA MÁS DE 7 CARACTÉRES SE LE ASIGNA ESE VALOR A LA VARIABLE TELEFONO
	if (($var[0] == 2 || $var[0] == 4) && strlen($var) > 7) $telefonoFuncion = mb_substr($var, 0, 8);

	//SI EL LARGO DE LA VARIABLE ES IGUAL A 17 (LA SUMA DE LOS 9 CARACTERES DE UN TELÉFONO MÁS LOS 8 DE UN CELULAR) DIVIDE EL STRING
	if (strlen($var) == 17) {
		//EN CASO DE QUE CONTENGA LA SINTÁXIS DE TELÉFONO SE LE ASIGNA LA mb_substrING A LA VARIABLE TELEFONO
		if (isset($var[9]) && ($var[9] == 2 || $var[9] == 4) && mb_substr($var, 7, 10) != '09') $telefonoFuncion = mb_substr($var, 10, 18);
		//EN CASO DE QUE CONTENGA LA SINTÁXIS DE CELULAR SE LE ASIGNA LA mb_substrING A LA VARIABLE CELULAR
		if (isset($var[8]) && mb_substr($var, 8, 2) == '09') $celularFuncion = mb_substr($var, 8, 18);
	}

	//EN CASO DE QUE LA VARIABLE CELULAR NO SE HAYA DEFINIDO LE ASIGNA UN STRING VACÍO PARA NO GENERAR CONFLICTOS EN LA QUERY

	if (!isset($celularFuncion)) $celularFuncion = null;
	if (!isset($telefonoFuncion)) $telefonoFuncion = null;

	if ($telefonoFuncion != null && $celularFuncion != null) {
		$telFuncion = $telefonoFuncion;
		$telFuncion .= ' ';
		$telFuncion .= $celularFuncion;
	} else if ($telefonoFuncion != null && $celularFuncion == '') $telFuncion = $telefonoFuncion;
	else if ($telefonoFuncion == '' && $celularFuncion != null) $telFuncion = $celularFuncion;
	else $telFuncion = '';

	return $telFuncion;
}

function obtener_area_avisada($id)
{
	global $conexion;

	$sql = "SELECT usuario FROM usuarios WHERE id = '$id'";
	$consulta = mysqli_query($conexion, $sql);

	return mysqli_num_rows($consulta) > 0 ? mysqli_fetch_assoc($consulta)['usuario'] : "";
}

function obtener_imagenes($id)
{
	global $conexion;

	$sql = "SELECT nombre_imagen FROM imagenes_registro WHERE id_registro = '$id' AND activo = 1";
	$consulta = mysqli_query($conexion, $sql);

	$imagenes = [];
	while ($row = mysqli_fetch_assoc($consulta)) {
		array_push($imagenes, $row['nombre_imagen']);
	}

	return $imagenes;
}

function obtener_nombre_sub_usuario($id_sub_usuario)
{
	global $conexion;

	$sql = "SELECT nombre, apellido FROM sub_usuarios WHERE id = '$id_sub_usuario'";
	$consulta = mysqli_query($conexion, $sql);
	$resultado = mysqli_fetch_assoc($consulta);

	return $resultado['nombre'] . " " . $resultado['apellido'];
}

function remplazarAcentos($texto)
{

	//  $texto_parseado = eliminarAcentos($texto);
	$texto_parseado = $texto;

	$remplazar_array = array(
		"'" => '', '"' => ' ', '`' => ' ', '`' => '',
		'Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A',
		'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',  'Ò' => 'O', 'Ó' => 'O',
		'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
		'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e',
		'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o',  'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
		'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', 'Ñ' => 'N', 'ñ' => 'n', '°' => ' ', 'Â' => ' ',
		'â' => 'a', '™' => ' ', '€' => '', 'Âº' => '', '/' => '/'
	);

	$texto_parseado = strtr($texto_parseado, $remplazar_array);
	$texto_parseado = preg_replace('([^A-Za-z0-9 ])', '', $texto_parseado);
	return $texto_parseado;
}

function eliminarAcentos($cadena)
{
	$especial = @utf8_decode('ÁÀÂÄáàäâªÉÈÊËéèëêÍÌÏÎíìïîÓÒÖÔóòöôÚÙÛÜúùüûÑñÇç³€™º');
	$reemplazar = @utf8_decode('AAAAaaaaaEEEEeeeeIIIIiiiiOOOOooooUUUUuuuuNnCcA    ');
	for ($i = 0; $i <= strlen($cadena); $i++) {
		for ($f = 0; $f < strlen($especial); $f++) {
			$caracteri = substr($cadena, $i, 1);
			$caracterf = substr($especial, $f, 1);
			if ($caracteri === $caracterf) {
				$cadena = substr($cadena, 0, $i) . substr($reemplazar, $f, 1) . substr($cadena, $i + 1);
			}
		}
	}
	return  $cadena;
}
