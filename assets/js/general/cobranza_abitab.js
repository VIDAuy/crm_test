function listarMensualidades() {

  let cedula = $("#ci").val();

  $("#tabla_cobranza_abitab").DataTable({
    ajax: `${url_app}listar_cobranza_abitab.php?cedula=${cedula}`,
    columns: [
      { data: "fecha_orden" },
      { data: "id" },
      { data: "nro_factura" },
      { data: "nombre" },
      { data: "cuota" },
      { data: "importe" },
      { data: "fecha_limite" },
      { data: "pago" },
      { data: "fecha_pago" },
    ],
    columnDefs: [
      {
        targets: [0],
        visible: false,
        searchable: false,
      },
    ],
    order: [[0, "ASC"]],
    bDestroy: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json",
    },
  });
}