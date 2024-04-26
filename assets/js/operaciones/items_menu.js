$(document).ready(function () {

    mostrar_contenido("gestionar_items_menu", tabla_items_menu());

});


function tabla_items_menu() {
    $("#tabla_items_menu").DataTable({
        ajax: `${url_operaciones}items_menu/tabla_items_menu.php`,
        columns: [
            { data: "id" },
            { data: "icono_svg" },
            { data: "ruta_enlace" },
            { data: "funcion" },
            { data: "nombre" },
            { data: "badge" },
            { data: "acciones" },
        ],
        bDestroy: true,
        order: [[0, "asc"]],
        language: { url: url_lenguage },
    });
}


function agregar_items_menu(openModal = false) {
    if (openModal == true) {
        $("#txt_icono_svg_aim").val('');
        $("#txt_ruta_enlace_aim").val('');
        $("#txt_funcion_aim").val('');
        $("#txt_nombre_aim").val('');
        $("#txt_badge_aim").val('');
        $("#modal_agregarItemsMenu").modal('show');
    } else {
        let icon_svg = $("#txt_icono_svg_aim").val();
        let ruta_enlace = $("#txt_ruta_enlace_aim").val();
        let funcion = $("#txt_funcion_aim").val();
        let nombre = $("#txt_nombre_aim").val();
        let badge = $("#txt_badge_aim").val();

        if (icon_svg == "") {
            error("Debe ingresar un icono SVG");
        } else if (nombre == "") {
            error("debe ingresar un nombre");
        } else {

            $.ajax({
                type: "POST",
                url: `${url_operaciones}items_menu/agregar_items_menu.php`,
                data: {
                    icon_svg,
                    ruta_enlace,
                    funcion,
                    nombre,
                    badge
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        $("#txt_icono_svg_aim").val('');
                        $("#txt_ruta_enlace_aim").val('');
                        $("#txt_funcion_aim").val('');
                        $("#txt_nombre_aim").val('');
                        $("#txt_badge_aim").val('');
                        tabla_items_menu(false);
                        $("#modal_agregarItemsMenu").modal('hide');
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    }
}


function editar_items_menu(openModal = false, id, icon_svg, ruta_enlace, funcion, nombre, badge) {
    if (openModal == true) {
        $("#txt_id_eim").val(id);
        $("#txt_icono_svg_eim").val(icon_svg);
        $("#txt_ruta_enlace_eim").val(ruta_enlace);
        $("#txt_funcion_eim").val(funcion);
        $("#txt_nombre_eim").val(nombre);
        $("#txt_badge_eim").val(badge);
        $("#modal_editarItemsMenu").modal('show');
    } else {
        let id = $("#txt_id_eim").val();
        let icon_svg = $("#txt_icono_svg_eim").val();
        let ruta_enlace = $("#txt_ruta_enlace_eim").val();
        let funcion = $("#txt_funcion_eim").val();
        let nombre = $("#txt_nombre_eim").val();
        let badge = $("#txt_badge_eim").val();

        if (id == "") {
            error("El campo ID no puede estar vacío");
        } else if (icon_svg == "") {
            error("Debe ingresar un icono SVG");
        } else if (nombre == "") {
            error("debe ingresar un nombre");
        } else {

            $.ajax({
                type: "POST",
                url: `${url_operaciones}items_menu/editar_items_menu.php`,
                data: {
                    id,
                    icon_svg,
                    ruta_enlace,
                    funcion,
                    nombre,
                    badge
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        $("#txt_id_eim").val('');
                        $("#txt_icono_svg_eim").val('');
                        $("#txt_ruta_enlace_eim").val('');
                        $("#txt_funcion_eim").val('');
                        $("#txt_nombre_eim").val('');
                        $("#txt_badge_eim").val('');
                        tabla_items_menu(false);
                        $("#modal_editarItemsMenu").modal('hide');
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    }
}


function eliminar_items_menu(id) {
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
                url: `${url_operaciones}items_menu/eliminar_items_menu.php`,
                data: {
                    id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        tabla_items_menu(false);
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    });
}