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
                                <a href='#' class='nav-link d-flex align-items-center gap-2' onclick='mostrar_contenido("gestionar_items_menu", tabla_items_menu())'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-menu-up" viewBox="0 0 16 16">
                                        <path d="M7.646 15.854a.5.5 0 0 0 .708 0L10.207 14H14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h3.793zM1 9V6h14v3zm14 1v2a1 1 0 0 1-1 1h-3.793a1 1 0 0 0-.707.293l-1.5 1.5-1.5-1.5A1 1 0 0 0 5.793 13H2a1 1 0 0 1-1-1v-2zm0-5H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1zM2 11.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 0-1h-8a.5.5 0 0 0-.5.5m0-4a.5.5 0 0 0 .5.5h11a.5.5 0 0 0 0-1h-11a.5.5 0 0 0-.5.5m0-4a.5.5 0 0 0 .5.5h6a.5.5 0 0 0 0-1h-6a.5.5 0 0 0-.5.5" />
                                    </svg>
                                    Items Menú
                                </a>
                                <a href='#' class='nav-link d-flex align-items-center gap-2' onclick='mostrar_contenido("gestionar_menu_por_area", tabla_menu())'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
                                    </svg>
                                    Menú por Área
                                </a>
                                <a href='#' class='nav-link d-flex align-items-center gap-2' onclick='mostrar_contenido("gestionar_menu_por_usuario", tabla_menu_por_usuarios())'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
                                    </svg>
                                    Menú por usuario
                                </a>
                                <a href='#' class='nav-link d-flex align-items-center gap-2' onclick='mostrar_contenido("gestionar_contenido", tabla_contenido())'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive-fill" viewBox="0 0 16 16">
                                        <path d="M12.643 15C13.979 15 15 13.845 15 12.5V5H1v7.5C1 13.845 2.021 15 3.357 15zM5.5 7h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1M.8 1a.8.8 0 0 0-.8.8V3a.8.8 0 0 0 .8.8h14.4A.8.8 0 0 0 16 3V1.8a.8.8 0 0 0-.8-.8z" />
                                    </svg>
                                    Contenido
                                </a>
                                <a href='#' class='nav-link d-flex align-items-center gap-2' onclick='mostrar_contenido("gestionar_contenido_por_area", tabla_contenido_por_area())'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-body-text" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M0 .5A.5.5 0 0 1 .5 0h4a.5.5 0 0 1 0 1h-4A.5.5 0 0 1 0 .5m0 2A.5.5 0 0 1 .5 2h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m9 0a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-9 2A.5.5 0 0 1 .5 4h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m5 0a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m7 0a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-12 2A.5.5 0 0 1 .5 6h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m8 0a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-8 2A.5.5 0 0 1 .5 8h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m7 0a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-7 2a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5" />
                                    </svg>
                                    Contenido por Área
                                </a>
                                <a href='#' class='nav-link d-flex align-items-center gap-2' onclick='mostrar_contenido("gestionar_usuarios", tabla_usuarios())'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                    </svg>
                                    Usuarios
                                </a>
                                <a href='#' class='nav-link d-flex align-items-center gap-2' onclick='mostrar_contenido("gestionar_sub_usuarios", tabla_sub_usuarios())'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                                        <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z" />
                                    </svg>
                                    Sub Usuarios
                                </a>
                                <a href='#' class='nav-link d-flex align-items-center gap-2' onclick='mostrar_contenido("gestionar_registros", tabla_registros())'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-list" viewBox="0 0 16 16">
                                        <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z" />
                                        <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8m0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0M4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0" />
                                    </svg>
                                    Registros
                                </a>
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

                <div id="container" style="width: 100%">
                    <!-- Contenedor Gestionar Items Menú -->
                    <div id="gestionar_items_menu" style="display: none">
                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <button class="btn btn-lg btn-outline-success rounded-4" onclick="agregar_items_menu(true)">Agregar Item Menú</button>
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
                    <!-- End Contenedor Gestionar Items Menu -->

                    <!-- Contenedor Gestionar Menú Por Área -->
                    <div id="gestionar_menu_por_area" style="display: none">
                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <button class="btn btn-lg btn-outline-success rounded-4" onclick="agregar_menu(true)">Agregar Menú por Área</button>
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
                    <!-- End Contenedor Gestionar Menú Por Área -->

                    <!-- Contenedor Gestionar Menú Por Usuario -->
                    <div id="gestionar_menu_por_usuario" style="display: none">
                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <button class="btn btn-lg btn-outline-success rounded-4" onclick="agregar_menu_por_usuario(true)">Agregar Menú Por Usuario</button>
                        </div>
                        <div class="table-responsive">
                            <table id="tabla_menu_por_usuario" class="table table-sm table-bordered table-striped table-hover" width="100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col-auto">#</th>
                                        <th scope="col-auto">Área</th>
                                        <th scope="col-auto">Usuario</th>
                                        <th scope="col-auto">Item</th>
                                        <th scope="col-auto">Acciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- End Contenedor Gestionar Menú Por Usuario -->

                    <!-- Contenedor Gestionar Contenido CRM -->
                    <div id="gestionar_contenido" style="display: none">
                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <button class="btn btn-lg btn-outline-success rounded-4" onclick="agregar_contenido(true)">Agregar Contenido</button>
                        </div>
                        <div class="table-responsive">
                            <table id="tabla_contenido" class="table table-sm table-bordered table-striped table-hover" width="100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col-auto">#</th>
                                        <th scope="col-auto">Nombre</th>
                                        <th scope="col-auto">Div</th>
                                        <th scope="col-auto">Acciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- End Contenedor Gestionar Contenido CRM -->

                    <!-- Contenedor Gestionar Contenido CRM Por Área -->
                    <div id="gestionar_contenido_por_area" style="display: none">
                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <button class="btn btn-lg btn-outline-success rounded-4" onclick="agregar_contenido_por_area(true)">Agregar Contenido Por Área</button>
                        </div>
                        <div class="table-responsive">
                            <table id="tabla_contenido_por_area" class="table table-sm table-bordered table-striped table-hover" width="100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col-auto">#</th>
                                        <th scope="col-auto">Nombre</th>
                                        <th scope="col-auto">Contenido</th>
                                        <th scope="col-auto">Acciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- End Contenedor Gestionar Contenido CRM Por Área -->

                    <!-- Contenedor Gestionar Usuarios -->
                    <div id="gestionar_usuarios" style="display: none">
                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <button class="btn btn-lg btn-outline-success rounded-4" onclick="agregar_usuario(true)">Agregar Usuario</button>
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
                    <!-- End Contenedor Gestionar Usuarios -->

                    <!-- Contenedor Gestionar Sub Usuarios -->
                    <div id="gestionar_sub_usuarios" style="display: none">
                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <button class="btn btn-lg btn-outline-success rounded-4" onclick="agregar_sub_usuario(true)">Agregar Sub Usuario</button>
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
                    <!-- End Contenedor Gestionar Sub Usuarios -->

                    <!-- Contenedor Gestionar Registros De Socios -->
                    <div id="gestionar_registros" style="display: none">
                        <div class="table-responsive mt-4">
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
                    <!-- Contenedor Gestionar Registros De Socios -->
                </div>


            </main>




            <!-- Modals -->
            <?php
            $array_modals = [
                "operaciones/items_menu/modal_agregar_items_menu.html",
                "operaciones/items_menu/modal_editar_items_menu.html",
                "operaciones/menu/modal_agregar_menu.html",
                "operaciones/menu_por_usuario/modal_agregar_menu_por_usuario.html",
                "operaciones/contenido/modal_agregar_contenido.html",
                "operaciones/contenido_por_area/modal_agregar_contenido_por_area.html",
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
            <script src="./assets/js/operaciones/menu_por_usuarios.js"></script>
            <script src="./assets/js/operaciones/contenido.js"></script>
            <script src="./assets/js/operaciones/registros.js"></script>
            <script src="./assets/js/operaciones/usuarios.js"></script>
            <script src="./assets/js/operaciones/sub_usuarios.js"></script>
</body>

</html>