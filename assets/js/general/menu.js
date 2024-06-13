$(document).ready(function () {

    mostrar_menu();

});


function mostrar_menu() {

    let div = document.getElementById("div_items_menu");
    div.innerHTML = "";

    $.ajax({
        type: "GET",
        url: `${url_ajax}menu.php`,
        data: "data",
        dataType: "JSON",
        beforeSend: function () {
            mostrarLoader();
        },
        complete: function () {
            mostrarLoader("O");
        },
        success: function (response) {
            if (response.error === false) {
                let items = response.items_menu;
                items.map((item) => {
                    div.innerHTML += item;
                });

                let id_items = response.id_items;
                id_items.map((val) => {
                    if (val == 1) {
                        getAfiliacionesCompetencia();
                        setInterval(getAfiliacionesCompetencia, 30000);
                    }
                    if (val == 2) {
                        alertas_de_vida_te_lleva();
                        setInterval(alertas_de_vida_te_lleva, 30000);
                    }
                    if (val == 3) {
                        cantidad_alertas();
                        setInterval(cantidad_alertas, 30000);
                        badge_cantidad_alertas_pendientes();
                        setInterval(badge_cantidad_alertas_pendientes, 30000);
                    }
                    if (val == 4) {
                        cantidad_volver_a_llamar();
                        setInterval(cantidad_volver_a_llamar, 30000);
                    }
                    if (val == 13) {
                        cantidad_consultas_no_leidas();
                        setInterval(cantidad_consultas_no_leidas, 30000);
                    }
                    if (val == 20) {
                        obtener_alertas_generales();
                        setInterval(obtener_alertas_generales, 30000);
                    }
                });

            } else {
                error(response.mensaje);
            }
        }
    });
}


function mostrar_menu_por_usuarios() {

    let div = document.getElementById("div_items_menu");

    $.ajax({
        type: "GET",
        url: `${url_ajax}menu_por_usuario.php`,
        data: "data",
        dataType: "JSON",
        beforeSend: function () {
            mostrarLoader();
        },
        complete: function () {
            mostrarLoader("O");
        },
        success: function (response) {
            if (response.error === false) {
                let items = response.items_menu;
                let estatus = response.estatus;

                if (estatus == 222) {
                    items.map((item) => {
                        div.innerHTML += item;
                    });
                }
            } else {
                error(response.mensaje);
            }
        }
    });

}