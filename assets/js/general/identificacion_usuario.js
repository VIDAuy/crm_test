$(document).ready(function () {

    verificar_sub_usuario();

});


function verificar_sub_usuario() {
    $.ajax({
        type: "GET",
        url: `${url_ajax}verificar_sub_usuarios.php`,
        dataType: "JSON",
        beforeSend: function () {
            showLoading();
        },
        complete: function () {
            hideLoading();
        },
        success: function (response) {
            if (response.error === false) {
                if (response.estatus === 200) abrir_modal_identificarse(true);
            } else {
                error(response.mensaje);
            }
        }
    });
}


function abrir_modal_identificarse(openModal = false) {
    if (openModal === true) {
        $('#modal_identificar_persona_en_sesion').modal({ backdrop: 'static', keyboard: false })
        $('#modal_identificar_persona_en_sesion').modal("show");

        $('#cedula_identificar_persona').keypress(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') identificar_persona();
        });
    } else {
        identificar_persona();
    }
}


function identificar_persona() {
    let sector = $("#sector").val();
    let cedula = $('#cedula_identificar_persona').val();

    if (cedula == "") {
        error("Debe ingresar su cédula");
    } else if (comprobarCI(cedula) === false) {
        error("Debe ingresar una cédula válida");
    } else {

        $.ajax({
            type: "GET",
            url: `${url_ajax}comprobar_persona_en_sesion.php`,
            data: {
                sector: sector,
                cedula: cedula
            },
            dataType: "JSON",
            success: function (response) {
                if (response.error === false) {
                    let datos = response.datos;
                    localStorage.setItem("id_sub_usuario", datos.id_sub_usuario);
                    localStorage.setItem("id_sector", datos.id_sector);
                    localStorage.setItem("sector", datos.sector);
                    localStorage.setItem("cedula", datos.cedula);
                    localStorage.setItem("nombre", datos.nombre);
                    localStorage.setItem("apellido", datos.apellido);
                    $('#cedula_identificar_persona').val('');
                    $('#modal_identificar_persona_en_sesion').modal("hide");
                    $('#nombre_usuario_en_sesion').text(`➡ ${datos.nombre} ${datos.apellido}`);
                    mostrar_menu_por_usuarios();

                    let contenido = response.todo_contenido;
                    contenido.map((val) => {
                        if (val == 9) {
                            badge_cantidad_alertas_pendientes();
                            setInterval(badge_cantidad_alertas_pendientes, 15000);
                            tabla_alertas_pendientes();
                            setInterval(tabla_alertas_pendientes, 30000);
                            $(".administrar_pendientes").css("display", "block");
                        }
                        if (val == 10) {
                            tabla_llamadas_pendientes();
                            setInterval(tabla_llamadas_pendientes, 15000);
                            badge_cantidad_pendientes_volver_a_llamar();
                            setInterval(badge_cantidad_pendientes_volver_a_llamar, 15000);
                            $("#vista_tabla_volver_a_llamar-tab").css("display", "block");
                        }
                        if (val == 11) {
                            cantidad_total_pendientes_crmessage();
                            setInterval(cantidad_total_pendientes_crmessage, 15000);
                            tabla_gestionar_pendientes_crmessage();
                            setInterval(tabla_gestionar_pendientes_crmessage, 30000);
                            $("#vista_tabla_crmessage-tab").css("display", "block");
                        }
                        if (val == 12) {
                            badge_cantidad_alertas_generales_pendientes();
                            setInterval(badge_cantidad_alertas_generales_pendientes, 15000);
                            tabla_reasignar_alertas_generales();
                            setInterval(tabla_reasignar_alertas_generales, 30000);
                            $("#vista_tabla_alertas_generales-tab").css("display", "block");
                        }
                    });



                    ejecutar_acciones_sesion();

                } else {
                    error(response.mensaje);
                }
            }
        });
    }
}