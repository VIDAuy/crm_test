$(document).ready(function () {

    $("#vista_tabla_alertas_generales-tab").css("display", "none");
});



function obtener_alertas_generales() {

    $("#span_alertas_auditoria").text(`0+`);

    $.ajax({
        type: "GET",
        url: `${url_ajax}alertas/cantidad_alertas_generales_pendientes.php`,
        data: {
            opcion: 1
        },
        dataType: "JSON",
        success: function (response) {
            if (response.error === false) {
                let cantidad = response.cantidad;
                $("#span_alertas_auditoria").text(`${cantidad}+`);
            }
        }
    });
}

function mostrar_alertas() {
    let cantidad_alertas = $("#span_alertas_auditoria").text();

    if (cantidad_alertas != "0+") {
        tabla_alertas_generales();
        $("#span_alertas_generales").text("Alertas - Registros de auditoría");
        $("#modal_alertasGenerales").modal("show");
    } else {
        error("No hay alertas pendientes");
    }
}

function tabla_alertas_generales() {
    $("#tabla_alertas_generales").DataTable({
        ajax: `${url_ajax}alertas/tabla_alertas_generales.php?opcion=1`,
        columns: [
            { data: "id" },
            { data: "area" },
            { data: "usuario" },
            { data: "descripcion" },
            { data: "fecha_registro" },
            { data: "acciones" },
        ],
        order: [[0, "asc"]],
        bDestroy: true,
        language: { url: url_lenguage },
    });
}

function alerta_leida(id, id_registro) {

    $.ajax({
        type: "POST",
        url: `${url_ajax}alertas/alerta_leida.php`,
        data: {
            id
        },
        dataType: "JSON",
        beforeSend: function () {
            mostrarLoader();
        },
        complete: function () {
            mostrarLoader("O");
        },
        success: function (response) {
            if (response.error === false) {
                tabla_registros_auditoria_socio(3, id_registro);
                obtener_alertas_generales();
                tabla_alertas_generales();
                tabla_reasignar_alertas_generales();
                badge_cantidad_alertas_generales_pendientes();
            } else {
                error(response.mensaje);
            }
        }
    });
}

function badge_cantidad_alertas_generales_pendientes() {

    $("#cantidad_total_pendientes_alertas_generales").text('0+');

    $.ajax({
        type: "GET",
        url: `${url_ajax}alertas/cantidad_alertas_generales_pendientes.php`,
        data: {
            opcion: 2
        },
        dataType: "JSON",
        success: function (response) {
            let cantidad = response.cantidad;
            $("#cantidad_total_pendientes_alertas_generales").text(`${cantidad}+`);
        }
    });
}

function tabla_reasignar_alertas_generales() {
    $("#tabla_reasignar_alertas_auditoria_pendientes").DataTable({
        ajax: `${url_ajax}alertas/tabla_alertas_generales.php?opcion=2`,
        columns: [
            { data: "id" },
            { data: "area" },
            { data: "usuario" },
            { data: "descripcion" },
            { data: "fecha_registro" },
            { data: "usuario_asignado" },
            { data: "usuario_asignador" },
            { data: "acciones" },
        ],
        order: [[0, "asc"]],
        bDestroy: true,
        language: { url: url_lenguage },
    });
}

function reasignar_alerta_general(openModal = false, id, id_registro, id_sub_registro, area_alerto, usuario_alerto, area_alertada, id_usuario_alertado, usuario_alertado, usuario_asignador, texto_descripcion) {
    if (openModal == true) {
        $("#id_registro_asignar_alerta_general").val(id);
        let numero = id_sub_registro == "" ? id_registro : id_sub_registro;
        $("#descripcion_asignar_alerta_general").text(`${texto_descripcion} - #${numero}`);
        $("#area_alerto_asignar_alerta_general").text(area_alerto);
        $("#usuario_alerto_asignar_alerta_general").text(usuario_alerto);
        $("#area_alertada_asignar_alerta_general").text(area_alertada);
        $("#usuario_alertado_asignar_alerta_general").text(usuario_alertado);
        usuario_asignador = usuario_asignador != "0" || usuario_asignador != "" ? usuario_asignador : "-";
        $("#usuario_asignador_asignar_alerta_general").text(usuario_asignador);

        id_usuario_alertado == "" || id_usuario_alertado == "0" ?
            select_sub_usuarios("Agregar", "select_asignar_alerta_general") :
            select_sub_usuarios("Editar", "select_asignar_alerta_general", id_usuario_alertado, usuario_alertado);


        $("#modal_asignarAlertasGenerales").modal("show");
    } else {

        let id_registro = $("#id_registro_asignar_alerta_general").val();
        let usuario = $("#select_asignar_alerta_general").val();

        $.ajax({
            type: "POST",
            url: `${url_ajax}alertas/reasignar_alertas_generales.php`,
            data: {
                id_registro,
                usuario
            },
            dataType: "JSON",
            success: function (response) {
                if (response.error === false) {
                    correcto(response.mensaje);
                    $("#id_registro_asignar_alerta_general").val('');
                    $("#descripcion_asignar_alerta_general").text('');
                    $("#area_alerto_asignar_alerta_general").text('');
                    $("#usuario_alerto_asignar_alerta_general").text('');
                    $("#area_alertada_asignar_alerta_general").text('');
                    $("#usuario_alertado_asignar_alerta_general").text('');
                    $("#usuario_asignador_asignar_alerta_general").text('');
                    $("#select_asignar_alerta_general").val('');
                    tabla_reasignar_alertas_generales();
                    obtener_alertas_generales();
                    badge_cantidad_alertas_generales_pendientes();
                    $("#modal_asignarAlertasGenerales").modal("hide");
                } else {
                    error(response.mensaje);
                }
            }
        });

    }
}