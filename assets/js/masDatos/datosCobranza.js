function datos_cobranza() {
	let cedula = $('#cedulas').text();

	if (cedula == '') {
		error('Debe ingresar la cédula que desea consultar');
	} else {

		$('#btnDatosCobranza').prop("disabled", true);
		$('#btnDatosCobranza').text('Cargando...');

		$.ajax({
			type: "GET",
			url: `${url_app}masDatos/datosCobranza.php?opcion=1`,
			data: {
				cedula: cedula
			},
			dataType: "JSON",
			success: function (response) {
				if (response.error === false) {
					tabla_cobranzas(cedula);
					$('#modalDatosCobranza').modal('show');
					$('#btnDatosCobranza').prop("disabled", false);
					$('#btnDatosCobranza').text('Cobranza');
				} else {
					$('#btnDatosCobranza').prop("disabled", true);
					$('#btnDatosCobranza').text('Cobranzas (sin registros)');
					error(response.mensaje);
				}
			}
		});

	}
}


function tabla_cobranzas(cedula) {
	$("#tabla_registros_cobranza").DataTable({
		ajax: `${url_app}masDatos/datosCobranza.php?cedula=${cedula}&opcion=2`,
		columns: [
			{ data: "mes" },
			{ data: "anho" },
			{ data: "importe" },
			{ data: "cobrado" },
		],
		order: [[1, "desc"], [0, "desc"]],
		bDestroy: true,
		language: {
			url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json",
		},
	});
}