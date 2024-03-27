<?php
$produccion = false;
$user = 'root';
$password = 'root';
$host = 'localhost';
$database = $produccion ? 'crm' : 'crm_test';

$mysqli = new mysqli($host, $user, $password, $database);

if (!$mysqli) die('Error al conectar a la base de datos');
