function tabla_contenido() {
    $("#tabla_contenido").DataTable({
        ajax: `${url_operaciones}contenido/tabla_contenido.php`,
        columns: [
            { data: "id" },
            { data: "nombre" },
            { data: "referencia" },
            { data: "acciones" },
        ],
        bDestroy: true,
        order: [[0, "asc"]],
        language: { url: url_lenguage },
    });
}


function agregar_contenido(openModal = false) {
    if (openModal == true) {
        $("#txt_nombre_agregar_contenido").val('');
        $("#select_agregar_referencia_contenido").val('');
        select_referencia_contenido("Agregar", "select_agregar_referencia_contenido", null, null);
        $("#modal_agregarContenido").modal("show");
    } else {
        let nombre = $("#txt_nombre_agregar_contenido").val();
        let referencia = $("#select_agregar_referencia_contenido").val();

        if (nombre == "") {
            error("Debe ingresar un nombre");
        } else if (referencia == "") {
            error("Debe seleccionar una referencia");
        } else {

            $.ajax({
                type: "POST",
                url: `${url_operaciones}contenido/agregar_contenido.php`,
                data: {
                    nombre,
                    referencia
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error == false) {
                        correcto(response.mensaje);
                        $("#txt_nombre_agregar_contenido").val('');
                        $("#select_agregar_referencia_contenido").val('');
                        tabla_contenido();
                        $("#modal_agregarContenido").modal("hide");
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    }
}


function editar_contenido(openModal = false, id, nombre, id_referencia, referencia) {
    if (openModal == true) {
        $("#txt_id_editar_contenido").val(id);
        $("#txt_nombre_editar_contenido").val(nombre);
        select_referencia_contenido("Editar", "select_editar_referencia_contenido", id_referencia, referencia);
        $("#modal_editarContenido").modal("show");
    } else {

        let id = $("#txt_id_editar_contenido").val();
        let nombre = $("#txt_nombre_editar_contenido").val();
        let referencia = $("#select_editar_referencia_contenido").val();

        if (id == "") {
            error("Debe ingresar un id");
        } else if (nombre == "") {
            error("Debe ingresar un nombre");
        } else if (referencia == "") {
            error("Debe seleccionar una referencia");
        } else {

            $.ajax({
                type: "POST",
                url: `${url_operaciones}contenido/editar_contenido.php`,
                data: {
                    id,
                    nombre,
                    referencia
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error == false) {
                        correcto(response.mensaje);
                        $("#txt_id_editar_contenido").val('');
                        $("#txt_nombre_editar_contenido").val('');
                        $("#select_editar_referencia_contenido").val('');
                        tabla_contenido();
                        $("#modal_editarContenido").modal("hide");
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    }
}


function eliminar_contenido(id) {
    Swal.fire({
        title: "Estas seguro?",
        text: `Vas a eliminar el item #${id}!`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                type: "POST",
                url: `${url_operaciones}contenido/eliminar_contenido.php`,
                data: {
                    id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        tabla_contenido();
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    });
}