function historiaComunicacionDeCedula() {
    $("#example1").DataTable().destroy();
    $.ajax({
        url: `${url_app}historiaComunicacionDeCedula.php`,
        type: "GET",
        dataType: "JSON",
        data: { CI: $("#ci").val() },
        beforeSend: function () {
            $("#historiaComunicacionDeCedula tr").remove();
        },
    }).done(function (datos) {
        if (!datos.noRegistros) {
            $.each(datos, function (index, el) {
                let nuevaLinea = "<tr>";
                nuevaLinea += "<td>" + el.id + "</td>";
                nuevaLinea += "<td>" + el.fecha + "</td>";
                nuevaLinea += "<td>" + el.sector + "</td>";
                nuevaLinea += "<td>" + el.usuario + "</td>";
                nuevaLinea += "<td>" + el.socio + "</td>";
                nuevaLinea += "<td>" + el.baja + "</td>";
                nuevaLinea += "<td>" + el.observacion + "</td>";
                nuevaLinea += "<td>" + el.avisar_a + "</td>";
                nuevaLinea += '<td class="text-center">' + el.imagen + '</td>';
                nuevaLinea += '<td class="text-center">' + el.mas_info + '</td>';
                nuevaLinea += "</tr>";
                $(nuevaLinea).appendTo("#historiaComunicacionDeCedula");
            });
            $("#example1").DataTable({
                pageLength: 5,
                searching: true,
                paging: true,
                lengthChange: false,
                info: true,
                order: [[0, "desc"]],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json",
                },
            });
            stateSave: true;
            $('[type="search"]').addClass("form-control-static");
            $('[type="search"]').css({ borderRadius: "5px" });
        }
    });
}

function modalHistoriaComunicacionDeCedula(CIParam) {
    $("#modalHistoriaComunicacionDeCedula").modal("show");
    $.ajax({
        url: url_app + "historiaComunicacionDeCedula.php",
        dataType: "JSON",
        data: {
            ID: CIParam,
        },
        beforeSend: function () {
            $("#MHCDCtitulo").text(null);
            $("#MHCDCcedula").val(null);
            $("#MHCDCnombre").val(null);
            $("#MHCDCtelefono").val(null);
            $("#MHCDCfecha_registro").val(null);
            $("#MHCDCsector").val(null);
            $("#MHCDCobservaciones").text(null);
            $("#MHCDCsocio").val(null);
            $("#MHCDCbaja").val(null);
        },
    })
        .done(function (datos) {
            $("#MHCDCtitulo").text(datos.id);
            $("#MHCDCcedula").val(datos.cedula);
            $("#MHCDCnombre").val(datos.nombre);
            $("#MHCDCtelefono").val(datos.telefono);
            $("#MHCDCfecha_registro").val(datos.fecha_registro);
            $("#MHCDCsector").val(datos.sector);
            $("#MHCDCobservaciones").text(datos.observaciones);
            if (datos.socio == "No") {
                $("#MHCDCsocio").css({ color: "red" });
            } else {
                $("#MHCDCsocio").css({ color: "black" });
            }
            $("#MHCDCsocio").val(datos.socio);
            if (datos.baja == "Sí") {
                $("#MHCDCbaja").css({ color: "red" });
            } else {
                $("#MHCDCbaja").css({ color: "black" });
            }
            $("#MHCDCbaja").val(datos.baja);
            $("#modalHistoriaComunicacionDeCedula").modal("show");
        })
        .fail(function () {
            error('Ha ocurrido un error al cargar "modalHistoriaComunicacionDeCedula", por favor cominíqueselo al administrador');
        });
}

function historiaComunicacionDeCedula_funcionarios() {
    let cedula = $("#ci").val();

    $("#tabla_historia_comunicacion_de_cedula_funcionario").DataTable({
        ajax: `${url_app}historiaComunicacionDeCedula_funcionarios.php?cedula=${cedula}`,
        columns: [
            { data: "id" },
            { data: "fecha" },
            { data: "sector" },
            { data: "observacion" },
        ],
        bDestroy: true,
        order: [[0, "desc"]],
        language: { url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json" },
    });
}