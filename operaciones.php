<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/img/favicon.png" type="image/png">
    <title>Operaciones</title>


    <link rel="stylesheet" href="./assets/css/estilos.css">
    <link rel="stylesheet" href="./assets/css/hrstyle.css">

    <!-- Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <!-- Font Awesome 4.5.0 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons 2.0.1 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Datatables 2.0.3 -->
    <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-html5-3.0.1/r-3.0.1/datatables.min.css" rel="stylesheet">
    <!-- Select2 4.1.0 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
</head>

<body>

    <header class="navbar sticky-top bg-dark flex-md-nowrap p-2 shadow" data-bs-theme="dark">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-danger fw-bolder" href="#"> Operaciones <span class="text-white" id="nombre_usuario_en_sesion"></span></a>

        <ul class="navbar-nav flex-row d-md-none">
            <li class="nav-item text-nowrap">
                <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <svg class="bi">
                        <use xlink:href="#list" />
                    </svg>
                </button>
            </li>
        </ul>
    </header>

    <div class="container-fluid">
        <div class="row">
            <div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
                <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title text-danger fw-bolder" id="sidebarMenuLabel"> Operaciones <span class="text-white" id="nombre_usuario_en_sesion"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">

                        <ul class="nav flex-column mb-auto">
                            <li class='nav-item'>
                                <a href='#' class='nav-link d-flex align-items-center gap-2' onclick='desestimar_baja(true)'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                        <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41m-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9" />
                                        <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5 5 0 0 0 8 3M3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9z" />
                                    </svg>
                                    Desestiamar baja otorgada
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>



            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">


                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-gestionar-registros-tab" data-bs-toggle="tab" data-bs-target="#nav-gestionar-registros" type="button" role="tab" aria-controls="nav-gestionar-registros" aria-selected="true" onclick="tabla_registros(true)">Gestionar Registros</button>
                        <button class="nav-link" id="nav-gestionar-items-menu-tab" data-bs-toggle="tab" data-bs-target="#nav-gestionar-items-menu" type="button" role="tab" aria-controls="nav-gestionar-items-menu" aria-selected="false" onclick="tabla_items_menu(true)">Gestionar items menú</button>
                        <button class="nav-link" id="nav-gestionar-menu-por-area-tab" data-bs-toggle="tab" data-bs-target="#nav-gestionar-menu-por-area" type="button" role="tab" aria-controls="nav-gestionar-menu-por-area" aria-selected="false" onclick="tabla_menu(true)">Gestionar menu por área</button>
                        <button class="nav-link" id="nav-gestionar-usuarios-tab" data-bs-toggle="tab" data-bs-target="#nav-gestionar-usuarios" type="button" role="tab" aria-controls="nav-gestionar-usuarios" aria-selected="false" onclick="tabla_usuarios(true)">Gestionar Usuarios</button>
                        <button class="nav-link" id="nav-gestionar-sub-usuarios-tab" data-bs-toggle="tab" data-bs-target="#nav-gestionar-sub-usuarios" type="button" role="tab" aria-controls="nav-gestionar-sub-usuarios" aria-selected="false" onclick="tabla_sub_usuarios(true)">Gestionar Sub Usuarios</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-gestionar-registros" role="tabpanel" aria-labelledby="nav-gestionar-registros-tab" tabindex="0">
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
                    <div class="tab-pane fade" id="nav-gestionar-items-menu" role="tabpanel" aria-labelledby="nav-gestionar-items-menu-tab" tabindex="0">
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
                    <div class="tab-pane fade" id="nav-gestionar-menu-por-area" role="tabpanel" aria-labelledby="nav-gestionar-menu-por-area-tab" tabindex="0">
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
                    <div class="tab-pane fade" id="nav-gestionar-usuarios" role="tabpanel" aria-labelledby="nav-gestionar-usuarios-tab" tabindex="0">
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
                                        <th scope="col-auto">Acciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-gestionar-sub-usuarios" role="tabpanel" aria-labelledby="nav-gestionar-sub-usuarios-tab" tabindex="0">
                        <div class="d-flex justify-content-end mb-3">
                            <button class="btn btn-success" onclick="agregar_sub_usuario(true)">➕</button>
                        </div>
                        <div class="table-responsive">
                            <table id="tabla_sub_usuarios" class="table table-sm table-bordered table-striped table-hover" width="100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col-auto">#</th>
                                        <th scope="col-auto">Área</th>
                                        <th scope="col-auto">Nombre</th>
                                        <th scope="col-auto">Apellido</th>
                                        <th scope="col-auto">Cedula</th>
                                        <th scope="col-auto">Gestor</th>
                                        <th scope="col-auto">Acciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>


            </main>




            <!-- Modals -->
            <?php
            $array_modals = [
                "operaciones/items_menu/modal_agregar_items_menu.html",
                "operaciones/items_menu/modal_editar_items_menu.html",
                "operaciones/menu/modal_agregar_menu.html",
                "operaciones/sub_usuarios/modal_agregar_sub_usuario.html",
                "operaciones/sub_usuarios/modal_editar_sub_usuario.html",
                "operaciones/usuarios/modal_agregar_usuario.html",
                "operaciones/modal_desestimar_baja.html",
                "modal_mostrar_imagenes.html",
                "modal_ver_mas_comentarios.html",
            ];

            foreach ($array_modals as $modal) {
                include_once('./views/modals/' . $modal);
            }
            ?>
            <!-- End Modals -->




            <!-- JQUERY 3.7.1 -->
            <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
            <!-- Popper 1.14.3 -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
            <!-- Bootstrap 5.3.3 -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>
            <!-- SweetAlert 2@11 -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <!-- Datatables 2.0.3 -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
            <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-html5-3.0.1/r-3.0.1/datatables.min.js"></script>
            <!-- Select2 4.1.0 -->
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

            <script src="./assets/js/funciones.js"></script>
            <script src="./assets/js/operaciones/funciones.js"></script>
            <script src="./assets/js/operaciones/items_menu.js"></script>
            <script src="./assets/js/operaciones/menu.js"></script>
            <script src="./assets/js/operaciones/registros.js"></script>
            <script src="./assets/js/operaciones/usuarios.js"></script>
            <script src="./assets/js/operaciones/sub_usuarios.js"></script>
</body>

</html>