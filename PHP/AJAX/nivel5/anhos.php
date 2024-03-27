<?php
    include('../../conexiones/conexion2.php');
    $mysqli = new mysqli($dbhost, $dbusuario, $dbpassword, $db);

    $q = "SELECT DISTINCT anho_registro
            FROM pagos_rechazados
            ORDER BY anho_registro";
    $r = $mysqli->query($q);
    while($row = $r->fetch_row()){
        $respuesta[] = array(
            'anho' => $row[0]
        );
    }
    echo json_encode($respuesta);