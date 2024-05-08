<?php
include_once '../configuraciones.php';

$id_area = $_SESSION['id'];
$opcion = $_REQUEST['opcion'];


//Consultar permisos para consultar funcionarios y gestionar bajas
if ($opcion == 1) {

    $permiso_funcionario = comprobar_permisos(1, $id_area, 1, null);
    if (mysqli_num_rows($permiso_funcionario) <= 0) {
        $mostrar_radio_buttons = '';
        $seccion_consulta_cedula = '
        <input type="text" class="form-control solo_numeros" id="ci" name="ci" placeholder="Ingrese cédula a buscar ..." aria-label="Ingrese cédula a buscar ..." aria-describedby="basic-addon1" maxlength="8" onkeypress="buscar_al_presionar_enter(event, 1)">
        <button class="btn btn-danger input-group-text" id="buscarCI" onclick="buscarDatos(false)">Buscar 🔍</button>';
    } else {
        $mostrar_radio_buttons = '
        <div class="col-lg-3"><div class="form-check">
                <input class="form-check-input" type="radio" name="radioBuscar" id="rbtBuscarSocio" value="socio" checked>
                <label class="form-check-label" for="rbtBuscarSocio"> Socio </label>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="radioBuscar" id="rbtBuscarFuncionario" value="funcionario">
                <label class="form-check-label" for="rbtBuscarFuncionario"> Funcionario </label>
            </div>
        </div>';
        $seccion_consulta_cedula = '
        <input type="text" class="form-control" id="ci" name="ci" placeholder="Ingrese cédula a buscar ..." aria-label="Ingrese cédula a buscar ..." aria-describedby="basic-addon1" maxlength="8" onkeypress="buscar_al_presionar_enter(event, 2)">
        <button class="btn btn-danger input-group-text" id="buscarCI" onclick="buscarDatos(true)">Buscar 🔍</button>';
    }



    $permiso_gestionar_baja = comprobar_permisos(1, $id_area, 2, null);
    $btn_gestionar_bajas = mysqli_num_rows($permiso_gestionar_baja) > 0 ?
        '<input type="button" class="btn btn-success" value="Gestionar bajas" onclick="corroborarBajas();">' : "";
    $btn_solicitar_baja = '<input type="button" class="btn btn-danger" value="Solicitar la baja" onclick="listarDatos();">';


    $html = "
    <div class='d-flex justify-content-center'>
        <div class='container mt-5 mb-3'>
            <div class='row'>
                <div class='col-lg-6'>
                    <div class='col-auto'>
                        <div class='input-group mb-3'>
                            <span class='input-group-text' id='basic-addon1'>Cédula:</span>
                            " . $seccion_consulta_cedula . "
                        </div>
                    </div>
                </div>
                " . $mostrar_radio_buttons . "
            </div>
        </div>
    </div>
    <div class='container'>
        <span style='float: right'>
            " . $btn_gestionar_bajas . "
        </span>
        " . $btn_solicitar_baja . "
    </div>";



    $response['error'] = false;
    $response['html'] = $html;
    echo json_encode($response);
}
