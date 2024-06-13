function datos_cobranza() {
	let cedula = $('#cedulas').text();

	if (cedula == '') {
		error('Debe ingresar la cédula que desea consultar');
	} else {

		$('#btnDatosCobranza').prop("disabled", true);
		$('#btnDatosCobranza').text('Cargando...');

		$.ajax({
			type: "GET",
			url: `${url_ajax}masDatos/datosCobranza.php?opcion=1`,
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
	let sector = localStorage.getItem('sector');
	if (sector == "Calidad" || sector == "Bajas") {
		$('#tabla_registros_cobranza').find('th').eq(3).after('<th>Tipo Recibo</th>');
		$("#tabla_registros_cobranza").DataTable({
			ajax: `${url_ajax}masDatos/datosCobranza.php?cedula=${cedula}&opcion=2`,
			columns: [
				{ data: "mes" },
				{ data: "anho" },
				{ data: "importe" },
				{ data: "cobrado" },
				{ data: "tipo_recibo" },
			],
			order: [[1, "desc"], [0, "desc"]],
			bDestroy: true,
			language: { url: url_lenguage },
		});
	} else {
		$("#tabla_registros_cobranza").DataTable({
			ajax: `${url_ajax}masDatos/datosCobranza.php?cedula=${cedula}&opcion=2`,
			columns: [
				{ data: "mes" },
				{ data: "anho" },
				{ data: "importe" },
				{ data: "cobrado" },
			],
			order: [[1, "desc"], [0, "desc"]],
			bDestroy: true,
			language: { url: url_lenguage },
		});
	}
}