<?php
include_once '../../../configuraciones.php';

$tabla["data"] = [];

$fecha_desde = $_REQUEST['fecha_desde'];
$fecha_hasta = $_REQUEST['fecha_hasta'];
$cedula = $_REQUEST['cedula'];
$fecha_hasta = date("Y-m-d", strtotime($fecha_hasta . " + 1 days"));


$lista_registros = obtener_etiquetas_socio($fecha_desde, $fecha_hasta, $cedula);

while ($row = mysqli_fetch_assoc($lista_registros)) {
    $id = $row['id'];
    $cedula = $row['cedula'];
    $mensaje = $row['mensaje'];
    $id_area = $row['id_area'];
    $sector = ucfirst($row['usuario']);
    $id_sub_usuario = $row['id_sub_usuario'];
    $usuario = $row['sub_usuario'];
    $fecha_registro = date("d/m/Y H:i:s", strtotime($row['fecha_registro']));
    $acciones = "
    <button class='btn btn-sm btn-primary' onclick='editar_etiqueta_socio(true, `" . $id . "`, `" . $cedula . "`, `" . $mensaje . "`, `" . $id_area . "`, `" . $sector . "`, `" . $id_sub_usuario . "`, `" . $usuario . "`);'>✏</button>
    <button class='btn btn-sm btn-danger' onclick='eliminar_etiqueta_socio(`" . $id . "`);'>❌</button>";


    if (strlen($mensaje) > 75) {
        $br  = array("<br />", "<br>", "<br/>");
        $mensaje = str_ireplace($br, "\r\n", $mensaje);

        $mensaje_sin_editar = $mensaje;
        $mensaje = substr($mensaje, 0, 80) . " ...<button class='btn btn-link' onclick='abrirModalVerMas(`" . $mensaje_sin_editar . "`);'>Ver Más</button>";
        $mensaje = mb_convert_encoding($mensaje, 'UTF-8', 'UTF-8');
    }


    $tabla["data"][] = [
        'id' => $id,
        'cedula' => $cedula,
        'mensaje' => $mensaje,
        'sector' => $sector,
        'usuario' => $usuario,
        'fecha_registro' => $fecha_registro,
        'acciones' => $acciones,
    ];
}


echo json_encode($tabla);




function obtener_etiquetas_socio($fecha_desde, $fecha_hasta, $cedula)
{
    $conexion = connection(DB);
    $tabla1 = TABLA_ETIQUETA_SOCIO;
    $tabla2 = TABLA_USUARIOS;
    $tabla3 = TABLA_SUB_USUARIOS;

    $where = $cedula != "null" ? "es.cedula = '$cedula' AND" : "es.fecha_registro BETWEEN '$fecha_desde' AND '$fecha_hasta' AND";

    try {
        $sql = "SELECT
                es.id,
                es.cedula,
                es.mensaje,
                es.id_area,
                u.usuario,
                es.id_sub_usuario,
                CONCAT( su.nombre, ' ', su.apellido ) AS sub_usuario,
                es.fecha_registro
               FROM
                {$tabla1} es
                INNER JOIN {$tabla2} u ON es.id_area = u.id 
                LEFT JOIN {$tabla3} su ON es.id_sub_usuario = su.id 
               WHERE
                $where
                es.activo = 1 
               ORDER BY es.id DESC 
               LIMIT 500";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "tabla_etiquetas_socio.php", $error);
        $consulta = false;
    }

    return $consulta;
}
