<?php
require '../conexiones/conexion113.php';

$response = array('success' => false);
$query = 'SELECT count(*)  AS cantidad from padron_datos_socio WHERE estado IN (673, 686, 690)';

if (($res = mysqli_query($mysqli113, $query)) && mysqli_num_rows($res) > 0) {
    $response = array('success' => true, 'cantidad' => mysqli_fetch_assoc($res)['cantidad']);
}

mysqli_close($mysqli113);
die(json_encode($response));
