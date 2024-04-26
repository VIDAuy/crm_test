<?php
include_once '../../../configuraciones.php';

$id = $_REQUEST['id'];


if ($id == "") devolver_error(ERROR_GENERAL);



$eliminar_contenido_por_area = eliminar_contenido_por_area($id);
if ($eliminar_contenido_por_area == false) devolver_error("Ocurrieron errores al eliminar el registro");



$response['error'] = false;
$response['mensaje'] = "Se elimino el registro con éxito";
echo json_encode($response);




function eliminar_contenido_por_area($id)
{
    $conexion = connection(DB);
    $tabla = TABLA_CONTENIDO_CRM_POR_AREA;

    try {
        $sql = "UPDATE {$tabla} SET activo = 0 WHERE id = '$id'";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "eliminar_contenido_por_area.php", $error);
    }

    return $consulta;
}
