<?php
session_start();
header('Content-type: application/json; charset=utf-8');
include '../../conexiones/conexion2.php';
$sector = $_SESSION['id'];
$id_sub_usuario = $_REQUEST['id_sub_usuario'];

if ($id_sub_usuario != "") {
    $q = "SELECT cedula FROM registros WHERE envioSector = '$sector' AND activo = 1 AND cedula != '' AND id_usuario_asignado = '$id_sub_usuario'";
} else {
    $q = "SELECT cedula FROM registros WHERE envioSector = '$sector' AND activo = 1 AND cedula != ''";
}

$r = mysqli_query($conexion, $q);

$qtot = mysqli_num_rows($r);
$jsondata = ['message' => $qtot];

mysqli_close($conexion);
die(json_encode($jsondata));
