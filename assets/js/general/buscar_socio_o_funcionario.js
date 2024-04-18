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
                $("#contenido1").css("display", "none");
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
            },
        }).done(function (datos) {
            let sector = $("#sector").val();
            $("#cedulas").text(cedula);
            historiaComunicacionDeCedula();
            mostrar_cantidad_etiquetas_socio();
            if (["Audit1", "Audit2", "Audit3", "Calidad", "Bajas", "Morosos", "Calidad_interna", "Rrhh_coord", "Cobranzas", "Comercial"].includes(sector)){
                verificar_auditoria_socio();
                verificar_socio_equifax();
            }
            if (["Audit1", "Audit2", "Audit3", "Calidad", "Bajas", "Morosos", "Calidad_interna", "Rrhh_coord", "Coordinacion", "Cobranzas"].includes(sector)) {
                $("#contenedor_cobranza_abitab").css("display", "block");
                tabla_cobranza_abitab();
                $(".patologias_socio").css("display", "block");
                tabla_patologias_socio();
            }
            if (["Comercial"].includes(sector)) {
                $("#contenedor_cobranza_abitab").css("display", "block");
                tabla_cobranza_abitab();
            }
            if (["Audit1", "Audit2", "Audit3", "Calidad", "Bajas", "Morosos", "Calidad_interna", "Rrhh_coord", "Coordinacion", "Cobranzas"].includes(sector)) {
                $("#div_agregarEtiquetaSocio").css("display", "block");
            }

            if (["Audit1", "Audit2", "Audit3", "Calidad", "Bajas", "Cobranzas"].includes(sector)) $("#btn_agregar_patologia_socio").css("display", "block");

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
            $("#contenido1").css("display", "block");

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
            $("#contenido1").css("display", "none");
            $("#contenido2").css("display", "none");
            $("#contenido_funcionario").css("display", "none");
            $("#acciones_socios_nivel_3").css("display", "none");
            $("#historiaComunicacionDeCedulaDiv").css("display", "none");
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
        },
    }).done(function (response) {
        $("#cedulas").text(cedula);
        if (response.error === false) {
            $("#cedula_funcionario").text(cedula);
            $("#numero_nodum").text(response.datos.id_nodum);
            $("#nombre_completo_funcionario").text(response.datos.nombre);
            $("#fecha_ingreso").text(response.datos.fecha_ingreso);
            $("#fecha_egreso").text(response.datos.fecha_egreso);
            $("#empresa_funcionario").text(response.datos.empresa);
            $("#estado_funcionario").text(response.datos.estado);
            $("#causal_de_baja_funcionario").text(response.datos.causa);
            $("#tipo_de_comisionamiento_funcionario").text(response.datos.planes);
            $("#filial_funcionario").text(response.datos.filial);
            $("#sub_filial_funcionario").text(response.datos.sub_filial);
            $("#cargo_funcionario").text(response.datos.cargo);
            $("#centro_de_costos_funcionario").text(response.datos.seccion);
            $("#tipo_de_trabajador_funcionario").text(response.datos.tipo_trabajador);
            $("#medio_de_pago_funcionario").text(response.datos.banco);
            $("#telefono_funcionario").text(response.datos.telefono);
            $("#correo_funcionario").text(response.datos.correo);

            $("#contenido_funcionario").css("display", "block");
            $("#historiaComunicacionDeCedulaDiv_funcionarios").css("display", "block");
            $("#historiaComunicacionDeCedulaDiv").css("display", "none");
            $("#acciones_socios_nivel_3").css("display", "none");

            historiaComunicacionDeCedula_funcionarios();
        } else {
            $("#acciones_socios_nivel_3").css("display", "none");
            alerta("<span style='color: #9C0404'> No se han encontrado resultados! </span>", "Seguro que la cédula ingresada pertenece a un funcionario?", "error");
        }
    }).fail(function (response) {
        error("Ha ocurrido un error, por favor comuníquese con el administrador");
    });
}