<!-- Contenedor Gestionar Items Menú -->
<div class="mt-3" id="gestionar_items_menu" style="display: none">
    <div class="alert alert-light border-secondary" role="alert">
        <h2 class="text-center text-decoration-underline">Items Menú</h2>
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-success" onclick="agregar_items_menu(true)">➕</button>
        </div>
        <div class="table-responsive">
            <table id="tabla_items_menu" class="table table-sm table-bordered table-striped table-hover" width="100%">
                <thead class="table-dark">
                    <tr>
                        <th scope="col-auto">#</th>
                        <th scope="col-auto">Icono SVG</th>
                        <th scope="col-auto">Ruta Enlace</th>
                        <th scope="col-auto">Función</th>
                        <th scope="col-auto">Nombre</th>
                        <th scope="col-auto">Badge</th>
                        <th scope="col-auto">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- End Contenedor Gestionar Items Menu -->