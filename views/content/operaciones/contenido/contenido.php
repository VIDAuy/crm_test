<!-- Contenedor Gestionar Contenido CRM -->
<div class="mt-3" id="gestionar_contenido" style="display: none">
    <div class="alert alert-light border-secondary" role="alert">
        <h2 class="text-center text-decoration-underline">Contenido</h2>
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-success" onclick="agregar_contenido(true)">➕</button>
        </div>
        <div class="table-responsive">
            <table id="tabla_contenido" class="table table-sm table-bordered table-striped table-hover" width="100%">
                <thead class="table-dark">
                    <tr>
                        <th scope="col-auto">#</th>
                        <th scope="col-auto">Nombre</th>
                        <th scope="col-auto">Referencia</th>
                        <th scope="col-auto">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- End Contenedor Gestionar Contenido CRM -->