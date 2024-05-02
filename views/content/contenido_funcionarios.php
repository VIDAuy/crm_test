<!-- Contenido Funcionarios -->
<div id="contenido_funcionario" style="display: none;">
    <div class="container">

        <hr class="style5 container">

        <div class="alert alert-info border border-info" role="alert">

            <h3 class="text-center">Cédula consultada: <span id="cedula_funcionario"></span></h3>

            <div class="row text-center">
                <div class="col-lg-2">
                    <label for="" class="col-form-label"><u>Número nodum:</u></label>
                    <p id="numero_nodum" style="font-weight: bold;"></p>
                </div>
                <div class="col-lg-2">
                    <label for="" class="col-form-label"><u>Nombre completo:</u></label>
                    <p id="nombre_completo_funcionario" style="font-weight: bold;"></p>
                </div>
                <div class="col-lg-2">
                    <label for="" class="col-form-label"><u>Teléfono:</u></label>
                    <p id="telefono_funcionario" style="font-weight: bold;"></p>
                </div>
                <div class="col-lg-3">
                    <label for="" class="col-form-label"><u>Correo electrónico:</u></label>
                    <p id="correo_funcionario" style="font-weight: bold;"></p>
                </div>
                <div class="col-lg-2">
                    <label for="" class="col-form-label"><u>Fecha de ingreso:</u></label>
                    <p id="fecha_ingreso" style="font-weight: bold;"></p>
                </div>
                <div class="col-lg-2">
                    <label for="" class="col-form-label"><u>Fecha de egreso:</u></label>
                    <p id="fecha_egreso" style="font-weight: bold;"></p>
                </div>
                <div class="col-lg-2">
                    <label for="" class="col-form-label"><u>Empresa:</u></label>
                    <p id="empresa_funcionario" style="font-weight: bold;"></p>
                </div>
                <div class="col-lg-2">
                    <label for="" class="col-form-label"><u>Estado:</u></label>
                    <p id="estado_funcionario" style="font-weight: bold;"></p>
                </div>
                <div class="col-lg-2">
                    <label for="" class="col-form-label"><u>Cargo:</u></label>
                    <p id="cargo_funcionario" style="font-weight: bold;"></p>
                </div>
                <div class="col-lg-2">
                    <label for="" class="col-form-label"><u>Centro de costos:</u></label>
                    <p id="centro_de_costos_funcionario" style="font-weight: bold;"></p>
                </div>
                <div class="col-lg-3">
                    <label for="" class="col-form-label"><u>Tipo de comisionamiento:</u></label>
                    <p id="tipo_de_comisionamiento_funcionario" style="font-weight: bold;"></p>
                </div>
                <div class="col-lg-2">
                    <label for="" class="col-form-label"><u>Filial:</u></label>
                    <p id="filial_funcionario" style="font-weight: bold;"></p>
                </div>
                <div class="col-lg-2">
                    <label for="" class="col-form-label"><u>Sub Filial:</u></label>
                    <p id="sub_filial_funcionario" style="font-weight: bold;"></p>
                </div>
                <div class="col-lg-2">
                    <label for="" class="col-form-label"><u>Tipo de trabajador:</u></label>
                    <p id="tipo_de_trabajador_funcionario" style="font-weight: bold;"></p>
                </div>
                <div class="col-lg-2">
                    <label for="" class="col-form-label"><u>Causal de baja:</u></label>
                    <p id="causal_de_baja_funcionario" style="font-weight: bold;"></p>
                </div>
                <div class="col-lg-2">
                    <label for="" class="col-form-label"><u>Medio de pago:</u></label>
                    <p id="medio_de_pago_funcionario" style="font-weight: bold;"></p>
                </div>
            </div>
        </div>

        <hr class="style5 container">

        <div class="alert alert-secondary" role="alert">
            <h3 class="text-center mb-5"><u>Consultas</u></h3>
            <div class="d-flex justify-content-center mb-5">
                <button type="button" class="btn btn-info" onclick="consulta_licencias()">Licencias</button>
            </div>
            <div class="d-flex justify-content-center mb-5">
                <div class="row">
                    <div class="form-group">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <div class="input-group">
                                    <span class="input-group-text bg-danger text-white" id="basic-addon1">Desde</span>
                                    <input type="date" class="form-control" id="fecha_desde" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group">
                                    <span class="input-group-text bg-danger text-white" id="basic-addon1">Hasta</span>
                                    <input type="date" class="form-control" id="fecha_hasta" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-info" onclick="consultas('horas')">Horas del acompañante</button>
                                <button type="button" class="btn btn-info" onclick="consultas('faltas')">Reporte de faltas</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="style5 container">
        <div class="alert alert-warning border border-warning" role="alert">
            <h3 class="text-center mb-3"><u>Cargar registro de llamada</u></h3>
            <div class="row mb-4">
                <div class="col-lg-6">
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Observación" id="obser_funcionarios"></textarea>
                        <label for="obser_funcionarios">Observación:</label>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-floating">
                        <select class="form-select agregarFiliales" id="ensec_funcionarios" aria-label="Avisar a">
                        </select>
                        <label for="ensec_funcionarios">Avisar a:</label>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <input type="button" class="btn btn-success" value="Cargar" onClick="cargo_registro_fucionario()">
            </div>
        </div>
        <hr class="style5 container">

    </div>
</div>
<!-- End Contenido Funcionarios -->