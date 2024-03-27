<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
$serverName        = '192.168.252.12\NODUMBD,1433';
$connectionInfo    = array(
    'Database'    => 'Modelo_RSE',
    'UID'        => 'consultas',
    'PWD'        => 'consultas.2k19',
    'Characterset'    => (string)    'UTF-8'
);
$conexion = sqlsrv_connect($serverName, $connectionInfo);

if (!$conexion) {
    echo "Conexión no se pudo establecer.<br />";
    die(print_r(sqlsrv_errors(), true));
}
