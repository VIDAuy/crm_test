function tabla_cobranza_abitab() {
  let cedula = $("#ci").val();

  $("#tabla_cobranza_abitab").DataTable({
    ajax: `${url_ajax}tabla_cobranza_abitab.php?cedula=${cedula}`,
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
    columnDefs: [{
      targets: [0],
      visible: false,
      searchable: false,
    }],
    order: [[0, "ASC"]],
    bDestroy: true,
    language: { url: url_lenguage },
  });


  $("#contenedor_cobranza_abitab").css("display", "block");

}