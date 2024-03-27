const produccion = false;
const app = produccion ? 'crm' : 'crm_test';
const url_app = 'http://192.168.1.250:82/' + app + '/PHP/AJAX/';

// AJAX
function agregarFiliales() {

  let sector = $('#sector').val();

  if (sector != "Morosos" && sector != "Calidad_interna") {
    let nuevaLinea1 = '<option selected value="sin_seleccion">Seleccione una opción</option>';
    $(nuevaLinea1).appendTo('.agregarFiliales');
    let nuevaLinea2 = '<option selected value="">No avisar</option>';
    $(nuevaLinea2).appendTo('.agregarFiliales');
  } else {
    let nuevaLinea1 = '<option selected value="">No avisar</option>';
    $(nuevaLinea1).appendTo('.agregarFiliales');
  }

  $.ajax({
    url: url_app + 'agregarFiliales.php',
    dataType: 'JSON',
    success: function (r) {
      $.each(r.datos, function (i, v) {
        let nuevaLinea = '<option value="' + v.id + '">' + v.usuario + '</option>';
        $(nuevaLinea).appendTo('.agregarFiliales');
      });
    },
  });
}

function select_usuarios(div) {

  document.getElementById(div).innerHTML = '<option value="" selected>Ninguna seleccionada</option>';

  $.ajax({
    type: "GET",
    url: `${url_app}select_usuarios.php?`,
    dataType: "JSON",
    success: function (response) {
      let datos = response.datos;
      datos.map((val) => {
        document.getElementById(div).innerHTML += `<option value="${val['id']}">${val['usuario']}</option>`;
      });
    }
  });

}


function enviar_terminos_y_condiciones_socio(openModal = false) {
  if (openModal === true) {
    $('#cedula_enviar_terminos_condiciones').val('');
    $('#celular_enviar_terminos_condiciones').val('');
    $('#modal_enviar_terminos_condiciones').modal('show');
  } else {
    let sector = $('#sector').val();
    let cedula = $('#cedula_enviar_terminos_condiciones').val();
    let celular = $('#celular_enviar_terminos_condiciones').val();

    if (cedula == '') {
      error('Debe ingresar una cédula');
    } else if (comprobarCI(cedula) === false) {
      error('Debe ingresar una cédula válida');
    } else if (celular != '' && comprobarCelular(celular) === false) {
      error('Debe ingresar un celular válido, <br> Ejemplo: 096548762');
    } else {
      $.ajax({
        type: 'POST',
        url: `${url_app}enviar_terminos_y_condiciones.php`,
        data: {
          sector: sector,
          cedula: cedula,
          celular: celular,
        },
        dataType: 'JSON',
        beforeSend: function () {
          mostrarLoader();
        },
        complete: function () {
          mostrarLoader('O');
        },
        success: function (response) {
          if (response.error === false) {
            correcto(response.mensaje);
            historiaComunicacionDeCedula();
            $('#cedula_enviar_terminos_condiciones').val('');
            $('#celular_enviar_terminos_condiciones').val('');
            $('#modal_enviar_terminos_condiciones').modal('hide');
          } else {
            error(response.mensaje);
          }
        },
      });
    }
  }
}

// Funciones complementarias

function ocultarContenido() {
  if ($('#ci').val() != $('cedulas').text()) {
    $('.contenido').css('display', 'none');
    $('.contenido_funcionario').css('display', 'none');
    $('#historiaComunicacionDeCedulaDiv').css('display', 'none');
    $(".patologias_socio").css("display", "none");
    $('#historiaComunicacionDeCedulaDiv_funcionarios').css('display', 'none');
    $('#acciones_socios_nivel_3').css('display', 'none');
  }
}

// Funciones de control

function comprobarCI(cedi) {
  if (cedi == '93233611' || cedi == '78183625') return true;

  let arrCoefs = [2, 9, 8, 7, 6, 3, 4, 1];
  let suma = 0;
  let difCoef = parseInt(arrCoefs.length - cedi.length);
  for (let i = cedi.length - 1; i > -1; i--) {
    let dig = cedi.substring(i, i + 1);
    let digInt = parseInt(dig);
    let coef = arrCoefs[i + difCoef];
    suma = suma + digInt * coef;
  }
  return suma % 10 == 0;
}

function comprobarCelular(celular) {
  let primeros_dos_digitos = celular.substring(0, 2);

  if (primeros_dos_digitos != 09) {
    return false;
  } else if (celular.length != 9) {
    return false;
  }

  return true;
}

function controlCargo(param) {
  let mensaje = '';
  if (param == 0) {
    if ($('#observacionesNSR').val() == '')
      mensaje += 'Es necesario que agregue una observación.';
  } else if (param == 1) {
    if ($('#nombreNS').val() == '')
      mensaje += 'Es necesario que llene el campo "nombre".\n';
    if ($('#apellidoNS').val() == '')
      mensaje += 'Es necesario que llene el campo "apellido".\n';
    if ($('#telefonoNS').val() == '' && $('#celularNS').val() == '')
      mensaje += 'Es necesario que agregue un teléfono o un celular.\n';
    else {
      if ($('#telefonoNS').val() != '') {
        if (!/^([0-9])*$/.test($('#telefonoNS').val()))
          mensaje += 'El campo "Telefono" sólo puede contener números.\n';
        else if ($('#telefonoNS').val().length != 8)
          mensaje += 'El campo "Teléfono" debe de tener 8 números.\n';
        else if (
          $('#telefonoNS').val().substring(0, 1) != 2 &&
          $('#telefonoNS').val().substring(0, 1) != 4
        )
          mensaje +=
            'El telefono ingresado en el campo "Teléfono" es inválido.\n';
      }
      if ($('#celularNS').val() != '') {
        if (!/^([0-9])*$/.test($('#celularNS').val()))
          mensaje += 'El campo "Celular" sólo puede contener números.\n';
        else if ($('#celularNS').val().length != 9)
          mensaje += 'El campo "Celular" debe de tener 9 números.\n';
        else if ($('#celularNS').val().substring(0, 2) != 09)
          mensaje +=
            'El celular ingresado en el campo "Celular" es inválido.\n';
      }
    }
    if ($('#observacionesNS').val() == '')
      mensaje += 'Es necesario que agregue una observación.';
  } else {
    if ($('#obser').val() == '')
      mensaje = 'Es necesario que agregue una observación.';
  }

  return mensaje;
}

