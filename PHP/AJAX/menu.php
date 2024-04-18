<?php
include_once '../configuraciones.php';

$id_area = $_SESSION['id'];

$obtener_items = obtener_menu($id_area);


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
$response['items_menu'] = $items_menu;
echo json_encode($response);




function obtener_menu($id_area)
{
    $conexion = connection(DB);
    $tabla1 = TABLA_MENU;
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
	      m.id_usuario = '$id_area' AND 
          m.activo = 1 AND 
          im.activo = 1
          ORDER BY im.id ASC";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
