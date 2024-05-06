<!-- Alertas y Llamadas Pendientes-->
<div class="container administrar_pendientes" id="contenedor_administrar_pendientes" style="display: none">

    <hr class="style5 container">

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="vista_tabla_alertas_pendientes-tab" data-bs-toggle="tab" data-bs-target="#vista_tabla_alertas_pendientes" type="button" role="tab" aria-controls="vista_tabla_alertas_pendientes" aria-selected="true">
                Alertas pendientes
                <span class="badge text-bg-secondary" id="cantidad_total_alertas_pendientes"></span>
            </button>

            <button class="nav-link" id="vista_tabla_alertas_generales-tab" data-bs-toggle="tab" data-bs-target="#vista_tabla_alertas_generales" type="button" role="tab" aria-controls="vista_tabla_alertas_generales" aria-selected="false">
                Alertas generales
                <span class="badge text-bg-secondary" id="cantidad_total_pendientes_alertas_generales"></span>
            </button>

            <button class="nav-link" id="vista_tabla_volver_a_llamar-tab" data-bs-toggle="tab" data-bs-target="#vista_tabla_volver_a_llamar" type="button" role="tab" aria-controls="vista_tabla_volver_a_llamar" aria-selected="false">
                Volver a llamar
                <span class="badge text-bg-secondary" id="cantidad_total_pendientes_volver_a_llamar"></span>
            </button>

            <button class="nav-link" id="vista_tabla_crmessage-tab" data-bs-toggle="tab" data-bs-target="#vista_tabla_crmessage" type="button" role="tab" aria-controls="vista_tabla_crmessage" aria-selected="false">
                CRMessage
                <span class="badge text-bg-secondary" id="cantidad_total_pendientes_crmessage"></span>
            </button>

        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">

        <div class="tab-pane fade show active" id="vista_tabla_alertas_pendientes" role="tabpanel" aria-labelledby="vista_tabla_alertas_pendientes-tab" tabindex="0">
            <div class="alert alert-primary border-primary" role="alert">
                <div class="table-responsive">
                    <h3 class="text-center mb-3"><u>Alertas Pendientes:</u></h3>
                    <table id="tabla_alertas_pendientes" class="table table-sm table-bordered table-striped table-hover" width="100%">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Cédula</th>
                                <th>Sector</th>
                                <th>Observación</th>
                                <th>Nombre Cliente</th>
                                <th>Teléfono</th>
                                <th>Usuario Asignado</th>
                                <th>Usuario Asignador</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="vista_tabla_alertas_generales" role="tabpanel" aria-labelledby="vista_tabla_alertas_generales-tab" tabindex="0">
            <div class="alert alert-primary border-primary" role="alert">
                <div class="table-responsive">
                    <h3 class="text-center mb-3"><u>Alertas generales:</u></h3>
                    <table id="tabla_reasignar_alertas_auditoria_pendientes" class="table table-sm table-bordered table-striped table-hover" width="100%">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Sector</th>
                                <th>Usuario Registro</th>
                                <th>Descripción</th>
                                <th>Fecha Registro</th>
                                <th>Usuario Asignado</th>
                                <th>Usuario Asignador</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="vista_tabla_volver_a_llamar" role="tabpanel" aria-labelledby="vista_tabla_volver_a_llamar-tab" tabindex="0">
            <div class="alert alert-primary border-primary" role="alert">
                <div class="table-responsive">
                    <h3 class="text-center mb-3"><u>Volver a llamar:</u></h3>
                    <table id="tabla_llamadas_pendientes" class="table table-sm table-bordered table-striped table-hover" width="100%">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Cédula</th>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Socio</th>
                                <th>Baja</th>
                                <th>Fecha y Hora</th>
                                <th>Comentario</th>
                                <th>Fecha de registro</th>
                                <th>Usuario Agendo</th>
                                <th>Usuario Asignado</th>
                                <th>Usuario Asignador</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="vista_tabla_crmessage" role="tabpanel" aria-labelledby="vista_tabla_crmessage-tab" tabindex="0">
            <div class="alert alert-primary border-primary" role="alert">
                <div class="table-responsive">
                    <h3 class="text-center mb-3"><u>CRMessage:</u></h3>
                    <table id="tabla_crmessage_todos_pendientes" class="table table-sm table-bordered table-striped table-hover" width="100%">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Área consulta</th>
                                <th>Área consultada</th>
                                <th>Consulta</th>
                                <th>Cédula Socio</th>
                                <th>Fecha Consulta</th>
                                <th>Estado Consulta</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- End Alertas y Llamadas Pendientes-->