function ir_a_vida_te_lleva() {
  let url = 'https://vida-apps.com/vida_te_lleva/panel_calidad/index.html';
  window.open(url, '_blank');
}

function verMasTabla(observacion) {
  $('#todo_comentario_funcionarios').val(observacion);
  $('#modalVerMasFuncionarios').modal('show');
}

function alerta(titulo, mensaje, icono) {
  Swal.fire({ title: titulo, html: mensaje, icon: icono });
}

function error(mensaje) {
  Swal.fire({ title: 'Error!', html: mensaje, icon: 'error' });
}

function warning(mensaje, titulo = "") {
  Swal.fire({ title: titulo, html: mensaje, icon: 'warning' });
}

function correcto(mensaje) {
  Swal.fire({ title: 'Exito!', html: mensaje, icon: 'success' });
}

function alerta_ancla(titulo, mensaje, icono) {
  Swal.fire({
    icon: icono,
    title: titulo,
    html: mensaje,
  }).then((result) => {
    if (result.isConfirmed) {
      location.reload();
    }
  });
}

function modal_ver_imagen_registro(ruta, id) {
  document.getElementById('mostrar_imagenes_relamos').innerHTML = '';

  $.ajax({
    type: 'GET',
    url: `${url_app}imagenes_de_registros.php`,
    data: {
      id: id,
    },
    dataType: 'JSON',
    success: function (response) {
      if (response.error === false) {
        let imagenes = response.datos;

        imagenes.map((val) => {
          let separar_nombre_archivo = val.split('.');
          let extencion_archivo = separar_nombre_archivo[1];

          if (extencion_archivo != 'pdf') {
            document.getElementById(
              'mostrar_imagenes_relamos'
            ).innerHTML += `<img src="${ruta}/${val}" style="width: 100%; height: auto"> <br> <br>`;
          } else {
            document.getElementById(
              'mostrar_imagenes_relamos'
            ).innerHTML += `<iframe src="${ruta}/${val}" width=100% height=600></iframe>`;
          }
        });
      } else {
        error(response.mensaje);
      }
    },
  });

  $('#modalVerImagenesRegistro').modal('show');
}

function mostrarLoader(opcion = 'M') {
  $loader =
    opcion == 'M'
      ? Swal.fire({
        title: 'Cargando...',
        allowEscapeKey: false,
        allowOutsideClick: false,
        didOpen: () => {
          swal.showLoading();
        },
      })
      : $loader.close();
}

function correcto_pasajero(mensaje) {
  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer);
      toast.addEventListener('mouseleave', Swal.resumeTimer);
    },
  });

  Toast.fire({
    icon: 'success',
    title: mensaje,
  });
}

function ocultar_todo_contenido() {
  $('.contenido_funcionario').css({ display: 'none' });
  $('#acciones_socios_nivel_3').css('display', 'none');
  $('.contenido').css({ display: 'none' });
  $('#historiaComunicacionDeCedulaDiv').css('display', 'none');
  $('#historiaComunicacionDeCedulaDiv_funcionarios').css('display', 'none');
  $('#b1').text('Coordinación');
  $('#b1').attr('disabled', false);
  $('#b2').text('Cobranza');
  $('#b2').attr('disabled', false);

  //noEsSocioRegistro
  $('#cedulasNSR').val('');
  $('#nombreNSR').val(null);
  $('#telefonoNSR').val(null);
  $('#observacionesNSR').val('');
  $('#avisarNSR').prop('selectedIndex', 0);
  $('#noEsSocioRegistro').css({ display: 'none' });

  //noEsSocio
  $('#cedulasNS').val('');
  $('#nombreNS').val(null);
  $('#apellidoNS').val(null);
  $('#telefonoNS').val(null);
  $('#celularNS').val(null);
  $('#observacionesNS').val('');
  $('#avisarNS').prop('selectedIndex', 0);
  $('#noEsSocio').css({ display: 'none' });

  //siEsSocio
  $('#cedulas').val('');
  $('#obser').val('');
  $('#ensec').prop('selectedIndex', 0);
  $('#siEsSocio').css({ display: 'none' });

  historiaComunicacionDeCedula();
  $(".patologias_socio").css("display", "none");

  $('#obser').val('');
  $('#observacionesNSR').val('');
}

function fecha_hora_actual() {
  let fecha = new Date();
  let hora = fecha.getHours();
  let minutos = fecha.getMinutes();
  fecha = fecha.toJSON().slice(0, 10);
  hora = String(hora).length == 1 ? `0${hora}` : hora;
  minutos = String(minutos).length == 1 ? `0${minutos}` : minutos;

  return `${fecha} ${hora}:${minutos}`;
}

function controlCedula(cedula) {
  if (cedula == "") {
    error("Debe ingresar una cédula");
  } else if (comprobarCI(cedula) === false) {
    error("Debe ingresar una cédula válida");
  } else {
    return true;
  }
}

function esNumero(cadena) {
  const regex_numeros = /^[0-9]*$/;
  return regex_numeros.test(cadena);
}