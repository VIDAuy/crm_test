// AJAX

function MIDBactualizarDatos() {
  let sector = $('#sector').val();
  let id_sub_usuario = localStorage.getItem('id_sub_usuario');
  id_sub_usuario = id_sub_usuario != null ? id_sub_usuario : '';

  let idrelacion = $('#MIDBidrelacion').val();
  let nombre_funcionario = $('#MIDBnombreFA').val();
  let estado = $('#MIDBestado').val();
  let motivo = $('#MIDBmno').val() == null ? '' : $('#MIDBmno').val();
  let observacion = $('#MIDBobservacion').val();
  let avisar_a_elite = $('#MIDBavisar_a_elite').is(':checked');

  if (idrelacion == '') {
    error(
      'Ha ocurrido un error, intente nuevamente y si el problema persiste contactese con el administrador'
    );
  } else if (nombre_funcionario == '') {
    error('Debe ingresar su nombre');
  } else if (estado == '') {
    error('Debe seleccionar un estado');
  } else if (motivo == '' && estado != 'Desestima solicitud') {
    error('Debe seleccionar un motivo');
  } else if (observacion == '') {
    error('Debe ingresar una observación');
  } else {
    $.ajax({
      url: `PHP/AJAX/sistemaBajas/actualizarBaja.php`,
      type: 'POST',
      dataType: 'JSON',
      data: {
        "idrelacion": idrelacion,
        "usuario": sector,
        "id_sub_usuario": id_sub_usuario,
        "avisar_a_elite": avisar_a_elite,
        "nombreFuncionarioFinal": nombre_funcionario,
        "estado": estado,
        "motivo": motivo,
        "observacionFinal": observacion,
      },
    })
      .done(function (respuesta) {
        if (respuesta.error) alert(respuesta.mensaje);
        else {
          alert(respuesta.mensaje);
          corroborarBajas();
          $('#modalInformacionDetalladaBaja').modal("hide");
          limpiarMIDB();
        }
      })
      .fail(function (respuesta) {
        alert(respuesta.mensaje);
      });
  }
}

function masInfoMLB(id) {
  $.ajax({
    url: 'PHP/AJAX/sistemaBajas/listarBajas.php',
    data: { id: id },
    dataType: 'JSON',
    success: function (content) {
      if (content.error) alert(content.mensaje);
      else {
        $('#ci').val(content.cedula_socio);
        if (
          content.cedula_socio.length == 7 ||
          content.cedula_socio.substring(0, 1) == 0
        ) {
          if (content.cedula_socio.substring(0, 1) == 0)
            content.cedula_socio = content.cedula_socio.substring(1, 8);
          c1 = content.cedula_socio.substring(0, 3);
          c2 = content.cedula_socio.substring(3, 6);
          c3 = content.cedula_socio.substring(6, 7);
          cedula = c1 + '.' + c2 + '-' + c3;
        } else {
          c1 = content.cedula_socio.substring(0, 1);
          c2 = content.cedula_socio.substring(1, 4);
          c3 = content.cedula_socio.substring(4, 7);
          c4 = content.cedula_socio.substring(7, 8);
          cedula = c1 + '.' + c2 + '.' + c3 + '-' + c4;
        }

        $('#idrelacion').val(content.idrelacion);

        $('#MIDBtitulo').text(`Detalles de la baja de: ${content.nombre_socio} (${cedula})`);
        $('#MIDBestadoActual').html(`Estado actual: <strong>${content.estado}</strong>`);

        // INFORMACIÓN DEL SOCIO

        $('#MIDBidrelacion').val(content.idrelacion);
        $('#MIDBnombre').val(content.nombre_socio);
        $('#MIDBcedula').val(content.cedula_socio);
        $('#MIDBfilialS').val(content.filial_socio);
        $('#MIDBmotivoB').val(content.motivo_baja);

        // INFORMACIÓN DE CONTACTO

        $('#MIDBnombreC').val(content.nombre_contacto);
        $('#MIDBapellido').val(content.apellido_contacto);
        $('#MIDBtel').val(content.telefono_contacto);
        $('#MIDBcel').val(content.celular_contacto);

        // INFORMACIÓN DE GESTIÓN

        $('#MIDBnombreF').val(content.nombre_funcionario);
        $('#MIDBfilialF').val(content.filial_solicitud);
        $('#MIDBobs').val(content.observaciones);
        $('#MIDBfechaIngreso').val(content.fecha_ingreso_baja);

        let sector = $('#sector').val();
        if (sector == 'Calidad' || sector == 'Bajas') {
          $('.class_MIDBavisar_a_elite').css('display', 'block');
        }

        // INFORMACIÓN DE ACTUALIZACIÓN DE LA GESTIÓN

        /*
          if (content.estado != 'Pendiente')
            $('#MIDBestado').val(content.estado);
          */
        //$('#MIDBobservacion').val(content.observacion_final);

        $('#modalInformacionDetalladaBaja').modal('show');
      }
    },
    error: function () {
      alert('Ocurrio un error. Por favor vuelva a intentar en instantes.');
    },
  });
}

