function tabla_registros_auditoria_socio(opcion = 1, id = null) {

    $("#contenedor_titulo_modal_auditorias_socio").html("Auditorias Registradas");
    mostrar_comentarios_auditoria(false);
    let cedula = $("#ci").val();
    let param = opcion == 2 ? `&cedula=${cedula}` : opcion == 3 ? `&id=${id}` : "";

    $("#tabla_auditorias_registradas").DataTable({
        ajax: `${url_ajax}auditorias_socio/tabla_auditorias.php?opcion=${opcion}${param}`,
        columns: [
            { data: "id" },
            { data: "cedula" },
            { data: "descripcion" },
            { data: "fecha_auditoria" },
            { data: "fecha_registro" },
            { data: "usuario_registro" },
            { data: "acciones" },
        ],
        order: [[0, "desc"]],
        bDestroy: true,
        language: { url: url_lenguage },
    });

    $("#modal_auditoriasSocioRegistradas").modal("show");
}


function registrar_auditoria_socio(openModal = false) {
    if (openModal == true) {
        $("#txt_registrar_cedula_auditoria_socio").val('');
        $("#txt_registrar_descripcion_auditoria_socio").val('');
        $("#txt_registrar_fecha_auditoria_socio").val('');
        $("#txt_avisar_carga_auditoria").val('');

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
        let avisar_a = $("#txt_avisar_carga_auditoria").val();

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
                    fecha_auditoria,
                    avisar_a
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


function editar_auditoria_socio(openModal = false, id, descripcion, fecha_auditoria) {
    if (openModal === true) {
        $("#txt_id_editar_auditoria_socio").val(id);
        $("#txt_descripcion_editar_auditoria_socio").val(descripcion);
        $("#txt_fecha_auditoria_editar_auditoria_socio").val(fecha_auditoria);
        $("#modal_editarAuditorias").modal("show");
    } else {

        let id = $("#txt_id_editar_auditoria_socio").val();
        let descripcion = $("#txt_descripcion_editar_auditoria_socio").val();
        let fecha_auditoria = $("#txt_fecha_auditoria_editar_auditoria_socio").val();

        $.ajax({
            type: "POST",
            url: `${url_ajax}auditorias_socio/editar_auditoria.php`,
            data: {
                id,
                descripcion,
                fecha_auditoria
            },
            dataType: "JSON",
            success: function (response) {
                if (response.error === false) {
                    correcto(response.mensaje);
                    tabla_registros_auditoria_socio(1, null);
                    $("#txt_id_editar_auditoria_socio").val('');
                    $("#txt_descripcion_editar_auditoria_socio").val('');
                    $("#txt_fecha_auditoria_editar_auditoria_socio").val('');
                    $("#modal_editarAuditorias").modal("hide");
                } else {
                    error(response.mensaje);
                }
            }
        });

    }
}


function mostrar_comentarios_auditoria(openModal = false, id, cedula) {
    if (openModal === true) {
        $("#span_id_auditoria").text('');
        $("#span_cedula_socio").text('');
        $("#contenedor_titulo_modal_auditorias_socio").html(`
        Comentarios - Auditoría 
        <span class='fw-bolder' id='span_id_auditoria'></span> -
        Cédula: 
        <span class='fw-bolder' id='span_cedula_socio'></span>:`);
        $("#span_id_auditoria").text(`#${id}`);
        $("#span_cedula_socio").text(cedula);
        tabla_comentarios_auditoria(id);
        $("#contenedor_auditorias_registradas").css('display', 'none');
        $("#contenedor_comentarios_auditorias_socio").css("display", "block");
        $("#btnVolver_auditorias_registradas").html(`
        <button type="button" class="btn btn-danger d-flex align-items-center" onclick="mostrar_comentarios_auditoria(false)">
            <span class="mb-1 me-1">👈</span>
            Volver
        </button>`);
    } else {
        $("#span_id_auditoria").text('');
        $("#span_cedula_socio").text('');
        $("#contenedor_titulo_modal_auditorias_socio").html("Auditorias Registradas");
        $("#contenedor_auditorias_registradas").css('display', 'block');
        $("#contenedor_comentarios_auditorias_socio").css("display", "none");
        $("#btnVolver_auditorias_registradas").html("");
    }
}


function ver_comentarios_auditorias_socio(id, cedula) {
    tabla_comentarios_auditoria(id);
    $("#modal_verComentariosAuditoriaSocio").modal("show");
}


function tabla_comentarios_auditoria(id) {
    $("#tabla_comentario_auditorias").DataTable({
        ajax: `${url_ajax}auditorias_socio/tabla_comentarios_auditoria.php?id=${id}`,
        columns: [
            { data: "id" },
            { data: "comentario" },
            { data: "usuario_registro" },
            { data: "fecha_registro" },
            { data: "acciones" },
        ],
        order: [[0, "asc"]],
        bDestroy: true,
        language: { url: url_lenguage },
    });
}


function registrar_comentario_auditoria_socio(openModal = false, id) {
    if (openModal == true) {
        $("#txt_id_registrar_comentario_auditoria").val(id);
        $("#txt_mensaje_registrar_comentario_auditoria").val('');
        $("#file_archivos_auditoria_socio").val('');
        $("#txt_avisar_carga_comentario_auditoria").val('');
        $("#modal_registrarComentarioAuditoria").modal("show");
    } else {
        let id = $("#txt_id_registrar_comentario_auditoria").val();
        let comentario = $("#txt_mensaje_registrar_comentario_auditoria").val();
        let avisar_a = $("#txt_avisar_carga_comentario_auditoria").val();

        if (id == "") {
            error("El campo ID no puede estar vacío");
        } else if (comentario == "") {
            error("Debe ingresar un comentario");
        } else {

            var form_data = new FormData();
            form_data.append("id", id);
            form_data.append("comentario", comentario);
            form_data.append("avisar_a", avisar_a);
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
                        tabla_registros_auditoria_socio(1, null);
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


function editar_comentario_auditoria(openModal = false, id, comentario) {
    if (openModal === true) {
        $("#txt_id_editar_comentario_auditoria_socio").val(id);
        $("#txt_descripcion_editar_comentario_auditoria_socio").val(comentario);
        $("#modal_editarComentarioAuditoria").modal("show");
    } else {

        let id = $("#txt_id_editar_comentario_auditoria_socio").val();
        let comentario = $("#txt_descripcion_editar_comentario_auditoria_socio").val();

        $.ajax({
            type: "POST",
            url: `${url_ajax}auditorias_socio/editar_comentario_auditoria.php`,
            data: {
                id,
                comentario
            },
            dataType: "JSON",
            success: function (response) {
                if (response.error === false) {
                    let datos = response.datos;
                    correcto(response.mensaje);
                    tabla_registros_auditoria_socio(1, null);
                    tabla_comentarios_auditoria(datos.id);
                    $("#txt_id_editar_comentario_auditoria_socio").val('');
                    $("#txt_descripcion_editar_comentario_auditoria_socio").val('');
                    $("#modal_editarComentarioAuditoria").modal("hide");
                } else {
                    error(response.mensaje);
                }
            }
        });

    }
}


function modal_ver_mp3(ruta_registros, string_imagenes) {
    let div = document.getElementById('mostrar_imagenes_relamos');
    div.innerHTML = '';

    let count = 1;
    let obtener_imagenes = string_imagenes.split(',');
    let modal = "";
    obtener_imagenes.map((val) => {
        let imagen = val.trim();
        let separar_nombre_archivo = imagen.split('.');
        let extencion_archivo = separar_nombre_archivo[1];

        if (extencion_archivo != "pdf") {
            div.innerHTML += `
            <h3 class="mt-3">Audio ${count}:</h3>
            <audio controls class='player_audio mb-4' id="audio_nro_${count}" loop>
                <source src="${ruta_registros}/${imagen}">
            </audio>`;
        } else {
            modal = "1";
            div.innerHTML += `
            <h3 class="mt-3">Archivo ${count}:</h3>
            <iframe class="mb-4" src="${ruta_registros}/${imagen}" title="Archivo: ${count}" width='100%' height='450'></iframe>`;
        }
        count++;
    });

    if (modal != "") {
        $('#modalVerImagenesRegistro').addClass("modal-lg");
    } else {
        $("#modalVerImagenesRegistro").removeClass("modal-lg");
    }

    $('#modalVerImagenesRegistro').modal('show');
}


function pausar_audios_al_cerrar_modal() {
    $('.player_audio').trigger("pause");
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
                    $("#contenedor_auditorias_socio").css("display", "block");
                    $("#div_auditorias_socio").html(`<button class='btn btn-info' onclick='tabla_registros_auditoria_socio(2, ${cedula})'> Auditoría Socio </button>`);
                } else if (response.error == 222) {
                    error(response.mensaje);
                }
            }
        });
    }

}