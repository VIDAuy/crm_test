<?php
if ($_SESSION['nivel'] == 1) {

    $siEsSocio = "
    <div class='alert alert-info border border-info' role='alert'>
        <h3 class='text-center'>
            Cédula consultada: 
            <span id='cedulas'></span>
        </h3>
		<div class='row text-center'>
			<div class='col-12'>
				<label for='' class='col-form-label'>Nombre completo:</label>
				<p id='nom' style='font-weight: bold;'></p>
			</div>
		</div>
    </div>";

    $agenda_volver_a_llamar = "";
} else {

    $siEsSocio = "
    <div class='alert alert-info border border-info' role='alert'>
        <h3 class='text-center'>
            Cédula consultada: 
            <span id='cedulas'></span>
        </h3>
        <div class='row text-center'>
            <div class='col-3'>
                <label for='' class='col-form-label'>Nombre completo:</label>
                <p id='nom' style='font-weight: bold;'></p>
            </div>
            <div class='col-3'>
                <label for='' class='col-form-label'>Teléfono:</label>
                <p id='telefono' style='font-weight: bold;'></p>
            </div>
            <div class='col-2'>
                <label for='' class='col-form-label'>Fecha de afiliación:</label>
                <p id='fechafil' style='font-weight: bold;'></p>
            </div>
            <div class='col-4 justify-content-center'>
                <label class='col-form-label d-block text-center'>Más datos:</label>
                <div class='d-flex'>
                    <button class='btn btn-primary btn-sm mx-auto mb-2' id='btnDatosCoordinacion' onclick='datos_coordinacion()'>Coordinación</button>
                    <button class='btn btn-primary btn-sm mx-auto mb-2' id='btnDatosCobranza' onclick='datos_cobranza()'>Cobranza</button>
                    <button class='btn btn-primary btn-sm mx-auto mb-2' id='btnDatosProductos' onclick='datos_productos()'>Productos</button>
                </div>
            </div>
        </div>
        <div class='row text-center'>
            <div class='col-3'>
                <label for='' class='col-form-label'>Radio:</label>
                <p id='radio' style='font-weight: bold;'></p>
            </div>
            <div class='col-3'>
                <label for='' class='col-form-label'>Sucursal:</label>
                <p id='sucursal' style='font-weight: bold;'></p>
            </div>
            <div class='col-3' id='div_inspira'>
                <label for='' class='col-form-label'>Inspira?:</label>
                <p id='inspira' style='font-weight: bold;'></p>
            </div>
        </div>
    </div>";

    $agenda_volver_a_llamar = "
    <div class='d-flex justify-content-center'>
    <button class='btn btn-secondary center-block mt-3 mb-5 ctr_agendar_volver_a_llamar' onclick='agendar_volver_a_llamar(true)'>Agregar a agenda 📞</button>
    </div>";
}

?>

<!-- Si Es Socio -->
<div class='container' id='siEsSocio' style='display: none;'>
    <hr class='style5 container'>

    <?php echo $siEsSocio; ?>

    <hr class='style5 container'>

    <div class='alert alert-warning border border-warning' role='alert'>
        <h3 class='text-center mb-5'><u>Cargar registro de llamada</u></h3>
        <div class='row mb-3'>
            <div class='col-lg-4 mb-3'>
                <div class='form-floating'>
                    <textarea class='form-control' placeholder='Observación' id='obser'></textarea>
                    <label for='obser'>Observación:</label>
                </div>
            </div>
            <div class='col-lg-4 mb-3'>
                <div class='form-floating'>
                    <select class='form-select agregarFiliales' id='ensec' aria-label='Avisar a'>
                    </select>
                    <label for='ensec'>Avisar a:</label>
                </div>
            </div>
            <div class='col-lg-4 mb-3' style='margin-top: -1%;'>
                <label>Cargar Imagen:</label>
                <div class='d-flex justify-content-center'>
                    <input type='file' class='form-control mb-3' name='cargar_imagen_registro_3[]' id='cargar_imagen_registro_3' accept='.jpg, .jpeg, .png, .pdf' multiple>
                </div>
            </div>
        </div>

        <?php echo $agenda_volver_a_llamar; ?>

        <div class='d-flex justify-content-center'>
            <input type='button' class='btn btn-success' value='Cargar' onClick='cargo(2, 1)'>
        </div>
    </div>
</div>
<!-- End Si Es Socio -->