<?php
include_once '../../configuraciones.php';


$tabla["data"] = [];
$area = ucfirst(obtener_datos_usuario($_SESSION['id'])['usuario']);
$opcion = $_REQUEST['opcion'];
$cedula = isset($_REQUEST['cedula']) ? $_REQUEST['cedula'] : null;
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;


if ($opcion == 1) $auditorias = obtener_auditorias_socio(1, $cedula, $id);
if ($opcion == 2) $auditorias = obtener_auditorias_socio(2, $cedula, $id);
if ($opcion == 3) $auditorias = obtener_auditorias_socio(3, $cedula, $id);


while ($row = mysqli_fetch_assoc($auditorias)) {

    $id = $row['id'];
    $cedula = $row['cedula'];
    $descripcion = $row['descripcion'];
    $fecha_auditoria = $row['fecha'];
    $fecha_registro = $row['fecha_registro'];
    $usuario_registro = obtener_nombre_sub_usuario($row['usuario_registro']);
    $acciones = "";
    $comentarios = obtener_comentarios_auditoria($id);
    if (mysqli_num_rows($comentarios) > 0)
        $acciones .= "<button class='btn btn-sm btn-info me-2' onclick='mostrar_comentarios_auditoria(true, `" . $id . "`, `" . $cedula . "`)'>🔍</button>";

    if (in_array($area, ["Auditoria"])) {
        $acciones .= "<button class='btn btn-sm btn-success me-2' onclick='registrar_comentario_auditoria_socio(true, `" . $id . "`)'>➕</button>";
        $acciones .= "<button class='btn btn-sm btn-primary' onclick='editar_auditoria_socio(true, `" . $id . "`, `" . $descripcion . "`, `" . $fecha_auditoria . "`)'>✏</button>";
    }


    $texto_tiene_formato = str_contains($descripcion, "<") == true ? 1 : 0;

    $texto_con_formato = $descripcion;
    $texto_sin_formato = strip_tags($descripcion);
    $texto_recortado = substr($texto_sin_formato, 0, 35);
    $descripcion = strlen($texto_sin_formato) > 35 ?
        "$texto_recortado ...<button class='btn btn-link' onclick='modalVerMasHtml(`" . $texto_con_formato . "`, $texto_tiene_formato);'>Ver Más</button>" :
        $texto_sin_formato;



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







function obtener_auditorias_socio($opcion = 1, $cedula = null, $id = null)
{
    $conexion = connection(DB);
    $tabla = TABLA_AUDITORIAS_SOCIO;

    if ($opcion == 1) $where = "";
    if ($opcion == 2) $where = "cedula = '$cedula' AND";
    if ($opcion == 3) $where = "id = '$id' AND";

    try {
        $sql = "SELECT * FROM {$tabla} WHERE $where activo = 1 ORDER BY id DESC LIMIT 100";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "tabla_auditorias.php", $error);
    }

    return $consulta;
}
