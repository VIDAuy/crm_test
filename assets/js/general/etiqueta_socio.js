$(document).ready(function () {

    mostrar_cantidad_etiquetas_socio();
    setInterval(mostrar_cantidad_etiquetas_socio, 60000);

});



function agregar_etiqueta_socio(openModal = false) {
    if (openModal == true) {
        $("#modal_AgregarEtiquetaSocio").modal("show");
    } else {

        let cedula = $("#ci").val();
        let etiqueta = $("#txt_etiqueta_socio").val();
        let id_sub_usuario = localStorage.getItem("id_sub_usuario");

        if (etiqueta == "") {
            error("El campo etiqueta esta vacío");
        } else {

            $.ajax({
                type: "POST",
                url: `${url_ajax}etiquetas_socio.php`,
                data: {
                    "opcion": 3,
                    "cedula": cedula,
                    "etiqueta": etiqueta,
                    "id_sub_usuario": id_sub_usuario
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        $("#txt_etiqueta_socio").val('');
                        mostrar_cantidad_etiquetas_socio();
                        $("#modal_AgregarEtiquetaSocio").modal("hide");
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    }
}

function ver_etiquetas_socio() {

    let cedula = $("#ci").val();

    $.ajax({
        type: "GET",
        url: `${url_ajax}etiquetas_socio.php`,
        data: {
            "opcion": 2,
            "cedula": cedula
        },
        dataType: "JSON",
        success: function (response) {
            if (response.error === false) {
                response.cantidad > 0 ? tabla_etiquetas(cedula) : error("El socio no tiene etiquetas registradas.");
            } else {
                error(response.mensaje);
            }
        }
    });

}

function tabla_etiquetas(cedula) {
    $("#tabla_etiquetas_socio").DataTable({
        ajax: `${url_ajax}etiquetas_socio.php?opcion=1&cedula=${cedula}`,
        columns: [
            { data: "id" },
            { data: "etiqueta" },
            { data: "usuario_agrego" },
            { data: "fecha_registro" },
        ],
        order: [[0, "asc"]],
        bDestroy: true,
        language: { url: url_lenguage },
    });

    $("#modal_verEtiquetasSocio").modal("show");
}

function mostrar_cantidad_etiquetas_socio() {
    document.getElementById("cantidad_etiquetas_socio").innerHTML = "0+";
    let cedula = $("#ci").val();

    $.ajax({
        type: "GET",
        url: `${url_ajax}etiquetas_socio.php`,
        data: {
            "opcion": 2,
            "cedula": cedula
        },
        dataType: "JSON",
        success: function (response) {
            if (response.error === false) {
                let cantidad = response.cantidad;
                document.getElementById("cantidad_etiquetas_socio").innerHTML = cantidad + "+";
            } else {
                error(response.mensaje);
            }
        }
    });
}