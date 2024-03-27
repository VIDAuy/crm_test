<?php
session_start();
session_destroy();
echo '<script>localStorage.clear();</script>';

const PRODUCCION = false;
$title = PRODUCCION ? "CRM" : "CRM_TEST";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- favicon Icon -->
    <link rel="icon" href="./assets/img/favicon.png" type="image/png">
    <title><?php echo $title; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/login.css">
    <link rel="stylesheet" href="./assets/css/tabla.css">
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4 mx-auto">
                <div class="account-wall">
                    <img class="profile-img" src="./assets/img/globito.jpg" alt="" />
                    <form class="form-signin" name="form" id="form">
                        <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Usuario" autofocus>
                        <input type="password" id="password" name="password" class="form-control mb-3" placeholder="Codigo">
                        <div class="d-flex justify-content-center">
                            <input type="button" id="boton" class="btn btn-primary btn-block" value="Ingresar" onclick="log()">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- JQUERY 2.2.3 -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- SweetAlert 2@10 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="./assets/js/log.js"></script>

</body>

</html>