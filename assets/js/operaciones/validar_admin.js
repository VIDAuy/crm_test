$(document).ready(function () {

    modo_operacion(modo_desarrollador);

});


function validar_adminstrador(openModal = false) {
    if (openModal === true) {
        $("#contenido_pagina").css("display", "none");
        $("#txt_password_admin").val('');
        mostrar_password(false);
        $('#modal_validarAdmin').modal("show");

        $('#txt_password_admin').keypress(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') validar_adminstrador(false);
        });
    } else {

        let password = $('#txt_password_admin').val();

        if (password == "") {
            error("Debe ingresar la contraseña");
        } else {

            $.ajax({
                type: "POST",
                url: `${url_operaciones}validar_admin.php`,
                data: {
                    password
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto_pasajero(response.mensaje);
                        mostrar_contenido("gestionar_items_menu", tabla_items_menu());
                        $("#contenido_pagina").css("display", "block");
                        $("#txt_password_admin").val('');
                        $('#modal_validarAdmin').modal("hide");
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    }
}


function mostrar_password(mostrar = false) {
    if (mostrar == false) {
        $('#txt_password_admin').get(0).type = 'password';
        $("#div_btn_mostrar_password").html(`<button type="button" class="btn btn-danger" onclick="mostrar_password(true)">Mostrar Contraseña</button>`);
    } else {
        $('#txt_password_admin').get(0).type = 'text';
        $("#div_btn_mostrar_password").html(`<button type="button" class="btn btn-success" onclick="mostrar_password(false)">Ocultar Contraseña</button>`);
    }
}