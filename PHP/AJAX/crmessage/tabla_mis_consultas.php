<?php
include_once '../../configuraciones.php';

$id_area = $_SESSION['id'];
$id_sub_usuario = isset($_SESSION['id_sub_usuario']) ? $_SESSION['id_sub_usuario'] : "";

$response["data"] = [];


$listado_consultas_area = obtener_consultas_area($id_area);
if ($listado_consultas_area === false) devolver_error("Ocurriron errores al obtener las consultas área");


while ($row = mysqli_fetch_assoc($listado_consultas_area)) {

  $id              = $row['id'];
  $area_consulta   = ucfirst(obtener_datos_usuario($row['area_consulta'])['usuario']);
  $area_consultada = ucfirst(obtener_datos_usuario($row['area_consultada'])['usuario']);
  $cedula_socio    = $row['cedula_socio'];
  $fecha_consulta  = date("d/m/Y H:i:s", strtotime($row['fecha_consulta']));
  $estado          = $row['estado'];
  $datos_mensajes  = obtener_datos_mensajes($id);
  $consulta        = $datos_mensajes['mensaje'];
  $usuario_consultado = $row['usuario_consultado'];
  $usuario_consultado = $usuario_consultado != "" || $usuario_consultado != null ? " ➡ " . ucfirst(obtener_nombre_sub_usuario(($usuario_consultado))) : "";

  $canitdad_no_leidos = cantidad_mis_consultas_no_leidos($id);
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
            <h5 class='card-title mb-4 card_titulo_crmessage'>" . $area_consultada . $usuario_consultado . "</h5>
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
                <button class='btn btn-sm btn-primary' onclick='abrir_menu_chat(false, $id, 1, $habilitar_marcar_leido)'>
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



if ($id_sub_usuario != "") {
  $listado_consultas_usuario = obtener_consultas_usuario($id_area, $id_sub_usuario);
  if ($listado_consultas_usuario === false) devolver_error("Ocurriron errores al obtener las consultas usuario");


  while ($row = mysqli_fetch_assoc($listado_consultas_usuario)) {

    $id                 = $row['id'];
    $area_consulta      = ucfirst(obtener_datos_usuario($row['area_consulta'])['usuario']);
    $area_consultada    = ucfirst(obtener_datos_usuario($row['area_consultada'])['usuario']);
    $cedula_socio       = $row['cedula_socio'];
    $fecha_consulta     = date("d/m/Y H:i:s", strtotime($row['fecha_consulta']));
    $estado             = $row['estado'];
    $datos_mensajes     = obtener_datos_mensajes($id);
    $consulta           = $datos_mensajes['mensaje'];
    $usuario_consultado = $row['usuario_consultado'];
    $usuario_consultado = $usuario_consultado != "" || $usuario_consultado != null ? " ➡ " . ucfirst(obtener_nombre_sub_usuario(($usuario_consultado))) : "";

    $canitdad_no_leidos = cantidad_mis_consultas_no_leidos($id);
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
              <h5 class='card-title mb-4 card_titulo_crmessage'>" . $area_consultada . $usuario_consultado . "</h5>
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
                  <button class='btn btn-sm btn-primary' onclick='abrir_menu_chat(false, $id, 1, $habilitar_marcar_leido)'>
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
}


echo json_encode($response);




function obtener_consultas_area($id_area)
{
  $conexion = connection(DB);
  $tabla = TABLA_CONSULTA_TRANSAREA;

  try {
    $sql = "SELECT * FROM {$tabla} WHERE area_consulta = '$id_area' AND (usuario_consulto IS NULL OR usuario_consulto = '') AND activo = 1";
    $consulta = mysqli_query($conexion, $sql);
    return $consulta;
  } catch (\Throwable $error) {
    registrar_errores($sql, "tabla_mis_consultas.php", $error);
    return false;
  }
}

function obtener_consultas_usuario($id_area, $id_sub_usuario)
{
  $conexion = connection(DB);
  $tabla = TABLA_CONSULTA_TRANSAREA;

  try {
    $sql = "SELECT * FROM {$tabla} WHERE area_consulta = '$id_area' AND usuario_consulto = '$id_sub_usuario' AND activo = 1";
    $consulta = mysqli_query($conexion, $sql);
    return $consulta;
  } catch (\Throwable $error) {
    registrar_errores($sql, "tabla_mis_consultas.php", $error);
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
    registrar_errores($sql, "tabla_mis_consultas.php", $error);
    return false;
  }
}

function cantidad_mis_consultas_no_leidos($id)
{
  $conexion = connection(DB);
  $tabla = TABLA_MENSAJES_CONSULTA_TRANSAREA;

  try {
    $sql = "SELECT * FROM {$tabla} WHERE id_consulta_transarea = '$id' AND visto_consultor = 0 AND activo = 1";
    $consulta = mysqli_query($conexion, $sql);
    $resultado = $consulta != false ? mysqli_num_rows($consulta) : false;
    return $resultado;
  } catch (\Throwable $error) {
    registrar_errores($sql, "tabla_mis_consultas.php", $error);
    return false;
  }
}
