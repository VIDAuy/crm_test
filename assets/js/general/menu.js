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
                items.map((item) => {
                    div.innerHTML += item;
                });
            } else {
                error(response.mensaje);
            }
        }
    });

}