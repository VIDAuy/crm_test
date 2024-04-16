<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/img/favicon.png" type="image/png">
    <title>Operaciones</title>


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

    <button class="btn btn-danger mb-3" onclick="desestimar_baja(true)">Desestiamar Baja</button>

    <button class="btn btn-danger mb-3" onclick="tabla_registros(true)">Dar Baja Registros</button>

    <button class="btn btn-primary mb-3" onclick="tabla_items_menu(true)">Gestionar items menú</button>

    <button class="btn btn-primary mb-3" onclick="tabla_menu(true)">Gestionar menú por área</button>


    <!-- Modal Desestimar Baja -->
    <div class="modal fade" id="modal_desestimarBaja" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Desestimar Baja</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="txt_cedula" placeholder="Ingrese la cédula:" maxlength="8">
                        <label for="txt_cedula">Ingrese la cédula:</label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="desestimar_baja(false)">Enviar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Desestimar Baja -->

    <!-- Modal Gestionar Registros -->
    <div class="modal fade" id="modal_gestionarRegistros" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Dar Baja Registros</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Gestionar Registros -->

    <!-- Modal Gestionar Items Menú -->
    <div class="modal fade" id="modal_gestionarItemsMenu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Gestionar Items Menú</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Gestionar Items Menú -->

    <!-- Modal Agregar Items Menú -->
    <div class="modal fade" id="modal_agregarItemsMenu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Agregar Item Menú</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Icono SVG" id="txt_icono_svg_aim"></textarea>
                        <label for="txt_icono_svg_aim">Icono SVG</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="txt_ruta_enlace_aim" placeholder="Ruta Enlace">
                        <label for="txt_ruta_enlace_aim">Ruta Enlace</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="txt_funcion_aim" placeholder="Función">
                        <label for="txt_funcion_aim">Función</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="txt_nombre_aim" placeholder="Nombre">
                        <label for="txt_nombre_aim">Nombre</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="txt_badge_aim" placeholder="Badge">
                        <label for="txt_badge_aim">Badge</label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="agregar_items_menu(false)">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Agregar Items Menú -->

    <!-- Modal Editar Items Menú -->
    <div class="modal fade" id="modal_editarItemsMenu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Gestionar Item Menú</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="txt_id_eim" placeholder="ID" disabled>
                        <label for="txt_id_eim">ID</label>
                    </div>

                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Icono SVG" id="txt_icono_svg_eim"></textarea>
                        <label for="txt_icono_svg_eim">Icono SVG</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="txt_ruta_enlace_eim" placeholder="Ruta Enlace">
                        <label for="txt_ruta_enlace_eim">Ruta Enlace</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="txt_funcion_eim" placeholder="Función">
                        <label for="txt_funcion_eim">Función</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="txt_nombre_eim" placeholder="Nombre">
                        <label for="txt_nombre_eim">Nombre</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="txt_badge_eim" placeholder="Badge">
                        <label for="txt_badge_eim">Badge</label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="editar_items_menu(false)">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Editar Items Menú -->

    <!-- Modal Gestionar Menú -->
    <div class="modal fade" id="modal_gestionarMenu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Gestionar Menú</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Gestionar Menú -->

    <!-- Modal Agregar Menú -->
    <div class="modal fade" id="modal_agregarMenu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Agregar Item Menú</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="form-floating mb-3">
                        <select class="form-select" id="select_area_am" aria-label="Seleccione un área">
                        </select>
                        <label for="select_area_am">Seleccione un área</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" id="select_item_am" aria-label="Seleccione un item">
                            <option selected>Seleccione una opción</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                        <label for="select_item_am">Seleccione un item</label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="agregar_menu(false)">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Agregar Menú -->








    <!-- Modals -->
    <?php include_once './views/modals/modal_mostrar_imagenes.html'; ?>
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
    <script src="./assets/js/operaciones.js"></script>
</body>

</html>