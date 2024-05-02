<?php
include_once '../configuraciones.php';


$opcion = $_REQUEST['opcion'];
if (isset($_REQUEST['cedula'])) $cedula = $_REQUEST['cedula'];
if (isset($_REQUEST['etiqueta'])) $mensaje = $_REQUEST['etiqueta'];
$id_sub_usuario = isset($_SESSION['id_sub_usuario']) ? $_SESSION['id_sub_usuario'] : "";
$id_area = $_SESSION['id'];



/** Tabla Etiquetas **/
if ($opcion == 1) {
    $tabla["data"] = [];

    $obtener_etiquetas = obtener_etiquetas($cedula);

    while ($row = mysqli_fetch_assoc($obtener_etiquetas)) {

        $id             = $row['id'];
        $etiqueta       = $row['mensaje'];
        $usuario_agrego = $row['id_sub_usuario'] != "" || $row['id_sub_usuario'] != null ? obtener_usuario($row['id_sub_usuario']) : "-";
        $area_agrego    = $row['id_area'] != "" || $row['id_area'] != null ? ucfirst(obtener_datos_usuario($row['id_area'])['usuario']) : "-";
        $fecha_registro = date("d/m/Y H:i:s", strtotime($row['fecha_registro']));

        $tabla["data"][] = [
            "id"             => $id,
            "etiqueta"       => $etiqueta,
            "area_agrego"    => $area_agrego,
            "usuario_agrego" => $usuario_agrego,
            "fecha_registro" => $fecha_registro,
        ];
    }

    echo json_encode($tabla);
}

/** Cantidad Etiquetas **/
if ($opcion == 2) {
    $cantidad_etiquetas = obtener_cantidad_etiquetas($cedula);

    $response['error'] = false;
    $response['cantidad'] = $cantidad_etiquetas;
    echo json_encode($response);
}

/** Registrar Nueva Etiqueta **/
if ($opcion == 3) {

    if ($cedula == "" || $mensaje == "" || $id_area == "") {
        $response['error'] = true;
        $response['mensaje'] = ERROR_GENERAL;
        die(json_encode($response));
    }

    $insert_etiqueta = registrar_nueva_etiqueta($cedula, $mensaje, $id_area, $id_sub_usuario);

    if ($insert_etiqueta === false) {
        $response['error'] = true;
        $response['mensaje'] = "Ocurrieron errores al registrar la etiqueta";
        die(json_encode($response));
    }

    $response['error'] = false;
    $response['mensaje'] = "Se ha registrado la etiqueta con éxito";

    echo json_encode($response);
}





function obtener_etiquetas($cedula)
{
    $conexion = connection(DB);
    $tabla = TABLA_ETIQUETA_SOCIO;

    $sql = "SELECT * FROM {$tabla} WHERE cedula = '$cedula' AND activo = 1";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}

function obtener_cantidad_etiquetas($cedula)
{
    $conexion = connection(DB);
    $tabla = TABLA_ETIQUETA_SOCIO;

    $sql = "SELECT COUNT(id) AS 'cantidad' FROM {$tabla} WHERE cedula = '$cedula' AND activo = 1";
    $consulta = mysqli_query($conexion, $sql);

    if ($consulta === false) {
        $response['error'] = true;
        $response['mensaje'] = "Ocurrio un error al obtener la cantidad de etiquetas del socio";
        die(json_encode($response));
    }

    return mysqli_fetch_assoc($consulta)['cantidad'];
}

function registrar_nueva_etiqueta($cedula, $mensaje, $id_area, $id_sub_usuario)
{
    $conexion = connection(DB);
    $tabla = TABLA_ETIQUETA_SOCIO;

    $sql = "INSERT INTO {$tabla} (cedula, mensaje, id_area, id_sub_usuario, fecha_registro) VALUES ('$cedula', '$mensaje', '$id_area', '$id_sub_usuario', NOW())";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}

function obtener_usuario($id)
{
    $conexion = connection(DB);
    $tabla = TABLA_SUB_USUARIOS;

    $sql = "SELECT nombre, apellido FROM {$tabla} WHERE id = '$id'";
    $consulta = mysqli_query($conexion, $sql);

    $respuesta = "";
    if ($consulta == true) {
        $resultado = mysqli_fetch_assoc($consulta);
        $nombre = $resultado['nombre'];
        $apellido = $resultado['apellido'];

        $respuesta = $nombre . " " . $apellido;
    }

    return $respuesta;
}
