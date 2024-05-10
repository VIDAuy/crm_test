<?php
include_once '../../../configuraciones.php';

$id = $_REQUEST['id'];


if ($id == "") devolver_error(ERROR_GENERAL);



$eliminar_etiqueta_socio = eliminar_etiqueta_socio($id);
if ($eliminar_etiqueta_socio == false) devolver_error("Ocurrieron errores al eliminar el registro");



$response['error'] = false;
$response['mensaje'] = "Se elimino el registro con éxito";
echo json_encode($response);




function eliminar_etiqueta_socio($id)
{
    $conexion = connection(DB);
    $tabla = TABLA_ETIQUETA_SOCIO;

    try {
        $sql = "UPDATE {$tabla} SET activo = 0 WHERE id = '$id'";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "eliminar_etiqueta_socio.php", $error);
    }

    return $consulta;
}
