<?php
include_once '../configuraciones.php';


$listar_usuarios = obtener_usuarios();


while ($row = mysqli_fetch_assoc($listar_usuarios)) {
    $row['id']      = strtolower($row['id']);
    $row['usuario'] = ucfirst($row['usuario']);
    $f[] = $row;
}

$respuesta = [
    'datos' => $f
];


echo json_encode($respuesta);
