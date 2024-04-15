<?php
include_once '../../configuraciones.php';

$id_area = $_SESSION['id'];
$id_sub_usuario = isset($_SESSION['id_sub_usuario']) ? $_SESSION['id_sub_usuario'] : "";


$cantidad_mis_consultas_area = obtener_cantidad_mis_consultas_area($id_area);
if ($cantidad_mis_consultas_area === false) devolver_error("Ocurriron errores al obtener la cantidad de mis consultas respondidas área");


$cantidad_consultas_asignadas_area = obtener_cantidad_consultas_asignadas_area($id_area);
if ($cantidad_consultas_asignadas_area === false) devolver_error("Ocurriron errores al obtener la cantidad de consultas asignadas al área");


$cantidad_mis_consultas_usuario = 0;
$cantidad_consultas_asignadas_usuario = 0;
if ($id_sub_usuario != "") {
  $cantidad_mis_consultas_usuario = obtener_cantidad_mis_consultas_usuario($id_sub_usuario);
  if ($cantidad_mis_consultas_usuario === false) devolver_error("Ocurriron errores al obtener la cantidad de mis consultas respondidas usuario");

  $cantidad_consultas_asignadas_usuario = obtener_cantidad_consultas_asignadas_usuario($id_sub_usuario);
  if ($cantidad_consultas_asignadas_usuario === false) devolver_error("Ocurriron errores al obtener la cantidad de consultas asignadas al usuario");
}



$cantidad_mis_consultas = $cantidad_mis_consultas_area + $cantidad_mis_consultas_usuario;
$cantidad_consultas_asignadas = $cantidad_consultas_asignadas_area + $cantidad_consultas_asignadas_usuario;

$response['error'] = false;
$response['cantidad_mis_consultas'] = $cantidad_mis_consultas;
$response['cantidad_consultas_asignadas'] = $cantidad_consultas_asignadas;

echo json_encode($response);




function obtener_cantidad_mis_consultas_area($id_area)
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
              ct.area_consulta = '$id_area' AND 
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

function obtener_cantidad_mis_consultas_usuario($id_sub_usuario)
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
              ct.usuario_consultado = '$id_sub_usuario' AND 
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

function obtener_cantidad_consultas_asignadas_area($id_area)
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
              ct.area_consultada = '$id_area' AND 
              (ct.usuario_consultado IS NULL OR ct.usuario_consultado = '') AND
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

function obtener_cantidad_consultas_asignadas_usuario($id_sub_usuario)
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
              ct.usuario_consultado = '$id_sub_usuario' AND
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
