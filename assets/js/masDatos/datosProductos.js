function datos_productos() {
	let cedula = $('#cedulas').text();

	if (cedula == '') {
		error('Debe ingresar la cédula que desea consultar');
	} else {

		$('#btnDatosProductos').prop("disabled", true);
		$('#btnDatosProductos').text('Cargando...');

		$.ajax({
			type: "GET",
			url: `${url_ajax}masDatos/datosProductos.php?opcion=1`,
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
	let sector = localStorage.getItem('sector');
	if (sector == "Calidad" || sector == "Bajas") {
		$('#tabla_productos_registrados').find('th').eq(3).after('<th>Cod Promo</th>');
		$('#tabla_productos_registrados').find('th').eq(4).after('<th>Fecha de afiliación</th>');
		$('#tabla_productos_registrados').find('th').eq(5).after('<th>Count</th>');
		$('#tabla_productos_registrados').find('th').eq(6).after('<th>Keepprice</th>');

		$("#tabla_productos_registrados").DataTable({
			ajax: `${url_ajax}masDatos/datosProductos.php?cedula=${cedula}&opcion=2`,
			columns: [
				{ data: "nroServicio" },
				{ data: "servicio" },
				{ data: "horas" },
				{ data: "importe" },
				{ data: "cod_promo" },
				{ data: "fecha_afiliacion" },
				{ data: "count" },
				{ data: "keepprice" },
			],
			order: [[0, "desc"]],
			bDestroy: true,
			language: { url: url_lenguage },
		});
	} else {
		$("#tabla_productos_registrados").DataTable({
			ajax: `${url_ajax}masDatos/datosProductos.php?cedula=${cedula}&opcion=2`,
			columns: [
				{ data: "nroServicio" },
				{ data: "servicio" },
				{ data: "horas" },
				{ data: "importe" },
			],
			order: [[0, "desc"]],
			bDestroy: true,
			language: { url: url_lenguage },
		});
	}
}