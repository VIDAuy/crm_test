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
            $("#cedulas").text(cedula);
            historiaComunicacionDeCedula();
            mostrar_cantidad_etiquetas_socio();
            comprobar_servicios_activos();


            /** Muestro el contenido según los permisos que tenga el usuario **/
            let contenido = datos.todo_contenido;
            contenido.map((val) => {
                if (val == 3) verificar_auditoria_socio();
                if (val == 4) mostrar_agregar_etiqueta_socio();
                if (val == 5) mostrar_agregar_patologia_socio();
                if (val == 6) tabla_cobranza_abitab();
                if (val == 7) tabla_patologias_socio();
                if (val == 8) verificar_socio_equifax();
                if (val == 23) verificar_envio_discador();
            });


            if (nivel == 1) tabla_cobranza_abitab();



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
                $("#span_direccion_titular_tarjeta_credito").text(datos.direccion);
                $("#span_nro_tarjeta_credito").text(datos.numero_tarjeta);
                $("#span_datos_titular_tarjeta_credito").text(datos.nombre_titular);
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