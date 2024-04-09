<?php
include_once "../../configuraciones.php";
include_once '../../lib/PhpSpreadSheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

ini_set('memory_limit', '-1');
php_ini_loaded_file();
$file = $_FILES["file"];
$archivo = $_FILES["file"]["name"];
$nuevo_nombre = generarHash(50) . ".xlsx";


if (move_uploaded_file($file["tmp_name"], "../../../assets/documentos/equifax/$nuevo_nombre") === false) devolver_error("Ocurrieron errores al subir el archivo");
$nombre_archivo = "../../../assets/documentos/equifax/$nuevo_nombre";
$documento = IOFactory::load($nombre_archivo);
$total_hojas = $documento->getSheetCount();


for ($indice_hoja = 0; $indice_hoja < $total_hojas; $indice_hoja++) {
    $hoja_actual = $documento->getSheet($indice_hoja);
    $numero_filas = $hoja_actual->getHighestDataRow();
    $letra = $hoja_actual->getHighestColumn();

    for ($indice_fila = 2; $indice_fila <= $numero_filas; $indice_fila++) {
        $cedula        = $hoja_actual->getCell("A" . $indice_fila)->getValue();
        $bajas         = $hoja_actual->getCell("B" . $indice_fila)->getValue();
        $convenio      = $hoja_actual->getCell("C" . $indice_fila)->getValue();
        $enero         = $hoja_actual->getCell("D" . $indice_fila)->getValue();
        $febrero       = $hoja_actual->getCell("E" . $indice_fila)->getValue();
        $marzo         = $hoja_actual->getCell("F" . $indice_fila)->getValue();
        $abril         = $hoja_actual->getCell("G" . $indice_fila)->getValue();
        $mayo          = $hoja_actual->getCell("H" . $indice_fila)->getValue();
        $junio         = $hoja_actual->getCell("I" . $indice_fila)->getValue();
        $julio         = $hoja_actual->getCell("J" . $indice_fila)->getValue();
        $agosto        = $hoja_actual->getCell("K" . $indice_fila)->getValue();
        $septiembre    = $hoja_actual->getCell("L" . $indice_fila)->getValue();
        $octubre       = $hoja_actual->getCell("M" . $indice_fila)->getValue();
        $noviembre     = $hoja_actual->getCell("N" . $indice_fila)->getValue();
        $diciembre     = $hoja_actual->getCell("O" . $indice_fila)->getValue();


        if ($cedula != "") {
            $datos[] = [
                "cedula"     => $cedula,
                "bajas"      => $bajas = $bajas != "" || $bajas != null ? ucfirst($bajas) : $bajas,
                "convenio"   => $convenio = $convenio != "" || $convenio != null ? ucfirst($convenio) : $convenio,
                "enero"      => $enero,
                "febrero"    => $febrero,
                "marzo"      => $marzo,
                "abril"      => $abril,
                "mayo"       => $mayo,
                "junio"      => $junio,
                "julio"      => $julio,
                "agosto"     => $agosto,
                "septiembre" => $septiembre,
                "octubre"    => $octubre,
                "noviembre"  => $noviembre,
                "diciembre"  => $diciembre,
            ];
        }
    }
}

$cantidad_registros = count($datos);
$id_insert_historial = registrar_historial_carga_excel($cantidad_registros, $nuevo_nombre);
if ($id_insert_historial === true) devolver_error("Ocurrieron errores al registrar la carga del archivo");


$errores = 0;
for ($i = 0; $i < $cantidad_registros; $i++) {

    $cedula     = $datos[$i]['cedula'];
    $bajas      = $datos[$i]['bajas'];
    $convenio   = $datos[$i]['convenio'];
    $enero      = $datos[$i]['enero'];
    $febrero    = $datos[$i]['febrero'];
    $marzo      = $datos[$i]['marzo'];
    $abril      = $datos[$i]['abril'];
    $mayo       = $datos[$i]['mayo'];
    $junio      = $datos[$i]['junio'];
    $julio      = $datos[$i]['julio'];
    $agosto     = $datos[$i]['agosto'];
    $septiembre = $datos[$i]['septiembre'];
    $octubre    = $datos[$i]['octubre'];
    $noviembre  = $datos[$i]['noviembre'];
    $diciembre  = $datos[$i]['diciembre'];

    $id_registro_equifax = registrar_equifax($cedula, $bajas, $convenio, $enero, $febrero, $marzo, $abril, $mayo, $junio, $julio, $agosto, $septiembre, $octubre, $noviembre, $diciembre);
    if ($id_registro_equifax === true) $errores++;
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
        $sql = "INSERT INTO {$tabla}(referencia, nombre_archivo, cantidad_registros, fecha_carga) VALUES('Uploader Equifax', '{$nuevo_nombre}', {$cantidad_registros}, NOW())";
        $consulta = mysqli_query($conexion, $sql);
        $id_insert_historial = mysqli_insert_id($conexion);
        $error = false;
    } catch (Exception $error) {
        registrar_errores($sql, "uploader_equifax.php", $error);
        $error = true;
    }

    return $error == true ? true : $id_insert_historial;
}

function registrar_equifax($cedula, $bajas, $convenio, $enero, $febrero, $marzo, $abril, $mayo, $junio, $julio, $agosto, $septiembre, $octubre, $noviembre, $diciembre)
{
    $conexion = connection(DB);
    $tabla = TABLA_REGISTROS_EQUIFAX;
    global $id_insert_historial;

    try {
        $sql = "INSERT INTO {$tabla}(id_historial_uploaders, cedula, bajas, convenio, enero, febrero, marzo, abril, mayo, junio, julio, agosto, septiembre, octubre, noviembre, diciembre) VALUES($id_insert_historial, '$cedula', '$bajas', '$convenio', '$enero', '$febrero', '$marzo', '$abril', '$mayo', '$junio', '$julio', '$agosto', '$septiembre', '$octubre', '$noviembre', '$diciembre')";
        $consulta = mysqli_query($conexion, $sql);
        $id_historial_registro_baja = mysqli_insert_id($conexion);
        $error = false;
    } catch (Exception $error) {
        registrar_errores($sql, "uploader_equifax.php", $error);
        $error = true;
    }

    return $error == true ? true : $id_historial_registro_baja;
}
