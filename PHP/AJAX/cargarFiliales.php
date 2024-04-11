<?php
include('../conexiones/conexion.php');
$mysqli = new mysqli($dbhost, $dbusuario, $dbpassword, $db);

$q = "SELECT nro_filial, filial FROM filiales_codigos WHERE activo = 1 AND pais = 'Uruguay' ORDER BY filial";
$r = $mysqli->query($q);

while ($row = $r->fetch_assoc()) {
    if ($row['filial'] != 'Acompañar' && $row['filial'] != 'Acompañar Colonia' && $row['filial'] != 'Inspira' && $row['filial'] != 'Núcleo') {
        $f[] = $row;
    }
}


echo json_encode($f);
