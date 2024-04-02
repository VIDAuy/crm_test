<?php
include_once '../configuraciones.php';
$id_sub_usuario = $_SESSION['id_sub_usuario'];
$sector = $_REQUEST['sector'];
$cedula = $_REQUEST['cedula'];
$celular = $_REQUEST['celular'];



$datos_padron = obtener_datos_padron($cedula);
if (count($datos_padron) == 0) {
    $response['error'] = true;
    $response['mensaje'] = "La cédula ingresada no esta registrada en padrón";
    die(json_encode($response));
}

$nombre   = $datos_padron['nombre'];
$telefono = $datos_padron['tel'];
$sucursal = $datos_padron['sucursal'];

if ($celular == "") {
    $celulares = buscarCelular($telefono)[0];
    if (intval($celulares) == 0 || $celulares == "" || !is_numeric($celulares)) {
        $response['error'] = true;
        $response['mensaje'] = "No se encontrarón registros de celular en padrón, debe ingresar un celular";
        die(json_encode($response));
    }
} else {
    $celulares = $celular;
}


$datos_productos = obtener_productos_padron($cedula);
if ($datos_productos === true) {
    $response['error'] = true;
    $response['mensaje'] = "La cédula ingresada no tiene productos registrados";
    die(json_encode($response));
}

switch ((int) $sucursal) {
    case 1372:
    case 1373:
    case 1374:
        $empresa = 3;
        return;
        break;
    case 1370:
    case 1371:
        $empresa = 2;
        return;
        break;
    default:
        $empresa = 1;
        break;
}

$datos_empresa = obtener_empresa($empresa);
if (count($datos_padron) == 0) {
    $response['error'] = true;
    $response['mensaje'] = "La cédula ingresada no esta registrada en padrón";
    die(json_encode($response));
}

$empresaNombre = $datos_empresa['empresa'];
$link = $datos_empresa['link'] . '?' . mb_strtolower(substr($datos_empresa['empresa'], 0, 1));

$parametros = generar_parametros($empresa, $datos_productos);
if ($parametros === false) {
    $response['error'] = true;
    $response['mensaje'] = "Ocurrio un error al generar los parámetros";
    die(json_encode($response));
}

$mensaje_con_link = generar_link_terminos_y_condiciones($empresa, $link, $parametros);
if ($mensaje_con_link == "") {
    $response['error'] = true;
    $response['mensaje'] = "Ocurrio un error al generar el link";
    die(json_encode($response));
}

$envio_sms = sendSMS($celulares, $mensaje_con_link);
if ($envio_sms === false) {
    $response['error'] = true;
    $response['mensaje'] = "Ocurrio un error al enviar el sms";
    die(json_encode($response));
}

$dejar_registro_de_envio = registrar_envio($cedula, $nombre, $celulares, $sector, $id_sub_usuario);
if ($dejar_registro_de_envio === false) {
    $response['error'] = true;
    $response['mensaje'] = "Ocurrieron errores al dejar constancia del envío de los términos y condiciones";
    die(json_encode($response));
}


$response['error'] = false;
$response['mensaje'] = "Se enviaron los términos y condiciones de la cédula " . $cedula . " al celular " . $celular . " con éxito";
die(json_encode($response));


function obtener_datos_padron($cedula)
{
    $conexion = connection(DB_ABMMOD);
    $tabla = TABLA_PADRON_DATOS_SOCIO;
    $sql = "SELECT * FROM {$tabla} WHERE cedula = '$cedula'";
    $consulta = mysqli_query($conexion, $sql);
    return mysqli_fetch_assoc($consulta);
}

