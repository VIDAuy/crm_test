$(document).ready(function () {

    $(".ctr_agendar_volver_a_llamar").css("display", "none");
    $(".administrar_pendientes").css("display", "none");

});


function tabla_llamadas_pendientes() {
    let cedula = localStorage.getItem("cedula");
    let id_sector = localStorage.getItem("id_sector");

    $('#tabla_llamadas_pendientes').DataTable({
        ajax: `${url_app}volver_a_llamar/tabla_llamadas_pendientes.php?opcion=1&cedula=${cedula}&area=${id_sector}`,
        columns: [
            { data: 'id' },
            { data: 'cedula' },
            { data: 'nombre' },
            { data: 'telefono' },
            { data: 'socio' },
            { data: 'baja' },
            { data: 'fecha_hora' },
            { data: 'comentario' },
            { data: 'fecha_registro' },
            { data: 'usuario_agendo' },
            { data: 'usuario_asignado' },
            { data: 'usuario_asignador' },
            { data: 'acciones' },
        ],
        columnDefs: [
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            }],
        "order": [[0, 'asc']],
        "bDestroy": true,
        language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json' },
    });
}

function badge_cantidad_pendientes_volver_a_llamar() {

    $("#cantidad_total_pendientes_volver_a_llamar").text('0+');

    $.ajax({
        type: "GET",
        url: `${url_app}volver_a_llamar/tabla_llamadas_pendientes.php?opcion=2`,
        dataType: "JSON",
        success: function (response) {
            let cantidad = response.cantidad;
            $("#cantidad_total_pendientes_volver_a_llamar").text(`${cantidad}+`);
        }
    });
}

function agendar_volver_a_llamar(openModal = false) {
    if (openModal === true) {
        $("#modal_agregar_volver_a_llamar").modal("show");

        let fecha = new Date();
        let hora = fecha.getHours();
        let minutos = fecha.getMinutes();

        fecha = fecha.toJSON().slice(0, 10);
        hora = String(hora).length == 1 ? `0${hora}` : hora;
        minutos = String(minutos).length == 1 ? `0${minutos}` : minutos;

        $("#fecha_nueva_agenda_volver_a_llamar").val(`${fecha} ${hora}:${minutos}`);
    } else {
        let area = $("#sector").val();
        let cedula = $("#cedulas").text();
        let telefono1 = $("#telefonoNSR").val();
        let telefono2 = $("#telefonoNS").val() + " " + $("#celularNS").val();
        let telefono3 = $("#telefono").text();
        let nombre1 = $("#nombreNSR").val();
        let nombre2 = $("#nombreNS").val() + " " + $("#apellidoNS").val();
        let nombre3 = $("#nom").text();
        let fecha = $("#fecha_nueva_agenda_volver_a_llamar").val();
        let mensaje = $("#mensaje_nueva_agenda_volver_a_llamar").val();
        let id_usuario_agendo = localStorage.getItem("id_sub_usuario");

        if (fecha == "") {
            error("Debe ingresar la fecha y hora");
        } else if (mensaje == "") {
            error("Debe ingresar un mensaje");
        } else {
            $.ajax({
                type: "POST",
                url: `${url_app}volver_a_llamar/agendar_volver_a_llamar.php`,
                data: {
                    area: area,
                    cedula: cedula,
                    telefono1: telefono1,
                    telefono2: telefono2,
                    telefono3: telefono3,
                    nombre1: nombre1,
                    nombre2: nombre2,
                    nombre3: nombre3,
                    fecha: fecha,
                    mensaje: mensaje,
                    id_usuario_agendo: id_usuario_agendo
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        $("#fecha_nueva_agenda_volver_a_llamar").val("");
                        $("#hora_nueva_agenda_volver_a_llamar").val("");
                        $("#mensaje_nueva_agenda_volver_a_llamar").val("");
                        $("#modal_agregar_volver_a_llamar").modal("hide");
                    } else {
                        error(response.mensaje);
                    }
                }
            });
        }


    }

}

