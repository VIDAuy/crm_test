<?php
include_once '../configuraciones.php';

$cedula         = $_REQUEST['cedula'];
$patologia      = $_REQUEST['patologia'];
$observacion    = $_REQUEST['observacion'];
$id_sub_usuario = $_REQUEST['id_sub_usuario'];
$sector         = $_REQUEST['sector'];
$nombre_socio   = $_REQUEST['nombre_socio'];
$telefono_socio = $_REQUEST['telefono_socio'];
$socio = verificar_socio_y_baja($cedula)['socio'] == null ? 1 : verificar_socio_y_baja($cedula)['socio'];
$baja = verificar_socio_y_baja($cedula)['baja'] == null ? 0 : verificar_socio_y_baja($cedula)['socio'];
$nombre_patologia = nombre_patologia($patologia);
$observacion_registro = "Patologia: $nombre_patologia - Observacion: $observacion";


if ($cedula == "" || $patologia == "" || $observacion == "") {
    $response['error'] = true;
    $response['mensaje'] = ERROR_GENERAL;
    die(json_encode($response));
}



$insert_patologia = registrar_patologia($cedula, $patologia, $observacion);

if ($insert_patologia === false) {
    $response['error'] = true;
    $response['mensaje'] = ERROR_AL_REGISTRAR;
    die(json_encode($response));
}


$insert_registro = insert_registro($cedula, $nombre_socio, $telefono_socio, $sector, $observacion_registro, $socio, $baja, $id_sub_usuario);

if ($insert_registro === false) {
    $response['error'] = true;
    $response['mensaje'] = ERROR_AL_REGISTRAR;
    die(json_encode($response));
}



$response['error'] = false;
$response['mensaje'] = EXITO_AL_REGISTRAR;


echo json_encode($response);




function registrar_patologia($cedula, $patologia, $observacion)
{
    $conexion = connection(DB_ABMMOD);
    $tabla = TABLA_PATOLOGIAS_SOCIO;

    $sql = "INSERT INTO {$tabla} (documento_socio, id_patologia, observacion, fecha) VALUES ('$cedula', '$patologia', '$observacion', NOW())";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}

function insert_registro($cedula, $nombre, $telefono, $sector, $observacion, $socio, $baja, $id_sub_usuario)
{
    include '../conexiones/conexion2.php';

    $sql = "INSERT INTO registros (cedula, nombre, telefono, fecha_registro, sector, observaciones, activo, socio, baja, id_sub_usuario)
	VALUES('{$cedula}', '{$nombre}', '{$telefono}', NOW(), '{$sector}', '{$observacion}', 1, {$socio}, {$baja}, '{$id_sub_usuario}')";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}

function verificar_socio_y_baja($cedula)
{
    $conexion = connection(DB);
    $tabla = TABLA_REGISTROS;

    $sql = "SELECT socio, baja FROM {$tabla} WHERE cedula = '$cedula' ORDER BY id DESC LIMIT 1";
    $consulta = mysqli_query($conexion, $sql);

    return mysqli_fetch_assoc($consulta);
}

function nombre_patologia($id)
{
    include_once '../conexiones/conexion3.php';
    $tabla = TABLA_PATOLOGIAS;

    $sql = "SELECT patologia AS 'nombre' FROM {$tabla} WHERE id_patologia = '$id' ORDER BY nombre ASC";
    $consulta = mysqli_query($conexion, $sql);
    $resultado = mysqli_fetch_assoc($consulta)['nombre'];

    return $resultado;
}
