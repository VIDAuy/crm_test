$(document).ready(function () {

    let sector = $("#sector").val();
    if (sector == "Personal") {
        $("#container_cierre_de_horas_personalizado").css("display", "block");
        $("#contenedor_consultas_generales").css("display", "block");
    }

});


function buscarDatos(radioButton = false) {
    let cedula = $("#ci").val();

    if (cedula.length == 0) {
        error("Debe ingresar la cédula de la persona que quiera buscar.");
    } else {
        if (radioButton == false) {
            comprobarCI(cedula) ? buscarSocio() : error("La cédula ingresada no es válida.");
        } else {
            let consultar = document.querySelector('input[name="radioBuscar"]:checked').value;

            if (consultar === "socio") {
                buscarSocio();
            } else if (consultar == 'funcionario') {
                esNumero(cedula) && comprobarCI(cedula) ? buscarFuncionario(cedula, "cedula") : buscarFuncionario(cedula, "pasaporte");
            }

        }
    }
}


function buscar_al_presionar_enter(e, tipo_consulta) {
    if (e.keyCode == 13) tipo_consulta == 1 ? buscarDatos(false) : buscarDatos(true);
}


$(document).on("input", "#ci", function () {
    if ($('#ci').val() != $('cedulas').text()) {
        ocultar_todo_socio();
        ocultar_todo_funcionario();
    }
});


function detectar_cambio_radio_buttons() {
    $(document).on('change', 'input[type=radio][name=radioBuscar]', function (event) {
        ocultar_todo_socio();
        ocultar_todo_funcionario();
    });
}


function buscarSocio() {
    let cedula = $("#ci").val();

    if (cedula == "") {
        error("Debe ingresar la cédula a buscar");
    } else {

        $.ajax({
            url: `${url_ajax}cargar_datos_socios.php`,
            type: "GET",
            dataType: "JSON",
            data: { CI: cedula },
            beforeSend: function () {
                ocultar_todo_socio();
                ocultar_todo_funcionario();
            },
        }).done(function (datos) {
            let sector = $("#sector").val();
            let nivel = $("#nivel").val();
            $("#cedulas").text(cedula);
            historiaComunicacionDeCedula();
            mostrar_cantidad_etiquetas_socio();
            $("#contenedor_etiquetas_de_socio").css("display", "block");
            comprobar_servicios_activos();


            if (["Auditoria", "Calidad", "Bajas", "Morosos", "Calidad_interna", "Rrhh_coord", "Cobranzas", "Comercial"].includes(sector)) {
                verificar_auditoria_socio();
                verificar_socio_equifax();
            }
            if (["Auditoria", "Calidad", "Bajas", "Morosos", "Calidad_interna", "Rrhh_coord", "Coordinacion", "Cobranzas"].includes(sector)) {
                $("#contenedor_cobranza_abitab").css("display", "block");
                tabla_cobranza_abitab();
                $(".patologias_socio").css("display", "block");
                tabla_patologias_socio();
            }
            if (["Comercial"].includes(sector)) {
                $("#contenedor_cobranza_abitab").css("display", "block");
                tabla_cobranza_abitab();
            }
            if (["Auditoria", "Calidad", "Bajas", "Morosos", "Calidad_interna", "Rrhh_coord", "Coordinacion", "Cobranzas"].includes(sector)) {
                $("#div_agregarEtiquetaSocio").css("display", "block");
            }

            if (["Auditoria", "Calidad", "Bajas", "Cobranzas"].includes(sector)) $("#btn_agregar_patologia_socio").css("display", "block");


            if (nivel == 1) {
                $("#contenedor_cobranza_abitab").css("display", "block");
                tabla_cobranza_abitab();
            }


            if (datos.noSocioConRegistros) {
                alerta("Problema!", datos.mensaje, "warning");
                $("#cedulasNSR").text(cedula);
                $("#nombreNSR").val(datos.nombre);
                $("#telefonoNSR").val(datos.telefono);
                $("#noEsSocioRegistro").css("display", "block");
                $("#historiaComunicacionDeCedulaDiv").css("display", "block");
                $("#historiaComunicacionDeCedulaDiv_funcionarios").css("display", "none");
            } else if (datos.noSocio) {
                alerta("<span style='color: #9C0404'>¿Está seguro de que la cédula pertenece un socio?</span>", datos.mensaje, "error");
                $("#cedulasNS").text(cedula);
                $("#noEsSocio").css("display", "block");
                $("#historiaComunicacionDeCedulaDiv_funcionarios").css("display", "none");
            } else if (datos.bajaProcesada) {
                alerta("Problema!", datos.mensaje, "warning");
                $("#cedulasNSR").text(cedula);
                $("#nombreNSR").val(datos.nombre);
                $("#telefonoNSR").val(datos.telefono);
                $("#noEsSocioRegistro").css("display", "block");
                $("#historiaComunicacionDeCedulaDiv").css("display", "block");
                $("#historiaComunicacionDeCedulaDiv_funcionarios").css("display", "none");
            } else {
                $("#nom").text(datos.nombre);
                $("#telefono").text(datos.tel);
                $("#fechafil").text(datos.fecha_afiliacion);
                $("#radio").text(datos.radio);
                $("#sucursal").text(datos.sucursal);
                $("#inspira").text(datos.inspira);
                $("#siEsSocio").css("display", "block");
                $("#historiaComunicacionDeCedulaDiv").css("display", "block");
                $("#historiaComunicacionDeCedulaDiv_funcionarios").css("display", "none");
                if (!datos.mostrar_inspira) $("#div_inspira").css("display", "none");
            }

        }).fail(function (err) {
            console.log(err);
            error("Ha ocurrido un error, por favor comuníquese con el administrador");
        });

    }
}


