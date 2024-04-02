<?php
include_once '../../configuraciones.php';

$id_usuario = $_SESSION['id'];


$cantidad_mis_consultas = obtener_cantidad_mis_consultas($id_usuario);

if ($cantidad_mis_consultas === false) {
    $response['error'] = true;
    $response['mensaje'] = "Ocurriron errores al obtener la cantidad de mis consultas respondidas";
    die(json_encode($response));
}

$cantidad_consultas_asignadas = obtener_cantidad_consultas_asignadas($id_usuario);

if ($cantidad_consultas_asignadas === false) {
    $response['error'] = true;
    $response['mensaje'] = "Ocurriron errores al obtener la cantidad de consultas asignadas";
    die(json_encode($response));
}


$response['error'] = false;
$response['cantidad_mis_consultas'] = $cantidad_mis_consultas;
$response['cantidad_consultas_asignadas'] = $cantidad_consultas_asignadas;

echo json_encode($response);




function obtener_cantidad_mis_consultas($id_usuario)
{
    $conexion = connection(DB);
    $tabla1 = TABLA_CONSULTA_TRANSAREA;
    $tabla2 = TABLA_MENSAJES_CONSULTA_TRANSAREA;

    try {
        $sql = "SELECT 
              * 
            FROM 
              {$tabla1} ct 
              INNER JOIN {$tabla2} mct ON ct.id = mct.id_consulta_transarea
            WHERE 
              ct.area_consulta = '$id_usuario' AND 
              mct.activo = 1 AND 
              mct.visto_consultor = 0";
        $consulta = mysqli_query($conexion, $sql);
        $resultado = $consulta != false ? mysqli_num_rows($consulta) : false;
        return $resultado;
    } catch (\Throwable $error) {
        registrar_errores($sql, "cantidad_consultas_no_leidas.php", $error);
        return false;
    }
}

function obtener_cantidad_consultas_asignadas($id_usuario)
{
    $conexion = connection(DB);
    $tabla1 = TABLA_CONSULTA_TRANSAREA;
    $tabla2 = TABLA_MENSAJES_CONSULTA_TRANSAREA;

    try {
        $sql = "SELECT 
                  * 
                FROM 
                  {$tabla1} ct 
                  INNER JOIN {$tabla2} mct ON ct.id = mct.id_consulta_transarea
                WHERE 
                  ct.area_consultada = '$id_usuario' AND 
                  mct.activo = 1 AND 
                  mct.visto_consultado = 0";
        $consulta = mysqli_query($conexion, $sql);
        $resultado = $consulta != false ? mysqli_num_rows($consulta) : false;
        return $resultado;
    } catch (\Throwable $error) {
        registrar_errores($sql, "cantidad_consultas_no_leidas.php", $error);
        return false;
    }
}
