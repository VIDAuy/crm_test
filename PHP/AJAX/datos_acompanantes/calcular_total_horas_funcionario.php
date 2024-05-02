<?php
include_once '../../configuraciones.php';

$cedula = $_REQUEST['cedula'];
$fecha_desde = $_REQUEST['fecha_desde'];
$fecha_hasta = $_REQUEST['fecha_hasta'];
$cantidad_horas = 0;


$consulta = consulta_general($cedula, $fecha_desde, $fecha_hasta);

while ($resultado = mysqli_fetch_array($consulta)) {

    $id_servicio = $resultado['id_servicio'];
    $hora_inicio = $resultado['hora_inicio'];
    $hora_fin = $resultado['hora_fin'];
    $fecha_servicio = $resultado['fecha_servicio'];
    $horario_cortado = $resultado['horario_cortado'];
    $idinfo = $resultado['idinfo'];
    $_fecha = $fecha_servicio;


    if ($horario_cortado == 1) {
        include '../../conexiones/conexion3.php';
        $_fecha = date('Y-m-d', strtotime($fecha_servicio . '+1 day'));
        $query = "SELECT 
                  h.hora_fin 
                 FROM 
                  servicios_new s 
                  INNER JOIN horarios h ON s.id = h.id_servicio 
                 WHERE 
                  h.activo = 1 AND 
                  h.hora_inicio = '00:00' AND 
                  h.horario_cortado = 1 AND 
                  s.activo = 1 AND 
                  s.fecha = '$_fecha' AND 
                  s.idinfo='$idinfo' AND 
                  h.cedula_acompanante = '$cedula'";
        $hora_fin = mysqli_fetch_assoc(mysqli_query($conexion, $query))['hora_fin'];
    }


    $suma_horas = strtotime($_fecha . " " . $hora_fin) - strtotime($fecha_servicio . " " . $hora_inicio);
    $suma_horas = $suma_horas / 60 / 60;


    $cantidad_horas = $cantidad_horas + $suma_horas;
}



$response['error'] = false;
$response['datos'] = $cantidad_horas;
echo json_encode($response);




function consulta_general($cedula, $fecha_desde, $fecha_hasta)
{
    include '../../conexiones/conexion3.php';

    $sql = "SELECT 
            s.id AS 'id_servicio', 
            h.hora_inicio, 
            h.hora_fin, 
            h.horario_cortado,
            s.idinfo,
            s.fecha AS 'fecha_servicio'
           FROM servicios_new s 
            INNER JOIN pedido_acomp p ON p.id = s.idinfo 
            INNER JOIN horarios h ON h.id_servicio = s.id
           WHERE 
            s.activo = 1 AND 
            h.activo = 1 AND 
            h.sin_acompanante = 0 AND 
            s.fecha BETWEEN '$fecha_desde' AND '$fecha_hasta' AND 
            (horario_cortado = 0 OR (horario_cortado = 1 AND hora_fin = '23:59')) AND 
            h.cedula_acompanante = '$cedula'
           ORDER BY s.id DESC";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
