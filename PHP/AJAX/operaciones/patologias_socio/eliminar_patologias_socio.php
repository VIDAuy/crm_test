<?php
include_once '../../../configuraciones.php';

$id = $_REQUEST['id'];


if ($id == "") devolver_error(ERROR_GENERAL);



$eliminar_patologia_socio = eliminar_patologia_socio($id);
if ($eliminar_patologia_socio == false) devolver_error("Ocurrieron errores al eliminar el registro de patología");



$response['error'] = false;
$response['mensaje'] = "Se elimino el registro con éxito";
echo json_encode($response);




function eliminar_patologia_socio($id)
{
    $conexion = connection(DB_ABMMOD);
    $tabla = TABLA_PATOLOGIAS_SOCIO;

    try {
        $sql = "DELETE {$tabla} WHERE id = '$id'";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "eliminar_patologia_socio.php", $error);
        $consulta = false;
    }

    return $consulta;
}