function corroborarBajas() {
  $('#tablaMLB').DataTable().destroy();
  $('#tablaMLB tbody').html('');
  $.ajax({
    url: 'PHP/AJAX/sistemaBajas/listarBajas.php',
    dataType: 'JSON',
    beforeSend: function () {
      $('#where').val('2');
    },
    success: function (content) {
      if (content.error) {
        alert(content.mensaje);
        $('#modalListarBajas .close').click();
      } else {
        $.each(content, function (index, el) {
          nuevaBaja =
            '<tr>' +
            '<th class="text-center">' +
            el.nombre +
            '</th>' +
            '<td class="text-center">' +
            el.cedula +
            '</td>' +
            '<td class="text-center">' +
            el.telefono +
            '</td>' +
            '<td class="text-center">' +
            el.fecha +
            '</td>' +
            '<td class="text-center">' +
            el.motivo +
            '</td>' +
            '<td class="text-center">' +
            el.fechaGestion +
            '</td>' +
            '<td>' +
            el.observaciones +
            '</td>' +
            '<td class="text-center">' +
            el.filial_solicitud +
            '</td>' +
            '<td><input type="button" class="btn btn-primary center-block" value="Información detallada" onclick="masInfoMLB(' +
            el.id +
            ')"></td>' +
            '</tr>';
          $(nuevaBaja).appendTo('#tbodyMLB');
        });
        $('#tablaMLB').DataTable({
          searching: true,
          paging: true,
          lengthChange: false,
          bSort: false,
          info: true,
          language: {
            zeroRecords: 'No se encontraron registros.',
            info: 'Pagina _PAGE_ de _PAGES_',
            infoEmpty: 'No Hay Registros Disponibles',
            infoFiltered: '(filtrado de _MAX_ hasta records)',
            search: 'Buscar:',
            paginate: {
              first: 'Primero',
              last: 'Último',
              next: 'Siguiente',
              previous: 'Anterior',
            },
          },
        });
        stateSave: true;
        $('[type="search"]').addClass('form-control-static');
        $('[type="search"]').css({ borderRadius: '5px' });
        $('#modalListarBajas').modal('show');
      }
    },
    error: function () {
      alert('Ocurrio un error. Por favor vuelva a intentar en instantes.');
    },
  });
}

function corroborarBajasWhere() {
  $('#tablaMLB').DataTable().destroy();
  $('#tablaMLB tbody').html('');
  $.ajax({
    url: 'PHP/AJAX/sistemaBajas/listarBajas.php',
    data: { where: $('#where').val() },
    dataType: 'JSON',
    success: function (content) {
      if (content.error)
        alert('Actualmente no hay bajas que apliquen con ese filtro');
      else {
        $.each(content, function (index, el) {
          nuevaBaja =
            '<tr>' +
            '<th class="text-center">' +
            el.nombre +
            '</th>' +
            '<td class="text-center">' +
            el.cedula +
            '</td>' +
            '<td class="text-center">' +
            el.telefono +
            '</td>' +
            '<td class="text-center">' +
            el.fecha +
            '</td>' +
            '<td class="text-center">' +
            el.motivo +
            '</td>' +
            '<td class="text-center">' +
            el.fechaGestion +
            '</td>' +
            '<td>' +
            el.observaciones +
            '</td>' +
            '<td class="text-center">' +
            el.filial_solicitud +
            '</td>' +
            '<td><input type="button" class="btn btn-primary center-block" value="Información detallada" onclick="masInfoMLB(' +
            el.id +
            ')"></td>' +
            '</tr>';
          $(nuevaBaja).appendTo('#tbodyMLB');
        });
        $('#tablaMLB').DataTable({
          searching: true,
          paging: true,
          lengthChange: false,
          bSort: false,
          info: true,
          language: {
            zeroRecords: 'No se encontraron registros.',
            info: 'Pagina _PAGE_ de _PAGES_',
            infoEmpty: 'No Hay Registros Disponibles',
            infoFiltered: '(filtrado de _MAX_ hasta records)',
            search: 'Buscar:',
            paginate: {
              first: 'Primero',
              last: 'Último',
              next: 'Siguiente',
              previous: 'Anterior',
            },
          },
        });
        stateSave: true;
        $('[type="search"]').addClass('form-control-static');
        $('[type="search"]').css({ borderRadius: '5px' });
        $('#modalListarBajas').modal('show');
      }
    },
    error: function () {
      alert('Ocurrio un error. Por favor vuelva a intentar en instantes.');
    },
  });
}

// Funciones complementarias

function limpiarMIDB() {
  $('#MIDBnombreFA').val('');
  $('#MIDBestado').val('');
  $('#MIDBmno').val('');
  $('#MIDBobservacion').val('');
  $('#MIDBavisar_a_elite').prop('checked', false);
}

