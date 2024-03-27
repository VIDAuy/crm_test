<?
date_default_timezone_set('America/Argentina/Buenos_Aires');
$dbhost      = "192.168.13.10";    // host del MySQL (generalmente localhost)
$dbusuario   = "root";            // aqui debes ingresar el nombre de usuario
$dbpassword  = "sist.2k8";        // password de acceso para el usuario de la
$db          = "comag";    // Seleccionamos la base con la cual
$conexion    = mysqli_connect($dbhost, $dbusuario, $dbpassword, $db);
if (!$conexion) {
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "error de depuración: " . mysqli_connect_errno() . PHP_EOL;
    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
