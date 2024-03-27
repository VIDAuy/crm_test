<?php
    include('../../conexiones/conexion2.php');
    $mysqli = new mysqli($dbhost, $dbusuario, $dbpassword, $db);
    $cedula = $_GET['ci'];

    $q      = "SELECT id FROM pagos_rechazados WHERE cedula = $cedula LIMIT 1";
    $r      = $mysqli->query($q);

    $id = $r->fetch_assoc();
    $id = $id['id'];

    $id = ($_GET['pasar'] == 'siguiente')
        ? ++$id
        : --$id;

    $q      = "SELECT cedula FROM pagos_rechazados WHERE id = $id";
    $r      = $mysqli->query($q);

    $cedula = $r->fetch_assoc();
    $cedula = array(
        'cedula' => (int) $cedula['cedula']
    );

    echo json_encode($cedula);