<?php
include_once '../../configuraciones.php';

$tabla["data"] = [];

$usuario = $_SESSION['usuario'];
$btnRegistrarComentario = $_REQUEST['btnRegistrarComentario'];
$cedula = $_REQUEST['cedula'];

$auditorias = obtener_auditorias_socio($cedula);

while ($row = mysqli_fetch_assoc($auditorias)) {

    $id = $row['id'];
    $cedula = $row['cedula'];
    $descripcion = $row['descripcion'];
    $fecha_auditoria = $row['fecha'];
    $fecha_registro = $row['fecha_registro'];
    $usuario_registro = ucfirst(obtener_datos_usuario($row['usuario_registro'])['usuario']);
    $acciones = "";
    $comentarios = obtener_comentarios_auditoria($id);
    if (mysqli_num_rows($comentarios) > 0) $acciones .= "<button class='btn btn-sm btn-info me-2' onclick='ver_comentarios_auditorias_socio(`" . $id . "`, `" . $cedula . "`)'>Ver Comentarios</button>";

    if ($btnRegistrarComentario == "true" && in_array($usuario_registro, ["Audit1", "Audit2", "Audit3"]))
        $acciones .= "<button class='btn btn-sm btn-success' onclick='registrar_comentario_auditoria_socio(true, `" . $id . "`)'>Nuevo Comentario</button>";

    $usuario_registro = $usuario_registro == "Audit1" ? "Nathalia Horvat" : (
        $usuario_registro == "Audit2" ? "Andrea Horvat" : (
            $usuario_registro == "Audit3" ? "Tatiana Landa" :
            $usuario_registro));

    if (strlen($descripcion) > 20) {
        $br  = array("<br />", "<br>", "<br/>");
        $descripcion = str_ireplace($br, "\r\n", $descripcion);

        $descripcion_sin_editar = $descripcion;
        $descripcion = substr($descripcion, 0, 20) . " ...<button class='btn btn-link' onclick='verMasTabla(`" . $descripcion_sin_editar . "`);'>Ver Más</button>";
        $descripcion = mb_convert_encoding($descripcion, 'UTF-8', 'UTF-8');
    }

    $tabla["data"][] = [
        "id" => $id,
        "cedula" => $cedula,
        "descripcion" => $descripcion,
        "fecha_auditoria" => date("d/m/Y H:i", strtotime($fecha_auditoria)),
        "fecha_registro" => date("d/m/Y H:i", strtotime($fecha_registro)),
        "usuario_registro" => $usuario_registro,
        "acciones" => $acciones,
    ];
}



echo json_encode($tabla);







function obtener_auditorias_socio($cedula)
{
    $conexion = connection(DB);
    $tabla = TABLA_AUDITORIAS_SOCIO;

    $where = $cedula != "" ? "cedula = '$cedula' AND" : "";
    $limit = $cedula == "" ? "ORDER BY id DESC LIMIT 100" : "";

    try {
        $sql = "SELECT * FROM {$tabla} WHERE $where activo = 1 $limit";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "tabla_auditorias.php", $error);
    }

    return $consulta;
}
