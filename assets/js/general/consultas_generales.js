/** Horas De Acompañantes **/
function registro_completo_horas_acompanantes() {
    let fecha_desde = $('#cg_fecha_desde_personal').val();
    let fecha_hasta = $('#cg_fecha_hasta_personal').val();

    if (fecha_desde == '') {
        error("Debe ingresar una fecha desde");
    } else if (fecha_hasta == '') {
        error("Debe ingresar una fecha hasta");
    } else if (fecha_desde > fecha_hasta) {
        error("La fecha desde tiene que ser menor a la fecha hasta");
    } else {

        $('#tabla_todas_horas_acompanantes_personal').DataTable({
            ajax: `${url_ajax}datos_acompanantes/todas_horas_acompanantes.php?fecha_desde=${fecha_desde}&fecha_hasta=${fecha_hasta}`,
            columns: [
                { data: 'fecha_filtro' },
                { data: 'id_servicio' },
                { data: 'cedula' },
                { data: 'nombre' },
                { data: 'hora_inicio' },
                { data: 'hora_fin' },
                { data: 'fecha_servicio' },
                { data: 'suma_horas' },
                { data: 'descanso' },
                { data: 'aislamiento' },
            ],
            columnDefs: [{
                targets: [0],
                visible: false,
                searchable: false,
            }],
            order: [[0, 'asc']],
            bDestroy: true,
            language: { url: url_lenguage },
            dom: 'Bfrtip',
            buttons: ['excel'],
        });

        $('#modalTodasHorasAcompanantes').modal('show');

    }
}
/** End Horas De Acompañantes **/


/** Reporte De Faltas **/
function registro_completo_faltas_acompanantes() {
    let fecha_desde = $('#cg_fecha_desde_personal').val();
    let fecha_hasta = $('#cg_fecha_hasta_personal').val();

    if (fecha_desde == '') {
        error("Debe ingresar una fecha desde");
    } else if (fecha_hasta == '') {
        error("Debe ingresar una fecha hasta");
    } else if (fecha_desde > fecha_hasta) {
        error("La fecha desde tiene que ser menor a la fecha hasta");
    } else {

        $('#tabla_todas_faltas_acompanantes_personal').DataTable({
            ajax: `${url_ajax}datos_acompanantes/todos_registros_faltas_acompanantes.php?fecha_desde=${fecha_desde}&fecha_hasta=${fecha_hasta}`,
            columns: [
                { data: 'trabajador' },
                { data: 'cedula' },
                { data: 'nombre' },
                { data: 'tipo_falta' },
                { data: 'actividad' },
                { data: 'empresa' },
                { data: 'fecha_inicio' },
                { data: 'fecha_final' },
            ],
            bDestroy: true,
            order: [[0, 'desc']],
            language: { url: url_lenguage },
            dom: 'Bfrtip',
            buttons: ['excel'],
        });

        $('#modalTodasFaltasAcompanantes').modal('show');

    }
}
/** End Reporte De Faltas **/


/** Licencias **/
function registro_completo_licencias_acompanantes() {
    let fecha_desde = $('#cg_fecha_desde_personal').val();
    let fecha_hasta = $('#cg_fecha_hasta_personal').val();

    if (fecha_desde == '') {
        error("Debe ingresar una fecha desde");
    } else if (fecha_hasta == '') {
        error("Debe ingresar una fecha hasta");
    } else if (fecha_desde > fecha_hasta) {
        error("La fecha desde tiene que ser menor a la fecha hasta");
    } else {

        $.ajax({
            type: 'GET',
            url: `${url_ajax}datos_acompanantes/todas_licencias_acompanantes.php`,
            data: {
                fecha_desde,
                fecha_hasta,
                opcion: 'consulta',
            },
            dataType: 'JSON',
            beforeSend: function () {
                mostrarLoader();
            },
            complete: function () {
                mostrarLoader('O');
            },
            success: function (response) {
                if (response.error === false) {
                    tabla_licencias_acompanantes(fecha_desde, fecha_hasta);

                    $('#modalDatosTodaslicencias').modal('show');
                } else {
                    error(response.mensaje);
                }
            },
        });

    }
}