function obtener_productos_padron($cedula)
{
    $conexion = connection(DB_ABMMOD);
    $tabla = TABLA_PADRON_PRODUCTO_SOCIO;
    $sql = "SELECT * FROM {$tabla} where cedula = '$cedula'";
    $consulta = mysqli_query($conexion, $sql);
    if ($consulta) {
        while ($row = mysqli_fetch_assoc($consulta)) {
            $servicios_socio[] = array(
                'cedula'                 => $row['cedula'],
                'servicio'               => $row['servicio'],
                'hora'                   => $row['hora'],
                'importe'                => $row['importe'],
                'cod_promo'              => $row['cod_promo'],
                'fecha_registro'         => $row['fecha_registro'],
                'numero_contrato'        => $row['numero_contrato'],
                'fecha_afiliacion'       => $row['fecha_afiliacion'],
                'nombre_vendedor'        => $row['nombre_vendedor'],
                'observaciones'          => $row['observaciones'],
                'lugar_venta'            => $row['lugar_venta'],
                'vendedor_independiente' => $row['vendedor_independiente'],
                'activo'                 => $row['activo'],
                'movimiento'             => $row['movimiento'],
                'fecha_inicio_derechos'  => $row['fecha_inicio_derechos'],
                'numero_vendedor'        => $row['numero_vendedor'],
                'keepprice1'             => $row['keepprice1'],
                'promoactivo'            => $row['promoactivo'],
                'tipo_de_cobro'          => $row['tipo_de_cobro'],
                'tipo_iva'               => $row['tipo_iva'],
                'idrelacion'             => $row['idrelacion'],
                'codigo_precio'          => $row['codigo_precio'],
                'aumento'                => $row['aumento'],
                'empresa'                => $row['empresa'],
                'nactual'                => $row['nactual'],
                'servdecod'              => $row['servdecod'],
                'count'                  => $row['count'],
                'version'                => $row['version'],
                'abm'                    => $row['abm'],
                'abmactual'              => $row['abmactual'],
                'usuario'                => $row['usuario'],
                'extra'                  => $row['extra'],
                'nomodifica'             => $row['nomodifica'],
                'precioOriginal'         => $row['precioOriginal'],
                'abitab'                 => $row['abitab'],
                'cedula_titular_gf'      => $row['cedula_titular_gf'],
            );
        }
    } else {
        $servicios_socio = false;
    }
    return $servicios_socio;
}

function obtener_empresa($empresa)
{
    $conexion = connection(DB_TERMINOS_Y_CONDICIONES);
    $tabla = TABLA_EMPRESA;
    $sql = "SELECT empresa, link FROM {$tabla} WHERE id = $empresa";
    $consulta = mysqli_query($conexion, $sql);
    return mysqli_fetch_assoc($consulta);
}

function generar_parametros($empresa, $datos_productos)
{
    $conexion = connection(DB_TERMINOS_Y_CONDICIONES);
    $tabla = VIEW_NEXO;
    $parametros = "";
    $errores = 0;
    foreach ($datos_productos as $array) {
        $id_servicio = $array['servicio'];
        $sql = "SELECT identificador FROM {$tabla} WHERE id_empresa = '$empresa' AND id_servicio = '$id_servicio'";
        $consulta = mysqli_query($conexion, $sql);
        if ($consulta) {
            while ($row = mysqli_fetch_assoc($consulta)) {
                $identificador = $row['identificador'];
                if ($identificador != "") {
                    $parametros .= "&" . $identificador;
                }
            }
        } else {
            $errores++;
        }
    }
    return $errores == 0 ? $parametros : false;
}

function generar_link_terminos_y_condiciones($empresa, $link, $parametros)
{
    if ($empresa != 3 && $empresa != 2) {
        $link  = "Puede ver los terminos y condiciones de su contrato en $link" . $parametros;
    }
    return $link;
}

function sendSMS($celular, $mensaje)
{
    $servicio = "http://192.168.104.6/apiws/1/apiws.php?wsdl";
    $parametros = array();
    $a = $parametros['authorizedKey'] = "9d752cb08ef466fc480fba981cfa44a1";
    $b = $parametros['msgId'] = "0";
    $c = $parametros['msgData'] = (string) $mensaje;
    $d = $parametros['msgRecip'] = (string)$celular;
    $client = new SoapClient($servicio, $parametros);
    return $client->sendSms($a, $b, $c, $d);
}

function buscarCelular($numeros)
{
    preg_match_all('/(09)[1-9]{1}\d{6}/x', $numeros, $respuesta);
    $respuesta = (count($respuesta[0]) !== 0) ? $respuesta[0] : false;
    return $respuesta;
}

function registrar_envio($cedula, $nombre, $celular, $sector, $id_sub_usuario)
{
    $conexion = connection(DB);
    $tabla = TABLA_REGISTROS;
    $observacion = "Constancia de envio de los terminos y condiciones al celular $celular";
    $socio = es_socio($cedula);
    $baja = esta_en_baja($cedula);

    $sql = "INSERT INTO {$tabla} (cedula, nombre, telefono, fecha_registro, sector, observaciones, envioSector, activo, socio, baja, id_sub_usuario) VALUES ('$cedula', '$nombre', '$celular', NOW(), '$sector', '$observacion', '', 1, $socio, $baja, $id_sub_usuario)";
    return mysqli_query($conexion, $sql);
}
