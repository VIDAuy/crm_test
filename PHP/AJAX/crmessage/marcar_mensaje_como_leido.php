<?php
include '../configuraciones.php';


$id = $_REQUEST['id'];
$tipo_consulta = $_REQUEST['tipoConsulta'];
$id_sub_usuario = isset($_SESSION['id_sub_usuario']) ? $_SESSION['id_sub_usuario'] : "";


$modificar_visto = marcar_alerta_leida($id, $tipo_consulta, $id_sub_usuario);

if ($modificar_visto === false) {
    $response['error'] = true;
    $response['mensaje'] = "Ocurrieron errores al marcar la alerta como leída";
    die(json_encode($response));
}



$response['error'] = false;
$response['mensaje'] = "Se marco la alerta como leída con éxito";

echo json_encode($response);




function marcar_alerta_leida($id, $tipo_consulta, $id_sub_usuario)
{
    $conexion = connection(DB);
    $tabla = TABLA_MENSAJES_CONSULTA_TRANSAREA;

    try {
        $set = $tipo_consulta == 1 ?
            "visto_consultor = 1, id_sub_usuario_visto_consultor = '$id_sub_usuario'" :
            "visto_consultado = 1, id_sub_usuario_visto_consultado = '$id_sub_usuario'";
        $sql = "UPDATE {$tabla} SET $set WHERE id_consulta_transarea = '$id' AND activo = 1";
        $consulta = mysqli_query($conexion, $sql);
        return $consulta;
    } catch (\Throwable $error) {
        registrar_errores($sql, "marcar_mensaje_como_leido.php", $error);
        return false;
    }
}
