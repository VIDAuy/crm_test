<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');

$dbhost = '192.168.1.13';
$dbusuario = 'root';
$dbpassword = 'sist.2k8';
$db = 'call';
$mysqli113 = mysqli_connect($dbhost, $dbusuario, $dbpassword, $db);
if (mysqli_connect_errno()) {
    echo 'Error: No se pudo conectar a MySQL.' . '<br>';
    echo 'error de depuración: ' . mysqli_connect_errno() . '<br>';
    echo 'error de depuración: ' . mysqli_connect_error() . '<br>';
    die();
}
