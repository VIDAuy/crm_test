$(document).ready(function () {

    let usuario = $("#sector").val();
    $("#span_usuario").text(usuario);
    $("#vista_tabla_crmessage-tab").css("display", "none");
});


function ver_crmessage() {
    /** Vacío los campos de los formularios **/
    $("#txt_consulta_nueva_consulta_crmessage").val('');
    $("#txt_area_consultada_nueva_consulta_crmessage").val('');
    $("#txt_cedula_nueva_consulta_crmessage").val('');
    $("#txt_respuesta_consulta_asignada_crmessage").val('');
    $("#txt_usuario_consultar_nueva_consulta_crmessage").val('');
    $("#nav-mis-consultas-tab").trigger('click'); //Muestro por defecto la ventana de ❝Mis Consultas❞

    select_usuarios("txt_area_consultada_nueva_consulta_crmessage"); //Lleno el select de usuarios

    /** Lleno las tablas **/
    tabla_mis_consultas();
    tabla_consultas_asignadas();
    $("#div_sub_usuario_crmessage").css("display", "none");

    $("#modalCRMessage").modal("show"); //Abro modal
}

function mostrar_select_usuarios_crmessage() {
    let area = $("#txt_area_consultada_nueva_consulta_crmessage").val();
    $("#div_sub_usuario_crmessage").css("display", "none");
    $("#txt_usuario_consultar_nueva_consulta_crmessage").val('');

    $.ajax({
        type: "GET",
        url: `${url_ajax}crmessage/verificar_area_con_sub_usuarios.php`,
        data: {
            area
        },
        dataType: "JSON",
        success: function (response) {
            if (response.error === false) {
                if (response.estado != 222) {
                    document.getElementById("txt_usuario_consultar_nueva_consulta_crmessage").innerHTML = `<option value=""> Seleccione si desea consultar a un usuario: </option>`;
                    let datos = response.datos;
                    datos.map((val) => {
                        document.getElementById("txt_usuario_consultar_nueva_consulta_crmessage").innerHTML += `<option value="${val['id']}">${val['usuario']}</option>`;
                    });
                    $("#div_sub_usuario_crmessage").css("display", "block");
                } else {
                    $("#div_sub_usuario_crmessage").css("display", "none");
                    $("#txt_usuario_consultar_nueva_consulta_crmessage").val('');
                }
            } else {
                error(response.mensaje);
            }
        }
    });
}

function tabla_mis_consultas() {
    $("#tabla_mis_consultas_crmessage").DataTable({
        ajax: `${url_ajax}crmessage/tabla_mis_consultas.php`,
        columns: [
            { data: "id" },
            { data: "consulta" },
        ],
        order: [[0, "asc"]],
        bDestroy: true,
        language: { url: url_lenguage },
        columnDefs: [
            {
                targets: [0],
                visible: false,
                searchable: false,
            },
        ],
        ordering: false,
        dom: 'frtip',
    });
}

function tabla_consultas_asignadas() {
    $("#tabla_consultas_asignadas_crmessage").DataTable({
        ajax: `${url_ajax}crmessage/tabla_consultas_asignadas.php`,
        columns: [
            { data: "id" },
            { data: "consulta" },
        ],
        order: [[0, "asc"]],
        bDestroy: true,
        language: { url: url_lenguage },
        columnDefs: [{
            targets: [0],
            visible: false,
            searchable: false,
        }],
        ordering: false,
        dom: 'frtip',
    });
}

function abrir_menu_chat(opcionResponder, id, tipoConsulta, marcarLeidos) {

    $("#txt_id_consulta_respuesta_asignada_crmessage").val(id);
    mostrar_mensajes_chat(id, opcionResponder);
    marcar_mensajes_como_leidos(id, tipoConsulta, marcarLeidos);

    var secondoffcanvas = document.getElementById("offcanvasDarkNavbar");
    var bsOffcanvas2 = new bootstrap.Offcanvas(secondoffcanvas);
    bsOffcanvas2.show();
}

function mostrar_mensajes_chat(id = null, opcionResponder = false) {
    let id_chat = id != null ? id : $("#txt_id_consulta_respuesta_asignada_crmessage").val();

    document.getElementById('div_mensajes').innerHTML = '';
    $.ajax({
        type: "GET",
        url: `${url_ajax}crmessage/registros_chat.php?id=${id_chat}`,
        dataType: "JSON",
        beforeSend: function () {
            mostrarLoader();
        },
        complete: function () {
            mostrarLoader("O");
        },
        success: function (response) {
            if (response.error === false) {
                let html_consulta = response.datos;
                let estado = response.estado_consulta;

                html_consulta.map((val) => {
                    document.getElementById('div_mensajes').innerHTML += val;
                });

                if (opcionResponder == true && estado == "En Proceso") {
                    $("#contenedor_responder_crmessage").css("display", "block");
                } else {
                    $("#contenedor_responder_crmessage").css("display", "none");
                }

            } else {
                error(response.mensaje);
            }
        }
    });
}

