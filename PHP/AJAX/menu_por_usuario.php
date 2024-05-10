<?php
include_once '../configuraciones.php';

$id_sub_usuario = $_SESSION['id_sub_usuario'];

$obtener_items = obtener_menu($id_sub_usuario);


while ($row = mysqli_fetch_assoc($obtener_items)) {

    $id = $row['id'];
    $icon_svg = $row['icon_svg'];
    $ruta_enlace = $row['ruta_enlace'];
    $funcion = $row['funcion'];
    $nombre = $row['nombre'];
    $badge = $row['badge'];

    $a = $ruta_enlace != "" ?
        "<a href='$ruta_enlace' class='nav-link d-flex align-items-center gap-2' target='_blank'>" : (
            $funcion != "" ? "<a href='#' class='nav-link d-flex align-items-center gap-2' onclick='$funcion'>" :
            "");
    $badge = $badge != "" ? "<span class='badge text-bg-danger' id='$badge'>0+</span>" : "";

    $items_menu[] = [
        "<li class='nav-item'>
                $a
                $icon_svg
                $nombre
                $badge
            </a>
        </li>",
    ];
}



$response['error'] = false;
$response['estatus'] = $items_menu != "" ? 222 : 0;
$response['items_menu'] = $items_menu;
echo json_encode($response);




function obtener_menu($id_sub_usuario)
{
    $conexion = connection(DB);
    $tabla1 = TABLA_MENU_POR_USUARIO;
    $tabla2 = TABLA_ITEMS_MENU;

    $sql = "SELECT
	      im.id,
	      im.icon_svg,
	      im.ruta_enlace,
	      im.funcion,
	      im.nombre,
	      im.badge
        FROM
	      {$tabla1} m
	      INNER JOIN {$tabla2} im ON m.id_item = im.id 
        WHERE
	      m.id_sub_usuario = '$id_sub_usuario' AND 
          m.activo = 1 AND 
          im.activo = 1
          ORDER BY im.id ASC";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
