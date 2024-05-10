<!-- Contenedor Gestionar Registros De Socios -->
<div class="mt-3" id="gestionar_registros" style="display: none">
    <div class="alert alert-light border-secondary" role="alert">
        <h2 class="text-center text-decoration-underline mb-5">Registros de socios</h2>

        <div class="d-flex justify-content-center mb-5">
            <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <div class="input-group">
                        <span class="input-group-text bg-danger text-white" id="basic-addon1">Desde:</span>
                        <input type="date" class="form-control" id="txt_fecha_desde_r" placeholder="Fecha desde" aria-label="Fecha desde" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="col-auto">
                    <div class="input-group">
                        <span class="input-group-text bg-danger text-white" id="basic-addon1">Hasta:</span>
                        <input type="date" class="form-control" id="txt_fecha_hasta_r" placeholder="Fecha hasta" aria-label="Fecha hasta" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="col-auto">
                    <div class="input-group">
                        <span class="input-group-text bg-danger text-white" id="basic-addon1">Cédula:</span>
                        <input type="number" class="form-control" id="txt_filtro_cedula_r" placeholder="Ingrese una cédula" aria-label="Ingrese una cédula" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger" onclick="ejecutar_tabla_registros(false)">🔎</button>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mb-2">
            <button type="button" class="btn btn-danger" onclick="ejecutar_tabla_registros(true)">♻</button>
        </div>


        <div class="table-responsive">
            <table id="tabla_registros" class="table table-sm table-bordered table-striped table-hover" width="100%">
                <thead class="table-dark">
                    <tr>
                        <th scope="col-auto">#</th>
                        <th scope="col-auto">Cédula</th>
                        <th scope="col-auto">Nombre</th>
                        <th scope="col-auto">Teléfono</th>
                        <th scope="col-auto">Fecha/Hora</th>
                        <th scope="col-auto">Sector</th>
                        <th scope="col-auto">Usuario</th>
                        <th scope="col-auto">Socio</th>
                        <th scope="col-auto">Baja</th>
                        <th scope="col-auto">Comentario</th>
                        <th scope="col-auto">Avisar a</th>
                        <th scope="col-auto">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- Contenedor Gestionar Registros De Socios -->