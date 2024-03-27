<?php

include '../configuraciones.php';

$id = $_REQUEST['id'];
$estado_consulta = "";
$contador = 1;


$listado_respuestas = obtener_respuestas($id);


while ($row = mysqli_fetch_assoc($listado_respuestas)) {

    $id                    = $row['id'];
    $id_consulta_transarea = $row['id_consulta_transarea'];
    $mensajes              = $row['mensaje'];
    $fecha_respuesta       = $row['fecha_registro'];
    $id_sub_usuario        = $row['id_sub_usuario'];
    $datos_consulta        = obtener_datos_consulta($id_consulta_transarea);
    $area_consulta         = ucfirst(obtener_datos_usuario($datos_consulta['area_consulta'])['usuario']);
    $area_consultada       = ucfirst(obtener_datos_usuario($datos_consulta['area_consultada'])['usuario']);
    $estado                = $datos_consulta['estado'];

    $estado_consulta = $estado == 1 ? "En Proceso" : "Terminado";

    if ($contador == 1) $area_consultada = $area_consulta;

    $color_icono = randomColor();


    $html = "
    <div class='d-flex text-body-secondary pt-3'>
        <svg class='bd-placeholder-img flex-shrink-0 me-2 rounded' width='32' height='32' xmlns='http://www.w3.org/2000/svg' role='img' aria-label='Placeholder: 32x32' preserveAspectRatio='xMidYMid slice' focusable='false'>
            <title>Placeholder</title>
            <rect width='100%' height='100%' fill='" . $color_icono . "'></rect>
            <text x='50%' y='50%' fill='" . $color_icono . "' dy='.3em'>32x32</text>
        </svg>
        <p class='pb-3 mb-0 small lh-sm border-bottom'>
            <strong class='d-block text-gray-dark'>" . $area_consultada . "</strong>
            " . $mensajes . "
            <small class='d-block mt-3'>
                <a href='#'>" . $fecha_respuesta . "</a>
            </small>
        </p>
    </div>";

    $response["datos"][] = [
        $html
    ];


    $contador++;
}


$response['error'] = false;
$response['estado_consulta'] = $estado_consulta;

echo json_encode($response);



function obtener_respuestas($id)
{
    $conexion = connection(DB);
    $tabla = TABLA_MENSAJES_CONSULTA_TRANSAREA;

    try {
        $sql = "SELECT * FROM {$tabla} WHERE id_consulta_transarea = '$id' AND activo = 1 ORDER BY id ASC";
        $consulta = mysqli_query($conexion, $sql);
        return $consulta;
    } catch (\Throwable $error) {
        registrar_errores($sql, "registros_chat.php", $error);
        return false;
    }
}

function obtener_datos_consulta($id_consulta_transarea)
{
    $conexion = connection(DB);
    $tabla = TABLA_CONSULTA_TRANSAREA;

    try {
        $sql = "SELECT * FROM {$tabla} WHERE id = '$id_consulta_transarea' AND activo = 1";
        $consulta = mysqli_query($conexion, $sql);
        $resultado = mysqli_fetch_assoc($consulta);
        return $resultado;
    } catch (\Throwable $error) {
        registrar_errores($sql, "registros_chat.php", $error);
        return false;
    }
}
