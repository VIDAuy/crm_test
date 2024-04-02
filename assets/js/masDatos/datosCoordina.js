function datos_coordinacion() {
	let cedula = $('#cedulas').text();

	if (cedula == '') {
		error('Debe ingresar la cédula que desea consultar');
	} else {

		$('#btnDatosCoordinacion').prop("disabled", true);
		$('#btnDatosCoordinacion').text('Cargando...');

		$.ajax({
			type: "GET",
			url: `${url_ajax}masDatos/datosCoordina.php`,
			data: {
				cedula: cedula,
				opcion: 1
			},
			dataType: "JSON",
			success: function (response) {
				if (response.error === false) {
					$('#btnDatosCoordinacion').prop("disabled", false);
					$('#btnDatosCoordinacion').text('Coordinación');
					tabla_coordinacion(cedula);
				} else {
					$('#btnDatosCoordinacion').prop("disabled", true);
					$('#btnDatosCoordinacion').text('Coordinación (sin registros)');
					error(response.mensaje);
				}
			}
		});

	}
}


function tabla_coordinacion(cedula) {
	$("#tabla_servicios_coordinacion").DataTable({
		ajax: `${url_ajax}masDatos/datosCoordina.php?cedula=${cedula}&opcion=2`,
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
		language: { url: url_lenguage },
	});

	$("#modalDatosCoordina").modal("show");
}