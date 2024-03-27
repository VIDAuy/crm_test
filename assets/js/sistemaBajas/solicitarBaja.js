// Funciones pasivas

$(function () {
	$('#botonMDDB').on('click', function (e) {
		corroborarDatos();
	});
});

// AJAX

function listarDatos(CI) {
	if (CI != '') {
		if (comprobarCI(CI)) {
			$.ajax(
				{
					url: 'PHP/AJAX/sistemaBajas/listarDatos.php?CI=' + CI,
					dataType: 'JSON',
					success: function (content) {
						limpiar();
						if (content.result) {
							if (content.cedula.length == 7 || content.cedula.substring(0, 1) == 0) {
								if (content.cedula.substring(0, 1) == 0) content.cedula = content.cedula.substring(1, 8)
								c1 = content.cedula.substring(0, 3);
								c2 = content.cedula.substring(3, 6);
								c3 = content.cedula.substring(6, 7);
								cedula = c1 + '.' + c2 + '-' + c3;
							}
							else {
								c1 = content.cedula.substring(0, 1);
								c2 = content.cedula.substring(1, 4);
								c3 = content.cedula.substring(4, 7);
								c4 = content.cedula.substring(7, 8);
								cedula = c1 + '.' + c2 + '.' + c3 + '-' + c4;
							}
							$('#cedulaTitulo').text(`${content.nombre} (CI: ${cedula})`);
							$('#idrelacion').val(content.idrelacion);
							$('#idrelacion2').val(content.idrelacion);
							$('#nombre_socio').val(content.nombre);
							$('#cedula_socio').val(content.cedula);
							$('#filial_socio').val(content.filial);
							$('#radio_socio').val(content.radio);
							$('#telefono_contacto').val(content.telefono);
							$('#celular_contacto').val(content.celular);
							$('#importe').val(content.importe);
							$('#modalSolicitarBaja').modal('show');
							cargarMSBhiddenItems();
						}
						else if (content.cedula) error(content.message);
						else if (content.registro) error(content.message);
						else if (content.baja) error(content.message);
						else if (content.bajaGestionada) error(content.message);
					},
					error: function () {
						$('#txtResult').html('Ocurrio un error. Por favor vuelva a intentar en instantes.');
						$('#primaria').css('display', 'none');
					}
				});
		}
		else error('La cédula ingresada no es válida.');
	}
	else {
		error('Se debe de ingresar la cédula del usuario previamente.');
		$('#modalSolicitarBaja .close').click();
	}
}

function cargarMSBhiddenItems() {
	$.ajax(
		{
			url: 'PHP/AJAX/serviciosContratados/listarServicios.php',
			dataType: 'JSON',
			data:
			{
				cedula: $('#ci').val()
			},
			beforeSend: function () {
				$('#MSBhiddenItems tr').remove();
			},
			success: function (content) {
				if (content.error) alert(content.mensaje);
				else {
					$.each(content, function (index, el) {
						nuevoServicio =
							'<tr>' +
							'<td><input type="hidden" name="nroServicio' + index + '" value="' + el.nroServicio + '"	></td>' +
							'<td><input type="hidden" name="servicio' + index + '" value="' + el.servicio + '"		></td>' +
							'<td><input type="hidden" name="horas' + index + '" value="' + el.horas + '"			></td>' +
							'<td><input type="hidden" name="importe' + index + '" value="' + el.importe + '"		></td>' +
							'</tr>';
						$(nuevoServicio).appendTo('#MSBhiddenItems');
					});
				}
			},
			error: function () {
				alert('Ha ocurrido un error inesperado, por favor comuníquese con el administrador.');
			}
		});
}

function guardarDatos() {
	$data = $('#formModalBajas').serialize();
	let sector = $('#sector').val();
	let id_sub_usuario = localStorage.getItem('id_sub_usuario');
	id_sub_usuario = id_sub_usuario != null ? id_sub_usuario : "";

	$.ajax(
		{
			url: `PHP/AJAX/sistemaBajas/guardarDatos.php?sector=${sector}&id_sub_usuario=${id_sub_usuario}`,
			data: $data,
			method: 'POST',
			dataType: 'JSON',
			success: function (content) {
				if (content.registroActivo) {
					limpiar();
					alert(content.message);
					$('#modalSolicitarBaja .close').click();
				}
				else if (content.result) {
					limpiar();
					alert(content.message);
					$('#modalSolicitarBaja .close').click();
				}
				else alert(content.message);
			},
			error: function () {
				$('#txtResult').html('Ocurrio un error. Por favor vuelva a intentar en instantes.');
				$('#primaria').css("display", "none");
			}
		});
}

// Funciones complementarias

function limpiar() {
	$('#idrelacion').val('');
	$('#nombre_funcionario').val('');
	$('#observaciones').val('');
	$('#nombre_socio').val('');
	$('#cedula_socio').val('');
	$('#filial_socio').val(undefined);
	$('#servicio_contratado').val('');
	$('#horas_contratadas').val(undefined);
	$('#importe').val('');
	$('#motivo_baja').val(undefined);
	$('#nombre_contacto').val('');
	$('#apellido_contacto').val('');
	$('#telefono_contacto').val('');
	$('#celular_contacto').val('');
}

