<!-- Contenedor Gestionar Usuarios -->
<div class="mt-3" id="gestionar_usuarios" style="display: none">
    <div class="alert alert-light border-secondary" role="alert">
        <h2 class="text-center text-decoration-underline">Usuarios</h2>
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-success" onclick="agregar_usuario(true)">➕</button>
        </div>
        <div class="table-responsive">
            <table id="tabla_usuarios" class="table table-sm table-bordered table-striped table-hover" width="100%">
                <thead class="table-dark">
                    <tr>
                        <th scope="col-auto">#</th>
                        <th scope="col-auto">Usuario</th>
                        <th scope="col-auto">Código</th>
                        <th scope="col-auto">Nivel</th>
                        <th scope="col-auto">Filial</th>
                        <th scope="col-auto">Email</th>
                        <th scope="col-auto">Fecha Última Sesión</th>
                        <th scope="col-auto">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- End Contenedor Gestionar Usuarios -->