<!-- Contenedor Gestionar Etiquetas De Socios -->
<div class="mt-3" id="gestionar_etiquetas_socio" style="display: none">
    <div class="alert alert-light border-secondary" role="alert">
        <h2 class="text-center text-decoration-underline mb-5">Etiquetas de socios</h2>

        <div class="d-flex justify-content-center mb-5">
            <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <div class="input-group">
                        <span class="input-group-text bg-danger text-white" id="basic-addon1">Desde:</span>
                        <input type="date" class="form-control" id="txt_fecha_desde_es" placeholder="Fecha desde" aria-label="Fecha desde" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="col-auto">
                    <div class="input-group">
                        <span class="input-group-text bg-danger text-white" id="basic-addon1">Hasta:</span>
                        <input type="date" class="form-control" id="txt_fecha_hasta_es" placeholder="Fecha hasta" aria-label="Fecha hasta" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="col-auto">
                    <div class="input-group">
                        <span class="input-group-text bg-danger text-white" id="basic-addon1">Cédula:</span>
                        <input type="number" class="form-control" id="txt_filtro_cedula_es" placeholder="Ingrese una cédula" aria-label="Ingrese una cédula" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger" onclick="ejecutar_tabla_etiquetas_socio(false)">🔎</button>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger" onclick="ejecutar_tabla_etiquetas_socio(true)">♻</button>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mb-2">
            <button type="button" class="btn btn-success" onclick="agregar_etiqueta_socio(true)">➕</button>
        </div>


        <div class="table-responsive">
            <table id="tabla_etiquetas_socio" class="table table-sm table-bordered table-striped table-hover" width="100%">
                <thead class="table-dark">
                    <tr>
                        <th scope="col-auto">#</th>
                        <th scope="col-auto">Cédula</th>
                        <th scope="col-auto">Comentario</th>
                        <th scope="col-auto">Sector</th>
                        <th scope="col-auto">Usuario</th>
                        <th scope="col-auto">Fecha Registro</th>
                        <th scope="col-auto">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- Contenedor Gestionar Etiquetas De Socios -->