<?php

/** Obtener todos los usuarios **/
function obtener_usuarios()
{
    $conexion = connection(DB);
    $tabla = TABLA_USUARIOS;
    $sql = "SELECT * FROM {$tabla} ORDER BY usuario ASC";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}

/** Obtener datos de usuario mediante id **/
function obtener_datos_usuario($id)
{
    $conexion = connection(DB);
    $tabla = TABLA_USUARIOS;
    $sql = "SELECT * FROM {$tabla} WHERE id = '$id' ORDER BY id DESC LIMIT 1";
    $consulta = mysqli_query($conexion, $sql);
    $resultado = mysqli_fetch_assoc($consulta);

    return $resultado;
}

/** Verificar si es socio **/
function es_socio($cedula)
{
    $conexion = connection(DB);
    $tabla = TABLA_REGISTROS;
    $sql = "SELECT socio FROM {$tabla} WHERE cedula = '$cedula' ORDER BY id DESC LIMIT 1";
    $consulta = mysqli_query($conexion, $sql);
    return mysqli_fetch_assoc($consulta)['socio'];
}

/** Verificar si esta dado de baja **/
function esta_en_baja($cedula)
{
    $conexion = connection(DB);
    $tabla = TABLA_REGISTROS;
    $sql = "SELECT baja FROM {$tabla} WHERE cedula = '$cedula' ORDER BY id DESC LIMIT 1";
    $consulta = mysqli_query($conexion, $sql);
    return mysqli_fetch_assoc($consulta)['baja'];
}

/** Registrar errores en la base de datos **/
function registrar_errores($consulta, $nombre_archivo, $error)
{
    $conexion = connection(DB);
    $tabla = TABLA_LOG_ERRORES;

    $consulta = str_replace("'", '"', $consulta);
    $error = str_replace("'", '"', $error);

    $sql = "INSERT INTO {$tabla} (consulta, nombre_archivo, error, fecha_registro) VALUES ('$consulta', '$nombre_archivo', '$error', NOW())";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}

/** Obtener auditorias del socio **/
function obtener_comentarios_auditoria($id)
{
    $conexion = connection(DB);
    $tabla = TABLA_COMENTARIO_AUDITORIAS_SOCIO;

    $sql = "SELECT * FROM {$tabla} WHERE id_auditoria_socio = '$id' AND activo = 1";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}

/** Obtener el nombre y apellido de la tabla sub_usuarios **/
function obtener_nombre_sub_usuario($id_sub_usuario)
{
    $conexion = connection(DB);
    $tabla = TABLA_SUB_USUARIOS;

    $sql = "SELECT nombre, apellido FROM {$tabla} WHERE id = '$id_sub_usuario'";
    $consulta = mysqli_query($conexion, $sql);
    $resultado = mysqli_fetch_assoc($consulta);

    return $resultado['nombre'] . " " . $resultado['apellido'];
}

/** Generar color random **/
function randomColor()
{
    $str = "#";
    for ($i = 0; $i < 6; $i++) {
        $randNum = rand(0, 15);
        switch ($randNum) {
            case 10:
                $randNum = "A";
                break;
            case 11:
                $randNum = "B";
                break;
            case 12:
                $randNum = "C";
                break;
            case 13:
                $randNum = "D";
                break;
            case 14:
                $randNum = "E";
                break;
            case 15:
                $randNum = "F";
                break;
        }
        $str .= $randNum;
    }
    return $str;
}

/** Reemplazar acento en string **/
function remplazarAcentos($texto)
{
    //  $texto_parseado = eliminarAcentos($texto);
    $texto_parseado = $texto;

    $remplazar_array = array(
        "'" => '', '"' => ' ', '`' => ' ', '`' => '',
        'Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A',
        'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',  'Ò' => 'O', 'Ó' => 'O',
        'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e',
        'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o',  'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
        'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', 'Ñ' => 'N', 'ñ' => 'n', '°' => ' ', 'Â' => ' ',
        'â' => 'a', '™' => ' ', '€' => '', 'Âº' => '', '/' => '/'
    );

    $texto_parseado = strtr($texto_parseado, $remplazar_array);
    $texto_parseado = preg_replace('([^A-Za-z0-9 ])', '', $texto_parseado);
    return $texto_parseado;
}

/** Eliminar acento en string **/
function eliminarAcentos($cadena)
{
    $especial = @utf8_decode('ÁÀÂÄáàäâªÉÈÊËéèëêÍÌÏÎíìïîÓÒÖÔóòöôÚÙÛÜúùüûÑñÇç³€™º');
    $reemplazar = @utf8_decode('AAAAaaaaaEEEEeeeeIIIIiiiiOOOOooooUUUUuuuuNnCcA    ');
    for ($i = 0; $i <= strlen($cadena); $i++) {
        for ($f = 0; $f < strlen($especial); $f++) {
            $caracteri = substr($cadena, $i, 1);
            $caracterf = substr($especial, $f, 1);
            if ($caracteri === $caracterf) {
                $cadena = substr($cadena, 0, $i) . substr($reemplazar, $f, 1) . substr($cadena, $i + 1);
            }
        }
    }
    return  $cadena;
}

