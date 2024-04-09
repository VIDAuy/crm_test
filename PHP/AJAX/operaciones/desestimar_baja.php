<?php
include_once '../../configuraciones.php';

$cedula = $_REQUEST['cedula'];



$verificar_socio = verificar_socio_padron($cedula);
if (mysqli_num_rows($verificar_socio) <= 0) devolver_error("No se encontrarón registros en padrón con la cédula ingresada");


$comprobar_baja_padron = comprobar_baja_padron($cedula);
if ($comprobar_baja_padron == false) devolver_error("La cédula ingresada no esta de baja");


$datos_padron = obtener_datos_padron($cedula);
if (count($datos_padron) == 0) devolver_error("La cédula ingresada no esta registrada en padrón");
$nombre   = $datos_padron['nombre'];
$telefono = $datos_padron['tel'];
$telefono = buscarCelular($telefono)[0];
if (intval($telefono) == 0 || $telefono == "" || !is_numeric($telefono)) $telefono = 0;


$registrar_crm = dejar_registro_crm($cedula, $nombre, $telefono);
if ($registrar_crm == false) devolver_error("Ocurrieron errores al dejar registro en CRM");


$revertir_baja_padron_socios = revertir_baja_padron_datos_socio($cedula);
if ($revertir_baja_padron_socios == false) devolver_error("Ocurrieron errores al modificar en padrón datos socio");


$revertir_baja_padron_productos = revertir_baja_padron_producto_socio($cedula);
if ($revertir_baja_padron_productos == false) devolver_error("Ocurrieron errores al modificar en padrón producto socio");



$response['error'] = false;
$response['mensaje'] = "Se desestimo la baja con éxito";
echo json_encode($response);



function verificar_socio_padron($cedula)
{
    $conexion = connection(DB_ABMMOD);
    $tabla1 = TABLA_PADRON_DATOS_SOCIO;
    $tabla2 = TABLA_PADRON_PRODUCTO_SOCIO;

    $sql = "SELECT * FROM {$tabla1} pds INNER JOIN {$tabla2} pps ON pds.cedula = pps.cedula WHERE pds.cedula = '$cedula'";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}

function comprobar_baja_padron($cedula)
{
    $conexion = connection(DB_ABMMOD);
    $tabla1 = TABLA_PADRON_DATOS_SOCIO;
    $tabla2 = TABLA_PADRON_PRODUCTO_SOCIO;

    $sql1 = "SELECT * FROM {$tabla1} WHERE cedula = '$cedula' AND abm = 'baja' AND abmactual = 1";
    $sql2 = "SELECT * FROM {$tabla2} WHERE cedula = '$cedula' AND abm = 'baja' AND abmactual = 1";
    $consulta1 = mysqli_query($conexion, $sql1);
    $consulta2 = mysqli_query($conexion, $sql2);

    return mysqli_num_rows($consulta1) <= 0 && mysqli_num_rows($consulta2) <= 0 ? false : true;
}

function revertir_baja_padron_datos_socio($cedula)
{
    $conexion = connection(DB_ABMMOD);
    $tabla = TABLA_PADRON_DATOS_SOCIO;

    $sql = "UPDATE {$tabla} SET abm = '0', abmactual = 0, observaciones = 'Baja Desestimada' WHERE cedula = '$cedula' AND abm = 'baja' AND abmactual = 1";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}

function revertir_baja_padron_producto_socio($cedula)
{
    $conexion = connection(DB_ABMMOD);
    $tabla = TABLA_PADRON_PRODUCTO_SOCIO;

    $sql = "UPDATE {$tabla} SET abm = '0', abmactual = 0 WHERE cedula = '$cedula' AND abm = 'baja' AND abmactual = 1";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}

function obtener_datos_padron($cedula)
{
    $conexion = connection(DB_ABMMOD);
    $tabla = TABLA_PADRON_DATOS_SOCIO;

    $sql = "SELECT * FROM {$tabla} WHERE cedula = '$cedula'";
    $consulta = mysqli_query($conexion, $sql);

    return mysqli_fetch_assoc($consulta);
}

function dejar_registro_crm($cedula, $nombre, $telefono)
{
    $conexion = connection(DB);
    $tabla = TABLA_REGISTROS;

    $sql = "INSERT INTO {$tabla} (cedula, nombre, telefono, fecha_registro, sector, observaciones, socio, baja) VALUES ('$cedula', '$nombre', '$telefono', NOW(), 'Sistema', 'Desestimo Baja', 1, 0)";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
