<?php
include_once '../../configuraciones.php';

$tabla["data"] = [];

$opcion = $_REQUEST['opcion'];

$registros = obtener_registros_discador($opcion);


while ($row = mysqli_fetch_assoc($registros)) {

    $id               = $row['id'];
    $cedula           = $row['cedula_datos_contacto'];
    $name             = $row['name_datos_contacto'];
    $numcall          = $row['numcall_datos_contacto'];
    $enable           = $row['enable_datos_contacto'];
    $columna1         = $row['columna1_datos_adicionales'];
    $columna2         = $row['columna2_datos_adicionales'];
    $columna3         = $row['columna3_datos_adicionales'];
    $columna4         = $row['columna4_datos_adicionales'];
    $columna4         = $columna4 != "" ? $columna4 : "-";
    $state            = $row['state_datos_actividad'];
    $statetimestamp   = $row['statetimestamp_datos_actividad'];
    $lastattempt      = $row['lastattempt_datos_actividad'];
    $attempttimestamp = $row['attempttimestamp_datos_actividad'];
    $billsec          = $row['billsec_datos_actividad'];
    $billsec          = $billsec != "" ? $billsec : "-";
    $uniqueid         = $row['uniqueid_datos_actividad'];
    $uniqueid         = $uniqueid != "" ? $uniqueid : "-";
    $option           = $row['option_datos_ejecucion'];
    $option           = $option != "" ? $option : "-";
    $description      = $row['descripcion_datos_ejecucion'];
    $description      = $description != "" ? $description : "-";


    $tabla["data"][] = [
        "id"               => $id,
        "cedula"           => $cedula,
        "name"             => $name,
        "numcall"          => $numcall,
        "enable"           => $enable,
        "columna1"         => $columna1,
        "columna2"         => $columna2,
        "columna3"         => $columna3,
        "columna4"         => $columna4,
        "state"            => $state,
        "statetimestamp"   => date("d/m/Y H:i:s", strtotime($statetimestamp)),
        "lastattempt"      => $lastattempt,
        "attempttimestamp" => date("d/m/Y H:i:s", strtotime($attempttimestamp)),
        "billsec"          => $billsec,
        "uniqueid"         => $uniqueid,
        "option"           => $option,
        "description"      => $description,
    ];
}



echo json_encode($tabla);







function obtener_registros_discador($opcion)
{
    $conexion = connection(DB);
    $tabla = TABLA_REGISTROS_DISCADOR;

    $sql = "SELECT * FROM {$tabla} WHERE id_tipo_discador = $opcion AND activo = 1";

    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
