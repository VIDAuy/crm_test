<?php
session_start();
header('Content-type: application/json; charset=utf-8');
include '../conexiones/conexion2.php';
$sector = $_SESSION['id'];

$q = "SELECT cedula FROM registros WHERE envioSector = '$sector' AND activo = 1 AND cedula != ''";
$r = mysqli_query($conexion, $q);

$qtot = mysqli_num_rows($r);
$jsondata = ['message' => $qtot];

mysqli_close($conexion);
die(json_encode($jsondata));
