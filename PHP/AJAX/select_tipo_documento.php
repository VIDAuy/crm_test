<?php
include '../conexiones/conexion2.php';
session_start();


$consulta = mysqli_query($conexion, "SELECT id, tipo FROM tipo_documento");


while ($row = mysqli_fetch_assoc($consulta)) {
    $row['id'] = strtolower($row['id']);
    $row['tipo'] = ucfirst($row['tipo']);
    $f[] = $row;
}


$respuesta = array(
    'datos' => $f
);



echo json_encode($respuesta);
