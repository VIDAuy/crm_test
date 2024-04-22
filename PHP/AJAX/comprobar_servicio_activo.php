<?php
include_once '../configuraciones.php';

$cedula = $_REQUEST['cedula'];

if ($cedula == "") devolver_error(ERROR_GENERAL);


$comprobar_servicios = comprobar_servicios_activos($cedula);
if ($comprobar_servicios === false) devolver_error("Ocurrieron errores al obtener los servicios activos");



$response['error'] = false;
$response['mensaje'] = "Tiene servicios activos en coordinación";
$response['servicios_activos'] = mysqli_num_rows($comprobar_servicios) > 0 ? true : false;



echo json_encode($response);




function comprobar_servicios_activos($cedula)
{
    $conexion = connection(DB_COORDINACION);
    $tabla1 = TABLA_PEDIDO_ACOMP;
    $tabla2 = TABLA_ESTADOS_PEDIDO;
    $tabla3 = TABLA_PATOLOGIAS;

    $sql = "SELECT
              p.id,
              p.obs_socio,
              p.id_socio,
              p.nombre_socio,
              p.fecha_ini,
              p.fechafin,
              p.hs_ini,
              p.hrfin,
              p.hs_x_dia,
              REPLACE ( p.lugar, '_', ' ' ) AS lugar,
              e.estado,
              p.id_estado_pedido,
              a.patologia 
            FROM
              {$tabla1} p
              INNER JOIN {$tabla2} e ON p.id_estado_pedido = e.id_estado
              INNER JOIN {$tabla3} a ON p.id_patologia = a.id_patologia 
            WHERE
              p.id_socio = '$cedula' 
              AND p.id_estado_pedido NOT IN ( '2', '3' ) 
            ORDER BY p.id DESC";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
