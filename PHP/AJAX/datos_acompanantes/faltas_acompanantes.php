<?php
include_once '../../configuraciones.php';

include '../../conexiones/conexion7.php';
$cedula = $_REQUEST['cedula'];
$fecha_desde = $_REQUEST['fecha_desde'];
$fecha_hasta = $_REQUEST['fecha_hasta'];

$tabla["data"] = [];


$sql = "SELECT
cod_trabajador,
cod_tipo_licen,
cod_actividad,
cod_emp,
fec_inicio,
fec_final
FROM
cpp_RHLicencias 
WHERE
(
    ( CAST ( fec_inicio AS DATE ) BETWEEN '$fecha_desde' AND '$fecha_hasta' ) 
    OR ( CAST ( fec_final AS DATE ) BETWEEN '$fecha_desde' AND '$fecha_hasta' ) 
    OR ( CAST ( fec_inicio AS DATE ) <= '$fecha_desde' AND CAST ( fec_final AS DATE ) >= '$fecha_hasta' ) 
) 
AND doc_persona = '$cedula'";
$consulta = sqlsrv_query($conexion, $sql);


while ($resultado = sqlsrv_fetch_array($consulta)) {

    $trabajador = $resultado['cod_trabajador'];
    $tipo_licencia = obtener_tipos(1, $resultado['cod_tipo_licen']);
    $actividad = obtener_tipos(2, $resultado['cod_actividad']);
    $empresa = obtener_tipos(3, $resultado['cod_emp']);
    $fecha_inicio = $resultado['fec_inicio']->FORMAT('d/m/Y');
    $fecha_final = $resultado['fec_final']->FORMAT('d/m/Y');

    $tabla["data"][] = [
        "trabajador" => $trabajador,
        "tipo_falta" => $tipo_licencia,
        "actividad" => $actividad,
        "empresa" => $empresa,
        "fecha_inicio" => $fecha_inicio,
        "fecha_final" => $fecha_final,
    ];
}



echo json_encode($tabla);