function nueva_consulta_crmessage() {

    let consulta = $("#txt_consulta_nueva_consulta_crmessage").val();
    let area_consultada = $("#txt_area_consultada_nueva_consulta_crmessage").val();
    let cedula_socio = $("#txt_cedula_nueva_consulta_crmessage").val();
    let id_usuario_consultado = $("#txt_usuario_consultar_nueva_consulta_crmessage").val();

    if (consulta == "") {
        error("Debe ingresar una consulta");
    } else if (area_consultada == "") {
        error("Debe seleccionar el área a consultar");
    } else if (cedula_socio != "" && comprobarCI(cedula_socio) === false) {
        error("Debe ingresar una cédula válida");
    } else {

        var form_data = new FormData();
        form_data.append("consulta", consulta);
        form_data.append("area_consultada", area_consultada);
        form_data.append("cedula_socio", cedula_socio);
        form_data.append("id_usuario_consultado", id_usuario_consultado);
        let totalImagenes = $("#file_archivos_crmessage").prop("files").length;
        for (let i = 0; i < totalImagenes; i++) {
            form_data.append("imagen[]", $("#file_archivos_crmessage").prop("files")[i]);
        }

        $.ajax({
            type: "POST",
            url: `${url_ajax}crmessage/nueva_consulta.php`,
            contentType: false,
            processData: false,
            data: form_data,
            dataType: "JSON",
            beforeSend: function () {
                mostrarLoader();
            },
            complete: function () {
                mostrarLoader("O");
            },
            success: function (response) {
                if (response.error === false) {
                    correcto(response.mensaje);
                    $("#txt_consulta_nueva_consulta_crmessage").val('');
                    $("#txt_area_consultada_nueva_consulta_crmessage").val('');
                    $("#txt_cedula_nueva_consulta_crmessage").val('');
                    tabla_mis_consultas();
                    if ($("#ci").val() != "") historiaComunicacionDeCedula();
                    $("#nav-mis-consultas-tab").trigger('click'); //Muestro por defecto la ventana de ❝Mis Consultas❞
                } else {
                    error(response.mensaje);
                }
            }
        });

    }

}

function responder_consulta() {
    let id_consulta = $("#txt_id_consulta_respuesta_asignada_crmessage").val();
    let respuesta = $("#txt_respuesta_consulta_asignada_crmessage").val();

    if (id_consulta == "") {
        error("Ocurrieron errores al responder");
    } else if (respuesta == "") {
        error("Debe ingresar una respuesta");
    } else {
        $.ajax({
            type: "POST",
            url: `${url_ajax}crmessage/responder_consulta.php`,
            data: {
                id_consulta,
                respuesta
            },
            dataType: "JSON",
            success: function (response) {
                if (response.error === false) {
                    correcto(response.mensaje);
                    $("#txt_respuesta_consulta_asignada_crmessage").val('');
                    mostrar_mensajes_chat();
                    tabla_mis_consultas();
                    tabla_consultas_asignadas();
                    if ($("#ci").val() != "") historiaComunicacionDeCedula();
                } else {
                    error(response.mensaje);
                }
            }
        });
    }
}

function cantidad_consultas_no_leidas() {
    $("#span_cantidad_respuestas_mis_consultas").text(`0+`);
    $("#span_cantidad_consultas_asignadas").text(`0+`);
    $("#cantidad_pendientes_crmessage").text(`0+`);

    $.ajax({
        type: "GET",
        url: `${url_ajax}crmessage/cantidad_consultas_no_leidas.php`,
        dataType: "JSON",
        success: function (response) {
            if (response.error === false) {
                let cant_mis_consultas = response.cantidad_mis_consultas;
                let cantidad_consultas_asignadas = response.cantidad_consultas_asignadas;
                let total_no_leidas = cant_mis_consultas + cantidad_consultas_asignadas;

                $("#span_cantidad_respuestas_mis_consultas").text(`${cant_mis_consultas}+`);
                $("#span_cantidad_consultas_asignadas").text(`${cantidad_consultas_asignadas}+`);
                $("#cantidad_pendientes_crmessage").text(`${total_no_leidas}+`);
            } else {
                error(response.mensaje);
            }
        }
    });
}

