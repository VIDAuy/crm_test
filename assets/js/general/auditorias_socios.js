function registrar_auditoria_socio(openModal = false) {
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
            $("#txt_registrar_fecha_auditoria_socio").val('');
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
        } else {

            $.ajax({
                type: "POST",
                url: `${url_ajax}auditorias_socio/registrar_auditoria.php`,
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
        $("#file_archivos_auditoria_socio").val('');
        $("#modal_registrarComentarioAuditoria").modal("show");
    } else {
        let id = $("#txt_id_registrar_comentario_auditoria").val();
        let comentario = $("#txt_mensaje_registrar_comentario_auditoria").val();

        if (id == "") {
            error("El campo ID no puede estar vacío");
        } else if (comentario == "") {
            error("Debe ingresar un comentario");
        } else {

            var form_data = new FormData();
            form_data.append("id", id);
            form_data.append("comentario", comentario);
            let totalImagenes = $("#file_archivos_auditoria_socio").prop("files").length;
            for (let i = 0; i < totalImagenes; i++) {
                form_data.append("imagen[]", $("#file_archivos_auditoria_socio").prop("files")[i]);
            }

            $.ajax({
                type: "POST",
                url: `${url_ajax}auditorias_socio/registrar_comentario.php`,
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
                        tabla_registros_auditoria_socio(true, false);
                        $("#txt_id_registrar_comentario_auditoria").val('');
                        $("#txt_mensaje_registrar_comentario_auditoria").val('');
                        $("#file_archivos_auditoria_socio").val('');
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
        ajax: `${url_ajax}auditorias_socio/tabla_comentarios_auditoria.php?id=${id}`,
        columns: [
            { data: "id" },
            { data: "comentario" },
            { data: "fecha_registro" },
            { data: "acciones" },
        ],
        order: [[0, "asc"]],
        bDestroy: true,
        language: { url: url_lenguage },
    });

    $("#modal_verComentariosAuditoriaSocio").modal("show");
}


function modal_ver_mp3(ruta_registros, string_imagenes) {
    let div = document.getElementById('mostrar_imagenes_relamos');
    div.innerHTML = '';

    let count = 1;
    let obtener_imagenes = string_imagenes.split(',');
    obtener_imagenes.map((val) => {
        let imagen = val.trim();
        let separar_nombre_archivo = imagen.split('.');
        let extencion_archivo = separar_nombre_archivo[1];
        div.innerHTML += `
        <h3>Audio ${count}:</h3>
        <audio controls class='player_audio mb-4' id="audio_nro_${count}" loop>
            <source src="${ruta_registros}/${imagen}">
        </audio>`;
        count++;
    });

    $('#modalVerImagenesRegistro').modal('show');
}

function pausar_audios_al_cerrar_modal() {
    $('.player_audio').trigger("pause");
}

function tabla_registros_auditoria_socio(btnRegistrarComentario = false, filtrarCedula = false) {

    let cedula = filtrarCedula != false ? $("#ci").val() : "";

    $("#tabla_auditorias_registradas").DataTable({
        ajax: `${url_ajax}auditorias_socio/tabla_auditorias.php?btnRegistrarComentario=${btnRegistrarComentario}&cedula=${cedula}`,
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
        language: { url: url_lenguage },
    });

    $("#modal_auditoriasSocioRegistradas").modal("show");
}

function verificar_auditoria_socio() {

    let cedula = $("#ci").val();
    $("#div_auditorias_socio").html("");

    if (controlCedula(cedula) === true) {
        $.ajax({
            type: "GET",
            url: `${url_ajax}auditorias_socio/comprobar_auditorias.php?cedula=${cedula}`,
            dataType: "JSON",
            success: function (response) {
                if (response.error === false) {
                    $("#div_auditorias_socio").html("<button class='btn btn-info' onclick='tabla_registros_auditoria_socio(false, true)'> Auditoría Socio </button>");
                } else if (response.error == 222) {
                    error(response.mensaje);
                }
            }
        });
    }

}