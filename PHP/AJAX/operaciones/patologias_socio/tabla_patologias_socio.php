<?php
include_once '../../../configuraciones.php';

$tabla["data"] = [];

$fecha_desde = $_REQUEST['fecha_desde'];
$fecha_hasta = $_REQUEST['fecha_hasta'];
$cedula = $_REQUEST['cedula'];
$fecha_hasta = date("Y-m-d", strtotime($fecha_hasta . " + 1 days"));


$lista_registros = obtener_patologias_socio($fecha_desde, $fecha_hasta, $cedula);

while ($row = mysqli_fetch_assoc($lista_registros)) {
    $id = $row['id'];
    $cedula = $row['documento_socio'];
    $id_patologia = $row['id_patologia'];
    $patologia = nombre_patologia($id_patologia);
    $observacion = $row['observacion'];
    $fecha_registro = date("d/m/Y H:i:s", strtotime($row['fecha']));
    $acciones = "<button class='btn btn-sm btn-danger' onclick='eliminar_patologia_socio(`" . $id . "`);'>❌</button>";


    if (strlen($observacion) > 75) {
        $br  = array("<br />", "<br>", "<br/>");
        $observacion = str_ireplace($br, "\r\n", $observacion);

        $observacion_sin_editar = $observacion;
        $observacion = substr($observacion, 0, 80) . " ...<button class='btn btn-link' onclick='abrirModalVerMas(`" . $observacion_sin_editar . "`);'>Ver Más</button>";
        $observacion = mb_convert_encoding($observacion, 'UTF-8', 'UTF-8');
    }


    $tabla["data"][] = [
        'id' => $id,
        'cedula' => $cedula,
        'patologia' => $patologia,
        'observacion' => $observacion,
        'fecha_registro' => $fecha_registro,
        'acciones' => $acciones,
    ];
}


echo json_encode($tabla);




function obtener_patologias_socio($fecha_desde, $fecha_hasta, $cedula)
{
    $conexion = connection(DB_ABMMOD);
    $tabla = TABLA_PATOLOGIAS_SOCIO;

    $where = $cedula != "null" ? "documento_socio = '$cedula'" : "fecha BETWEEN '$fecha_desde' AND '$fecha_hasta'";

    try {
        $sql = "SELECT
                id,
                documento_socio,
                id_patologia,
                observacion,
                fecha
               FROM
                {$tabla}
               WHERE
                $where
               ORDER BY id DESC 
               LIMIT 500";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "tabla_patologias_socio.php", $error);
        $consulta = false;
    }

    return $consulta;
}

function nombre_patologia($id_patologia)
{
    $conexion = connection(DB_COORDINACION);
    $tabla = TABLA_PATOLOGIAS;

    try {
        $sql = "SELECT patologia FROM {$tabla} WHERE id_patologia = '$id_patologia'";
        $consulta = mysqli_query($conexion, $sql);
        $resultado = mysqli_fetch_assoc($consulta);
        $respuesta = $resultado['patologia'];
    } catch (\Throwable $error) {
        registrar_errores($sql, "tabla_patologias_socio.php", $error);
        $respuesta = false;
    }

    return $respuesta;
}
