<?php
$noEsSocioRegistros = "";
$agenda_volver_a_llamar = "";

if ($_SESSION['nivel'] == 1) {

    $noEsSocioRegistros = "
    <div class='alert alert-info border border-info' role='alert'>
        <h3 class='text-center'>
            Cédula consultada: 
            <span id='cedulasNSR'></span>
        </h3>
		<div class='row'>
			<div class='col-12'>
				<label for='nombreNSR'>Nombre completo:</label>
				<input type='text' class='form-control' id='nombreNSR' readonly>
			</div>
		</div>
    </div>";
} else {

    $noEsSocioRegistros = "
    <div class='alert alert-info border border-info' role='alert'>
        <h3 class='text-center'>
            Cédula consultada: 
            <span id='cedulasNSR'></span>
        </h3>
        <div class='row'>
            <div class='col-6'>
                <label for='nombreNSR'>Nombre completo:</label>
                <input type='text' class='form-control' id='nombreNSR' readonly>
            </div>
            <div class='col-6'>
                <label for='telefonoNSR'>Telefono:</label>
                <input type='text' class='form-control' id='telefonoNSR' readonly>
            </div>
        </div>
    </div>";

    $agenda_volver_a_llamar = "
    <div class='d-flex justify-content-center'>
        <button class='btn btn-secondary center-block mt-3 mb-5 ctr_agendar_volver_a_llamar' onclick='agendar_volver_a_llamar(true)'>
            Agregar a agenda 📞
        </button>
    </div>";
}

?>

<!-- No Es Socio Pero Tiene Registros -->
<div class='container' id='noEsSocioRegistro' style='display: none;'>
    <hr class='style5 container'>

    <?php echo $noEsSocioRegistros; ?>

    <hr class='style5 container'>

    <div class='alert alert-warning border border-warning' role='alert'>
        <h3 class='text-center mb-5'><u>Cargar registro de llamada</u></h3>
        <div class='row mb-3'>
            <div class='col-lg-4 mb-3'>
                <div class='form-floating'>
                    <textarea class='form-control' placeholder='Observación' id='observacionesNSR'></textarea>
                    <label for='observacionesNSR'>Observación:</label>
                </div>
            </div>
            <div class='col-lg-4 mb-3'>
                <div class='form-floating'>
                    <select class='form-select agregarFiliales' id='avisarNSR' aria-label='Avisar a'>
                    </select>
                    <label for='avisarNSR'>Avisar a:</label>
                </div>
            </div>
            <div class='col-lg-4 mb-3' style='margin-top: -1%;'>
                <label>Cargar Imagen:</label>
                <div class='d-flex justify-content-center'>
                    <input type='file' class='form-control mb-3' name='cargar_imagen_registro_1[]' id='cargar_imagen_registro_1' accept='.jpg, .jpeg, .png, .pdf' multiple>
                </div>
            </div>
        </div>

        <?php echo $agenda_volver_a_llamar; ?>

        <div class='d-flex justify-content-center'>
            <button class='btn btn-success center-block' onClick='cargo(0, 0)' style='display: block;'> Cargar
            </button>
        </div>
    </div>
</div>
<!-- End No Es Socio Pero Tiene Registros -->