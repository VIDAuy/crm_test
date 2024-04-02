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

    <div class="alert alert-light border-secondary ms-2 me-2 mt-3 mb-5" role="alert">
        <h3 class="text-center mb-3"><u>Desestimar Baja:</u></h3>
        <div class="input-group mb-3">
            <span class="input-group-text">Ingrese la cédula:</span>
            <input type="number" class="form-control" id="txt_cedula" maxlength="8" />
            <button class="btn btn-danger input-group-text" onclick="desestimar_baja()">Enviar</button>
        </div>
    </div>



    <div class="alert alert-light border-secondary ms-2 me-2" role="alert">
        <h3 class="text-center"><u>Registros:</u></h3>
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
                <tbody class="table-group-divider" id="historiaComunicacionDeCedula">
                </tbody>
            </table>
        </div>
    </div>


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