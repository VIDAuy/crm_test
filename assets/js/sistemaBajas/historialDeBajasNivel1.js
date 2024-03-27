// AJAX

function listar()
{
	$('#JtablaMHDB').DataTable().destroy();
	$("#JtablaMHDB tbody").html("");

	$.ajax(
	{
		url: 'PHP/AJAX/sistemaBajas/historialDeBajasNivel1.php',
		dataType: 'JSON',
		data: {filial: $('#filial').val()}
	})
	.done(function(registros)
	{
		if (registros.sinRegistros) alert('No hay registros para visualizar.');
		else
		{
			$.each(registros, function(i,registros)
			{
				var newRow =
					"<tr>"
						+ "<td style='width: 1%;  margin: 1px; padding: 0; margin-right: 10px;' class='text-center'>" + registros.id + "</td>"
						+ "<td style='width: 5%;  margin: 1px; padding: 0; margin-right: 10px;' class='text-center'>" + registros.cedula_socio + "</td>"
						+ "<td style='width: 15%; margin: 1px; padding: 0; margin-right: 10px;' class='text-center'>" + registros.nombre_socio + "</td>"
						+ "<td style='width: 10%; margin: 1px; padding: 0; margin-right: 10px;' class='text-center'>" + registros.motivo_baja + "</td>"
						+ "<td style='width: 10%; margin: 1px; padding: 0; margin-right: 10px;' class='text-center'>" + registros.estado + "</td>"
						+ "<td style='width: 3%;  margin: 1px; padding: 0; margin-right: 10px;' class='text-center'><input type='button' class='btn btn-sm btn-outline-primary' value='+ info' onclick='modalMasInfoHistorialDeBajas(" + registros.id + ")'</td>"
					+ "</tr>"
				$(newRow).appendTo("#JtablaMHDB tbody");
			});
			$('#JtablaMHDB').DataTable(
			{
				searching: true,
				paging: true,
				lengthChange: false,
				ordering: true,
				info: true,
				order: [0,'asc'],
				columnDefs:
				[
					{
						targets: [ 0 ],
						orderData: [ 0, 1 ]
					}, {
						targets: [3 ],
						orderData: [ 3, 0 ]
					}
				],
				language:
				{
					zeroRecords: "No se encontraron registros.",
					info: "Pagina _PAGE_ de _PAGES_",
					infoEmpty: "No Hay Registros Disponibles",
					infoFiltered: "(filtrado de _MAX_ hasta records)",
					search:"Buscar:",
					paginate:
					{
						first:      "Primero",
						last:       "Último",
						next:       "Siguiente",
						previous:   "Anterior"
					},
				}
			});
			stateSave: true
			$('[type="search"]').addClass('form-control-static');
			$('[type="search"]').css({borderRadius: '5px'});
			$('#modalHistorialDeBajas').modal('show');
		}
	})
	.fail(function()
	{
		alert('Ha ocurrido un error, por favor comuníquese con el administrador');
	});
}

function modalMasInfoHistorialDeBajas(param)
{
	$.ajax(
	{
		url: 'PHP/AJAX/sistemaBajas/listarBajas.php',
		data: {id: param, filial: $('#filial').val()},
		dataType: 'JSON',
		success: function(content)
		{
			if(content.error) alert(content.mensaje);
			else
			{
				$('#ci').val(content.cedula_socio);
				if (content.cedula_socio.length == 7 || content.cedula_socio.substring(0,1) == 0)
				{
					if (content.cedula_socio.substring(0,1) == 0) content.cedula_socio = content.cedula_socio.substring(1,8);
					c1 = content.cedula_socio.substring(0, 3);
					c2 = content.cedula_socio.substring(3, 6);
					c3 = content.cedula_socio.substring(6, 7);
					cedula = c1 + '.' + c2 + '-' + c3;
				}
				else
				{
					c1 = content.cedula_socio.substring(0, 1);
					c2 = content.cedula_socio.substring(1, 4);
					c3 = content.cedula_socio.substring(4, 7);
					c4 = content.cedula_socio.substring(7, 8);
					cedula = c1 + '.' + c2 + '.' + c3 + '-' + c4;
				}

				$('#idrelacion').val(content.idrelacion);

				$('#MMIHDBtitulo').text('Detalles de la baja de: ' + content.nombre_socio + ' (' + cedula + ')');
				$('#MMIHDBestadoActual').text('Estado actual: ' + content.estado);

				// INFORMACIÓN DEL SOCIO

					$('#MMIHDBidrelacion').val(content.idrelacion);
					$('#MMIHDBnombre').val(content.nombre_socio);
					$('#MMIHDBcedula').val(content.cedula_socio);
					$('#MMIHDBfilialS').val(content.filial_socio);
					$('#MMIHDBmotivoB').val(content.motivo_baja);

				// INFORMACIÓN DE CONTACTO

					$('#MMIHDBnombreC').val(content.nombre_contacto);
					$('#MMIHDBapellido').val(content.apellido_contacto);
					$('#MMIHDBtel').val(content.telefono_contacto);
					$('#MMIHDBcel').val(content.celular_contacto);

				// INFORMACIÓN DE GESTIÓN

					$('#MMIHDBnombreF').val(content.nombre_funcionario);
					$('#MMIHDBfilialF').val(content.filial_solicitud);
					$('#MMIHDBobs').val(content.observaciones);
					$('#MMIHDBfechaIngreso').val(content.fecha_ingreso_baja);

				// ACTUALIZACIÓN DE GESTIÓN

				$('#MMIHDBnombreFA').val(content.nombre_funcionario_final);
				$('#MMIHDBestado').val(content.estado);
				$('#MMIHDBmno').val(content.motivo_no_otorgada);
				$('#MMIHDBobservacion').val(content.observacion_final);

				$('#modalMasInfoHistorialDeBajas').modal('show');
			}
		},
		error: function()
		{
			alert('Ocurrio un error. Por favor vuelva a intentar en instantes.');
		}
	});
}

// Funciones complementarias

function historialDeBajas()
{
	listar();
}