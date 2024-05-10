function consultas(tipo) {
    let cedula = $("#ci").val();
    let fecha_desde = $("#fecha_desde").val();
    let fecha_hasta = $("#fecha_hasta").val();

    if (cedula == "") {
        error("Debe ingresar una cédula");
    } else if (fecha_desde == "") {
        error("Debe ingresar una fecha desde");
    } else if (fecha_hasta.length == "") {
        error("Debe ingresar una fecha hasta");
    } else {
        tipo == "horas"
            ? buscarHorasAcompanante(cedula, fecha_desde, fecha_hasta)
            : buscarFaltasAcompanante(cedula, fecha_desde, fecha_hasta);
    }
}

/** Licencia Acompañante **/
function consulta_licencias() {
    let cod_trabajador = $("#numero_nodum").text();

    $.ajax({
        type: "GET",
        url: `${url_ajax}datos_acompanantes/licencia_acompanante.php`,
        data: {
            cod_trabajador: cod_trabajador,
            opcion: "consulta",
        },
        dataType: "JSON",
        beforeSend: function () {
            mostrarLoader();
        },
        complete: function () {
            mostrarLoader('O');
        },
        success: function (response) {
            if (response.error === false) {
                tabla_licencia_acompanante(cod_trabajador);

                $("#modalDatoslicencia_acompanantes").modal("show");
            } else {
                error(response.mensaje);
            }
        },
    });
}

function tabla_licencia_acompanante(cod_trabajador) {
    let groupColumn = 0;

    $("#tabla_licencia_personal").DataTable({
        ajax: `${url_ajax}datos_acompanantes/licencia_acompanante.php?cod_trabajador=${cod_trabajador}&opcion=tabla`,
        columnDefs: [{ visible: false, targets: groupColumn }],
        columns: [
            { data: "anio" },
            { data: "fecha_inicio" },
            { data: "fecha_fin" },
            { data: "dias_generados" },
            { data: "dias_tomados" },
            { data: "dias_restantes" },
        ],
        bDestroy: true,
        order: [[groupColumn, "asc"]],
        ordering: false,
        searching: false,
        drawCallback: function (settings) {
            let api = this.api();
            let rows = api.rows({ page: "current" }).nodes();
            let last = null;

            api
                .column(groupColumn, { page: "current" })
                .data()
                .each(function (group, i) {
                    if (last !== group) {
                        $(rows)
                            .eq(i)
                            .before(
                                '<tr class="group">' +
                                '<td colspan="5" style="background-color: #6F934F; color: white; font-weight: bolder;">' +
                                group +
                                "</td></tr>"
                            );

                        last = group;
                    }
                });
        },
        language: { url: url_lenguage },
        footerCallback: function (row, data, start, end, display) {
            total_tomados = this.api()
                .column(4)
                .data()
                .reduce(function (a, b) {
                    return parseInt(a) + parseInt(b);
                }, 0);

            $(this.api().column(4).footer()).html(total_tomados);

            total_restantes = this.api()
                .column(5)
                .data()
                .reduce(function (a, b) {
                    return parseInt(b);
                }, 0);

            $(this.api().column(5).footer()).html(total_restantes);
        },
        rowGroup: {
            dataSrc: "anio",
        },
    });
}
/** End Licencia Acompañante **/


function buscarHorasAcompanante(cedula, fecha_desde, fecha_hasta) {
    $.ajax({
        type: "GET",
        url: `${url_ajax}datos_acompanantes/calcular_total_horas_funcionario.php`,
        data: {
            cedula: cedula,
            fecha_desde: fecha_desde,
            fecha_hasta: fecha_hasta,
        },
        dataType: "JSON",
        beforeSend: function () {
            mostrarLoader();
        },
        complete: function () {
            mostrarLoader('O');
        },
        success: function (response) {
            if (response.error === false) {
                tabla_horas_acompanante(cedula, fecha_desde, fecha_hasta);

                $("#modalHorasAcompanantes").modal("show");
                $("#total_horas_acompañante").text(response.datos + " " + "en total");
            } else {
                $("#modalHorasAcompanantes").modal("show");
            }
        },
    });
}

function tabla_horas_acompanante(cedula, fecha_desde, fecha_hasta) {
    $("#tabla_horas_acompanantes").DataTable({
        ajax: `${url_ajax}datos_acompanantes/horas_acompanantes.php?cedula=${cedula}&fecha_desde=${fecha_desde}&fecha_hasta=${fecha_hasta}`,
        columns: [
            { data: "fecha_filtro" },
            { data: "id_info" },
            { data: "hora_inicio" },
            { data: "hora_fin" },
            { data: "fecha_servicio" },
            { data: "suma_horas" },
            { data: "descanso" },
            { data: "aislamiento" },
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
        language: { url: url_lenguage },
    });
}

function buscarFaltasAcompanante(cedula, fecha_desde, fecha_hasta) {
    $("#tabla_faltas_acompanantes").DataTable({
        ajax: `${url_ajax}datos_acompanantes/faltas_acompanantes.php?cedula=${cedula}&fecha_desde=${fecha_desde}&fecha_hasta=${fecha_hasta}`,
        columns: [
            { data: "trabajador" },
            { data: "tipo_falta" },
            { data: "actividad" },
            { data: "empresa" },
            { data: "fecha_inicio" },
            { data: "fecha_final" },
        ],
        bDestroy: true,
        order: [[0, "asc"]],
        language: { url: url_lenguage },
    });

    $("#modalFaltasAcompanantes").modal("show");
}