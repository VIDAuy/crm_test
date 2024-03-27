function datosProductos() {
	let cedula = $('#cedulas').text();

	if (cedula == '') {
		error('Debe ingresar la cédula que desea consultar');
	} else {

		$.ajax({
			type: "GET",
			url: `${url_app}masDatos/datosProductos.php?opcion=1`,
			data: {
				cedula: cedula
			},
			dataType: "JSON",
			beforeSend: function () {
				$('#b3').prop("disabled", true);
				$('#b3').text('Cargando...');
				mostrarLoader();
			},
			complete: function () {
				mostrarLoader('O');
			},
			success: function (response) {
				if (response.error === false) {
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

					$('#modalDatosProductos').modal('show');
					$('#b3').prop("disabled", false);
					$('#b3').text('Productos');
				} else {
					$('#b3').text('Productos (sin registros)');
					error(response.mensaje);
				}
			}
		});

	}
}