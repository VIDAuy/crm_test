function ejecutar_tabla_etiquetas_socio(formatiarInputsFecha = false) {
    let fecha = new Date();
    let fecha_actual = fecha.toJSON().slice(0, 10);

    if (formatiarInputsFecha == true) {
        $("#txt_fecha_desde_es").val(`${fecha_actual}`);
        $("#txt_fecha_hasta_es").val(`${fecha_actual}`);
        $("#txt_filtro_cedula_es").val('');
    }


    let cedula = $("#txt_filtro_cedula_es").val();
    if (cedula == "") {
        let fecha_desde = $("#txt_fecha_desde_es").val();
        let fecha_hasta = $("#txt_fecha_hasta_es").val();

        if (fecha_desde == "") {
            error("Debe ingresar una fecha desde");
        } else if (fecha_hasta == "") {
            error("Debe ingresar una fecha hasta");
        } else if (fecha_desde > fecha_actual) {
            error("La fecha desde no puede ser mayor a la fecha actual");
        } else if (fecha_hasta > fecha_actual) {
            error("La fecha hasta no puede ser mayor a la fecha actual");
        } else if (fecha_desde > fecha_hasta) {
            error("La fecha desde debe ser menor a la fecha hasta");
        } else {
            tabla_etiquetas_socio(fecha_desde, fecha_hasta, null);
        }
    } else {

        let cedula = $("#txt_filtro_cedula_es").val();

        if (cedula == "") {
            error("Ingrese una cédula para filtrar");
        } else if (comprobarCI(cedula) === false) {
            error("Debe ingresar una cédula válida");
        } else {
            tabla_etiquetas_socio(null, null, cedula);
        }
    }
}


function tabla_etiquetas_socio(fecha_desde = null, fecha_hasta = null, cedula = null) {
    $("#tabla_etiquetas_socio").DataTable({
        ajax: `${url_operaciones}etiquetas_socio/tabla_etiquetas_socio.php?fecha_desde=${fecha_desde}&fecha_hasta=${fecha_hasta}&cedula=${cedula}`,
        columns: [
            { data: "id" },
            { data: "cedula" },
            { data: "mensaje" },
            { data: "sector" },
            { data: "usuario" },
            { data: "fecha_registro" },
            { data: "acciones" },
        ],
        bDestroy: true,
        order: [[0, "asc"]],
        language: { url: url_lenguage },
    });
}


$("#select_area_agregar_etiquetas_socio").change(function () {
    let id_area = $("#select_area_agregar_etiquetas_socio").val();

    if (id_area != "") {
        select_usuarios_del_area("Agregar", "select_sub_usuarios_agregar_etiquetas_socio", id_area, null, null);
        $("#select_sub_usuarios_agregar_etiquetas_socio").prop('disabled', false);
    } else {
        $("#select_sub_usuarios_agregar_etiquetas_socio").prop('disabled', true);
    }
});


