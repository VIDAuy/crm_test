$(document).ready(function () {
    alertas_de_vida_te_lleva();
    setInterval(alertas_de_vida_te_lleva, 5000);

});



function alertas_de_vida_te_lleva() {
    let sector = $("#sector").val();

    if (["Calidad"].includes(sector)) {
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
}