function historiaComunicacionDeCedula() {
    let cedula = $("#ci").val();

    $("#tabla_historia_comunicacion_de_cedula").DataTable({
        ajax: `${url_ajax}historiaComunicacionDeCedula.php?cedula=${cedula}`,
        columns: [
            { data: "id" },
            { data: "fecha" },
            { data: "sector" },
            { data: "usuario" },
            { data: "socio" },
            { data: "baja" },
            { data: "observacion" },
            { data: "avisar_a" },
            { data: "imagen" },
            { data: "mas_info" },
        ],
        bDestroy: true,
        order: [[0, "desc"]],
        language: { url: url_lenguage },
        pageLength: 5,
    });
}

function modal_ver_imagen_registro(ruta, id) {
    document.getElementById('mostrar_imagenes_relamos').innerHTML = '';

    $.ajax({
        type: 'GET',
        url: `${url_ajax}imagenes_de_registros.php`,
        data: {
            id: id,
        },
        dataType: 'JSON',
        success: function (response) {
            if (response.error === false) {
                let imagenes = response.datos;

                imagenes.map((val) => {
                    let separar_nombre_archivo = val.split('.');
                    let extencion_archivo = separar_nombre_archivo[1];

                    if (extencion_archivo != 'pdf') {
                        document.getElementById(
                            'mostrar_imagenes_relamos'
                        ).innerHTML += `<img src="${ruta}/${val}" style="width: 100%; height: auto"> <br> <br>`;
                    } else {
                        document.getElementById(
                            'mostrar_imagenes_relamos'
                        ).innerHTML += `<iframe src="${ruta}/${val}" width=100% height=600></iframe>`;
                    }
                });
            } else {
                error(response.mensaje);
            }
        },
    });

    $('#modalVerImagenesRegistro').modal('show');
}

function abrir_modal_ver_mas_registro(id, cedula, nombre, telefono, fecha_registro, sector, observacion, socio, baja) {
    $("#MHCDCtitulo").text(`#${id}`);
    $("#MHCDCcedula").val(cedula);
    $("#MHCDCnombre").val(nombre);
    $("#MHCDCtelefono").val(telefono);
    $("#MHCDCfecha_registro").val(fecha_registro);
    $("#MHCDCsector").val(sector);
    $("#MHCDCobservaciones").val(observacion);
    socio == 0 ? $("#MHCDCsocio").css("color", "#DC3545") : $("#MHCDCsocio").css("color", "black");
    baja == 1 ? $("#MHCDCbaja").css("color", "#DC3545") : $("#MHCDCbaja").css("color", "black");
    $("#MHCDCsocio").val(socio == 1 ? 'Si' : "No");
    $("#MHCDCbaja").val(baja == 1 ? "Si" : "No");


    $("#modalHistoriaComunicacionDeCedula").modal("show");
}

function historiaComunicacionDeCedula_funcionarios() {
    let cedula = $("#ci").val();

    $("#tabla_historia_comunicacion_de_cedula_funcionario").DataTable({
        ajax: `${url_ajax}historiaComunicacionDeCedula_funcionarios.php?cedula=${cedula}`,
        columns: [
            { data: "id" },
            { data: "fecha" },
            { data: "sector" },
            { data: "observacion" },
        ],
        bDestroy: true,
        order: [[0, "desc"]],
        language: { url: url_lenguage },
    });
}