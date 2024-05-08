$(document).ready(function () {

    $("#q").css("visibility", "visible");
    $("#bq").text("0+");
    agregarFiliales();
});



// AJAX
function cantidad_alertas() {

    let sector = $("#sector").val();
    let nivel = $("#nivel").val();
    let id_sub_usuario = localStorage.getItem("id_sub_usuario");

    if (["Calidad", "Bajas", "Cobranzas", "Rrhh_coord", "Coordinacion", "Morosos", "Comercial"].includes(sector)) {

        if (id_sub_usuario != null) {
            $.ajax({
                data: {
                    nivel,
                    id_sub_usuario
                },
                url: `${url_ajax}alertas/cantidad_alertas_pendientes.php`,
                type: "POST",
                dataType: "JSON",
                success: function (content) {
                    $("#bq").text(content.message + "+");
                },
            });
        }

    } else {

        $.ajax({
            data: {
                nivel
            },
            url: `${url_ajax}alertas/cantidad_alertas_del_area.php`,
            type: "POST",
            dataType: "JSON",
            success: function (content) {
                $("#bq").text(content.message + "+");
            },
        });
    }

}


function tabla_alertas_pendientes() {

    $("#tabla_alertas_pendientes").DataTable({
        ajax: `${url_ajax}alertas/tabla_alertas_pendientes.php?opcion=1`,
        columns: [
            { data: "id" },
            { data: "cedula" },
            { data: "sector" },
            { data: "nombre" },
            { data: "telefono" },
            { data: "usuario_asignado" },
            { data: "usuario_asignador" },
            { data: "acciones" },
        ],
        order: [[0, "asc"]],
        bDestroy: true,
        language: { url: url_lenguage },
    });
}


function badge_cantidad_alertas_pendientes() {

    $("#cantidad_total_alertas_pendientes").text('0+');

    $.ajax({
        type: "GET",
        url: `${url_ajax}alertas/tabla_alertas_pendientes.php?opcion=2`,
        dataType: "JSON",
        success: function (response) {
            let cantidad = response.cantidad;
            $("#cantidad_total_alertas_pendientes").text(`${cantidad}+`);
        }
    });
}


function abrir_asignar_alerta(openModal = false, id, cedula, nombre, telefono, sector, id_sub_usuario, id_usuario_asignado = null, id_usuario_asignador = null, usuario_asignado = null, usuario_asignador = null) {
    if (openModal === true) {


        if (id_usuario_asignado == null && id_usuario_asignador == null) {
            $("#id_registro_asignar_alerta_a_usuario").val(id);
            $("#id_sub_usuario_asignar_alerta_a_usuario").val(id_sub_usuario);
            $("#tipo_operacion_asignar_alerta_a_usuario").val("Asignar");
            $("#cedula_registro_asignar_alerta_a_usuario").html(cedula);
            $("#nombre_cliente_registro_asignar_alerta_a_usuario").html(nombre);
            $("#sector_registro_asignar_alerta_a_usuario").html(sector);
            $("#telefono_registro_asignar_alerta_a_usuario").html(telefono);
            $("#usuario_asignado_registro_asignar_alerta_a_usuario").html(usuario_asignado == null ? "<span class='text-danger'>Ninguno</span>" : usuario_asignado);
            $("#usuario_asignador_registro_asignar_alerta_a_usuario").html(usuario_asignador == null ? "<span class='text-danger'>Ninguno</span>" : usuario_asignador);
            select_sub_usuarios("Agregar", "select_asignar_alerta_pendiente");

            $("#modal_asignarAlertaPendiente").modal('show');
        } else {
            $("#id_registro_asignar_alerta_a_usuario").val(id);
            $("#id_sub_usuario_asignar_alerta_a_usuario").val(id_sub_usuario);
            $("#tipo_operacion_asignar_alerta_a_usuario").val("Reasignar");
            $("#cedula_registro_asignar_alerta_a_usuario").html(cedula);
            $("#nombre_cliente_registro_asignar_alerta_a_usuario").html(nombre);
            $("#sector_registro_asignar_alerta_a_usuario").html(sector);
            $("#telefono_registro_asignar_alerta_a_usuario").html(telefono);
            $("#usuario_asignado_registro_asignar_alerta_a_usuario").html(usuario_asignado == "" ? "Ninguno" : usuario_asignado);
            $("#usuario_asignador_registro_asignar_alerta_a_usuario").html(usuario_asignador == "" ? "Ninguno" : usuario_asignador);
            select_sub_usuarios("Editar", "select_asignar_alerta_pendiente", id_usuario_asignado, usuario_asignado);

            $("#modal_asignarAlertaPendiente").modal('show');
        }

    } else {
        let id_registro = $("#id_registro_asignar_alerta_a_usuario").val();
        let id_usuario_asignador = $("#id_sub_usuario_asignar_alerta_a_usuario").val();
        let id_usuario_asignar = $("#select_asignar_alerta_pendiente").val();
        let tipo_operacion = $("#tipo_operacion_asignar_alerta_a_usuario").val();


        if (id_registro == "" || id_usuario_asignador == "" || tipo_operacion == "") {
            error("Ocurrido un error, contacte con el administrador");
        } else if (id_usuario_asignar == "0") {
            error("Debe seleccionar un usuario");
        } else {

            $.ajax({
                type: "POST",
                url: `${url_ajax}alertas/asignar_alerta_a_usuario.php`,
                data: {
                    "id_registro": id_registro,
                    "id_usuario_asignador": id_usuario_asignador,
                    "id_usuario_asignar": id_usuario_asignar,
                    "tipo_operacion": tipo_operacion,
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        $("#id_registro_asignar_alerta_a_usuario").val('');
                        $("#id_sub_usuario_asignar_alerta_a_usuario").val('');
                        $("#select_asignar_alerta_pendiente").val('');
                        $("#tipo_operacion_asignar_alerta_a_usuario").val('');

                        tabla_alertas_pendientes();
                        cantidad_alertas();
                        $("#modal_asignarAlertaPendiente").modal("hide");
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    }
}


function ver_registros_alertas() {

    $("#modal_historialRegistrosDeAlertas").modal("show");

    $('#tabla_historial_alertas').DataTable({
        ajax: `${url_ajax}alertas/tabla_historial_alertas.php`,
        columns: [
            { data: 'id' },
            { data: 'cedula' },
            { data: 'sector' },
            { data: 'observaciones' },
            { data: 'nombre' },
            { data: 'telefono' },
            { data: 'fecha_registro' },
            { data: 'usuario_asignado' },
            { data: 'usuario_asignador' },
        ],
        "order": [[0, 'desc']],
        "bDestroy": true,
        language: { url: url_lenguage },
    });
}