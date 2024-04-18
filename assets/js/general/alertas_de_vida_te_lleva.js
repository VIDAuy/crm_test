function alertas_de_vida_te_lleva() {
    $.ajax({
        type: "GET",
        url: `${url_ajax}contar_pendientes_vida_te_lleva.php`,
        dataType: "JSON",
        success: function (response) {
            if (response.error === false) {
                document.getElementById("cantidad_pendientes_vida_te_lleva").innerHTML = response.cantidad + "+";
            }
        },
    });
}