<?php
include_once '../../../configuraciones.php';

$tabla["data"] = [];


$obtener_usuarios = obtener_usuarios();

while ($row = mysqli_fetch_assoc($obtener_usuarios)) {
    $id                  = $row['id'];
    $usuario             = $row['usuario'];
    $codigo              = $row['codigo'];
    $nivel               = $row['nivel'];
    $filial              = $row['filial'] != "" ? $row['filial'] : "-";
    $email               = $row['email'] != "" ? $row['email'] : "-";
    $fecha_ultima_sesion = $row['fecha_ultima_sesion'] != "" ? date("d/m/Y H:i:s", strtotime($row['fecha_ultima_sesion'])) : "-";
    $acciones            = "
    <button class='btn btn-sm btn-primary' onclick='editar_usuario(true, `" . $id . "`, `" . $usuario . "`, `" . $codigo . "`, `" . $nivel . "`, `" . $filial . "`, `" . $email . "`);'>✏</button>
    <button class='btn btn-sm btn-danger' onclick='eliminar_usuario(`" . $id . "`);'>❌</button>";



    $tabla["data"][] = [
        'id'                  => $id,
        'usuario'             => $usuario,
        'codigo'              => $codigo,
        'nivel'               => $nivel,
        'filial'              => $filial,
        'email'               => $email,
        'fecha_ultima_sesion' => $fecha_ultima_sesion,
        'acciones'            => $acciones,
    ];
}

echo json_encode($tabla);