function buscarFuncionario(cedula, tipo) {
    $.ajax({
        url: `${url_ajax}cargar_datos_funcionarios.php`,
        type: "GET",
        dataType: "JSON",
        data: {
            CI: cedula,
            tipo: tipo,
        },
        beforeSend: function () {
            ocultar_todo_socio();
            ocultar_todo_funcionario();
        },
    }).done(function (response) {
        $("#cedulas").text(cedula);
        if (response.error === false) {
            let datos = response.datos;
            $("#cedula_funcionario").text(cedula);
            $("#numero_nodum").text(datos.id_nodum);
            $("#nombre_completo_funcionario").text(datos.nombre);
            $("#fecha_ingreso").text(datos.fecha_ingreso);
            $("#fecha_egreso").text(datos.fecha_egreso);
            $("#empresa_funcionario").text(datos.empresa);
            $("#estado_funcionario").text(datos.estado);
            $("#causal_de_baja_funcionario").text(datos.causa);
            $("#tipo_de_comisionamiento_funcionario").text(datos.planes);
            $("#filial_funcionario").text(datos.filial);
            $("#sub_filial_funcionario").text(datos.sub_filial);
            $("#cargo_funcionario").text(datos.cargo);
            $("#centro_de_costos_funcionario").text(datos.seccion);
            $("#tipo_de_trabajador_funcionario").text(datos.tipo_trabajador);
            $("#medio_de_pago_funcionario").text(datos.banco);
            $("#telefono_funcionario").text(datos.telefono);
            $("#correo_funcionario").text(datos.correo);

            $("#contenido_funcionario").css("display", "block");
            $("#historiaComunicacionDeCedulaDiv_funcionarios").css("display", "block");
            $("#historiaComunicacionDeCedulaDiv").css("display", "none");
            $("#acciones_socios_nivel_3").css("display", "none");
            historiaComunicacionDeCedula_funcionarios();

        } else {
            ocultar_todo_funcionario();
            alerta("<span style='color: #9C0404'> No se han encontrado resultados! </span>", "Seguro que la cédula ingresada pertenece a un funcionario?", "error");
        }
    }).fail(function (response) {
        error("Ha ocurrido un error, por favor comuníquese con el administrador");
    });
}


function ocultar_todo_socio() {
    $("#contenedor_etiquetas_de_socio").css("display", "none");
    $("#contenedor_auditorias_socio").css("display", "none");
    $(".patologias_socio").css("display", "none");
    $("#contenedor_cobranza_abitab").css("display", "none");

    $("#acciones_socios_nivel_3").css("display", "block");
    $("#contenido_funcionario").css("display", "none");
    $("#historiaComunicacionDeCedulaDiv").css("display", "none");
    $("#historiaComunicacionDeCedulaDiv_funcionarios").css("display", "none");
    $("#btnDatosCoordinacion").text("Coordinación");
    $("#btnDatosCoordinacion").attr("disabled", false);
    $("#btnDatosCobranza").text("Cobranza");
    $("#btnDatosCobranza").attr("disabled", false);
    $('#btnDatosProductos').text('Productos');
    $("#btnDatosProductos").attr("disabled", false);

    //noEsSocioRegistro
    $("#cedulasNSR").val("");
    $("#nombreNSR").val(null);
    $("#telefonoNSR").val(null);
    $("#observacionesNSR").val("");
    $("#avisarNSR").prop("selectedIndex", 0);
    $("#noEsSocioRegistro").css("display", "none");

    //noEsSocio
    $("#cedulasNS").val("");
    $("#nombreNS").val(null);
    $("#apellidoNS").val(null);
    $("#telefonoNS").val(null);
    $("#celularNS").val(null);
    $("#observacionesNS").val("");
    $("#avisarNS").prop("selectedIndex", 0);
    $("#noEsSocio").css("display", "none");

    //siEsSocio
    $("#cedulas").val("");
    $("#obser").val("");
    $("#ensec").prop("selectedIndex", 0);
    $("#siEsSocio").css("display", "none");
}


function ocultar_todo_funcionario() {
    $("#contenido_funcionario").css("display", "none");
    $("#acciones_socios_nivel_3").css("display", "none");
    $("#historiaComunicacionDeCedulaDiv").css("display", "none");
    $("#historiaComunicacionDeCedulaDiv_funcionarios").css("display", "none");
    $("#btnDatosCoordinacion").val("Coordinación");
    $("#btnDatosCoordinacion").attr("disabled", false);
    $("#btnDatosCobranza").val("Cobranza");
    $("#btnDatosCobranza").attr("disabled", false);

    //siEsSocio
    $("#cedulas").val("");
    $("#obser").val("");
    $("#ensec").prop("selectedIndex", 0);
    $("#siEsSocio").css("display", "none");

    //noEsSocioRegistro
    $("#cedulasNSR").val("");
    $("#nombreNSR").val(null);
    $("#telefonoNSR").val(null);
    $("#observacionesNSR").val("");
    $("#avisarNSR").prop("selectedIndex", 0);
    $("#noEsSocioRegistro").css("display", "none");

    //noEsSocio
    $("#cedulasNS").val("");
    $("#nombreNS").val(null);
    $("#apellidoNS").val(null);
    $("#telefonoNS").val(null);
    $("#celularNS").val(null);
    $("#observacionesNS").val("");
    $("#avisarNS").prop("selectedIndex", 0);
    $("#noEsSocio").css("display", "none");
}