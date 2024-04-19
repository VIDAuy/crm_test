<?php
include_once '../../../configuraciones.php';

$tabla["data"] = [];


$lista_registros = obtener_registros();

while ($row = mysqli_fetch_assoc($lista_registros)) {
    $acciones = "";
    $id = $row['id'];
    $cedula = $row['cedula'];
    $nombre = $row['nombre'];
    $telefono = $row['telefono'];
    $fecha_registro = date("d/m/Y H:i:s", strtotime($row['fecha_registro']));
    $sector = $row['sector'];
    $observacion = $row['observaciones'];
    $btnVerMas = "<button class='btn btn-link' onclick='abrirModalVerMas(`" . $observacion . "`)'>Ver más ...</button>";
    $resumen_observacion =
        strlen($observacion) > 29 ?
        "<span style='margin-right: -3%'>" . mb_substr($observacion, 0, 22) . "</span>" . $btnVerMas :
        $observacion;
    $socio = $row['socio'] == 1 ? "Si" : "<span class='text-danger'>No</span>";
    $baja = $row['baja'] == 1 ? "<span class='text-danger'>Si</span>" : "No";
    $envioSector = $row['envioSector'] != "" ? obtener_datos_usuario($row['envioSector'])['usuario'] : "-";
    $id_sub_usuario = $row['sub_usuario'];
    $imagenes = obtener_imagenes($id);
    if ($imagenes != 0) $acciones .= "<button class='btn btn-sm btn-info' onclick='modal_ver_imagen_registro(`" . URL_DOCUMENTOS . "`, `" . $imagenes . "`);'>Ver Archivos</button>";


    if (in_array($sector, ['Audit1', 'Audit2', 'Audit3'])) {
        $usuario = ($sector == "Audit1") ? "Nathalia Horvat" : (($sector == "Audit2") ? "Andrea Horvat" : (($sector == "Audit3") ? "Tatiana Landa" : ""));
    } else {
        $usuario = $id_sub_usuario != "" ? @utf8_encode($id_sub_usuario) : "-";
    }
    $acciones .= "<button class='btn btn-sm btn-danger' onclick='eliminar_registro(`" . $id . "`);'>❌</button>";


    $tabla["data"][] = [
        'id' => $id,
        'cedula' => $cedula,
        'nombre' => $nombre,
        'telefono' => $telefono,
        'fecha_registro' => $fecha_registro,
        'sector' => $sector,
        'usuario' => $usuario,
        'socio' => $socio,
        'baja' => $baja,
        'observacion' => $resumen_observacion,
        'envio_sector' => $envioSector,
        'acciones' => $acciones,
    ];
}



echo json_encode($tabla);




function obtener_registros()
{
    include '../../../conexiones/conexion2.php';
    $tabla1 = TABLA_REGISTROS;
    $tabla2 = TABLA_SUB_USUARIOS;

    try {
        $sql = "SELECT
	        r.id,
	        r.cedula,
            r.nombre,
            r.telefono,
            r.fecha_registro,
            r.sector,
            r.observaciones,
            r.socio,
            r.baja,
            r.envioSector,
            r.id_sub_usuario,
            CONCAT(su.nombre, ' ', su.apellido) AS sub_usuario 
          FROM
	        {$tabla1} r
	        LEFT JOIN {$tabla2} su ON r.id_sub_usuario = su.id
          WHERE
            r.eliminado = 0
          ORDER BY r.id DESC 
	      LIMIT 500";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "tabla_registros.php", $error);
    }

    return $consulta;
}

function obtener_imagenes($id)
{
    $conexion = connection(DB);
    $tabla = TABLA_IMAGENES_REGISTROS;
    $imagen = "";

    try {
        $sql = "SELECT 
			nombre_imagen 
		   FROM 
			{$tabla} 
		   WHERE 
			id_registro = '$id' AND 
			activo = 1
            ORDER BY id DESC";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "tabla_registros.php", $error);
    }


    if (mysqli_num_rows($consulta) > 0) {
        while ($row = mysqli_fetch_assoc($consulta)) {
            $imagen .= $imagen == "" ? $row['nombre_imagen'] : ", " . $row['nombre_imagen'];
        }

        $resultados = $imagen;
    } else {
        $resultados = 0;
    }


    return $resultados;
}
