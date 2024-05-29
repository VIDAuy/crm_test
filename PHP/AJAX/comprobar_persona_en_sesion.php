<?php
include_once '../configuraciones.php';

$id_area = $_SESSION['id'];
$sector = $_REQUEST['sector'];
$cedula = $_REQUEST['cedula'];


$id_sector = obtener_usuario_datos($sector)['id'];
$tiempo_expiracion = obtener_usuario_datos($sector)['tiempo_expiracion'];

if ($id_sector == "" || $id_sector == false || $id_sector == null) {
    $response['error'] = true;
    $response['mensaje'] = ERROR_GENERAL;
    die(json_encode($response));
}


$datos_usuario = validar_usuario($id_sector, $cedula);
if ($datos_usuario == "" || $datos_usuario == false || $datos_usuario == null) devolver_error("La cédula ingresada no pertenece a ninguna persona del sector $sector");
$id_sub_usuario = $datos_usuario['id'];
$nombre = $datos_usuario['nombre'];
$apellido = $datos_usuario['apellido'];
$es_gestor = $datos_usuario['gestor'];



$_SESSION['id_sub_usuario'] = $id_sub_usuario;
$_SESSION['id_sector'] = $id_sector;
$_SESSION['sector'] = $sector;
$_SESSION['cedula'] = $cedula;
$_SESSION['nombre'] = $nombre;
$_SESSION['apellido'] = $apellido;
$_SESSION['gestor'] = $es_gestor;



$contenido = [];
if ($es_gestor == 1) {
    $permiso_contenido = comprobar_permisos(2, $id_area, null, 3);
    if ($permiso_contenido === false) devolver_error("Ocurrieron errores al obtener los permisos");
    if (mysqli_num_rows($permiso_contenido) > 0) {
        while ($row = mysqli_fetch_assoc($permiso_contenido)) {
            $id = $row['id'];
            array_push($contenido, $id);
        }
    }
}



$response['error'] = false;
$response['mensaje'] = "Bienvenid@ de vuelta $nombre";
$response['datos'] = [
    "id_sub_usuario" => $id_sub_usuario,
    "id_sector" => $id_sector,
    "sector" => $sector,
    "cedula" => $cedula,
    "nombre" => $nombre,
    "apellido" => $apellido,
    "gestor" => $es_gestor,
    "tiempo_expiracion" => $tiempo_expiracion,
];
$response['todo_contenido'] = $contenido;
echo json_encode($response);




function obtener_usuario_datos($sector)
{
    $conexion = connection(DB);
    $tabla = TABLA_USUARIOS;

    $sql = "SELECT id, tiempo_expiracion FROM {$tabla} WHERE usuario = '$sector'";
    $consulta = mysqli_query($conexion, $sql);

    return mysqli_fetch_assoc($consulta);
}


function validar_usuario($id_sector, $cedula)
{
    $conexion = connection(DB);
    $tabla = TABLA_SUB_USUARIOS;

    $sql = "SELECT id, nombre, apellido, gestor FROM {$tabla} WHERE id_sector = '$id_sector' AND cedula = '$cedula' AND activo = 1";
    $consulta = mysqli_query($conexion, $sql);

    return mysqli_fetch_assoc($consulta);
}