function agregar_etiqueta_socio(openModal = false) {
    if (openModal === true) {
        $("#txt_cedula_agregar_etiquetas_socio").val('');
        $("#txt_mensaje_agregar_etiquetas_socio").val('');
        select_areas_con_identificacion("Agregar", "select_area_agregar_etiquetas_socio", null, null);
        $("#select_sub_usuarios_agregar_etiquetas_socio").prop('disabled', true);
        $("#modal_agregarEtiquetaSocio").modal("show");

    } else {

        let cedula = $("#txt_cedula_agregar_etiquetas_socio").val();
        let mensaje = $("#txt_mensaje_agregar_etiquetas_socio").val();
        let sector = $("#select_area_agregar_etiquetas_socio").val();
        let usuario = $("#select_sub_usuarios_agregar_etiquetas_socio").val();

        if (cedula == "") {
            error("Debe ingresar una cédula");
        } else if (comprobarCI(cedula) === false) {
            error("Debe ingresar una cédula válida");
        } else if (mensaje == "") {
            error("Debe ingresar una mensaje");
        } else if (sector == "") {
            error("Debe seleccionar un área");
        } else if (usuario == "") {
            error("Debe seleccionar un usuario");
        } else {

            $.ajax({
                type: "POST",
                url: `${url_operaciones}etiquetas_socio/agregar_etiqueta_socio.php?`,
                data: {
                    cedula,
                    mensaje,
                    sector,
                    usuario
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        $("#txt_cedula_agregar_etiquetas_socio").val('');
                        $("#txt_mensaje_agregar_etiquetas_socio").val('');
                        $("#select_area_agregar_etiquetas_socio").val('');
                        $("#select_sub_usuarios_agregar_etiquetas_socio").val('');
                        ejecutar_tabla_etiquetas_socio(true);
                        $("#modal_agregarEtiquetaSocio").modal("hide");
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }

    }
}


$("#select_area_editar_etiquetas_socio").change(function () {
    let id_area = $("#select_area_editar_etiquetas_socio").val();

    if (id_area != "") {
        select_usuarios_del_area("Agregar", "select_sub_usuarios_editar_etiquetas_socio", id_area, null, null);
        $("#select_sub_usuarios_editar_etiquetas_socio").prop('disabled', false);
    } else {
        $("#select_sub_usuarios_editar_etiquetas_socio").prop('disabled', true);
    }
});


function editar_etiqueta_socio(openModal = false, id, cedula, mensaje, id_area, sector, id_sub_usuario, usuario) {
    if (openModal === true) {
        $("#txt_id_editar_etiquetas_socio").val(id);
        $("#txt_cedula_editar_etiquetas_socio").val(cedula);
        $("#txt_mensaje_editar_etiquetas_socio").val(mensaje);
        select_areas_con_identificacion("Editar", "select_area_editar_etiquetas_socio", id_area, sector);
        select_usuarios_del_area("Editar", "select_sub_usuarios_editar_etiquetas_socio", id_area, id_sub_usuario, usuario);
        $("#modal_editarEtiquetaSocio").modal("show");

    } else {

        let id = $("#txt_id_editar_etiquetas_socio").val();
        let cedula = $("#txt_cedula_editar_etiquetas_socio").val();
        let mensaje = $("#txt_mensaje_editar_etiquetas_socio").val();
        let sector = $("#select_area_editar_etiquetas_socio").val();
        let usuario = $("#select_sub_usuarios_editar_etiquetas_socio").val();

        if (id == "") {
            error("Debe ingresar un id");
        } else if (cedula == "") {
            error("Debe ingresar una cédula");
        } else if (comprobarCI(cedula) === false) {
            error("Debe ingresar una cédula válida");
        } else if (mensaje == "") {
            error("Debe ingresar una mensaje");
        } else if (sector == "") {
            error("Debe seleccionar un área");
        } else if (usuario == "") {
            error("Debe seleccionar un usuario");
        } else {

            $.ajax({
                type: "POST",
                url: `${url_operaciones}etiquetas_socio/editar_etiqueta_socio.php?`,
                data: {
                    id,
                    cedula,
                    mensaje,
                    sector,
                    usuario
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        $("#txt_id_editar_etiquetas_socio").val('');
                        $("#txt_cedula_editar_etiquetas_socio").val('');
                        $("#txt_mensaje_editar_etiquetas_socio").val('');
                        $("#select_area_editar_etiquetas_socio").val('');
                        $("#select_sub_usuarios_editar_etiquetas_socio").val('');
                        ejecutar_tabla_etiquetas_socio(true);
                        $("#modal_editarEtiquetaSocio").modal("hide");
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    }
}


function eliminar_etiqueta_socio(id) {
    Swal.fire({
        title: "Estas seguro?",
        text: `Vas a eliminar la etiqueta #${id}!`,
        icon: "warning",
        reverseButtons: true,
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        cancelButtonColor: "#DC3545",
        confirmButtonText: "Si, eliminar!",
        confirmButtonColor: "#198754",
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                type: "POST",
                url: `${url_operaciones}etiquetas_socio/eliminar_etiqueta_socio.php`,
                data: {
                    id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        ejecutar_tabla_etiquetas_socio(true);
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    });
}