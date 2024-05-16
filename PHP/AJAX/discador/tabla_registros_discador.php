<?php
include_once '../../configuraciones.php';

$tabla["data"] = [];

$cedula = $_REQUEST['cedula'];

$registros = obtener_registros_discador($cedula);


while ($row = mysqli_fetch_assoc($registros)) {

    $id               = $row['id'];
    $id_tipo_discador = $row['id_tipo_discador'];
    $tipo_discador = "";
    if ($id_tipo_discador == 1) $tipo_discador = "Convenios";
    if ($id_tipo_discador == 2) $tipo_discador = "Domiciliarios";
    if ($id_tipo_discador == 3) $tipo_discador = "Onajpu";
    $telefono         = $row['numcall_datos_contacto'];
    $estado           = $row['state_datos_actividad'];
    $estado           = $estado == "Completed" ? "<span class='text-success fw-bolder'>$estado</span>" : "<span class='text-danger fw-bolder'>$estado</span>";
    $fecha_recibido   = $row['attempttimestamp_datos_actividad'];
    $description      = $row['descripcion_datos_ejecucion'];
    $description      = $description != "" ? $description : "-";


    $tabla["data"][] = [
        "id"             => $id,
        "tipo_discador"  => $tipo_discador,
        "telefono"       => $telefono,
        "estado"         => $estado,
        "fecha_recibido" => date("d/m/Y H:i:s", strtotime($fecha_recibido)),
        "description"    => $description,
    ];
}



echo json_encode($tabla);







function obtener_registros_discador($cedula)
{
    $conexion = connection(DB);
    $tabla = TABLA_REGISTROS_DISCADOR;

    $sql = "SELECT * FROM {$tabla} WHERE cedula_datos_contacto = $cedula AND activo = 1";

    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
