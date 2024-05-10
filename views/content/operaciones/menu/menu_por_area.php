<!-- Contenedor Gestionar Menú Por Área -->
<div class="mt-3" id="gestionar_menu_por_area" style="display: none">
    <div class="alert alert-light border-secondary" role="alert">
        <h2 class="text-center text-decoration-underline">Menú por área</h2>
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-success" onclick="agregar_menu(true)">➕</button>
        </div>
        <div class="table-responsive">
            <table id="tabla_menu" class="table table-sm table-bordered table-striped table-hover" width="100%">
                <thead class="table-dark">
                    <tr>
                        <th scope="col-auto">#</th>
                        <th scope="col-auto">Área</th>
                        <th scope="col-auto">Item</th>
                        <th scope="col-auto">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- End Contenedor Gestionar Menú Por Área -->