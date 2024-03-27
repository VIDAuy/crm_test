function datosCobranza() {
	let cedula = $('#cedulas').text();

	if (cedula == '') {
		error('Debe ingresar la cédula que desea consultar');
	} else {

		$.ajax({
			type: "GET",
			url: `${url_app}masDatos/datosCobranza.php?opcion=1`,
			data: {
				cedula: cedula
			},
			dataType: "JSON",
			beforeSend: function () {
				$('#b2').prop("disabled", true);
				$('#b2').text('Cargando...');
				mostrarLoader();
			},
			complete: function () {
				mostrarLoader('O');
			},
			success: function (response) {
				if (response.error === false) {
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

					$('#modalDatosCobranza').modal('show');
					$('#b2').prop("disabled", false);
					$('#b2').text('Cobranza');
				} else {
					$('#b2').text('Cobranzas (sin registros)');
					error(response.mensaje);
				}
			}
		});

	}
}