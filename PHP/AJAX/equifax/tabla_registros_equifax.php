<?php
include_once '../../configuraciones.php';

$tabla["data"] = [];

$registros = isset($_REQUEST['cedula']) ? obtener_registros_equifax($_REQUEST['cedula']) : obtener_registros_equifax(false);


while ($row = mysqli_fetch_assoc($registros)) {

    $id            = $row['id'];
    $cedula        = $row['cedula'];
    $bajas         = $row['bajas'];
    $convenio      = $row['convenio'];
    $enero         = $row['enero'];
    $febrero       = $row['febrero'];
    $marzo         = $row['marzo'];
    $abril         = $row['abril'];
    $mayo          = $row['mayo'];
    $junio         = $row['junio'];
    $julio         = $row['julio'];
    $agosto        = $row['agosto'];
    $septiembre    = $row['septiembre'];
    $octubre       = $row['octubre'];
    $noviembre     = $row['noviembre'];
    $diciembre     = $row['diciembre'];
    $total_general = sumar_array([$enero, $febrero, $marzo, $abril, $mayo, $junio, $julio, $agosto, $septiembre, $octubre, $noviembre, $diciembre]);


    $tabla["data"][] = [
        "id"            => $id,
        "cedula"        => $cedula,
        "bajas"         => $bajas,
        "convenio"      => $convenio,
        "enero"         => $enero      != 0 ? "$" . number_format($enero) : "-",
        "febrero"       => $febrero    != 0 ? "$" . number_format($febrero) : "-",
        "marzo"         => $marzo      != 0 ? "$" . number_format($marzo) : "-",
        "abril"         => $abril      != 0 ? "$" . number_format($abril) : "-",
        "mayo"          => $mayo       != 0 ? "$" . number_format($mayo) : "-",
        "junio"         => $junio      != 0 ? "$" . number_format($junio) : "-",
        "julio"         => $julio      != 0 ? "$" . number_format($julio) : "-",
        "agosto"        => $agosto     != 0 ? "$" . number_format($agosto) : "-",
        "septiembre"    => $septiembre != 0 ? "$" . number_format($septiembre) : "-",
        "octubre"       => $octubre    != 0 ? "$" . number_format($octubre) : "-",
        "noviembre"     => $noviembre  != 0 ? "$" . number_format($noviembre) : "-",
        "diciembre"     => $diciembre  != 0 ? "$" . number_format($diciembre) : "-",
        "total_general" => "$" . number_format($total_general),
    ];
}



echo json_encode($tabla);







function obtener_registros_equifax($cedula = false)
{
    $conexion = connection(DB);
    $tabla = TABLA_REGISTROS_EQUIFAX;

    $where = $cedula != false ? "AND cedula = '$cedula'" : "";
    $sql = "SELECT * FROM {$tabla} WHERE activo = 1 $where";

    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
