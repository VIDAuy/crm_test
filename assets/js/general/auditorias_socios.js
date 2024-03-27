function registrar_auditoria_socio(openModal = false) {
    let fecha_actual = fecha_hora_actual();

    if (openModal == true) {
        $("#txt_registrar_cedula_auditoria_socio").val('');
        $("#txt_registrar_descripcion_auditoria_socio").val('');
        $("#txt_registrar_fecha_auditoria_socio").val('');

        let cedula = $("#ci").val();

        if (cedula == "") {
            error("Debe ingresar la cédula del socio");
        } else if (comprobarCI(cedula) === false) {
            error('Debe ingresar una cédula válida');
        } else {
            $("#txt_registrar_cedula_auditoria_socio").val(cedula);
            $("#txt_registrar_fecha_auditoria_socio").val(`${fecha_actual}`);
            $("#modal_registrarAuditoriaSocio").modal("show");
        }

    } else {

        let cedula = $("#txt_registrar_cedula_auditoria_socio").val();
        let descripcion = $("#txt_registrar_descripcion_auditoria_socio").val();
        let fecha_auditoria = $("#txt_registrar_fecha_auditoria_socio").val();

        if (cedula == "") {
            error("Debe ingresar la cédula del socio");
        } else if (comprobarCI(cedula) === false) {
            error('Debe ingresar una cédula válida');
        } else if (descripcion == "") {
            error("Debe ingresar una descripción");
        } else if (fecha_auditoria == "") {
            error("Debe ingresar una fecha para la auditoría");
        } else if (fecha_actual >= fecha_auditoria) {
            error("La fecha y hora de auditoría debe ser mayor a la fecha y hora actual");
        } else {

            $.ajax({
                type: "POST",
                url: `${url_app}auditorias_socio/registrar_auditoria.php`,
                data: {
                    cedula,
                    descripcion,
                    fecha_auditoria
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        $("#txt_registrar_cedula_auditoria_socio").val('');
                        $("#txt_registrar_descripcion_auditoria_socio").val('');
                        $("#txt_registrar_fecha_auditoria_socio").val('');
                        $("#modal_registrarAuditoriaSocio").modal("hide");
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    }
}

function registrar_comentario_auditoria_socio(openModal = false, id) {
    if (openModal == true) {
        $("#txt_id_registrar_comentario_auditoria").val(id);
        $("#txt_mensaje_registrar_comentario_auditoria").val('');
        $("#modal_registrarComentarioAuditoria").modal("show");
    } else {
        let id = $("#txt_id_registrar_comentario_auditoria").val();
        let comentario = $("#txt_mensaje_registrar_comentario_auditoria").val();

        if (id == "") {
            error("El campo ID no puede estar vacío");
        } else if (comentario == "") {
            error("Debe ingresar un comentario");
        } else {

            $.ajax({
                type: "POST",
                url: `${url_app}auditorias_socio/registrar_comentario.php`,
                data: {
                    id,
                    comentario
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        tabla_auditorias_socio();
                        $("#txt_id_registrar_comentario_auditoria").val('');
                        $("#txt_mensaje_registrar_comentario_auditoria").val('');
                        $("#modal_registrarComentarioAuditoria").modal("hide");
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    }
}

function ver_comentarios_auditorias_socio(id, cedula) {
    $("#span_id_auditoria").text(`#${id}`);
    $("#span_cedula_socio").text(cedula);

    $("#tabla_comentario_auditorias").DataTable({
        ajax: `${url_app}auditorias_socio/tabla_comentarios_auditoria.php?id=${id}`,
        columns: [
            { data: "id" },
            { data: "comentario" },
            { data: "fecha_registro" },
        ],
        order: [[0, "asc"]],
        bDestroy: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json",
        },
    });

    $("#modal_verComentariosAuditoriaSocio").modal("show");
}

function tabla_registros_auditoria_socio(btnRegistrarComentario = false) {

    $("#tabla_auditorias_registradas").DataTable({
        ajax: `${url_app}auditorias_socio/tabla_auditorias.php?btnRegistrarComentario=${btnRegistrarComentario}`,
        columns: [
            { data: "id" },
            { data: "cedula" },
            { data: "descripcion" },
            { data: "fecha_auditoria" },
            { data: "fecha_registro" },
            { data: "usuario_registro" },
            { data: "acciones" },
        ],
        order: [[0, "asc"]],
        bDestroy: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json",
        },
    });

    $("#modal_auditoriasSocioRegistradas").modal("show");
}

function verificar_auditoria_socio() {
    let cedula = $("#ci").val();
    $("#div_auditorias_socio").html("");

    if (controlCedula(cedula) === true) {
        $.ajax({
            type: "GET",
            url: `${url_app}auditorias_socio/comprobar_auditorias.php?cedula=${cedula}`,
            dataType: "JSON",
            success: function (response) {
                if (response.error === false) {
                    $("#div_auditorias_socio").html("<button class='btn btn-info' onclick='tabla_registros_auditoria_socio(false)'> Auditoría Socio </button>");
                } else if (response.error == 222) {
                    error(response.mensaje);
                }
            }
        });
    }

}