// Funciones de control
function corroborarDatos() {
	mensaje = '';

	// CONTROLES DE INFORMACIÓN DE USUARIO --

	// CONTROLES DEL INPUT -- nombre_socio --

	if ($('#nombre_socio').val() == '')
		mensaje += 'El campo "Nombre socio" no puede estar vacío. \n';
	else if (!/^([a-zA-Z_ÑñáéíóúÁÉÍÓÚ ])*$/.test($('#nombre_socio').val()))
		mensaje += 'El campo "Nombre socio" sólo puede contener letras. \n';

	// CONTROLES DEL INPUT -- cedula_socio --

	if ($('#cedula_socio').val() == '')
		mensaje += 'El campo "C.I. del socio" no puede estar vacío. \n';
	else if (!/^([0-9])*$/.test($('#cedula_socio').val()))
		mensaje += 'El campo "C.I. del socio" sólo puede contener números. \n';
	else if (!comprobarCI($('#cedula_socio').val()))
		mensaje += 'El campo "C.I. del socio" contiene una cédula inválida. \n';

	// CONTROLES DEL INPUT -- filial_socio --

	if ($('#filial_socio').val() == '')
		mensaje += 'El campo "Filial socio" no puede estar vacío. \n';

	// CONTROLES DEL INPUT -- motivo_baja --

	if ($('#motivo_baja').val() == undefined)
		mensaje += 'Debe seleccionar un motivo de la baja.. \n';

	// CONTROLES DE INFORMACIÓN DE CONTACTO --

	// CONTROLES DEL INPUT -- nombre_contacto --

	if ($('#nombre_contacto').val() == '')
		mensaje += 'El campo "Nombre contacto" no puede estar vacío. \n';
	else if (!/^([a-zA-Z_ÑñáéíóúÁÉÍÓÚ ])*$/.test($('#nombre_contacto').val()))
		mensaje += 'El campo "Nombre contacto" sólo puede contener letras. \n';

	// CONTROLES DEL INPUT -- apellido_contacto --

	if ($('#apellido_contacto').val() == '')
		mensaje += 'El campo "Apellido contacto" no puede estar vacío. \n';
	else if (!/^([a-zA-Z_ÑñáéíóúÁÉÍÓÚ ])*$/.test($('#apellido_contacto').val()))
		mensaje += 'El campo "Apellido contacto" sólo puede contener letras. \n';

	// CONTROLES DE LOS INPUT -- telefono_contacto Y celular_contacto --

	if ($('#telefono_contacto').val() == '' && $('#celular_contacto').val() == '')
		mensaje += 'Se debe ingresar un teléfono o un celular de contacto. \n';
	else {
		if ($('#telefono_contacto').val() != '') {
			if (!/^([0-9])*$/.test($('#telefono_contacto').val()))
				mensaje += 'El campo "Teléfono contacto" sólo puede contener números.\n';
			else if ($('#telefono_contacto').val().length != 8)
				mensaje += 'El campo "Teléfono contacto" debe de tener 8 números.\n';
			else if ($('#telefono_contacto').val().substring(0, 1) != 2 && $('#telefono_contacto').val().substring(0, 1) != 4)
				mensaje += 'El telefono ingresado en el campo "Teléfono contacto" es inválido.\n';
		}
		if ($('#celular_contacto').val() != '') {
			if (!/^([0-9])*$/.test($('#celular_contacto').val()))
				mensaje += 'El campo "Celular contacto" sólo puede contener números.\n';
			else if ($('#celular_contacto').val().length != 9)
				mensaje += 'El campo "Celular contacto" debe de tener 9 números.\n';
			else if ($('#celular_contacto').val().substring(0, 2) != 09)
				mensaje += 'El celular ingresado en el campo "Celular contacto" es inválido.\n';
		}
	}

	// CONTROLES DE INFORMACIÓN DE GESTIÓN --

	// CONTROLES DEL INPUT -- nombre_funcionario --

	if ($('#nombre_funcionario').val() == '')
		mensaje += 'El campo "Nombre de funcionario" no puede estar vacío. \n';
	else if (!/^([a-zA-Z_ÑñáéíóúÁÉÍÓÚ ])*$/.test($('#nombre_funcionario').val()))
		mensaje += 'El campo "Nombre de funcionario" sólo puede contener letras. \n';

	// CONTROLES DEL INPUT -- observaciones --

	if ($('#observaciones').val() == '')
		mensaje += 'El campo "Observaciones" no puede estar vacío. \n';

	// CORROBORA QUE NO HAYA OCURRIDO NINGÚN ERROR, EN CASO DE QUE SÍ LOS ENLISTA EN UN ALERT
	// DE LO CONTRARIO INGRESA LOS DATOS EN LA DB

	if (mensaje != "") alert("Han ocurrido los siguientes errores: \n" + mensaje);
	else guardarDatos();
}

function motivoEstado() {
	if ($('#estado').val() != "No otorgada") {
		$('#motivo_no_otorgada').prop('disabled', true);
		$('#motivo_no_otorgada').val('Seleccione un motivo');
	}
	else $('#motivo_no_otorgada').prop('disabled', false);
}

function comprobarCI(cedi) {
	if (cedi == "93233611" || cedi == "78183625") return true;

	let arrCoefs = [2, 9, 8, 7, 6, 3, 4, 1];
	let suma = 0;
	let difCoef = parseInt(arrCoefs.length - cedi.length);
	for (let i = cedi.length - 1; i > -1; i--) {
		let dig = cedi.substring(i, i + 1);
		let digInt = parseInt(dig);
		let coef = arrCoefs[i + difCoef];
		suma = suma + digInt * coef;
	}
	return (suma % 10) == 0;
}


$('.solo_numeros').keydown(function (e) {
	if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 40]) !== -1 || (e.keyCode >= 35 && e.keyCode <= 39)) return;
	if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) e.preventDefault();
	if (e.altKey) return false;
});