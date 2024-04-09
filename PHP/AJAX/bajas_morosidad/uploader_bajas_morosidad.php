<?php
include_once "../../configuraciones.php";
include_once '../../lib/PhpSpreadSheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

ini_set('memory_limit', '-1');
php_ini_loaded_file();
$file = $_FILES["file"];
$archivo = $_FILES["file"]["name"];
$nuevo_nombre = generarHash(50) . ".xlsx";


if (move_uploaded_file($file["tmp_name"], "../../../assets/documentos/bajas_morosidad/$nuevo_nombre") === false) devolver_error("Ocurrieron errores al subir el archivo");
$nombre_archivo = "../../../assets/documentos/bajas_morosidad/$nuevo_nombre";
$documento = IOFactory::load($nombre_archivo);
$total_hojas = $documento->getSheetCount();


for ($indice_hoja = 0; $indice_hoja < $total_hojas; $indice_hoja++) {
    $hoja_actual = $documento->getSheet($indice_hoja);
    $numero_filas = $hoja_actual->getHighestDataRow();
    $letra = $hoja_actual->getHighestColumn();

    for ($indice_fila = 2; $indice_fila <= $numero_filas; $indice_fila++) {
        $cedula = $hoja_actual->getCell("A" . $indice_fila)->getValue();

        if ($cedula != "")
            $datos[] = [
                "cedula" => $cedula
            ];
    }
}

$cantidad_registros = count($datos);
$id_insert_historial = registrar_historial_carga_excel($cantidad_registros, $nuevo_nombre);
if ($id_insert_historial === true) devolver_error("Ocurrieron errores al registrar la carga del archivo");


$errores = 0;
for ($i = 0; $i < $cantidad_registros; $i++) {

    $cedula = $datos[$i]['cedula'];

    $datos_padron = obtener_datos_padron($cedula);
    if (count($datos_padron) == 0) $errores++;
    $nombre   = $datos_padron['nombre'];
    $telefono = $datos_padron['tel'];
    $telefono = buscarCelular($telefono)[0];
    if (intval($telefono) == 0 || $telefono == "" || !is_numeric($telefono)) $telefono = 0;

    $dejar_registro_crm = dejar_registro_crm($cedula, $nombre, $telefono);
    if ($dejar_registro_crm === true) $errores++;

    $id_registro_bajas_morosidad = registrar_bajas_morosidad($cedula);
    if ($id_registro_bajas_morosidad === true) $errores++;

    $baja_padron_datos_socios = dar_baja_padron_datos_socios($cedula);
    if ($baja_padron_datos_socios === true) $errores++;

    $baja_padron_productos_socio = dar_baja_padron_productos_socio($cedula);
    if ($baja_padron_productos_socio === true) $errores++;
}
if ($errores > 0) devolver_error("Hubo errores al guardar la información");



$response['error'] = false;
$response['mensaje'] = "Se guardaron los datos con éxito";
echo json_encode($response);




function registrar_historial_carga_excel($cantidad_registros, $nuevo_nombre)
{
    $conexion = connection(DB);
    $tabla = TABLA_HISTORIAL_UPLOADERS;

    try {
        $sql = "INSERT INTO {$tabla} (referencia, nombre_archivo, cantidad_registros, fecha_carga) VALUES ('Uploader Bajas Morosidad', '{$nuevo_nombre}', {$cantidad_registros}, NOW())";
        $consulta = mysqli_query($conexion, $sql);
        $id_insert_historial = mysqli_insert_id($conexion);
        $return = false;
    } catch (Exception $error) {
        registrar_errores($sql, "uploader_bajas_morosidad.php", $error);
        $return = true;
    }

    return $return == true ? true : $id_insert_historial;
}

function registrar_bajas_morosidad($cedula)
{
    $conexion = connection(DB);
    $tabla = TABLA_BAJAS_MOROSIDAD;
    global $id_insert_historial;

    try {
        $sql = "INSERT INTO {$tabla} (id_historial_uploaders, cedula) VALUES ($id_insert_historial, '$cedula')";
        $consulta = mysqli_query($conexion, $sql);
    } catch (Exception $error) {
        registrar_errores($sql, "uploader_bajas_morosidad.php", $error);
    }

    return $consulta;
}

function obtener_datos_padron($cedula)
{
    $conexion = connection(DB_ABMMOD);
    $tabla = TABLA_PADRON_DATOS_SOCIO;

    try {
        $sql = "SELECT * FROM {$tabla} WHERE cedula = '$cedula'";
        $consulta = mysqli_query($conexion, $sql);
    } catch (Exception $error) {
        registrar_errores($sql, "uploader_bajas_morosidad.php", $error);
    }

    return mysqli_fetch_assoc($consulta);
}

function dejar_registro_crm($cedula, $nombre, $telefono)
{
    $conexion = connection(DB);
    $tabla = TABLA_REGISTROS;

    try {
        $sql = "INSERT INTO {$tabla} (cedula, nombre, telefono, fecha_registro, sector, observaciones, socio, baja) VALUES ('$cedula', '$nombre', '$telefono', NOW(), 'Sistema', 'Baja por morosidad', 0, 1)";
        $consulta = mysqli_query($conexion, $sql);
    } catch (Exception $error) {
        registrar_errores($sql, "uploader_bajas_morosidad.php", $error);
    }

    return $consulta;
}

function dar_baja_padron_datos_socios($cedula)
{
    $conexion = connection(DB_ABMMOD);
    $tabla = TABLA_PADRON_DATOS_SOCIO;

    try {
        $sql = "UPDATE {$tabla} SET abmactual = 1, abm = 'baja', observaciones = 'Baja por morosidad' WHERE cedula = '$cedula'";
        $consulta = mysqli_query($conexion, $sql);
    } catch (Exception $error) {
        registrar_errores($sql, "uploader_bajas_morosidad.php", $error);
    }

    return $consulta;
}

function dar_baja_padron_productos_socio($cedula)
{
    $conexion = connection(DB_ABMMOD);
    $tabla = TABLA_PADRON_PRODUCTO_SOCIO;

    try {
        $sql = "UPDATE {$tabla} SET abmactual = 1, abm = 'baja' WHERE cedula = '$cedula'";
        $consulta = mysqli_query($conexion, $sql);
    } catch (Exception $error) {
        registrar_errores($sql, "uploader_bajas_morosidad.php", $error);
    }

    return $consulta;
}
