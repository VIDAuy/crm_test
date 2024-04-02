<?php
include_once '../../configuraciones.php';

$tabla["data"] = [];

$usuario = $_SESSION['usuario'];
$btnRegistrarComentario = $_REQUEST['btnRegistrarComentario'];

$auditorias = obtener_auditorias_socio();

while ($row = mysqli_fetch_assoc($auditorias)) {

    $id = $row['id'];
    $cedula = $row['cedula'];
    $descripcion = $row['descripcion'];
    $fecha_auditoria = $row['fecha'];
    $fecha_registro = $row['fecha_registro'];
    $usuario_registro = $row['usuario_registro'];
    $acciones = "";
    $comentarios = obtener_comentarios_auditoria($id);
    if (mysqli_num_rows($comentarios) > 0) $acciones .= "<button class='btn btn-sm btn-info me-2' onclick='ver_comentarios_auditorias_socio(`" . $id . "`, `" . $cedula . "`)'>Ver Comentarios</button>";

    if ($btnRegistrarComentario == "true") {
        $usuario == "Audit1" || $usuario == "Audit2" || $usuario == "Audit3" ?
            $acciones .= "<button class='btn btn-sm btn-success' onclick='registrar_comentario_auditoria_socio(true, `" . $id . "`)'>Nuevo Comentario</button>" :
            "";
    }

    $usuario_registro = $usuario_registro == "Audit1" ? "Nathalia Horvat" : (
        $usuario_registro == "Audit2" ? "Andrea Horvat" : (
            $usuario_registro == "Audit3" ? "Tatiana Landa" :
            $usuario_registro));

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







function obtener_auditorias_socio()
{
    $conexion = connection(DB);
    $tabla = TABLA_AUDITORIAS_SOCIO;

    $sql = "SELECT * FROM {$tabla} WHERE activo = 1";

    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