function abrir_agenda_volver_a_llamar(openModal = false) {
    if (openModal === true) {
        $("#modal_agrega_volver_a_llamar").modal("show");

        setInterval(abrir_agenda_volver_a_llamar, 60000);
    }

    let area = $("#sector").val();
    let id_sub_usuario = localStorage.getItem("id_sub_usuario");

    $("#tabla_agenda_volver_a_llamar").DataTable({
        ajax: `${url_app}volver_a_llamar/listado_agenda_volver_a_llamar.php?area=${area}&id_sub_usuario=${id_sub_usuario}`,
        columns: [
            { data: "id" },
            { data: "cedula" },
            { data: "nombre" },
            { data: "telefono" },
            { data: "es_socio" },
            { data: "baja" },
            { data: "fecha_hora" },
            { data: "mensaje" },
            { data: "fecha_registro" },
            { data: "acciones" },
        ],
        columnDefs: [
            {
                targets: [0],
                visible: false,
                searchable: false,
            },
        ],
        order: [[0, "asc"]],
        bDestroy: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json",
        },
    });
}

function cambiar_fecha_y_hora_volver_a_llamar(openModal = false, id) {
    if (openModal === true) {
        $("#modal_cambiar_fecha_y_hora_volver_a_llamar").modal("show");
        $("#id_reagendar_volver_a_llamar").val(id);
        let fecha = new Date();
        let hora = fecha.getHours();
        let minutos = fecha.getMinutes();

        fecha = fecha.toJSON().slice(0, 10);
        hora = String(hora).length == 1 ? `0${hora}` : hora;
        minutos = String(minutos).length == 1 ? `0${minutos}` : minutos;

        $("#fecha_reagendar_volver_a_llamar").val(`${fecha} ${hora}:${minutos}`);
        $("#hora_reagendar_agenda_volver_a_llamar").val();
    } else {

        let id_registro = $("#id_reagendar_volver_a_llamar").val();
        let fecha = $("#fecha_reagendar_volver_a_llamar").val();

        $.ajax({
            type: "POST",
            url: `${url_app}volver_a_llamar/cambiar_fecha_y_hora_volver_a_llamar.php`,
            data: {
                "id": id_registro,
                "fecha": fecha,
            },
            dataType: "JSON",
            success: function (response) {
                if (response.error === false) {
                    correcto(response.mensaje);
                    $("#modal_cambiar_fecha_y_hora_volver_a_llamar").modal("hide");
                    tabla_llamadas_pendientes();
                    abrir_agenda_volver_a_llamar();
                } else {
                    error(response.mensaje);
                }
            }
        });
    }
}

function cantidad_volver_a_llamar() {
    let area = $("#sector").val();
    let id_sub_usuario = localStorage.getItem("id_sub_usuario");

    if (area == "Morosos" || area == "Calidad" || area == "Bajas") {
        document.getElementById("cantidad_pendientes_volver_a_llamar").innerHTML = "0+";

        $.ajax({
            type: "GET",
            url: `${url_app}volver_a_llamar/contar_pendientes_volver_a_llamar.php`,
            data: {
                area: area,
                id_sub_usuario: id_sub_usuario
            },
            dataType: "JSON",
            success: function (response) {
                if (response.error === false) {
                    let cantidad = response.cantidad;
                    $("#cantidad_pendientes_volver_a_llamar").text(`${cantidad}+`);
                    if (cantidad > 0) mostrar_recordatorio();
                }
            },
        });
    }
}

