function tabla_contenido(openModal = false) {
    $("#tabla_contenido").DataTable({
        ajax: `${url_operaciones}contenido/tabla_contenido.php`,
        columns: [
            { data: "id" },
            { data: "nombre" },
            { data: "div" },
            { data: "acciones" },
        ],
        bDestroy: true,
        order: [[0, "asc"]],
        language: { url: url_lenguage },
    });
}


function tabla_contenido_por_area(openModal = false) {
    $("#tabla_contenido_por_area").DataTable({
        ajax: `${url_operaciones}contenido_por_area/tabla_contenido_por_area.php`,
        columns: [
            { data: "id" },
            { data: "area" },
            { data: "contenido" },
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
        $("#txt_div_agregar_contenido").val('');
        $("#modal_agregarContenido").modal("show");
    } else {
        let nombre = $("#txt_nombre_agregar_contenido").val();
        let div = $("#txt_div_agregar_contenido").val();

        if (nombre == "") {
            error("Debe ingresar un nombre");
        } else {

            $.ajax({
                type: "POST",
                url: `${url_operaciones}contenido/agregar_contenido.php`,
                data: {
                    nombre,
                    div
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error == false) {
                        correcto(response.mensaje);
                        $("#txt_nombre_agregar_contenido").val('');
                        $("#txt_div_agregar_contenido").val('');
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


function agregar_contenido_por_area(openModal = false) {
    if (openModal == true) {
        $('#select_area_agregar_contenido_por_area').val('');
        $('#select_contenido_agregar_contenido_por_area').val('');
        select_areas("Agregar", "select_area_agregar_contenido_por_area", null, null);
        select_contenido("Agregar", "select_contenido_agregar_contenido_por_area", null, null);
        $("#modal_agregarContenidoPorArea").modal("show");
    } else {
        let id_usuario = $("#select_area_agregar_contenido_por_area").val();
        let id_contenido = $("#select_contenido_agregar_contenido_por_area").val();

        if (id_usuario == "") {
            error("Debe seleccionar un área");
        } else if (id_contenido == "") {
            error("Debe seleccionar un contenido");
        } else {

            $.ajax({
                type: "POST",
                url: `${url_operaciones}contenido_por_area/agregar_contenido_por_area.php`,
                data: {
                    id_usuario,
                    id_contenido
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error == false) {
                        correcto(response.mensaje);
                        $("#select_area_agregar_contenido_por_area").val('');
                        $("#select_contenido_agregar_contenido_por_area").val('');
                        tabla_contenido_por_area();
                        $("#modal_agregarContenidoPorArea").modal("hide");
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    }
}


function dar_baja_registro(id, url_archivo, tabla) {
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
                url: `${url_operaciones}${url_archivo}`,
                data: {
                    id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        tabla == "contenido" ? tabla_contenido(false) : tabla_contenido_por_area(false);
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    });
}