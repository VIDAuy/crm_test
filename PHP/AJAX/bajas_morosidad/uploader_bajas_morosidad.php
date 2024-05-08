<?php
include_once "../../configuraciones.php";
include_once '../../lib/PhpSpreadSheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

ini_set('memory_limit', '-1');
php_ini_loaded_file();
$file = $_FILES["file"];
$archivo = $_FILES["file"]["name"];
$nuevo_nombre = generarHash(50) . ".xlsx";


/** Guardo el archivo en el servidor **/
if (move_uploaded_file($file["tmp_name"], "../../../assets/documentos/bajas_morosidad/$nuevo_nombre") === false) devolver_error("Ocurrieron errores al subir el archivo");
$nombre_archivo = "../../../assets/documentos/bajas_morosidad/$nuevo_nombre";
$documento = IOFactory::load($nombre_archivo);
$total_hojas = $documento->getSheetCount();



/** Proceso para procesar el excel y obtener la cédula, nombre y teléfono para generar un array **/
for ($indice_hoja = 0; $indice_hoja < $total_hojas; $indice_hoja++) {
    $hoja_actual = $documento->getSheet($indice_hoja);
    $numero_filas = $hoja_actual->getHighestDataRow();
    $letra = $hoja_actual->getHighestColumn();

    for ($indice_fila = 2; $indice_fila <= $numero_filas; $indice_fila++) {
        $cedula   = $hoja_actual->getCell("A" . $indice_fila)->getValue();
        $nombre   = $hoja_actual->getCell("B" . $indice_fila)->getValue();
        $telefono = $hoja_actual->getCell("C" . $indice_fila)->getValue();


        if ($cedula != "") {
            $obtener_datos_padron = obtener_datos_padron($cedula);
            if (is_array($obtener_datos_padron)) {
                $nombre = $obtener_datos_padron['nombre'];
                $telefono = $obtener_datos_padron['tel'];
            }

            $telefono = corregirTelefono($telefono);
            $telefono = buscarNumero($telefono);


            $datos[] = [
                "cedula"   => $cedula,
                "nombre"   => $nombre,
                "telefono" => $telefono,
            ];
        }
    }
}



/** Guardo el historial de carga **/
$cantidad_registros = count($datos);
$id_insert_historial = registrar_historial_carga_excel($cantidad_registros, $nuevo_nombre);
if ($id_insert_historial === true) devolver_error("Ocurrieron errores al registrar la carga del archivo");




/** Proceso para registrar en registros de crm y en bajas morosidad **/
$errores = 0;
$mensaje = "";
for ($i = 0; $i < $cantidad_registros; $i++) {
    $cedula   = $datos[$i]['cedula'];
    $nombre   = $datos[$i]['nombre'];
    $telefono = $datos[$i]['telefono'];


    $dejar_registro_crm = dejar_registro_crm($cedula, $nombre, $telefono);
    if ($dejar_registro_crm === false) {
        $errores++;
        $mensaje .= "Error al registrar cédula: $cedula, nombre: $nombre y teléfono: $telefono";
    }

    $id_registro_bajas_morosidad = registrar_bajas_morosidad($cedula);
    if ($id_registro_bajas_morosidad === false) {
        $errores++;
        $mensaje .= "Error al registrar cédula: $cedula";
    }
}



$response['error'] = $errores > 0 ? true : false;
$response['mensaje'] = $mensaje == "" ? "Se guardaron los datos con éxito" : $mensaje;
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

function dejar_registro_crm($cedula, $nombre, $telefono)
{
    include '../../conexiones/conexion2.php';
    $tabla = TABLA_REGISTROS;

    try {
        $sql = "INSERT INTO {$tabla} (cedula, nombre, telefono, fecha_registro, sector, observaciones, socio, baja) VALUES ('$cedula', '$nombre', '$telefono', NOW(), 'Sistema', 'Baja por morosidad', 0, 1)";
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
        $sql = "SELECT nombre, tel FROM {$tabla} WHERE cedula = '$cedula' ORDER BY id DESC LIMIT 1";
        $consulta = mysqli_query($conexion, $sql);
    } catch (Exception $error) {
        registrar_errores($sql, "uploader_bajas_morosidad.php", $error);
        $consulta = false;
    }

    if ($consulta === false) devolver_error("Ocurrieron errores al realizar la consulta");
    $resultados = mysqli_num_rows($consulta) > 0 ? mysqli_fetch_assoc($consulta) : false;

    return $resultados;
}
