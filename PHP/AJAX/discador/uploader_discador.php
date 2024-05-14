<?php
include_once "../../configuraciones.php";
include_once '../../lib/PhpSpreadSheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

ini_set('memory_limit', '-1');
php_ini_loaded_file();
$file = $_FILES["file"];
$archivo = $_FILES["file"]["name"];
$tipo_discador = $_REQUEST['tipo_discador'];
$nuevo_nombre = generarHash(50) . ".xlsx";


$dar_baja_registros_equifax = dar_baja_registros_discador($tipo_discador);
if ($dar_baja_registros_equifax === false) devolver_error("Ha ocurrido un error al intentar vaciar la tabla");


if (move_uploaded_file($file["tmp_name"], "../../../assets/documentos/discador/$nuevo_nombre") === false) devolver_error("Ocurrieron errores al subir el archivo");
$nombre_archivo = "../../../assets/documentos/discador/$nuevo_nombre";
$documento = IOFactory::load($nombre_archivo);
$total_hojas = $documento->getSheetCount();


for ($indice_hoja = 0; $indice_hoja < $total_hojas; $indice_hoja++) {
    $hoja_actual = $documento->getSheet($indice_hoja);
    $numero_filas = $hoja_actual->getHighestDataRow();
    $letra = $hoja_actual->getHighestColumn();

    for ($indice_fila = 13; $indice_fila <= $numero_filas; $indice_fila++) {

        //Datos de contacto
        $cedula_datos_contacto                = $hoja_actual->getCell("A" . $indice_fila)->getValue();
        $name_datos_contacto                  = $hoja_actual->getCell("B" . $indice_fila)->getValue();
        $numcall_datos_contacto               = $hoja_actual->getCell("C" . $indice_fila)->getValue();
        $enable_datos_contacto                = $hoja_actual->getCell("D" . $indice_fila)->getValue();
        //Datos Adicionales
        $columna1_datos_adicionales           = $hoja_actual->getCell("E" . $indice_fila)->getValue();
        $columna2_datos_adicionales           = $hoja_actual->getCell("F" . $indice_fila)->getValue();
        $columna3_datos_adicionales           = $hoja_actual->getCell("G" . $indice_fila)->getValue();
        $columna4_datos_adicionales           = $tipo_discador == 1 ? $hoja_actual->getCell("H" . $indice_fila)->getValue() : "";


        if ($tipo_discador == 1) {

            //Datos de actividad
            $state_datos_actividad            = $hoja_actual->getCell("I" . $indice_fila)->getValue();
            $statetimestamp_datos_actividad   = $hoja_actual->getCell("J" . $indice_fila)->getValue();
            $lastattempt_datos_actividad      = $hoja_actual->getCell("K" . $indice_fila)->getValue();
            $attempttimestamp_datos_actividad = $hoja_actual->getCell("L" . $indice_fila)->getValue();
            $billsec_datos_actividad          = $hoja_actual->getCell("M" . $indice_fila)->getValue();
            $uniqueid_datos_actividad         = $hoja_actual->getCell("N" . $indice_fila)->getValue();
            //Datos de ejecución
            $option_datos_ejecucion           = $hoja_actual->getCell("O" . $indice_fila)->getValue();
            $description_datos_ejecucion      = $hoja_actual->getCell("P" . $indice_fila)->getValue();
        }

        if (in_array($tipo_discador, [2, 3])) {
            //Datos de actividad
            $state_datos_actividad            = $hoja_actual->getCell("H" . $indice_fila)->getValue();
            $statetimestamp_datos_actividad   = $hoja_actual->getCell("I" . $indice_fila)->getValue();
            $lastattempt_datos_actividad      = $hoja_actual->getCell("J" . $indice_fila)->getValue();
            $attempttimestamp_datos_actividad = $hoja_actual->getCell("K" . $indice_fila)->getValue();
            $billsec_datos_actividad          = $hoja_actual->getCell("L" . $indice_fila)->getValue();
            $uniqueid_datos_actividad         = $hoja_actual->getCell("M" . $indice_fila)->getValue();
            //Datos de ejecución
            $option_datos_ejecucion           = $hoja_actual->getCell("N" . $indice_fila)->getValue();
            $description_datos_ejecucion      = $hoja_actual->getCell("O" . $indice_fila)->getValue();
        }


        if ($cedula_datos_contacto != "") {
            $datos[] = [
                $cedula_datos_contacto,
                $name_datos_contacto,
                $numcall_datos_contacto,
                $enable_datos_contacto,
                $columna1_datos_adicionales,
                $columna2_datos_adicionales,
                $columna3_datos_adicionales,
                $columna4_datos_adicionales,
                $state_datos_actividad,
                $statetimestamp_datos_actividad,
                $lastattempt_datos_actividad,
                $attempttimestamp_datos_actividad,
                $billsec_datos_actividad,
                $uniqueid_datos_actividad,
                $option_datos_ejecucion,
                $description_datos_ejecucion,
            ];
        }
    }
}

$cantidad_registros = count($datos);
$id_insert_historial = registrar_historial_carga_excel($cantidad_registros, $nuevo_nombre);
if ($id_insert_historial === true) devolver_error("Ocurrieron errores al registrar la carga del archivo");