function cambiarMIDBidrelacion() {
  $('#MIDBidrelacion').val($('#idrelacion').val());
}

// Funciones de control

function controlMIDBactualizarDatos() {
  let mensaje = '';

  // CONTROL DE CAMPOS

  if ($('#MIDBnombreFA').val() == '')
    mensaje += 'El campo "Nombre funcionario" es obligatorio.\n';
  if ($('#MIDBestado').val() == undefined)
    mensaje += 'El campo "Estado" es obligatorio.\n';
  if (
    $('#MIDBestado').val() == 'No otorgada' &&
    $('#MIDBmno').val() == undefined
  )
    mensaje += 'El campo "Motivo no otorgada" es obligatorio.\n';
  if ($('#MIDBobservacion').val() == '')
    mensaje += 'El campo "Observaciones" es obligatorio.\n';

  return mensaje;
}

function corroborarMIDBestado() {
  $('#MIDBmno').prop('disabled', true);
  let estado = $('#MIDBestado').val();

  if (estado != '') {
    $('#MIDBmno').prop('disabled', false);
    document.getElementById('MIDBmno').innerHTML =
      "<option value='' selected>Seleccione un motivo</option>";

    if (estado == 'Otorgada') {
      document.getElementById('MIDBmno').innerHTML =
        "<option value='' selected>¿Motivo de otorgada?</option>";
      document.getElementById('MIDBmno').innerHTML +=
        "<option value='En plazo y al dia'>En plazo y al dia</option>";
      document.getElementById('MIDBmno').innerHTML +=
        "<option value='Solicitud de Depto Legal'>Solicitud de Depto Legal</option>";
      document.getElementById('MIDBmno').innerHTML +=
        "<option value='Excepción de Gerencia'>Excepción de Gerencia</option>";
      document.getElementById('MIDBmno').innerHTML +=
        "<option value='Cobranzas'>Cobranzas</option>";
      document.getElementById('MIDBmno').innerHTML +=
        "<option value='Valor Agregado'>Valor Agregado</option>";
      document.getElementById('MIDBmno').innerHTML +=
        "<option value='Fallecimiento'>Fallecimiento</option>";
    } else if (estado == 'No otorgada') {
      document.getElementById('MIDBmno').innerHTML =
        "<option value='' selected>¿Motivo no otorgada?</option>";
      document.getElementById('MIDBmno').innerHTML +=
        "<option value='Deuda'>Deuda</option>";
      document.getElementById('MIDBmno').innerHTML +=
        "<option value='Plazo'>Plazo</option>";
      document.getElementById('MIDBmno').innerHTML +=
        "<option value='Ilocalizable'>Ilocalizable</option>";
      document.getElementById('MIDBmno').innerHTML +=
        "<option value='Pendiente comprobante'>Pendiente comprobante</option>";
    } else if (estado == 'Continua') {
      document.getElementById('MIDBmno').innerHTML =
        "<option value='' selected>¿Como continua?</option>";
      document.getElementById('MIDBmno').innerHTML +=
        "<option value='Igual'>Igual</option>";
      document.getElementById('MIDBmno').innerHTML +=
        "<option value='Reduce'>Reduce</option>";
      document.getElementById('MIDBmno').innerHTML +=
        "<option value='Pasa a acotado'>Pasa a acotado</option>";
      document.getElementById('MIDBmno').innerHTML +=
        "<option value='Pasa a GF'>Pasa a GF</option>";
      document.getElementById('MIDBmno').innerHTML +=
        "<option value='Otros'>Otros</option>";
    } else if (estado == 'En gestión') {
      document.getElementById('MIDBmno').innerHTML =
        "<option value='' selected>¿Motivo de gestión?</option>";
      document.getElementById('MIDBmno').innerHTML +=
        "<option value='Gestionando pago'>Gestionando pago</option>";
      document.getElementById('MIDBmno').innerHTML +=
        "<option value='Aguardando plazo'>Aguardando plazo</option>";
      document.getElementById('MIDBmno').innerHTML +=
        "<option value='Ilocalizable'>Ilocalizable</option>";
      document.getElementById('MIDBmno').innerHTML +=
        "<option value='Aguardando auditoria'>Aguardando auditoría</option>";
      document.getElementById('MIDBmno').innerHTML +=
        "<option value='Pendiente excepción'>Pendiente excepción</option>";
      document.getElementById('MIDBmno').innerHTML +=
        "<option value='Derivado a Elite'>Derivado a Elite</option>";
      document.getElementById('MIDBmno').innerHTML +=
        "<option value='Pendiente de otorgar en CRM'>Pendiente de otorgar en CRM</option>";
    } else {
      document.getElementById('MIDBmno').innerHTML = '';
      $('#MIDBmno').prop('disabled', true);
    }
  } else {
    document.getElementById('MIDBmno').innerHTML = '';
    $('#MIDBmno').prop('disabled', true);
  }
}
