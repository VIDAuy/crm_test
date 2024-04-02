<?php
include_once '../configuraciones.php';


$cedula = $_REQUEST['cedula'];
$filtro = "";


$patologias_registradas = patologias_registradas($cedula);

while ($row = mysqli_fetch_assoc($patologias_registradas)) {

    $id_patologia = $row['id_patologia'];

    if ($filtro == "") {
        $filtro = $id_patologia;
    } else {
        $filtro = $filtro . ", " . $id_patologia;
    }
}


$patologias_sin_registrar = patologias_sin_registrar($filtro);

while ($row = mysqli_fetch_assoc($patologias_sin_registrar)) {

    $row['id'] = $row['id'];
    $row['nombre'] = strtoupper($row['nombre']);
    $f[] = $row;
}


$respuesta = array(
    'datos' => $f
);



echo json_encode($respuesta);




function patologias_registradas($cedula)
{
    $conexion = connection(DB_ABMMOD);
    $tabla = TABLA_PATOLOGIAS_SOCIO;

    $sql = "SELECT id_patologia FROM {$tabla} WHERE documento_socio = '{$cedula}'";

    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}

function patologias_sin_registrar($filtro)
{
    include_once '../conexiones/conexion3.php';
    $tabla = TABLA_PATOLOGIAS;
    $sql = "";

    if ($filtro == "") {
        $sql = "SELECT id_patologia AS 'id', patologia AS 'nombre' FROM {$tabla} ORDER BY nombre ASC";
    } else {
        $sql = "SELECT id_patologia AS 'id', patologia AS 'nombre' FROM {$tabla} WHERE id_patologia NOT IN ($filtro) ORDER BY nombre ASC";
    }

    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