/** Corregir número de teléfono */
function corregirTelefono($var)
{
    // CORRECCIÓN Y ASIGNACIÓN DE TELÉFONO

    //EN CASO DE QUE EL TELÉFONO EMPIECE CON '0' Y UN ESPACIO LOS QUITA DE LA VARIABLE
    if (mb_substr($var, 0, 2) == '0 ') {
        $var = mb_substr($var, 2, 20);
    }

    //REEMPLAZA TODOS LOS ESPACIOS QUE TENGA LA VARIABLE
    $var = str_replace(' ', '', $var);

    if ($var[0] == 9) {
        $var = 0 . $var;
    }

    //EN CASO DE QUE EL NÚMERO EMPIECE CON 09 Y TENGA MÁS DE 8 CARACTÉRES SE LE ASIGNA ESE VALOR A LA VARIABLE CELULAR
    if (mb_substr($var, 0, 2) == '09' && strlen($var) > 8) {
        $celularFuncion = mb_substr($var, 0, 9);
    }

    ///EN CASO DE QUE EL NÚMERO EMPIECE CON 2 O 4 Y TENGA MÁS DE 7 CARACTÉRES SE LE ASIGNA ESE VALOR A LA VARIABLE TELEFONO
    if (($var[0] == 2 || $var[0] == 4) && strlen($var) > 7) {
        $telefonoFuncion = mb_substr($var, 0, 8);
    }

    //SI EL LARGO DE LA VARIABLE ES IGUAL A 17 (LA SUMA DE LOS 9 CARACTERES DE UN TELÉFONO MÁS LOS 8 DE UN CELULAR) DIVIDE EL STRING
    if (strlen($var) == 17) {
        //EN CASO DE QUE CONTENGA LA SINTÁXIS DE TELÉFONO SE LE ASIGNA LA mb_substrING A LA VARIABLE TELEFONO
        if (isset($var[9]) && ($var[9] == 2 || $var[9] == 4) && mb_substr($var, 7, 9) != '09') {
            $telefonoFuncion = mb_substr($var, 9, 18);
        }
        //EN CASO DE QUE CONTENGA LA SINTÁXIS DE CELULAR SE LE ASIGNA LA mb_substrING A LA VARIABLE CELULAR
        if (isset($var[8]) && mb_substr($var, 8, 2) == '09') {
            $celularFuncion = mb_substr($var, 8, 18);
        }
    }

    //EN CASO DE QUE LA VARIABLE CELULAR NO SE HAYA DEFINIDO LE ASIGNA UN STRING VACÍO PARA NO GENERAR CONFLICTOS EN LA QUERY

    if (!isset($celularFuncion)) {
        $celularFuncion = null;
    }
    if (!isset($telefonoFuncion)) {
        $telefonoFuncion = null;
    }

    if ($telefonoFuncion != null && $celularFuncion != null) {
        $telFuncion = $telefonoFuncion;
        $telFuncion .= ' ';
        $telFuncion .= $celularFuncion;
    } else if ($telefonoFuncion != null && $celularFuncion == '') {
        $telFuncion = $telefonoFuncion;
    } else if ($telefonoFuncion == '' && $celularFuncion != null) {
        $telFuncion = $celularFuncion;
    } else {
        $telFuncion = '';
    }

    unset($telefonoFuncion);
    unset($celularFuncion);

    return $telFuncion;
}

/** Procesar Fecha **/
function reformar_fecha($fecha)
{
    $array_datos = explode('/', $fecha);
    $dia = $array_datos[0];
    $mes = $array_datos[1];
    $ano = $array_datos[2];
    $dia = strlen($dia) == 1 ? "0$dia" : $dia;
    $mes = strlen($mes) == 1 ? "0$mes" : $mes;

    return "$dia/$mes/$ano";
}

/** Términa el proceso y devuelve el error expecificado **/
function devolver_error($mensaje)
{
    $response['error'] = true;
    $response['mensaje'] = $mensaje;
    die(json_encode($response));
}

/** Genera un hash con el largo requerido **/
function generarHash($largo)
{
    $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyz';
    return substr(str_shuffle($caracteres_permitidos), 0, $largo);
}

//Suma un array de numeros
function sumar_array($array_numeros)
{
    $total_suma = 0;
    foreach ($array_numeros as $numero) {
        $total_suma = $total_suma + $numero;
    }
    return $total_suma;
}

/** Busca y devuelve el primer número de celular encontrado en el string **/
function buscarCelular($numeros)
{
    preg_match_all('/(09)[1-9]{1}\d{6}/x', $numeros, $respuesta);
    $respuesta = (count($respuesta[0]) !== 0) ? $respuesta[0] : false;
    return $respuesta;
}
