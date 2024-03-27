<?
date_default_timezone_set('America/Argentina/Buenos_Aires');
$dbhost      = "192.168.252.20";    // host del MySQL (generalmente localhost)
$dbusuario   = "consultas";            // aqui debes ingresar el nombre de usuario
$dbpassword  = "2k8.vida";        // password de acceso para el usuario de la
$db          = "moodle_vida";    // Seleccionamos la base con la cual
$conexion    = mysqli_connect($dbhost, $dbusuario, $dbpassword, $db);
if (!$conexion) {
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "error de depuración: " . mysqli_connect_errno() . PHP_EOL;
    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
