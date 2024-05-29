$(document).ready(function () {

  eliminar_local_storage();

});



function ejecutar_acciones_sesion(tiempo) {
  if (localStorage.getItem('status') == 'pendiente') cerrarSesion();

  (function ($) {
    var timeout;
    $(document).on('mousemove', function (event) {
      if (timeout !== undefined) window.clearTimeout(timeout);
      timeout = window.setTimeout(function () {
        let cedula = localStorage.getItem('cedula');
        if (cedula != null) $(event.target).trigger('mousemoveend');
      }, tiempo); //Determinas el tiempo en milisegundo aquí, 10 minutos en 600000 milisegundos
    });
  })(jQuery);
}


$(document).on('mousemoveend', function () {
  $('#txt_cedula_sesion_expirada').val('');
  $('#modal_sesionExpirada').modal({ backdrop: 'static', keyboard: false });
  $('#modal_sesionExpirada').modal('show');
  localStorage.setItem('status', 'pendiente');

  $('#txt_cedula_sesion_expirada').keypress(function (event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (keycode == '13') extender_sesion();
  });
});


let errores = 1;
function extender_sesion() {
  let cedula = $('#txt_cedula_sesion_expirada').val();
  let cedula_registrada = localStorage.getItem('cedula');
  localStorage.setItem('status', 'pendiente');

  if (cedula == '') {
    error('Debe ingresar su cédula');
    localStorage.setItem('status', 'pendiente');
  } else if (comprobarCI(cedula) === false) {
    error("Debe ingresar una cédula válida");
    localStorage.setItem('status', 'pendiente');
  } else {

    if (cedula != cedula_registrada) {
      if (errores == 1) error("La cédula ingresada no es correcta. <br> <span style='font-weight: bolder'> Tiene un máximo de 3 intentos para ingresar la cédula correcta, de lo contrario, se cerrará la sesión. </span>");
      if (errores == 2) error("¡Última oportunidad! <br> <span style='font-weight: bolder'> Si no ingresa su cédula correctamente se cerrará la sesión. </span>");
      if (errores >= 3) cerrarSesion();
      errores++;

    } else {
      errores = 1;
      correcto_pasajero('¡Su sesión se ha extendido!');
      $('#modal_sesionExpirada').modal('hide');
      localStorage.setItem('status', 'ok');
    }

  }
}


function eliminar_local_storage() {
  localStorage.clear();
  localStorage.setItem('status', 'ok');
}


function cerrarSesion() {
  localStorage.clear();
  localStorage.setItem('status', 'ok');
  location.href = `http://192.168.1.250:82/crm/cerrarSesion.php`;
}
