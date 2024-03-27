function datosCoordina() {
	let cedula = $('#cedulas').text();

	if (cedula == '') {
		error('Debe ingresar la cédula que desea consultar');
	} else {

		$.ajax({
			type: "GET",
			url: `${url_app}masDatos/datosCoordina.php?opcion=1`,
			data: {
				cedula: cedula
			},
			dataType: "JSON",
			beforeSend: function () {
				$('#b1').prop("disabled", true);
				$('#b1').text('Cargando...');
				mostrarLoader();
			},
			complete: function () {
				mostrarLoader('O');
			},
			success: function (response) {
				if (response.error === false) {
					$("#tabla_servicios_coordinacion").DataTable({
						ajax: `${url_app}masDatos/datosCoordina.php?cedula=${cedula}&opcion=2`,
						columns: [
							{ data: "id" },
							{ data: "observacion" },
							{ data: "fecha_inicio" },
							{ data: "fecha_fin" },
							{ data: "hora_inicio" },
							{ data: "hora_fin" },
							{ data: "horas_x_dia" },
							{ data: "lugar" },
							{ data: "estado" },
							{ data: "patologia" },
						],
						order: [[0, "desc"]],
						bDestroy: true,
						language: {
							url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json",
						},
					});

					$('#modalDatosCoordina').modal('show');
					$('#b1').prop("disabled", false);
					$('#b1').text('Coordinación');
				} else {
					error(response.mensaje);
					$('#b1').prop("disabled", true);
					$('#b1').text('Coordinación (sin registros)');
				}
			}
		});

	}
}