function tabla_licencias_acompanantes(fecha_desde, fecha_hasta) {
    let groupColumn = 0;

    $('#tabla_todas_licencias_personal').DataTable({
        ajax: `${url_ajax}datos_acompanantes/todas_licencias_acompanantes.php?fecha_desde=${fecha_desde}&fecha_hasta=${fecha_hasta}&opcion=tabla`,
        columns: [
            { data: 'anio' },
            { data: 'cedula' },
            { data: 'nombre_completo' },
            { data: 'fecha_inicio' },
            { data: 'fecha_fin' },
            { data: 'cant_dias' },
            { data: 'tipo_licencia' },
        ],
        bDestroy: true,
        order: [[groupColumn, 'asc']],
        columnDefs: [{ visible: false, targets: groupColumn }],
        ordering: false,
        searching: false,
        drawCallback: function (settings) {
            let api = this.api();
            let rows = api.rows({ page: 'current' }).nodes();
            let last = null;
            api.column(groupColumn, { page: 'current' }).data().each(function (group, i) {
                if (last !== group) {
                    $(rows).eq(i).before(`
                <tr class="group">
                    <td colspan="6" style="background-color: #6F934F; color: white; font-weight: bolder;">
                        group
                    </td>
                </tr>`);
                    last = group;
                }
            });
        },
        language: { url: url_lenguage },
        dom: 'Bfrtip',
        buttons: ['excel'],
        rowGroup: {
            dataSrc: 'anio',
        },
    });
}
/** End Licencias **/


/** Capacitación De Acompañantes **/
function registro_capacitacion_acompanantes() {
    let fecha_desde = $('#cg_fecha_desde_personal').val();
    let fecha_hasta = $('#cg_fecha_hasta_personal').val();

    if (fecha_desde == '') {
        error("Debe ingresar una fecha desde");
    } else if (fecha_hasta == '') {
        error("Debe ingresar una fecha hasta");
    } else if (fecha_desde > fecha_hasta) {
        error("La fecha desde tiene que ser menor a la fecha hasta");
    } else {

        $.ajax({
            type: 'GET',
            url: `${url_ajax}datos_acompanantes/capacitacion_acompanantes.php`,
            data: {
                fecha_desde,
                fecha_hasta,
                opcion: 'consulta',
            },
            dataType: 'JSON',
            beforeSend: function () {
                mostrarLoader();
            },
            complete: function () {
                mostrarLoader('O');
            },
            success: function (response) {
                if (response.error === false) {
                    tabla_capacitacion_acompanantes(fecha_desde, fecha_hasta);

                    $('#modalCapacitacionAcompanantes').modal('show');
                } else {
                    error(response.mensaje);
                }
            },
        });

    }
}

function tabla_capacitacion_acompanantes(fecha_desde, fecha_hasta) {
    $('#tabla_capacitacion_acompanantes').DataTable({
        ajax: `${url_ajax}datos_acompanantes/capacitacion_acompanantes.php?opcion=tabla&fecha_desde=${fecha_desde}&fecha_hasta=${fecha_hasta}`,
        columns: [
            { data: 'nombre_completo' },
            { data: 'cedula' },
            { data: 'filial' },
            { data: 'fecha' },
        ],
        order: [[3, 'desc']],
        bDestroy: true,
        language: { url: url_lenguage },
        dom: 'Bfrtip',
        buttons: ['excel'],
    });
}
/** End Capacitación De Acompañantes **/


/** Viaticos A Descontar **/
function registro_viaticos_descontar_acompanantes() {
    let fecha_desde = $('#cg_fecha_desde_personal').val();
    let fecha_hasta = $('#cg_fecha_hasta_personal').val();

    if (fecha_desde == '') {
        error("Debe ingresar una fecha desde");
    } else if (fecha_hasta == '') {
        error("Debe ingresar una fecha hasta");
    } else if (fecha_desde > fecha_hasta) {
        error("La fecha desde tiene que ser menor a la fecha hasta");
    } else {

        alert('Los Viáticos a descontar aún no están disponibles!');

    }
}
/** End Viaticos A Descontar **/


/** Listado De Radios **/
function registro_listado_radios() {
    let fecha_desde = $('#cg_fecha_desde_personal').val();
    let fecha_hasta = $('#cg_fecha_hasta_personal').val();

    if (fecha_desde == '') {
        error("Debe ingresar una fecha desde");
    } else if (fecha_hasta == '') {
        error("Debe ingresar una fecha hasta");
    } else if (fecha_desde > fecha_hasta) {
        error("La fecha desde tiene que ser menor a la fecha hasta");
    } else {

        alert('Los Listados de radios aún no está disponible!');

    }
}
/** End Listado De Radios **/


/** Archivos De Cobranza **/
function registro_archivos_cobranza() {
    let fecha_desde = $('#cg_fecha_desde_personal').val();
    let fecha_hasta = $('#cg_fecha_hasta_personal').val();

    if (fecha_desde == '') {
        error("Debe ingresar una fecha desde");
    } else if (fecha_hasta == '') {
        error("Debe ingresar una fecha hasta");
    } else if (fecha_desde > fecha_hasta) {
        error("La fecha desde tiene que ser menor a la fecha hasta");
    } else {

        alert('Los Archivos de cobranza aún no están disponibles!');

    }
}
/** End Archivos De Cobranza **/


