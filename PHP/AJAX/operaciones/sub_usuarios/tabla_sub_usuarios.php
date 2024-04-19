<?php
include_once '../../../configuraciones.php';

$tabla["data"] = [];


$obtener_sub_usuarios = obtener_sub_usuarios();

while ($row = mysqli_fetch_assoc($obtener_sub_usuarios)) {
    $id          = $row['id'];
    $area        = ucfirst(obtener_datos_usuario($row['id_sector'])['usuario']);
    $nombre      = $row['nombre'];
    $apellido    = $row['apellido'];
    $cedula      = $row['cedula'];
    $gestor      = $row['gestor'] != 0 ? "<span class='text-success'> Si </span>" : "<span class='text-danger'> No </span>";
    $btnEditar   = "<button class='btn btn-sm btn-primary' onclick='editar_sub_usuario(true, `" . $row['id'] . "`, `" . $row['id_sector'] . "`, `" . $area . "`, `" . $row['nombre'] . "`, `" . $row['apellido'] . "`, `" . $row['cedula'] . "`, `" . $row['gestor'] . "`);'>✏</button>";
    $btnEliminar = "<button class='btn btn-sm btn-danger' onclick='eliminar_sub_usuario(`" . $id . "`);'>❌</button>";

    $tabla["data"][] = [
        'id'       => $id,
        'area'     => $area,
        'nombre'   => $nombre,
        'apellido' => $apellido,
        'cedula'   => $cedula,
        'gestor'   => $gestor,
        'acciones' => "$btnEditar $btnEliminar",
    ];
}

echo json_encode($tabla);