$errores = 0;
for ($i = 0; $i < $cantidad_registros; $i++) {

    $cedula_datos_contacto            = $datos[$i][0];
    $name_datos_contacto              = $datos[$i][1];
    $numcall_datos_contacto           = $datos[$i][2];
    $enable_datos_contacto            = $datos[$i][3];
    $columna1_datos_adicionales       = $datos[$i][4];
    $columna2_datos_adicionales       = $datos[$i][5];
    $columna3_datos_adicionales       = $datos[$i][6];
    $columna4_datos_adicionales       = $datos[$i][7];
    $state_datos_actividad            = $datos[$i][8];
    $statetimestamp_datos_actividad   = $datos[$i][9];
    $lastattempt_datos_actividad      = $datos[$i][10];
    $attempttimestamp_datos_actividad = $datos[$i][11];
    $billsec_datos_actividad          = $datos[$i][12];
    $uniqueid_datos_actividad         = $datos[$i][13];
    $option_datos_ejecucion           = $datos[$i][14];
    $description_datos_ejecucion      = $datos[$i][15];


    $id_registro_equifax = registrar_discador($tipo_discador, $cedula_datos_contacto, $name_datos_contacto, $numcall_datos_contacto, $enable_datos_contacto, $columna1_datos_adicionales, $columna2_datos_adicionales, $columna3_datos_adicionales, $columna4_datos_adicionales, $state_datos_actividad, $statetimestamp_datos_actividad, $lastattempt_datos_actividad, $attempttimestamp_datos_actividad, $billsec_datos_actividad, $uniqueid_datos_actividad, $option_datos_ejecucion, $description_datos_ejecucion);
    if ($id_registro_equifax === true) $errores++;
}
if ($errores > 0) devolver_error("Hubo errores al guardar la información");



$response['error'] = false;
$response['mensaje'] = "Se guardaron los datos con éxito";
echo json_encode($response);




function dar_baja_registros_discador($tipo_discador)
{
    $conexion = connection(DB);
    $tabla = TABLA_REGISTROS_DISCADOR;

    try {
        $sql = "UPDATE {$tabla} SET activo = 0 WHERE activo = 1 AND id_tipo_discador = '$tipo_discador'";
        $consulta = mysqli_query($conexion, $sql);
    } catch (Exception $error) {
        registrar_errores($sql, "uploader_discador.php", $error);
        $consulta = false;
    }

    return $consulta;
}

function registrar_historial_carga_excel($cantidad_registros, $nuevo_nombre)
{
    $conexion = connection(DB);
    $tabla = TABLA_HISTORIAL_UPLOADERS;

    try {
        $sql = "INSERT INTO {$tabla}(referencia, nombre_archivo, cantidad_registros, fecha_carga) VALUES('Uploader Discador', '{$nuevo_nombre}', {$cantidad_registros}, NOW())";
        $consulta = mysqli_query($conexion, $sql);
        $id_insert_historial = mysqli_insert_id($conexion);
        $error = false;
    } catch (Exception $error) {
        registrar_errores($sql, "uploader_discador.php", $error);
        $error = true;
    }

    return $error == true ? true : $id_insert_historial;
}

function registrar_discador($tipo_discador, $cedula_datos_contacto, $name_datos_contacto, $numcall_datos_contacto, $enable_datos_contacto, $columna1_datos_adicionales, $columna2_datos_adicionales, $columna3_datos_adicionales, $columna4_datos_adicionales, $state_datos_actividad, $statetimestamp_datos_actividad, $lastattempt_datos_actividad, $attempttimestamp_datos_actividad, $billsec_datos_actividad, $uniqueid_datos_actividad, $option_datos_ejecucion, $description_datos_ejecucion)
{
    $conexion = connection(DB);
    $tabla = TABLA_REGISTROS_DISCADOR;
    global $id_insert_historial;

    try {
        $sql = "INSERT INTO {$tabla} (
            id_historial_uploader, 
            id_tipo_discador, 
            cedula_datos_contacto, 
            name_datos_contacto, 
            numcall_datos_contacto, 
            enable_datos_contacto, 
            columna1_datos_adicionales,
            columna2_datos_adicionales,
            columna3_datos_adicionales,
            columna4_datos_adicionales,
            state_datos_actividad, 
            statetimestamp_datos_actividad, 
            lastattempt_datos_actividad, 
            attempttimestamp_datos_actividad, 
            billsec_datos_actividad, 
            uniqueid_datos_actividad, 
            option_datos_ejecucion, 
            descripcion_datos_ejecucion
            ) VALUES (
                '$id_insert_historial', 
                '$tipo_discador', 
                '$cedula_datos_contacto',
                '$name_datos_contacto',
                '$numcall_datos_contacto',
                '$enable_datos_contacto',
                '$columna1_datos_adicionales',
                '$columna2_datos_adicionales',
                '$columna3_datos_adicionales',
                '$columna4_datos_adicionales',
                '$state_datos_actividad',
                '$statetimestamp_datos_actividad',
                '$lastattempt_datos_actividad',
                '$attempttimestamp_datos_actividad',
                '$billsec_datos_actividad',
                '$uniqueid_datos_actividad',
                '$option_datos_ejecucion',
                '$description_datos_ejecucion'
            )";
        $consulta = mysqli_query($conexion, $sql);
        $id_historial_registro_baja = mysqli_insert_id($conexion);
        $error = false;
    } catch (Exception $error) {
        registrar_errores($sql, "uploader_discador.php", $error);
        $error = true;
    }

    return $error == true ? true : $id_historial_registro_baja;
}

function obtener_nombre($cedula)
{
    $conexion = connection(DB_ABMMOD);
    $tabla = TABLA_PADRON_DATOS_SOCIO;

    try {
        $sql = "SELECT * FROM {$tabla} WHERE cedula = '$cedula'";
        $consulta = mysqli_query($conexion, $sql);
    } catch (Exception $error) {
        registrar_errores($sql, "uploader_discador.php", $error);
        $consulta = false;
    }

    $respuesta = $consulta != false && mysqli_num_rows($consulta) > 0 ? mysqli_fetch_assoc($consulta) : false;

    return $respuesta;
}
