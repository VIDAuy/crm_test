<?php
include_once '../../configuraciones.php';

$id_consulta = $_REQUEST['id_consulta'];
$respuesta = $_REQUEST['respuesta'];
$id_sub_usuario = isset($_SESSION['id_sub_usuario']) ? $_SESSION['id_sub_usuario'] : "";


$insert_respuesta = registrar_respuesta($id_consulta, $respuesta, $id_sub_usuario);
if ($insert_respuesta === false) devolver_error("Ocurriron errores al registrar la respuesta");


$update_estado = modificar_estado_consulta($id_consulta);
if ($insert_respuesta === false) devolver_error("Ocurriron errores al modificar el estado de la consulta");


$detectar_cedula = detectar_cedula_en_consulta($id_consulta);
if ($detectar_cedula === false) devolver_error("Ocurrieron errores al detectar cédula en consulta");

if (mysqli_num_rows($detectar_cedula) > 0) {
    $datos_consulta = mysqli_fetch_assoc($detectar_cedula);
    $cedula_socio = $datos_consulta['cedula_socio'];
    $area_consulta = $datos_consulta['area_consulta'];
    $registrar_crm = registrar_crm($cedula_socio, $area_consulta, $respuesta, $id_sub_usuario);
    if ($registrar_crm === false) devolver_error("Ocurrieron errores al registrar en crm");
}



$response['error'] = false;
$response['mensaje'] = "Se registro la respuesta con éxito";
echo json_encode($response);




function registrar_respuesta($id_consulta, $mensaje, $id_sub_usuario)
{
    $conexion = connection(DB);
    $tabla = TABLA_MENSAJES_CONSULTA_TRANSAREA;

    try {
        $sql = "INSERT INTO {$tabla} (id_consulta_transarea, mensaje, fecha_registro, id_sub_usuario, visto_consultor, visto_consultado) VALUES ('$id_consulta', '$mensaje', NOW(), '$id_sub_usuario', 0, 1)";
        $consulta = mysqli_query($conexion, $sql);
        return $consulta;
    } catch (\Throwable $error) {
        registrar_errores($sql, "responder_consulta.php", $error);
        return false;
    }
}

function modificar_estado_consulta($id_consulta)
{
    $conexion = connection(DB);
    $tabla = TABLA_CONSULTA_TRANSAREA;

    try {
        $sql = "UPDATE {$tabla} SET estado = 2 WHERE id = '$id_consulta'";
        $consulta = mysqli_query($conexion, $sql);
        return $consulta;
    } catch (\Throwable $error) {
        registrar_errores($sql, "responder_consulta.php", $error);
        return false;
    }
}

function detectar_cedula_en_consulta($id_consulta)
{
    $conexion = connection(DB);
    $tabla = TABLA_CONSULTA_TRANSAREA;

    try {
        $sql = "SELECT * FROM {$tabla} WHERE id = '$id_consulta' AND cedula_socio != ''";
        $consulta = mysqli_query($conexion, $sql);
        return $consulta;
    } catch (\Throwable $error) {
        registrar_errores($sql, "responder_consulta.php", $error);
        return false;
    }
}

function registrar_crm($cedula_socio, $area_consulta, $respuesta, $id_sub_usuario)
{
    include_once '../../conexiones/conexion2.php';
    $tabla = TABLA_REGISTROS;
    $sector = $_SESSION['usuario'];
    $socio = es_socio($cedula_socio);
    $baja = esta_en_baja($cedula_socio);
    $datos_padron = obtener_datos_padron_del_socio($cedula_socio);
    $nombre = $datos_padron['nombre'];
    $telefono = $datos_padron['tel'];

    try {
        $sql = "INSERT INTO {$tabla} (cedula, nombre, telefono, fecha_registro, sector, observaciones, envioSector, activo, socio, baja, id_sub_usuario) VALUES ('$cedula_socio', '$nombre', '$telefono', NOW(), '$sector', '$respuesta', '$area_consulta', 0, '$socio', '$baja', '$id_sub_usuario')";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "nueva_consulta.php", $error);
    }

    return $consulta;
}
