<?php
    include('../../conexiones/conexion2.php');
    $mysqli = new mysqli($dbhost, $dbusuario, $dbpassword, $db);
    $id = $_GET['id'];

    $q = "SELECT rpr.cedula, tipo_de_cobro, observacion 
            FROM registros_pagos_rechazados AS rpr
                INNER JOIN pagos_rechazados AS pr
                    ON pr.id = rpr.id_referencia
            WHERE rpr.id = $id";
    $r = $mysqli->query($q);

    if ($r){
        $f = $r->fetch_assoc();
        $respuesta = array(
            'correcto'      => true,
            'observacion'   => $f['observacion'],
            'tipoCobro'     => $f['tipo_de_cobro'],
            'cedula'        => $f['cedula']
        );
        $q = "UPDATE registros_pagos_rechazados
                SET mostrar_opcional = null
                WHERE id = $id";
        $r = $mysqli->query($q);
    } else {
        $respuesta = array(
            'error' => true,
            'mensaje' => 'Ha ocurrido un error'
        );
    }

    echo json_encode($respuesta);