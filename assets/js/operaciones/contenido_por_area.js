function tabla_contenido_por_area() {
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


function editar_contenido_por_area(openModal = false, id, id_usuario, usuario, id_contenido, contenido) {
    if (openModal == true) {
        $("#txt_id_editar_contenido_por_area").val(id);
        select_areas("Editar", "select_area_editar_contenido_por_area", id_usuario, usuario);
        select_contenido("Editar", "select_contenido_editar_contenido_por_area", id_contenido, contenido);
        $("#modal_editarContenidoPorArea").modal("show");
    } else {

        let id = $("#txt_id_editar_contenido_por_area").val();
        let usuario = $("#select_area_editar_contenido_por_area").val();
        let contenido = $("#select_contenido_editar_contenido_por_area").val();

        if (id == "") {
            error("Debe ingresar un id");
        } else if (usuario == "") {
            error("Debe seleccionar un área");
        } else if (contenido == "") {
            error("Debe seleccionar un contenido");
        } else {

            $.ajax({
                type: "POST",
                url: `${url_operaciones}contenido_por_area/editar_contenido_por_area.php`,
                data: {
                    id,
                    usuario,
                    contenido
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error == false) {
                        correcto(response.mensaje);
                        $("#txt_id_editar_contenido_por_area").val('');
                        $("#select_area_editar_contenido_por_area").val('');
                        $("#select_contenido_editar_contenido_por_area").val('');
                        tabla_contenido_por_area();
                        $("#modal_editarContenidoPorArea").modal("hide");
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    }
}


function eliminar_contenido_por_area(id) {
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
                url: `${url_operaciones}contenido_por_area/eliminar_contenido_por_area.php`,
                data: {
                    id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        tabla_contenido_por_area();
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    });
}