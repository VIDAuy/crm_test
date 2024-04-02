<?php
include_once '../../configuraciones.php';

$area = $_REQUEST['area'];
$area = obtener_area($area);
$id_sub_usuario = $_REQUEST['id_sub_usuario'];
$fecha_actual = date("Y-m-d H:i:s");


$tabla["data"] = [];

$consulta = consulta_general($area, $id_sub_usuario);


while ($resultado = mysqli_fetch_assoc($consulta)) {

    $id             = $resultado['id'];
    $area           = $resultado['area'];
    $cedula         = $resultado['cedula'];
    $nombre         = $resultado['nombre'];
    $telefono       = $resultado['telefono'];
    $es_socio       = $resultado['es_socio'] == 1 ? "Si" : "No";
    $baja           = esta_en_baja($cedula) == 1 ? "Si" : "No";
    $fecha_hora     = date("d/m/Y H:i:s", strtotime($resultado['fecha_hora']));
    $mensaje        = $resultado['mensaje'];
    $fecha_registro = date("d/m/Y H:i:s", strtotime($resultado['fecha_registro']));
    $acciones = "<button class='btn btn-primary mb-2' onclick='cambiar_fecha_y_hora_volver_a_llamar(true, `" . $id . "`)'>Reagendar llamada</button> <br>";

    $fecha_recordatorio = $resultado['fecha_hora'];
    $fecha_menos_1_hora = date("Y-m-d H:i:s", strtotime($fecha_recordatorio . "- 1 hour"));

    if ($fecha_actual >= $fecha_menos_1_hora) {
        $acciones .= "<button class='btn btn-warning' onclick='cargar_registro_volver_a_llamar(true, `" . $id . "`, `" . $area . "`, `" . $cedula . "`, `" . $nombre . "`, `" . $telefono . "`, `" . $es_socio . "`, `" . $fecha_hora . "`, `" . $mensaje . "`, `" . $fecha_registro . "`)'>Registrar llamada</button>";
    }

    $tabla["data"][] = [
        "id"             => $id,
        "cedula"         => $cedula,
        "nombre"         => $nombre,
        "telefono"       => $telefono,
        "es_socio"       => $es_socio,
        "baja"           => $baja,
        "fecha_hora"     => $fecha_hora,
        "mensaje"        => $mensaje,
        "fecha_registro" => $fecha_registro,
        "acciones"       => $acciones
    ];
}





echo json_encode($tabla);






function obtener_area($area)
{
    $conexion = connection(DB);
    $tabla = TABLA_USUARIOS;

    $sql = "SELECT id FROM {$tabla} WHERE usuario = '$area' ORDER BY id DESC LIMIT 1";
    $consulta = mysqli_query($conexion, $sql);

    return mysqli_fetch_assoc($consulta)['id'];
}

function consulta_general($area, $id_sub_usuario)
{
    $conexion = connection(DB);
    $tabla = TABLA_AGENDA_VOLVER_A_LLAMAR;

    $sql = "SELECT
	id,
	area,
	cedula,
	nombre,
	telefono,
	es_socio,
	fecha_hora,
	mensaje,
	fecha_registro 
    FROM
	{$tabla} 
    WHERE
    mostrar = 1 AND
    activo = 1 AND 
    area = '$area' AND
    id_sub_usuario = '$id_sub_usuario'";

    return mysqli_query($conexion, $sql);
}