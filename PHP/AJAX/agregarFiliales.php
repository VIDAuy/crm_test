<?php
    include '../conexiones/conexion2.php';
    session_start();
    if(isset($_SESSION['id']))
    {
        $id = $_SESSION['id'];
        $q = "SELECT id, usuario FROM usuarios WHERE id != 43 ORDER BY usuario ASC";
        $r = mysqli_query($conexion, $q);
        while($row = mysqli_fetch_assoc($r))
        {
            $row['usuario'] = strtolower($row['usuario']);
            $row['usuario'] = ucfirst($row['usuario']);
            $f[] = $row;
        }
        $respuesta = array(
            'datos' => $f
        );
        echo json_encode($respuesta);
    }
    else
    {
        header('location: ../../');
    }