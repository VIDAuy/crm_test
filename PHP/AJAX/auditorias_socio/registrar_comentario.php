<?php
include_once '../../configuraciones.php';

$id_auditoria_socio = $_REQUEST['id'];
$comentario         = $_REQUEST['comentario'];
$id_area            = $_SESSION['id'];
$id_sub_usuario     = isset($_SESSION['id_sub_usuario']) ? $_SESSION['id_sub_usuario'] : "";
$avisar_a           = $_REQUEST['avisar_a'];


if ($id_auditoria_socio == "" || $comentario == "" || $id_area == "") devolver_error(ERROR_GENERAL);


if (count($_FILES) > 0) {
    $imagen = $_FILES['imagen'];
    if (controlarExtension($imagen, array("mp3", "pdf")) <= 0) devolver_error("Los archivos cargados solo pueden ser de tipo .mp3");

    $id_registro = registrar_comentario($id_auditoria_socio, $comentario, $id_area, $id_sub_usuario);
    if ($id_registro === false) devolver_error("Ocurrieron errores al registrar el comentario");

    $archivo_registrado = registrar_imagen_comentario($id_registro, $imagen);
    if ($archivo_registrado === false) devolver_error("Error al cargar el registro");
} else {

    $id_registro = registrar_comentario($id_auditoria_socio, $comentario, $id_area, $id_sub_usuario);
    if ($id_registro === false) devolver_error("Ocurrieron errores al registrar el comentario");
}


if ($avisar_a != "") {
    $registrar_alerta = registrar_alerta($id_auditoria_socio, $id_area, $id_sub_usuario, $avisar_a, 2, $id_registro);
    if ($registrar_alerta === false) devolver_error("Ocurrieron errores al registrar la alerta");
}



$response['error'] = false;
$response['mensaje'] = EXITO_AL_REGISTRAR;
echo json_encode($response);




function registrar_comentario($id_auditoria_socio, $comentario, $id_area, $id_sub_usuario)
{
    $conexion = connection(DB);
    $tabla = TABLA_COMENTARIO_AUDITORIAS_SOCIO;

    $comentario = str_replace("'", '"', $comentario);

    $sql = "INSERT INTO {$tabla} (id_auditoria_socio, comentario, area_registro, usuario_registro, fecha_registro) VALUES ('$id_auditoria_socio', '$comentario', '$id_area', '$id_sub_usuario', NOW())";
    $consulta = mysqli_query($conexion, $sql);
    $id_insert = $consulta != false ? mysqli_insert_id($conexion) : false;

    return $id_insert;
}

function registrar_imagen_comentario($id_registro, $imagen)
{
    $conexion = connection(DB);
    $tabla = TABLA_ARCHIVOS_AUDITORIAS;

    $errores = 0;
    for ($i = 0; $i < count($imagen["name"]); $i++) {

        $extension_archivo = strtolower(pathinfo(basename($imagen["name"][$i]), PATHINFO_EXTENSION));
        $nombre_archivo =  generarHash(50) . '.' . $extension_archivo;
        $ruta_origen = $imagen["tmp_name"][$i];

        $destino = "../../../assets/documentos/archivos_auditorias/" . $nombre_archivo;

        if (move_uploaded_file($ruta_origen, $destino)) {
            try {
                $sql = "INSERT INTO {$tabla} (id_comentario_auditoria, nombre_archivo) VALUES ('$id_registro', '$nombre_archivo')";
                $consulta = mysqli_query($conexion, $sql);
            } catch (\Throwable $error) {
                registrar_errores($sql, "registrar_comentario.php", $error);
                $errores++;
            }
        }
    }

    return $errores > 0 ? false : true;
}
