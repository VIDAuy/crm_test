$(document).ready(function () {

    contenedor_consultar_cedula();

});


function contenedor_consultar_cedula() {
    $("#contenedor_consultar_cedulas").html("");

    $.ajax({
        type: "GET",
        url: `${url_ajax}obtener_permisos.php`,
        data: {
            opcion: 1
        },
        dataType: "JSON",
        beforeSend: function () {
            cargando("M", "Cargando...");
        },
        complete: function () {
            cargando("O");
        },
        success: function (response) {
            if (response.error === false) {
                let html = response.html;
                $("#contenedor_consultar_cedulas").html(html);
                detectar_cambio_radio_buttons();
            } else {
                error(response.mensaje);
            }
        }
    });
}