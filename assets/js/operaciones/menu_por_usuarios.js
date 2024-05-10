function tabla_menu_por_usuarios() {
    $("#tabla_menu_por_usuario").DataTable({
        ajax: `${url_operaciones}menu_por_usuarios/tabla_menu_por_usuario.php`,
        columns: [
            { data: "id" },
            { data: "area" },
            { data: "usuario" },
            { data: "item" },
            { data: "acciones" },
        ],
        bDestroy: true,
        order: [[0, "asc"]],
        language: { url: url_lenguage },
    });
}


function agregar_menu_por_usuario(openModal = false) {
    if (openModal == true) {
        $("#select_area_agregar_menu_por_usuario").val('');
        $("#select_usuario_agregar_menu_por_usuario").val('');
        $("#select_item_agregar_menu_por_usuario").val('');
        select_areas_con_identificacion("Agregar", "select_area_agregar_menu_por_usuario", null, null);
        $("#select_usuario_agregar_menu_por_usuario").prop('disabled', true);
        select_items("select_item_agregar_menu_por_usuario");
        $("#modal_agregarMenuUsuario").modal("show");
    } else {
        let id_area = $("#select_area_agregar_menu_por_usuario").val();
        let id_usuario = $("#select_usuario_agregar_menu_por_usuario").val();
        let id_item = $("#select_item_agregar_menu_por_usuario").val();

        if (id_area == "") {
            error("Debe seleccionar un área");
        } else if (id_usuario == "") {
            error("Debe seleccionar un usuario");
        } else if (id_item == "") {
            error("Debe seleccionar un item");
        } else {

            $.ajax({
                type: "POST",
                url: `${url_operaciones}menu_por_usuarios/agregar_menu_por_usuario.php`,
                data: {
                    id_area,
                    id_usuario,
                    id_item
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        tabla_menu_por_usuarios();
                        $("#select_area_agregar_menu_por_usuario").val('');
                        $("#select_usuario_agregar_menu_por_usuario").val('');
                        $("#select_item_agregar_menu_por_usuario").val('');
                        $("#modal_agregarMenuUsuario").modal("hide");
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    }
}


function eliminar_menu_por_usuario(id) {
    Swal.fire({
        title: "Estas seguro?",
        text: `Vas a eliminar el menú #${id}!`,
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
                url: `${url_operaciones}menu_por_usuarios/eliminar_menu_por_usuario.php`,
                data: {
                    id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        tabla_menu_por_usuarios();
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    });
}


$(document).on('change', '#select_area_agregar_menu_por_usuario', function (event) {
    let id_area = $('#select_area_agregar_menu_por_usuario').val();

    if (id_area != "") {
        select_usuarios_del_area("select_usuario_agregar_menu_por_usuario", id_area);
    } else {
        $("#select_usuario_agregar_menu_por_usuario").prop('disabled', true);
    }
});