<?php
include './configuraciones.php';


$cedula = $_REQUEST['cedula'];


if ($cedula == "") {
    $response['error'] = true;
    $response['mensaje'] = ERROR_GENERAL;
    die(json_encode($response));
}


$tabla["data"] = [];


$obtener_datos = obtener_pagos_socio($cedula);

while ($row = mysqli_fetch_assoc($obtener_datos)) {

    $id_pago = $row['id_pago'];
    $id = $row['id'];
    $nombre = $row['nombre'];
    $importe = $row['importe'];
    $mes = strlen($row['mes']) < 2 ? "0" . $row['mes'] : $row['mes'];
    $ano = $row['ano'];
    $fecha_limite = $row['fecha_limite'];
    $nro_factura = $row['nro_factura'];
    $id_estado_pago = $row['pago'];
    $datos_webhooks = obtener_datos_webhook($id_pago);
    $fecha_estado = $datos_webhooks['fecha'];


    if ($id_estado_pago == 2) {
        $estado_pago = "<span class='text-success fw-bolder'> Aprobado </span>";
        $fecha_pago = date("d/m/Y H:i:s", strtotime($fecha_estado));
    } else if ($id_estado_pago == 0 || $id_estado_pago == 1) {
        $estado_pago = "<span class='text-warning fw-bolder'> Pendiente </span>";
        $fecha_pago = "";
    } else {
        $estado_pago = "<span class='text-danger fw-bolder'> Cancelado </span>";
        $fecha_pago = "";
    }


    $tabla["data"][] = [
        "fecha_orden" => $id_pago,
        "id" => $id,
        "nro_factura" => $nro_factura,
        "nombre" => $nombre,
        "cuota" => "$mes/$ano",
        "importe" => "$" . $importe,
        "fecha_limite" => date("d/m/Y", strtotime($fecha_limite)),
        "pago" => $estado_pago,
        "fecha_pago" => $fecha_pago,
    ];
}


echo json_encode($tabla);





function obtener_pagos_socio($cedula)
{
    $conexion = connection(DB_COBRA);
    $tabla = TABLA_COBROS_CUOTAS_ABITAB;

    $sql = "SELECT * FROM {$tabla} WHERE cedula = '{$cedula}' GROUP BY id_pago";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}

function obtener_datos_webhook($id_pago)
{
    $conexion = connection(DB_REDES_DE_COBRANZA);
    $tabla = TABLA_WEBHOOKS;

    $sql = "SELECT * FROM {$tabla} WHERE id_pago = '{$id_pago}' ORDER BY id DESC LIMIT 1";
    $consulta = mysqli_query($conexion, $sql);

    return mysqli_fetch_assoc($consulta);
}



/*
function listarMensualidades($fecha_desde = false, $fecha_hasta = false, $todos = false)
{
    $conexion = connection(DB_REDES_DE_COBRANZA);
    $tabla = TABLA_WEBHOOKS;

    $where = "WHERE DATE(fecha) BETWEEN '{$fecha_desde}' AND '{$fecha_hasta}' ";

    if (!$todos) $where .= "AND estado='approved'";

    $sql = "SELECT id_pago, fecha FROM {$tabla} {$where} GROUP BY id_pago ORDER BY DATE(fecha) DESC";
    $resultado = mysqli_query($conexion, $sql);

    return $resultado;
}

function obtener_fecha_pago($id_pago)
{
    $conexion = connection(DB_REDES_DE_COBRANZA);
    $tabla = TABLA_WEBHOOKS;

    $sql = "SELECT fecha FROM {$tabla} WHERE id_pago = '$id_pago' AND `estado` = 'approved' GROUP BY id_pago";
    $consulta = mysqli_query($conexion, $sql);
    $resultado = mysqli_fetch_assoc($consulta)['fecha'];

    return $resultado;
}
*/