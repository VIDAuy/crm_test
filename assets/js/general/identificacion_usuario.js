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
                    let gestor = datos.gestor;
                    $('#cedula_identificar_persona').val('');
                    $('#modal_identificar_persona_en_sesion').modal("hide");
                    $('#nombre_usuario_en_sesion').text(`➡ ${datos.nombre} ${datos.apellido}`);


                    if (["Calidad"].includes(sector)) {
                        alertas_de_vida_te_lleva();
                        setInterval(alertas_de_vida_te_lleva, 15000);
                    }

                    if (["Calidad", "Bajas", "Rrhh_coord", "Morosos", "Coordinacion"].includes(sector) && gestor == 1) {
                        tabla_llamadas_pendientes();
                        setInterval(tabla_llamadas_pendientes, 300000);

                        tabla_alertas_pendientes();
                        setInterval(tabla_alertas_pendientes, 300000);

                        badge_cantidad_pendientes_volver_a_llamar();
                        setInterval(badge_cantidad_pendientes_volver_a_llamar, 15000);

                        $(".administrar_pendientes").css("display", "block");
                        $("#vista_tabla_volver_a_llamar-tab").css("display", "block");
                    }

                    if (["Calidad", "Bajas", "Rrhh_coord", "Morosos", "Coordinacion"].includes(sector)) {
                        cantidad_volver_a_llamar();
                        setInterval(cantidad_volver_a_llamar, 15000);
                        $(".ctr_agendar_volver_a_llamar").css("display", "block");
                    }

                    if (["Cobranzas"].includes(sector) && gestor == 1) {
                        tabla_alertas_pendientes();
                        setInterval(tabla_alertas_pendientes, 300000);

                        $(".administrar_pendientes").css("display", "block");
                        $("#vista_tabla_volver_a_llamar-tab").css("display", "none");
                    }


                    cantidad_alertas();
                    cantidad_consultas_no_leidas();
                    ejecutar_acciones_sesion();

                } else {
                    error(response.mensaje);
                }
            }
        });
    }
}