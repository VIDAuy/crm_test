<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

include '../conexiones/conexion2.php';

$app = $produccion ? 'http://192.168.1.250:82/crm' : 'http://192.168.1.250:82/crm_test';


$tabla["data"] = [];

$consulta = todas_alertas_respuestas();


while ($resultado = mysqli_fetch_array($consulta)) {

    $respuesta_estado = $resultado["respuesta"];
    $leido = $resultado["leido"];

    if ($respuesta_estado == "Pendiente") {
        $estado = $app . '/assets/img/icono_respuesta_pendiente.png';
    } else if ($respuesta_estado == "Cargado") {
        $estado = $app . '/assets/img/icono_respuesta_cargada.png';
    } else {
        $estado = $app . '/assets/img/icono_respuesta_devuelta.png';
    }


    $checkbox = "<a href='#'>
        
                    <font style='vertical-align: inherit; text-align: justify;'>
                        <font style='vertical-align: inherit'>
                            Leido <input type='checkbox' class='check_leido' id='check_leido' name='check_leido'  value=" . $resultado['nro_carga'] . ">    
                        </font>
                    </font>
                        
                </a>";


    $mostrar_checkbox = $leido == 1 ? $checkbox : "";


    $fila = "<div class='media text-muted pt-3'>
                
                <img data-src='" . $estado . "' alt='32x32' class='mr-2 rounded' src='" . $estado . "' data-holder-rendered='true' style='width: 32px; height: 32px' />
                
                <div class='media-body pb-3 mb-0 small lh-125 border-bottom border-gray'>
                    
                    <div class='d-flex justify-content-between align-items-center w-100'>
            
                        <strong class='text-gray-dark'>
                
                            <font style='vertical-align: inherit'>
                    
                                <font style='vertical-align: inherit'>Área: " . $resultado['area'] . "</font>
                
                            </font>
                        
                        </strong>
            
                        <a href='#'>
                            
                            <font style='vertical-align: inherit'>
                                
                                <font style='vertical-align: inherit'>Respuesta: " . $resultado['respuesta'] . "</font>

                            </font>    
                        
                        </a>

                        " . $mostrar_checkbox . "
                    
                    </div>

                    <span class='d-block'>
        
                        <font style='vertical-align: inherit'>
                            
                            <font style='vertical-align: inherit'>Nro. Carga: " . $resultado['nro_carga'] . "</font>
            
                        </font>

                    </span>

                </div>

            </div>";



    $tabla["data"][] = [
        "fila" => $fila,
    ];
}



echo json_encode($tabla);









function todas_alertas_respuestas()
{
    global $conexion;

    $consulta = mysqli_query($conexion, "SELECT
	c.id,
	c.avisar_a AS 'area',
	c.id AS 'nro_carga',
	e.estado AS 'respuesta',
    r.leido
    FROM
	carga_documentos AS c,
	respuesta_carga_documento AS r,
	estado_documento AS e 
    WHERE
	c.id = r.nro_carga AND
	r.respuesta = e.id
	ORDER BY c.id DESC");

    return $consulta;
}
