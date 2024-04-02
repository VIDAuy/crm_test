$(document).ready(function () {

    let usuario = $("#sector").val();
    $("#span_usuario").text(usuario);

    cantidad_consultas_no_leidas();
    setInterval(cantidad_consultas_no_leidas, 15000);
});


function ver_crmessage() {
    /** Vacío los campos de los formularios **/
    $("#txt_consulta_nueva_consulta_crmessage").val('');
    $("#txt_area_consultada_nueva_consulta_crmessage").val('');
    $("#txt_cedula_nueva_consulta_crmessage").val('');
    $("#txt_respuesta_consulta_asignada_crmessage").val('');
    $("#nav-mis-consultas-tab").trigger('click'); //Muestro por defecto la ventana de ❝Mis Consultas❞

    select_usuarios("txt_area_consultada_nueva_consulta_crmessage"); //Lleno el select de usuarios

    /** Lleno las tablas **/
    tabla_mis_consultas();
    tabla_consultas_asignadas();

    $("#modalCRMessage").modal("show"); //Abro modal
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

    if (consulta == "") {
        error("Debe ingresar una consulta");
    } else if (area_consultada == "") {
        error("Debe seleccionar el área a consultar");
    } else if (cedula_socio != "" && comprobarCI(cedula_socio) === false) {
        error("Debe ingresar una cédula válida");
    } else {

        $.ajax({
            type: "POST",
            url: `${url_ajax}crmessage/nueva_consulta.php`,
            data: {
                consulta,
                area_consultada,
                cedula_socio
            },
            dataType: "JSON",
            success: function (response) {
                if (response.error === false) {
                    correcto(response.mensaje);
                    $("#txt_consulta_nueva_consulta_crmessage").val('');
                    $("#txt_area_consultada_nueva_consulta_crmessage").val('');
                    $("#txt_cedula_nueva_consulta_crmessage").val('');
                    tabla_mis_consultas();
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
                } else {
                    error(response.mensaje);
                }
            }
        });
    }
}

function cantidad_consultas_no_leidas() {
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