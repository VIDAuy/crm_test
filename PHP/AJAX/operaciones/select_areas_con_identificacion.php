<?php
include_once '../../configuraciones.php';

$consulta_usuarios =
    isset($_REQUEST['id_area']) ?
    obtener_areas($_REQUEST['id_area']) :
    obtener_areas("");

while ($row = mysqli_fetch_assoc($consulta_usuarios)) {
    $row['usuario'] = ucfirst($row['usuario']);
    $f[] = $row;
}

$respuesta['datos'] = $f;
echo json_encode($respuesta);



function obtener_areas($id_area)
{
    $conexion = connection(DB);
    $tabla1 = TABLA_USUARIOS;
    $tabla2 = TABLA_SUB_USUARIOS;

    $where = $id_area != "" ? "u.id != '$id_area' AND" : "";

    try {
        $sql = "SELECT 
        u.id, 
        u.usuario 
        FROM 
        {$tabla1} u
        INNER JOIN {$tabla2} su ON u.id = su.id_sector 
        WHERE 
        $where 
        u.id != 43 AND
        u.activo = 1 AND
        su.activo = 1
        GROUP BY u.id
        ORDER BY u.usuario ASC";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "select_areas.php", $error);
    }

    return $consulta;
}
