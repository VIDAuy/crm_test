function ver_registros_volver_a_llamar() {

    $("#modal_historialRegistrosVolverALlamar").modal("show");

    $('#tabla_historial_volver_a_llamar').DataTable({
        ajax: `${url_app}tabla_historial_volver_a_llamar.php?`,
        columns: [
            { data: 'id' },
            { data: 'cedula' },
            { data: 'nombre' },
            { data: 'telefono' },
            { data: 'socio' },
            { data: 'baja' },
            { data: 'fecha_hora' },
            { data: 'comentario' },
            { data: 'fecha_registro' },
            { data: 'usuario_agendo' },
            { data: 'usuario_asignado' },
            { data: 'usuario_asignador' },
        ],
        "order": [[0, 'desc']],
        "bDestroy": true,
        language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json' },
    });
}

function ver_registros_alertas() {

    $("#modal_historialRegistrosDeAlertas").modal("show");

    $('#tabla_historial_alertas').DataTable({
        ajax: `${url_app}tabla_historial_alertas.php`,
        columns: [
            { data: 'id' },
            { data: 'cedula' },
            { data: 'sector' },
            { data: 'nombre' },
            { data: 'telefono' },
            { data: 'fecha_registro' },
            { data: 'usuario_asignado' },
            { data: 'usuario_asignador' },
        ],
        "order": [[0, 'desc']],
        "bDestroy": true,
        language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json' },
    });
}