<?php
include_once '../../configuraciones.php';


include '../../conexiones/conexion7.php';
$fecha_desde = $_REQUEST['fecha_desde'];
$fecha_hasta = $_REQUEST['fecha_hasta'];



$tabla["data"] = [];

$sql = "SELECT
c.cod_trabajador,
c.doc_persona,
t.nombre1,
t.nombre2,
t.apellido1,
t.apellido2,
c.cod_tipo_licen,
c.cod_actividad,
c.cod_emp,
c.fec_inicio,
c.fec_final
FROM
cpp_RHLicencias as c,
v_RHTrabajador as t
WHERE
(
    ( CAST ( c.fec_inicio AS DATE ) BETWEEN '$fecha_desde' AND '$fecha_hasta' ) 
    OR ( CAST ( c.fec_final AS DATE ) BETWEEN '$fecha_desde' AND '$fecha_hasta' ) 
    OR ( CAST ( c.fec_inicio AS DATE ) <= '$fecha_desde' AND CAST ( c.fec_final AS DATE ) >= '$fecha_hasta' ) 
)
AND c.doc_persona = t.doc_persona";
$consulta = sqlsrv_query($conexion, $sql);



while ($resultado = sqlsrv_fetch_array($consulta)) {

    $trabajador = $resultado['cod_trabajador'];
    $cedula = $resultado['doc_persona'];
    $nombre_1_verificar = TRIM($resultado['nombre1']);
    $nombre1 = verificar_letras($nombre_1_verificar) == true ? $nombre_1_verificar : "";
    $nombre_2_verificar = TRIM($resultado['nombre2']);
    $nombre2 = verificar_letras($nombre_2_verificar) == true ? $nombre_2_verificar : "";
    $apellido1_verificar = TRIM($resultado['apellido1']);
    $apellido1 = verificar_letras($apellido1_verificar) == true ? $apellido1_verificar : "";
    $apellido2_verificar = TRIM($resultado['apellido2']);
    $apellido2 = verificar_letras($apellido2_verificar) == true ? $apellido2_verificar : "";
    $nombre_completo = $nombre1 . " " . $nombre2 . " " . $apellido1 . " " . $apellido2;
    $tipo_licencia = obtener_tipos(1, $resultado['cod_tipo_licen']);
    $actividad = obtener_tipos(2, $resultado['cod_actividad']);
    $empresa = obtener_tipos(3, $resultado['cod_emp']);
    $fecha_inicio = $resultado['fec_inicio']->FORMAT('d/m/Y');
    $fecha_final = $resultado['fec_final']->FORMAT('d/m/Y');

    $tabla["data"][] = [
        "trabajador" => $trabajador,
        "cedula" => $cedula,
        "nombre" => $nombre_completo,
        "tipo_falta" => $tipo_licencia,
        "actividad" => $actividad,
        "empresa" => $empresa,
        "fecha_inicio" => $fecha_inicio,
        "fecha_final" => $fecha_final,
    ];
}



echo json_encode($tabla);
