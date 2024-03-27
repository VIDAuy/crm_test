<?php
$agenda_volver_a_llamar = "";

if ($_SESSION['nivel'] != 1)
    $agenda_volver_a_llamar = "
    <div class='d-flex justify-content-center'>
        <button class='btn btn-secondary center-block mt-3 mb-5 ctr_agendar_volver_a_llamar' onclick='agendar_volver_a_llamar(true)'>
            Agregar a agenda 📞
        </button>
    </div>";

?>

<!-- No Es Socio -->
<div class='container' id='noEsSocio' style='display: none;'>
    <hr class='style5 container'>

    <div class='alert alert-info border border-info' role='alert'>
        <h3 class='text-center'>Cédula consultada: <span id='cedulasNS'></span></h3>
        <div class='row'>
            <div class='col-6'>
                <label for='nombreNS'>Nombre:</label>
                <input type='text' class='form-control' id='nombreNS'>
            </div>
            <div class='col-6'>
                <label for='apellidoNS'>Apellido:</label>
                <input type='text' class='form-control' id='apellidoNS'>
            </div>
        </div>
        <div class='row'>
            <div class='col-6'>
                <label for='telefonoNS'>Telefono:</label>
                <input type='text' class='form-control' id='telefonoNS' maxlength='8'>
            </div>
            <div class='col-6'>
                <label for='celularNS'>Celular:</label>
                <input type='text' class='form-control' id='celularNS' maxlength='9'>
            </div>
        </div>
    </div>

    <hr class='style5 container'>

    <div class='alert alert-warning border border-warning' role='alert'>
        <div class='row mb-3'>
            <div class='col-lg-4 mb-3'>
                <div class='form-floating'>
                    <textarea class='form-control' placeholder='Observación' id='observacionesNS'></textarea>
                    <label for='observacionesNS'>Observación:</label>
                </div>
            </div>
            <div class='col-lg-4 mb-3'>
                <div class='form-floating'>
                    <select class='form-select agregarFiliales' id='avisarNS' aria-label='Avisar a'>
                    </select>
                    <label for='avisarNS'>Avisar a:</label>
                </div>
            </div>
            <div class='col-lg-4 mb-3' style='margin-top: -1%;'>
                <label>Cargar Imagen:</label>
                <div class='d-flex justify-content-center'>
                    <input type='file' class='form-control mb-3' name='cargar_imagen_registro_2[]' id='cargar_imagen_registro_2' accept='.jpg, .jpeg, .png, .pdf' multiple>
                </div>
            </div>
        </div>

        <?php echo $agenda_volver_a_llamar; ?>

        <div class='d-flex justify-content-center'>
            <button class='btn btn-success center-block' onClick='cargo(1, 0)' style='display: block;'> Cargar
            </button>
        </div>
    </div>
</div>
<!-- End No Es Socio -->