<!-- Consultas Generales -->
<div id="contenedor_consultas_generales" style="display: none">

    <div class="alert alert-secondary border-secondary" role="alert">
        <h3 class="text-center mb-5"><u>Consultas Generales</u></h3>
        <div class="d-flex justify-content-center mb-3">
            <div class="row">
                <div class="form-group">
                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Desde</span>
                                <input type="date" class="form-control" id="cg_fecha_desde_personal" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Hasta</span>
                                <input type="date" class="form-control" id="cg_fecha_hasta_personal" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center mb-3">
            <div class="row">
                <div class="form-group">
                    <div class="row g-3 align-items-center">
                        <div class="col-auto mb-3">
                            <button type="button" class="btn btn-info mr-4" onclick="registro_completo_horas_acompanantes()">Horas de acompañantes ⏳</button>
                        </div>
                        <div class="col-auto mb-3">
                            <button type="button" class="btn btn-info mr-4" onclick="registro_completo_faltas_acompanantes()">Reporte de faltas 📕</button>
                        </div>
                        <div class="col-auto mb-3">
                            <button class="btn btn-info" onclick="registro_completo_licencias_acompanantes()">Licencias 📗</button>
                        </div>
                        <div class="col-auto mb-3">
                            <button class="btn btn-info mr-4" onclick="registro_capacitacion_acompanantes()">Capacitación de acompañantes 📒</button>
                        </div>
                        <div class="col-auto mb-3">
                            <button class="btn btn-danger mr-4" onclick="registro_viaticos_descontar_acompanantes()">Viáticos a descontar 📓</button>
                        </div>
                        <div class="col-auto mb-3">
                            <button class="btn btn-danger" onclick="registro_listado_radios()">Listado de radios 📔</button>
                        </div>
                        <div class="col-auto mb-3">
                            <button class="btn btn-danger mr-4" onclick="registro_archivos_cobranza()">Archivos de cobranza 📚</button>
                        </div>
                        <div class="col-auto mb-3">
                            <button class="btn btn-danger mr-4" onclick="registro_corte_producto_abm()">Corte de producto ABM 📋</button>
                        </div>
                        <div class="col-auto mb-3">
                            <button class="btn btn-danger" onclick="registro_resultado_comision()">Resultado de comisión 📊</button>
                        </div>
                        <div class="col-auto mb-3">
                            <button class="btn btn-danger mr-4" onclick="registro_retenciones_socios()">Retenciones de socios 📂</button>
                        </div>
                        <div class="col-auto mb-3">
                            <button class="btn btn-danger mr-4" onclick="registro_horas_auxiliares_limpieza()">Horas auxiliares de limpieza ⏳</button>
                        </div>
                        <div class="col-auto mb-3">
                            <button class="btn btn-danger" onclick="registro_horas_particulares()">Horas particulares ⏳</button>
                        </div>
                        <div class="col-auto mb-3">
                            <button class="btn btn-danger mr-4" onclick="registro_control_satisfaccion_paraguay()">Control de satisfacción Paraguay 📜</button>
                        </div>
                        <div class="col-auto mb-3">
                            <button class="btn btn-danger mr-4" onclick="registro_uniformes_descontar()">Uniformes a descontar 📝</button>
                        </div>
                        <div class="col-auto mb-3">
                            <button class="btn btn-danger" onclick="registro_capacitacion_comercial()">Capacitación comercial 📄</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- End Consultas Generales -->