function cargar_registro_volver_a_llamar(openModal = false, id, area, cedula, nombre, telefono, es_socio, fecha_hora, mensaje, fecha_registro) {
    if (openModal === true) {
        $("#id_volver_a_llamar").val(id);
        $("#area_volver_a_llamar").val(area);
        $("#cedula_volver_a_llamar").val(cedula);
        $("#nombre_volver_a_llamar").val(nombre);
        $("#telefono_volver_a_llamar").val(telefono);
        $("#es_socio_volver_a_llamar").val(es_socio);
        $("#fecha_hora_volver_a_llamar").val(fecha_hora);
        $("#mensaje_volver_a_llamar").val(mensaje);
        $("#fecha_registro_volver_a_llamar").val(fecha_registro);
        $("#cargar_imagen_volver_a_llamar").val("");

        $("#modal_cargar_registro_volver_a_llamar").modal("show");
    } else {

        let id = $("#id_volver_a_llamar").val();
        let area = $("#area_volver_a_llamar").val();
        let cedula = $("#cedula_volver_a_llamar").val();
        let nombre = $("#nombre_volver_a_llamar").val();
        let telefono = $("#telefono_volver_a_llamar").val();
        let es_socio = $("#es_socio_volver_a_llamar").val();
        let fecha_hora = $("#fecha_hora_volver_a_llamar").val();
        let mensaje = $("#mensaje_volver_a_llamar").val();
        let fecha_registro = $("#fecha_registro_volver_a_llamar").val();
        let observacion = $("#observacion_volver_a_llamar").val();
        let avisar_a = $("#avisar_a_volver_a_llamar").val();
        let id_sub_usuario = localStorage.getItem("id_sub_usuario");


        if (observacion == "") {
            error("Debe ingresar una observación");
        } else if (avisar_a == "sin_seleccion") {
            error("Debe seleccionar a quien desea avisar");
        } else {

            var form_data = new FormData();
            form_data.append("id", id);
            form_data.append("nombre", nombre);
            form_data.append("telefono", telefono);
            form_data.append("observacion", observacion);
            form_data.append("ensec", avisar_a);
            form_data.append("cedulas", cedula);
            form_data.append("sector", area);
            form_data.append("socio", es_socio == "Si" ? 1 : 0);

            let totalImagenes = $("#cargar_imagen_volver_a_llamar").prop("files").length;
            for (let i = 0; i < totalImagenes; i++) {
                form_data.append("cargar_imagen_volver_a_llamar[]", $("#cargar_imagen_volver_a_llamar").prop("files")[i]);
            }

            form_data.append("id_sub_usuario", id_sub_usuario);

            $.ajax({
                type: "POST",
                data: form_data,
                url: `${url_app}volver_a_llamar/cargar_registro_volver_a_llamar.php`,
                dataType: "JSON",
                contentType: false,
                processData: false,
                beforeSend: function () {
                    mostrarLoader();
                },
                complete: function () {
                    mostrarLoader("O");
                },
                success: function (content) {
                    if (content.error === false) {
                        correcto(content.message);
                        cantidad_volver_a_llamar();
                        historiaComunicacionDeCedula();
                        abrir_agenda_volver_a_llamar(false);
                        $("#observacion_volver_a_llamar").val("");
                        $("#avisar_a_volver_a_llamar").val("sin_seleccion");
                        $("#cargar_imagen_volver_a_llamar").val("");
                        $("#modal_cargar_registro_volver_a_llamar").modal("hide");
                        tabla_alertas_pendientes();
                        tabla_llamadas_pendientes();
                    } else {
                        error(content.message);
                    }
                },
            });

        }
    }
}

