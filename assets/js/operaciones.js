const url_operaciones = `${url_app}/php/ajax/operaciones/`;



function tabla_registros(openModal = false) {
    $("#tabla_registros").DataTable({
        ajax: `${url_operaciones}tabla_registros.php`,
        columns: [
            { data: "id" },
            { data: "cedula" },
            { data: "nombre" },
            { data: "telefono" },
            { data: "fecha_registro" },
            { data: "sector" },
            { data: "usuario" },
            { data: "socio" },
            { data: "baja" },
            { data: "observacion" },
            { data: "envio_sector" },
            { data: "acciones" },
        ],
        bDestroy: true,
        order: [[0, "desc"]],
        language: { url: url_lenguage },
    });

    if (openModal == true) $("#modal_gestionarRegistros").modal("show");
}

function abrirModalVerMas(observacion) {
    Swal.fire({
        title: "Observación!",
        html: observacion,
        icon: "info"
    });
}

function confirmar_eliminar_registro(id) {
    Swal.fire({
        title: "Estas seguro?",
        text: `Vas a eliminar el registro #${id}!`,
        icon: "warning",
        reverseButtons: true,
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        cancelButtonColor: "#DC3545",
        confirmButtonText: "Si, eliminar!",
        confirmButtonColor: "#198754",
    }).then((result) => {
        if (result.isConfirmed) {
            eliminar_registro(id);
        }
    });
}

function eliminar_registro(id) {
    $.ajax({
        type: "POST",
        url: `${url_operaciones}eliminar_registro.php`,
        data: {
            id
        },
        dataType: "JSON",
        success: function (response) {
            if (response.error === false) {
                correcto(response.mensaje);
                tabla_registros();
            } else {
                error(response.mensaje);
            }
        }
    });
}

function modal_ver_imagen_registro(ruta, imagenes) {
    let imagen = imagenes.split(', ');
    let div = document.getElementById('mostrar_imagenes_relamos');
    div.innerHTML = "";

    imagen.map((val) => {
        let separar_nombre_archivo = val.split('.');
        let extencion_archivo = separar_nombre_archivo[1];
        div.innerHTML +=
            extencion_archivo != 'pdf' ?
                `<img src="${ruta}/${val}" class="mb-3" style="width: 100%; height: auto">` :
                `<iframe src="${ruta}/${val}" class="mb-3" width=100% height=600></iframe>`;
    });

    $("#modalVerImagenesRegistro").modal("show");
}

function desestimar_baja(openModal = false) {
    if (openModal == true) {
        $("#modal_desestimarBaja").modal("show");
    } else {
        let cedula = $("#txt_cedula").val();

        if (cedula == "") {
            error("Debe ingresar una cédula");
        } else if (controlCedula(cedula) == false) {
            error("Debe ingresar una cédula válida");
        } else {

            $.ajax({
                type: "POST",
                url: `${url_operaciones}desestimar_baja.php`,
                data: {
                    cedula
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        tabla_registros();
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    }
}

function tabla_items_menu(openModal = false) {
    $("#tabla_items_menu").DataTable({
        ajax: `${url_operaciones}tabla_items_menu.php`,
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

    if (openModal == true) $("#modal_gestionarItemsMenu").modal("show");
}

function tabla_menu(openModal = false) {
    $("#tabla_menu").DataTable({
        ajax: `${url_operaciones}tabla_menu.php`,
        columns: [
            { data: "id" },
            { data: "area" },
            { data: "item" },
            { data: "acciones" },
        ],
        bDestroy: true,
        order: [[0, "asc"]],
        language: { url: url_lenguage },
    });

    if (openModal == true) $("#modal_gestionarMenu").modal("show");
}

function agregar_menu(openModal = false) {
    if (openModal == true) {
        $("#select_area_am").val('');
        $("#select_item_am").val('');
        select_areas();
        select_items();
        $("#modal_agregarMenu").modal('show');
    } else {
        let select_area = $("#select_area_am").val();
        let select_item = $("#select_item_am").val();

        if (select_area == "") {
            error("Debe seleccionar un área");
        } else if (select_item == "") {
            error("Debe seleccionar un item");
        } else {

            $.ajax({
                type: "POST",
                url: `${url_operaciones}agregar_menu.php`,
                data: {
                    select_area,
                    select_item
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        $("#select_area_am").val('');
                        $("#select_item_am").val('');
                        tabla_menu(false);
                        $("#modal_agregarMenu").modal('hide');
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    }
}

function select_areas() {
    let div = document.getElementById("select_area_am");
    div.innerHTML = '<option selected value="">Seleccione una opción</option>';

    $.ajax({
        url: `${url_operaciones}select_areas.php`,
        dataType: 'JSON',
        beforeSend: function () {
            mostrarLoader();
        },
        complete: function () {
            mostrarLoader("O");
        },
        success: function (r) {
            $.each(r.datos, function (i, v) {
                div.innerHTML += `<option value="${v.id}">${v.usuario}</option>`;
            });
        },
    });
}

function select_items() {
    let div = document.getElementById("select_item_am");
    div.innerHTML = '<option selected value="">Seleccione una opción</option>';

    $.ajax({
        url: `${url_operaciones}select_items.php`,
        dataType: 'JSON',
        beforeSend: function () {
            mostrarLoader();
        },
        complete: function () {
            mostrarLoader("O");
        },
        success: function (r) {
            $.each(r.datos, function (i, v) {
                div.innerHTML += `<option value="${v.id}">${v.nombre}</option>`;
            });
        },
    });
}

function eliminar_menu(id) {
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
                url: `${url_operaciones}eliminar_menu.php`,
                data: {
                    id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        tabla_menu(false);
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
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
                url: `${url_operaciones}agregar_items_menu.php`,
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
                url: `${url_operaciones}editar_items_menu.php`,
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
                url: `${url_operaciones}eliminar_items_menu.php`,
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