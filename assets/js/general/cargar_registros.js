function cargo(param, socioParam) {
    let nombre = param == 0 ? $("#nombreNSR").val() :
        param == 1 ? $("#nombreNS").val() + " " + $("#apellidoNS").val() :
            $("#nom").text();

    let telefono = param == 0 ? $("#telefonoNSR").val() :
        param == 1 ? $("#telefonoNS").val() + " " + $("#celularNS").val() :
            $("#telefono").text();

    let observacion = param == 0 ? $("#observacionesNSR").val() :
        param == 1 ? $("#observacionesNS").val() :
            $("#obser").val();

    let ensec = param == 0 ? $("#avisarNSR").val() :
        param == 1 ? $("#avisarNS").val() :
            $("#ensec").val();

    cedulas = $("#cedulas").text();
    sector = $("#sector").val();

    if (controlCargo(param) != "") {
        error("Ha ocurrido lo siguiente:\n" + controlCargo(param));
    } else if (ensec == "sin_seleccion") {
        error("Debe seleccionar a quien desea avisar");
    } else {

        var form_data = new FormData();
        form_data.append("nombre", nombre);
        form_data.append("telefono", telefono);
        form_data.append("observacion", observacion);
        form_data.append("ensec", ensec);
        form_data.append("cedulas", cedulas);
        form_data.append("sector", sector);
        form_data.append("socio", socioParam);


        if (param == 0) {
            let totalImagenes = $("#cargar_imagen_registro_1").prop("files").length;
            for (let i = 0; i < totalImagenes; i++) {
                form_data.append("imagen[]", $("#cargar_imagen_registro_1").prop("files")[i]);
            }
        } else if (param == 1) {
            let totalImagenes = $("#cargar_imagen_registro_2").prop("files").length;
            for (let i = 0; i < totalImagenes; i++) {
                form_data.append("imagen[]", $("#cargar_imagen_registro_2").prop("files")[i]);
            }
        } else {
            let totalImagenes = $("#cargar_imagen_registro_3").prop("files").length;
            for (let i = 0; i < totalImagenes; i++) {
                form_data.append("imagen[]", $("#cargar_imagen_registro_3").prop("files")[i]);
            }
        }


        $.ajax({
            type: "POST",
            data: form_data,
            url: `${url_ajax}datos.php`,
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
                    //$("#ci").val("");
                    $("#nombreNSR").val("");
                    $("#nombreNS").val("");
                    $("#apellidoNS").val("");
                    $("#telefonoNSR").val("");
                    $("#telefonoNS").val("");
                    $("#celularNS").val("");
                    $("#observacionesNSR").val("");
                    $("#observacionesNS").val("");
                    $("#obser").val("");
                    $("#avisarNSR").val("");
                    $("#avisarNS").val("");
                    $("#ensec").val("");
                    $("#cargar_imagen_registro_1").val("");
                    $("#cargar_imagen_registro_2").val("");
                    $("#cargar_imagen_registro_3").val("");
                    $('#ensec').prop('selectedIndex', 0);
                    //ocultar_todo_contenido();
                    historiaComunicacionDeCedula();
                    correcto(content.message);
                } else {
                    alerta("Error!", content.message, "error");
                }
            },
        });

    }
}

function cargo_registro_fucionario() {
    let cedula = $("#cedula_funcionario").text();
    let nombre = $("#nombre_completo_funcionario").text();
    let telefono = $("#telefono_funcionario").text();
    let observacion = $("#obser_funcionarios").val();
    let avisar = $("#ensec_funcionarios").val();

    if (cedula == "") {
        alerta("Error!", "Debe ingresar una cedula", "error");
    } else if (observacion == "") {
        alerta("Error!", "Debe ingresar una observación", "error");
    } else {
        $.ajax({
            type: "POST",
            url: url_ajax + "datos_funcionarios.php",
            data: {
                cedula: cedula,
                nombre: nombre,
                tel: telefono,
                observacion: observacion,
                avisar: avisar,
            },
            dataType: "JSON",
            success: function (response) {
                if (response.error == false) {
                    alerta("Exito!", response.mensaje, "success");
                    $("#obser_funcionarios").val("");
                    $("#ensec_funcionarios").val("");
                    historiaComunicacionDeCedula_funcionarios();
                } else {
                    alerta("Error!", response.mensaje, "error");
                }
            },
        });
    }
}