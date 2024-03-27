<?php
$produccion = false;

$host = 'localhost';
$user = 'root';
$pass = 'root';
$base = $produccion ? 'crm' : 'crm_test';

if (mysqli_connect($host, $user, $pass, $base)) {
    return $mysqli = new mysqli($host, $user, $pass, $base);
} else {
    return mysqli_connect_errno() . PHP_EOL;
}