function abrir_asignar_llamada(openModal = false, id, id_area, cedula, nombre, telefono, es_socio, baja, fecha_hora, mensaje, fecha_registro, id_usuario_asignado = null, usuario_asignado = null, id_usuario_asignador = null, usuario_asignador = null) {
    if (openModal === true) {

        if (id_usuario_asignado == null && id_usuario_asignador == null) {
            $("#id_registro_asignar_llamada_a_usuario").val(id);
            $("#id_area_asignar_llamada_a_usuario").val(id_area);
            $("#tipo_operacion_asignar_llamada_a_usuario").val("Asignar");

            $("#cedula_registro_asignar_llamada_a_usuario").html(cedula);
            $("#nombre_registro_asignar_llamada_a_usuario").html(nombre);
            $("#telefono_registro_asignar_llamada_a_usuario").html(telefono);
            $("#socio_registro_asignar_llamada_a_usuario").html(es_socio == 1 ? "Si" : "No");
            $("#baja_registro_asignar_llamada_a_usuario").html(baja == 1 ? "Si" : "No");
            $("#fechayhora_registro_asignar_llamada_a_usuario").html(fecha_hora);
            $("#comentario_registro_asignar_llamada_a_usuario").html(mensaje);
            $("#fechaderegistro_registro_asignar_llamada_a_usuario").html(fecha_registro);
            $("#asignado_registro_asignar_llamada_a_usuario").html("Ninguno");
            $("#asignador_registro_asignar_llamada_a_usuario").html("Ninguno");

            select_sub_usuarios("Agregar", "select_asignar_llamada_a_usuario");

            $("#modal_asignarLlamadaAUsuario").modal("show");
        } else {
            $("#id_registro_asignar_llamada_a_usuario").val(id);
            $("#id_area_asignar_llamada_a_usuario").val(id_area);
            $("#tipo_operacion_asignar_llamada_a_usuario").val("Reasignar");

            $("#cedula_registro_asignar_llamada_a_usuario").html(cedula);
            $("#nombre_registro_asignar_llamada_a_usuario").html(nombre);
            $("#telefono_registro_asignar_llamada_a_usuario").html(telefono);
            $("#socio_registro_asignar_llamada_a_usuario").html(es_socio == 1 ? "Si" : "No");
            $("#baja_registro_asignar_llamada_a_usuario").html(baja == 1 ? "Si" : "No");
            $("#fechayhora_registro_asignar_llamada_a_usuario").html(fecha_hora);
            $("#comentario_registro_asignar_llamada_a_usuario").html(mensaje);
            $("#fechaderegistro_registro_asignar_llamada_a_usuario").html(fecha_registro);
            $("#asignado_registro_asignar_llamada_a_usuario").html(usuario_asignado);
            $("#asignador_registro_asignar_llamada_a_usuario").html(usuario_asignador);

            select_sub_usuarios("Editar", "select_asignar_llamada_a_usuario", id_usuario_asignado, usuario_asignado);

            $("#modal_asignarLlamadaAUsuario").modal("show");
        }

    } else {
        let id_registro = $("#id_registro_asignar_llamada_a_usuario").val();
        let id_usuario_asignador = localStorage.getItem("id_sub_usuario");
        let id_usuario_asignar = $("#select_asignar_llamada_a_usuario").val();
        let id_area = $("#id_area_asignar_llamada_a_usuario").val();
        let tipo_operacion = $("#tipo_operacion_asignar_llamada_a_usuario").val();


        if (id_registro == "" || id_usuario_asignador == "" || tipo_operacion == "") {
            error("Ocurrido un error, contacte con el administrador");
        } else if (id_usuario_asignar == "0") {
            error("Debe seleccionar un usuario");
        } else {

            $.ajax({
                type: "POST",
                url: `${url_app}volver_a_llamar/asignar_llamada_a_usuario.php`,
                data: {
                    "id_registro": id_registro,
                    "id_area": id_area,
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

                        tabla_llamadas_pendientes();
                        cantidad_alertas();
                        $("#modal_asignarLlamadaAUsuario").modal("hide");
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    }
}


/*
select_sub_usuarios("Agregar", "select_asignar_llamada_a_usuario_agregar");
select_sub_usuarios("Editar", "select_asignar_llamada_a_usuario_editar", id_sub_usuario, nombre_sub_usuario);
*/

function select_sub_usuarios(opcion, div, id_sub_usuario = null, nombre_sub_usuario = null) {

    let id_area = localStorage.getItem("id_sector");

    if (opcion == "Agregar") {

        document.getElementById(div).innerHTML = "<option value='0' selected>Seleccione un usuario</option>";

        $.ajax({
            type: "GET",
            url: `${url_app}volver_a_llamar/select_sub_usuarios.php?area=${id_area}`,
            dataType: "JSON",
            success: function (response) {
                let datos = response.datos;
                datos.map((val) => {
                    document.getElementById(div).innerHTML += `<option value="${val['id']}">${val['nombre']}</option>`;
                });
            }
        });
    } else {

        document.getElementById(div).innerHTML = `<option value='${id_sub_usuario}' selected>${nombre_sub_usuario}</option>`;

        $.ajax({
            type: "GET",
            url: `${url_app}volver_a_llamar/select_sub_usuarios.php?id_sub_usuario=${id_sub_usuario}`,
            dataType: "JSON",
            success: function (response) {
                let datos = response.datos;
                datos.map((val) => {
                    document.getElementById(div).innerHTML += `<option value="${val['id']}">${val['nombre']}</option>`;
                });
            }
        });
    }

}


function mostrar_recordatorio() {
    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        },
    });
    Toast.fire({
        icon: 'info',
        title: 'Recordatorio',
        html: 'Tiene agenda pendiente para volver a llamar!',
    });
}