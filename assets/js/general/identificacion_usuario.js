$(document).ready(function () {

    abrir_modal_identificarse(true);

});


function abrir_modal_identificarse(openModal = false) {
    let sector = $("#sector").val();

    if (["Recepcion", "Morosos", "Calidad", "Servicios", "Coordinacion", "Bajas", "Calidad_interna", "Cobranzas", "Rrhh_coord"].includes(sector)) {
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
                    //correcto_pasajero(response.mensaje);
                    $('#cedula_identificar_persona').val('');
                    $('#modal_identificar_persona_en_sesion').modal("hide");
                    $('#nombre_usuario_en_sesion').text(`➡ ${datos.nombre} ${datos.apellido}`);


                    if (
                        (sector == "Calidad" && ["43382081", "49554284", "45909437", "46955506", "48936512"].includes(cedula)) ||
                        (sector == "Bajas" && ["44417851", "50709395"].includes(cedula)) ||
                        (sector == "Rrhh_coord" && ["49651319", "54608246"].includes(cedula))
                    ) {
                        tabla_llamadas_pendientes();
                        setInterval(tabla_llamadas_pendientes, 300000);
                        tabla_alertas_pendientes();
                        setInterval(tabla_alertas_pendientes, 300000);
                        badge_cantidad_pendientes_volver_a_llamar();
                        setInterval(badge_cantidad_pendientes_volver_a_llamar, 15000);

                        $(".administrar_pendientes").css("display", "block");
                        $("#vista_tabla_volver_a_llamar-tab").css("display", "block");
                    }

                    if ((sector == "Cobranzas" && ["47070163"].includes(cedula))) {
                        tabla_alertas_pendientes();
                        setInterval(tabla_alertas_pendientes, 300000);

                        $(".administrar_pendientes").css("display", "block");
                        $("#vista_tabla_volver_a_llamar-tab").css("display", "none");
                    }

                    if (["Calidad", "Morosos", "Bajas", "Rrhh_coord"].includes(sector)) $(".ctr_agendar_volver_a_llamar").css("display", "block");

                    if (["Calidad", "Bajas", "Cobranzas", "Rrhh_coord"].includes(sector)) {
                        $("#div_agregarEtiquetaSocio").css("display", "block");
                        $("#contenedor_cobranza_abitab").css("display", "block");
                    }


                    cantidad_volver_a_llamar();
                    setInterval(cantidad_volver_a_llamar, 5000);
                    cantidad_consultas_no_leidas();

                } else {
                    error(response.mensaje);
                }
            }
        });
    }
}