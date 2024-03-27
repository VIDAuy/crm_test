<?php

include '../configuraciones.php';

$id_usuario = $_SESSION['id'];

$response["data"] = [];


$listado_consultas = obtener_consultas($id_usuario);

if ($listado_consultas === false) {
  $response['error'] = true;
  $response['mensaje'] = "Ocurriron errores al obtener las consultas";
  die(json_encode($response));
}


while ($row = mysqli_fetch_assoc($listado_consultas)) {

  $id              = $row['id'];
  $area_consulta   = ucfirst(obtener_datos_usuario($row['area_consulta'])['usuario']);
  $area_consultada = ucfirst(obtener_datos_usuario($row['area_consultada'])['usuario']);
  $cedula_socio    = $row['cedula_socio'];
  $fecha_consulta  = $row['fecha_consulta'];
  $estado          = $row['estado'];
  $datos_mensajes  = obtener_datos_mensajes($id);
  $consulta        = $datos_mensajes['mensaje'];

  $canitdad_no_leidos = cantidad_consultas_asignadas_no_leidos($id);
  $mostrar_canitdad_no_leidos = $canitdad_no_leidos > 0 ? "<span class='bg-danger rounded-circle p-1 fw-bolder'>$canitdad_no_leidos+</span>" : "";
  $habilitar_marcar_leido = $canitdad_no_leidos > 0 ? 1 : 0;

  if ($cedula_socio != "") $cedula_socio = "
    <span class='fw-bolder d-block'>
        <i class='bi bi-person-vcard me-1'></i>
        " . $cedula_socio . "
    </span>";

  $estado = $estado == 1 ? "En Proceso" : "Terminado";

  $html =
    "<div class='card'>
        <div class='card-body'>
          <div class='d-flex'>
            <h5 class='card-title mb-4 card_titulo_crmessage'>" . $area_consulta . "</h5>
            <span class='mb-3 card_texto_estado_crmessage ms-auto'>
              <i class='bi bi-info-circle me-1'></i>
              " . $estado . "
            </span>
          </div>
          <p class='card-text blockquote-footer card_texto_crmessage'>
            " . $consulta . "
          </p>
          <div class='card-footer'>
            <div class='d-flex'>
              <small class='text-body-secondary card_texto_secundario_crmessage'>
                " . $cedula_socio . "
                <span class='fw-bolder'>
                  <i class='bi bi-clock me-1'></i>
                  " . $fecha_consulta . "
                </span>
              </small>
              <span class='mb-3 ms-auto'>
                <button class='btn btn-sm btn-primary' onclick='abrir_menu_chat(true, $id, 2, $habilitar_marcar_leido)'>
                  <span>
                    <i class='bi bi-chat-left-dots me-1'></i>
                    Mensajes
                  </span>
                  " . $mostrar_canitdad_no_leidos . "
                </button>
              </span>
            </div>
            <div></div>
          </div>
        </div>
      </div>";


  $response["data"][] = [
    'id'       => $id,
    'consulta' => $html,
  ];
}



echo json_encode($response);




function obtener_consultas($id_usuario)
{
  $conexion = connection(DB);
  $tabla = TABLA_CONSULTA_TRANSAREA;

  try {
    $sql = "SELECT * FROM {$tabla} WHERE area_consultada = '$id_usuario' AND activo = 1";
    $consulta = mysqli_query($conexion, $sql);
    return $consulta;
  } catch (\Throwable $error) {
    registrar_errores($sql, "tabla_consultas_asignadas.php", $error);
    return false;
  }
}

function obtener_datos_mensajes($id)
{
  $conexion = connection(DB);
  $tabla = TABLA_MENSAJES_CONSULTA_TRANSAREA;

  try {
    $sql = "SELECT * FROM {$tabla} WHERE id_consulta_transarea = '$id' AND activo = 1 ORDER BY id ASC LIMIT 1";
    $consulta = mysqli_query($conexion, $sql);
    $resultado = mysqli_fetch_assoc($consulta);
    return $resultado;
  } catch (\Throwable $error) {
    registrar_errores($sql, "tabla_consultas_asignadas.php", $error);
    return false;
  }
}

function cantidad_consultas_asignadas_no_leidos($id)
{
  $conexion = connection(DB);
  $tabla = TABLA_MENSAJES_CONSULTA_TRANSAREA;

  try {
    $sql = "SELECT * FROM {$tabla} WHERE id_consulta_transarea = '$id' AND visto_consultado = 0 AND activo = 1";
    $consulta = mysqli_query($conexion, $sql);
    $resultado = $consulta != false ? mysqli_num_rows($consulta) : false;
    return $resultado;
  } catch (\Throwable $error) {
    registrar_errores($sql, "tabla_consultas_asignadas.php", $error);
    return false;
  }
}