/** Corte De Producto ABM **/
function registro_corte_producto_abm() {
    let fecha_desde = $('#cg_fecha_desde_personal').val();
    let fecha_hasta = $('#cg_fecha_hasta_personal').val();

    if (fecha_desde == '') {
        error("Debe ingresar una fecha desde");
    } else if (fecha_hasta == '') {
        error("Debe ingresar una fecha hasta");
    } else if (fecha_desde > fecha_hasta) {
        error("La fecha desde tiene que ser menor a la fecha hasta");
    } else {

        alert('El Corte de producto ABM aún no está disponible!');

    }
}
/** End Corte De Producto ABM **/


/** Resultado De Comisión **/
function registro_resultado_comision() {
    let fecha_desde = $('#cg_fecha_desde_personal').val();
    let fecha_hasta = $('#cg_fecha_hasta_personal').val();

    if (fecha_desde == '') {
        error("Debe ingresar una fecha desde");
    } else if (fecha_hasta == '') {
        error("Debe ingresar una fecha hasta");
    } else if (fecha_desde > fecha_hasta) {
        error("La fecha desde tiene que ser menor a la fecha hasta");
    } else {

        alert('Los Resultados de comisión aún no están disponibles!');

    }
}
/** End Resultado De Comisión **/


/** Retenciones De Socios **/
function registro_retenciones_socios() {
    let fecha_desde = $('#cg_fecha_desde_personal').val();
    let fecha_hasta = $('#cg_fecha_hasta_personal').val();

    if (fecha_desde == '') {
        error("Debe ingresar una fecha desde");
    } else if (fecha_hasta == '') {
        error("Debe ingresar una fecha hasta");
    } else if (fecha_desde > fecha_hasta) {
        error("La fecha desde tiene que ser menor a la fecha hasta");
    } else {

        alert('Las Retenciones de socios aún no están disponibles!');

    }
}
/** End Retenciones De Socios **/


/** Horas Auxiliares De Limpieza **/
function registro_horas_auxiliares_limpieza() {
    let fecha_desde = $('#cg_fecha_desde_personal').val();
    let fecha_hasta = $('#cg_fecha_hasta_personal').val();

    if (fecha_desde == '') {
        error("Debe ingresar una fecha desde");
    } else if (fecha_hasta == '') {
        error("Debe ingresar una fecha hasta");
    } else if (fecha_desde > fecha_hasta) {
        error("La fecha desde tiene que ser menor a la fecha hasta");
    } else {

        alert('Las Horas auxiliares de limpieza aún no están disponibles!');

    }
}
/** End Horas Auxiliares De Limpieza **/


/** Horas Particulares **/
function registro_horas_particulares() {
    let fecha_desde = $('#cg_fecha_desde_personal').val();
    let fecha_hasta = $('#cg_fecha_hasta_personal').val();

    if (fecha_desde == '') {
        error("Debe ingresar una fecha desde");
    } else if (fecha_hasta == '') {
        error("Debe ingresar una fecha hasta");
    } else if (fecha_desde > fecha_hasta) {
        error("La fecha desde tiene que ser menor a la fecha hasta");
    } else {

        alert('Las Horas particulares aún no están disponibles!');

    }
}
/** End Horas Particulares **/


/** Control De Satisfacción Paraguay **/
function registro_control_satisfaccion_paraguay() {
    let fecha_desde = $('#cg_fecha_desde_personal').val();
    let fecha_hasta = $('#cg_fecha_hasta_personal').val();

    if (fecha_desde == '') {
        error("Debe ingresar una fecha desde");
    } else if (fecha_hasta == '') {
        error("Debe ingresar una fecha hasta");
    } else if (fecha_desde > fecha_hasta) {
        error("La fecha desde tiene que ser menor a la fecha hasta");
    } else {

        alert('El Control de satisfacción Paraguay aún no está disponible!');

    }
}
/** End Control De Satisfacción Paraguay **/


/** Uniformes A Descontar **/
function registro_uniformes_descontar() {
    let fecha_desde = $('#cg_fecha_desde_personal').val();
    let fecha_hasta = $('#cg_fecha_hasta_personal').val();

    if (fecha_desde == '') {
        error("Debe ingresar una fecha desde");
    } else if (fecha_hasta == '') {
        error("Debe ingresar una fecha hasta");
    } else if (fecha_desde > fecha_hasta) {
        error("La fecha desde tiene que ser menor a la fecha hasta");
    } else {

        alert('Los Uniformes a descontar aún no están disponibles!');

    }
}
/** End Uniformes A Descontar **/


/** Capacitación Comercial **/
function registro_capacitacion_comercial() {
    let fecha_desde = $('#cg_fecha_desde_personal').val();
    let fecha_hasta = $('#cg_fecha_hasta_personal').val();

    if (fecha_desde == '') {
        error("Debe ingresar una fecha desde");
    } else if (fecha_hasta == '') {
        error("Debe ingresar una fecha hasta");
    } else if (fecha_desde > fecha_hasta) {
        error("La fecha desde tiene que ser menor a la fecha hasta");
    } else {

        alert('La Capacitación comercial aún no están disponibles!');

    }
}
/** End Capacitación Comercial **/