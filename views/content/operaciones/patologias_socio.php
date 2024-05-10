<!-- Contenedor Gestionar Etiquetas De Socios -->
<div class="mt-3" id="gestionar_patologias_socio" style="display: none">
    <div class="alert alert-light border-secondary" role="alert">
        <h2 class="text-center text-decoration-underline mb-5">Patologías de socios</h2>

        <div class="d-flex justify-content-center mb-5">
            <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <div class="input-group">
                        <span class="input-group-text bg-danger text-white" id="basic-addon1">Desde:</span>
                        <input type="date" class="form-control" id="txt_fecha_desde_ps" placeholder="Fecha desde" aria-label="Fecha desde" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="col-auto">
                    <div class="input-group">
                        <span class="input-group-text bg-danger text-white" id="basic-addon1">Hasta:</span>
                        <input type="date" class="form-control" id="txt_fecha_hasta_ps" placeholder="Fecha hasta" aria-label="Fecha hasta" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="col-auto">
                    <div class="input-group">
                        <span class="input-group-text bg-danger text-white" id="basic-addon1">Cédula:</span>
                        <input type="number" class="form-control" id="txt_filtro_cedula_ps" placeholder="Ingrese una cédula" aria-label="Ingrese una cédula" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger" onclick="ejecutar_tabla_patologias_socio(false)">🔎</button>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger" onclick="ejecutar_tabla_patologias_socio(true)">♻</button>
                </div>
            </div>
        </div>

        <div class="alert alert-warning border-warning" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill me-2" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
            </svg>
            <span>¡Primero se debe eliminar el registro de CRM y luego eliminar la patología desde aquí!</span>
        </div>


        <div class="table-responsive">
            <table id="tabla_patologias_socio" class="table table-sm table-bordered table-striped table-hover" width="100%">
                <thead class="table-dark">
                    <tr>
                        <th scope="col-auto">#</th>
                        <th scope="col-auto">Cédula</th>
                        <th scope="col-auto">Patología</th>
                        <th scope="col-auto">Observación</th>
                        <th scope="col-auto">Fecha Registro</th>
                        <th scope="col-auto">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- Contenedor Gestionar Etiquetas De Socios -->