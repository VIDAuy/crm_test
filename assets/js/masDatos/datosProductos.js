function datos_productos() {
	let cedula = $('#cedulas').text();

	if (cedula == '') {
		error('Debe ingresar la cédula que desea consultar');
	} else {

		$('#btnDatosProductos').prop("disabled", true);
		$('#btnDatosProductos').text('Cargando...');

		$.ajax({
			type: "GET",
			url: `${url_app}masDatos/datosProductos.php?opcion=1`,
			data: {
				cedula: cedula
			},
			dataType: "JSON",
			success: function (response) {
				if (response.error === false) {
					tabla_productos(cedula);
					$('#modalDatosProductos').modal('show');
					$('#btnDatosProductos').prop("disabled", false);
					$('#btnDatosProductos').text('Productos');
				} else {
					$('#btnDatosProductos').prop("disabled", true);
					$('#btnDatosProductos').text('Productos (sin registros)');
					error(response.mensaje);
				}
			}
		});

	}
}


function tabla_productos(cedula) {
	$("#tabla_productos_registrados").DataTable({
		ajax: `${url_app}masDatos/datosProductos.php?cedula=${cedula}&opcion=2`,
		columns: [
			{ data: "nroServicio" },
			{ data: "servicio" },
			{ data: "horas" },
			{ data: "importe" },
		],
		order: [[0, "desc"]],
		bDestroy: true,
		language: {
			url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json",
		},
	});
}