function marcar_mensajes_como_leidos(id, tipoConsulta, marcarLeidos) {

    if (marcarLeidos == 1) { //Hay mensajes pendientes de ver
        $.ajax({
            type: "POST",
            url: `${url_ajax}crmessage/marcar_mensaje_como_leido.php`,
            data: {
                id,
                tipoConsulta
            },
            dataType: "JSON",
            success: function (response) {
                if (response.error === false) {
                    cantidad_consultas_no_leidas();
                    tabla_mis_consultas();
                    tabla_consultas_asignadas();
                } else {
                    error(response.mensaje);
                }
            }
        });
    }
}

function historial_crmessage(openModal = false, opcion = 1) {

    let div = opcion == 1 ? "tabla_historial_mis_consultas_crmessage" : "tabla_historial_consultas_asignadas_crmessage";

    $(`#${div}`).DataTable({
        ajax: `${url_ajax}crmessage/tabla_historial_crmessage.php?opcion=${opcion}`,
        columns: [
            { data: "id" },
            { data: "area_y_usuario_consulta" },
            { data: "area_y_usuario_consultado" },
            { data: "consulta" },
            { data: "cedula_socio" },
            { data: "fecha_consulta" },
            { data: "estado" },
            { data: "acciones" },
        ],
        bDestroy: true,
        order: [[0, "asc"]],
        language: { url: url_lenguage },
    });

    if (openModal == true) $("#modal_historialCRMessage").modal("show");
}

function mostrar_mensajes_consulta(id) {
    $("#tabla_mostrar_mensajes_crmessage").DataTable({
        ajax: `${url_ajax}crmessage/tabla_mostrar_mensajes_crmessage.php?id=${id}`,
        columns: [
            { data: "id" },
            { data: "area" },
            { data: "usuario" },
            { data: "mensaje" },
            { data: "cedula_socio" },
            { data: "fecha_registro" },
            { data: "tipo" },
        ],
        bDestroy: true,
        order: [[0, "asc"]],
        language: { url: url_lenguage },
    });

    $("#modal_mostrarMensajesCRMessage").modal("show");
}

function tabla_gestionar_pendientes_crmessage() {
    $("#tabla_crmessage_todos_pendientes").DataTable({
        ajax: `${url_ajax}crmessage/tabla_gestionar_pendientes.php?opcion=1`,
        columns: [
            { data: "id" },
            { data: "area_y_usuario_consulta" },
            { data: "area_y_usuario_consultado" },
            { data: "consulta" },
            { data: "cedula_socio" },
            { data: "fecha_consulta" },
            { data: "estado" },
            { data: "acciones" },
        ],
        bDestroy: true,
        order: [[0, "asc"]],
        language: { url: url_lenguage },
    });
}

function cantidad_total_pendientes_crmessage() {
    $("#cantidad_total_pendientes_crmessage").text(`0+`);

    $.ajax({
        type: "GET",
        url: `${url_ajax}crmessage/tabla_gestionar_pendientes.php`,
        data: {
            opcion: 2
        },
        dataType: "JSON",
        success: function (response) {
            if (response.error === false) {
                let cantidad = response.cantidad;
                $("#cantidad_total_pendientes_crmessage").text(`${cantidad}+`);
            } else {
                error(response.mensaje);
            }
        }
    });
}

function reasignar_crmessage(openModal = false, id = null, id_usuario_consultado = null, usuario_consultado = null) {
    if (openModal == true) {
        $("#txt_id_reasignar_crmessage").val('');
        $("#select_sub_usuarios_reasignar_crmessage").val('');
        $("#txt_id_reasignar_crmessage").val(id);
        select_sub_usuarios("Editar", "select_sub_usuarios_reasignar_crmessage", id_usuario_consultado, usuario_consultado);
        $("#modal_reasignarCRMessage").modal("show");
    } else {

        let id = $("#txt_id_reasignar_crmessage").val();
        let sub_usuario = $("#select_sub_usuarios_reasignar_crmessage").val();

        if (id == "") {
            error("Debe ingresar un id");
        } else if (sub_usuario == "") {
            error("Debe seleccionar un funcionario");
        } else {

            $.ajax({
                type: "POST",
                url: `${url_ajax}crmessage/reasignar_crmessage.php`,
                data: {
                    id,
                    sub_usuario
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        $("#txt_id_reasignar_crmessage").val('');
                        $("#select_sub_usuarios_reasignar_crmessage").val('');
                        tabla_gestionar_pendientes_crmessage();
                        $("#modal_reasignarCRMessage").modal("hide");
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }

    }
}