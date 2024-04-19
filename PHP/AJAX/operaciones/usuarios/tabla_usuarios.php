<?php
include_once '../../../configuraciones.php';

$tabla["data"] = [];


$obtener_usuarios = obtener_usuarios();

while ($row = mysqli_fetch_assoc($obtener_usuarios)) {
    $id       = $row['id'];
    $usuario  = $row['usuario'];
    $codigo   = $row['codigo'];
    $nivel    = $row['nivel'];
    $filial   = $row['filial'] != "" ? $row['filial'] : "-";
    $email    = $row['email'] != "" ? $row['email'] : "-";
    $acciones = "<button class='btn btn-sm btn-danger' onclick='eliminar_usuario(`" . $id . "`);'>❌</button>";

    $tabla["data"][] = [
        'id'       => $id,
        'usuario'  => $usuario,
        'codigo'   => $codigo,
        'nivel'    => $nivel,
        'filial'   => $filial,
        'email'    => $email,
        'acciones' => $acciones,
    ];
}

echo json_encode($tabla);
