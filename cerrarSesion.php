<?php
session_start();
$array_variables_sesion = ["usuario", "nivel", "filial", "id", "id_sub_usuario", "id_sector", "sector", "cedula", "nombre", "apellido", "gestor"];
foreach ($array_variables_sesion as $variable_sesion) {
    unset($_SESSION[$variable_sesion]);
}
header('location: login.php');
