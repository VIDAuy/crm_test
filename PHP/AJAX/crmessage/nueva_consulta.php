<?php
include_once '../../configuraciones.php';

$area_consulta = $_SESSION['id'];
$area_consultada = $_REQUEST['area_consultada'];
$cedula_socio = $_REQUEST['cedula_socio'];
$consulta = $_REQUEST['consulta'];
$id_sub_usuario = isset($_SESSION['id_sub_usuario']) ? $_SESSION['id_sub_usuario'] : "";
$id_usuario_consultado = $_REQUEST['id_usuario_consultado'];


if (
    $area_consulta == "" ||
    $area_consultada == "" ||
    $consulta == "" ||
    (!in_array($id_usuario_consultado, ["", "null"]) && !is_numeric($id_usuario_consultado))
) devolver_error(ERROR_GENERAL);



if (count($_FILES) > 0) {
    $imagen = $_FILES['imagen'];
    if (controlarExtension($imagen, ["jpg", "jpeg", "png", "pdf"]) <= 0) devolver_error("Los archivos cargados solo pueden ser de tipo .jpg, .jpeg, .png, .pdf");

    $id_consulta = registrar_consulta($area_consulta, $id_sub_usuario, $area_consultada, $cedula_socio, $id_usuario_consultado);
    if ($id_consulta === false) devolver_error("Ocurrieron errores al registrar la consulta");

    $archivo_registrado = registrar_imagen_consulta($id_consulta, $imagen);
    if ($archivo_registrado === false) devolver_error("Error al cargar el registro");
} else {

    $id_consulta = registrar_consulta($area_consulta, $id_sub_usuario, $area_consultada, $cedula_socio, $id_usuario_consultado);
    if ($id_consulta === false) devolver_error("Ocurrieron errores al registrar la consulta");
}


$insert_mensaje = registrar_mensaje($id_consulta, $consulta, $id_sub_usuario);
if ($insert_mensaje === false) devolver_error("Ocurrieron errores al registrar el mensaje");


if ($cedula_socio != "") {
    $registrar_crm = registrar_crm($cedula_socio, $area_consultada, $consulta, $id_sub_usuario);
    if ($registrar_crm === false) devolver_error("Ocurrieron errores al registrar en crm");
}


$response['error'] = false;
$response['mensaje'] = "Se registro la consulta con éxito";

echo json_encode($response);




function registrar_consulta($area_consulta, $id_sub_usuario, $area_consultada, $cedula_socio, $id_usuario_consultado)
{
    $conexion = connection(DB);
    $tabla = TABLA_CONSULTA_TRANSAREA;
    $id_sub_usuario = $id_sub_usuario != "" ? $id_sub_usuario : "";
    $id_usuario_consultado = is_numeric($id_usuario_consultado) ? $id_usuario_consultado : "";

    try {
        $sql = "INSERT INTO {$tabla} (area_consulta, area_consultada, usuario_consulto, usuario_consultado, cedula_socio, fecha_consulta) VALUES ('$area_consulta', '$area_consultada', '$id_sub_usuario', '$id_usuario_consultado', '$cedula_socio', NOW())";
        $consulta = mysqli_query($conexion, $sql);
        $id_insert = mysqli_insert_id($conexion);
        return $consulta != false ? $id_insert : false;
    } catch (\Throwable $error) {
        registrar_errores($sql, "nueva_consulta.php", $error);
        return false;
    }
}

function registrar_imagen_consulta($id_registro, $imagen)
{
    $conexion = connection(DB);
    $tabla = TABLA_ARCHIVOS_CRMESSAGE;

    $errores = 0;
    for ($i = 0; $i < count($imagen["name"]); $i++) {

        $extension_archivo = strtolower(pathinfo(basename($imagen["name"][$i]), PATHINFO_EXTENSION));
        $nombre_archivo =  generarHash(50) . '.' . $extension_archivo;
        $ruta_origen = $imagen["tmp_name"][$i];

        $destino = "../../../assets/documentos/archivos_crmessage/" . $nombre_archivo;

        if (move_uploaded_file($ruta_origen, $destino)) {
            try {
                $sql = "INSERT INTO {$tabla} (id_consulta, nombre_archivo) VALUES ('$id_registro', '$nombre_archivo')";
                $consulta = mysqli_query($conexion, $sql);
            } catch (\Throwable $error) {
                registrar_errores($sql, "nueva_consulta.php", $error);
                $errores++;
            }
        }
    }

    return $errores > 0 ? false : true;
}


function registrar_mensaje($id_consulta, $mensaje, $id_sub_usuario)
{
    $conexion = connection(DB);
    $tabla = TABLA_MENSAJES_CONSULTA_TRANSAREA;

    try {
        $sql = "INSERT INTO {$tabla} (id_consulta_transarea, mensaje, fecha_registro, id_sub_usuario, visto_consultor, visto_consultado) VALUES ('$id_consulta', '$mensaje', NOW(), '$id_sub_usuario', 1, 0)";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "nueva_consulta.php", $error);
    }

    return $consulta;
}

function registrar_crm($cedula_socio, $area_consultada, $consulta, $id_sub_usuario)
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
        $sql = "INSERT INTO {$tabla} (cedula, nombre, telefono, fecha_registro, sector, observaciones, envioSector, activo, socio, baja, id_sub_usuario) VALUES ('$cedula_socio', '$nombre', '$telefono', NOW(), '$sector', '$consulta', '$area_consultada', 0, '$socio', '$baja', '$id_sub_usuario')";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "nueva_consulta.php", $error);
    }

    return $consulta;
}
