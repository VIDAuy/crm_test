function tabla_usuarios() {
    $("#tabla_usuarios").DataTable({
        ajax: `${url_operaciones}usuarios/tabla_usuarios.php`,
        columns: [
            { data: "id" },
            { data: "usuario" },
            { data: "codigo" },
            { data: "nivel" },
            { data: "filial" },
            { data: "email" },
            { data: "acciones" },
        ],
        bDestroy: true,
        order: [[0, "asc"]],
        language: { url: url_lenguage },
    });
}


function agregar_usuario(openModal = false) {
    if (openModal == true) {
        $("#txt_usuario_agregar_usuario_admin").val('');
        $("#txt_codigo_agregar_usuario_admin").val('');
        $("#txt_nivel_agregar_usuario_admin").val('');
        $("#txt_filial_agregar_usuario_admin").val('');
        $("#txt_email_agregar_usuario_admin").val('');
        $("#modal_agregarUsuario").modal('show');
    } else {
        let usuario = $("#txt_usuario_agregar_usuario_admin").val();
        let codigo = $("#txt_codigo_agregar_usuario_admin").val();
        let nivel = $("#txt_nivel_agregar_usuario_admin").val();
        let filial = $("#txt_filial_agregar_usuario_admin").val();
        let email = $("#txt_email_agregar_usuario_admin").val();


        if (usuario == "") {
            error("Ingrese un usuario");
        } else if (codigo == "") {
            error("Ingrese un código");
        } else if (nivel == "") {
            error("Seleccione un nivel");
        } else {

            $.ajax({
                type: "POST",
                url: `${url_operaciones}usuarios/agregar_usuario.php`,
                data: {
                    usuario,
                    codigo,
                    nivel,
                    filial,
                    email
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        $("#txt_usuario_agregar_usuario_admin").val('');
                        $("#txt_codigo_agregar_usuario_admin").val('');
                        $("#txt_nivel_agregar_usuario_admin").val('');
                        $("#txt_filial_agregar_usuario_admin").val('');
                        $("#txt_email_agregar_usuario_admin").val('');
                        tabla_usuarios(false);
                        $("#modal_agregarUsuario").modal('hide');
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    }
}


function eliminar_usuario(id) {
    Swal.fire({
        title: "Estas seguro?",
        text: `Vas a eliminar el usuario #${id}!`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                type: "POST",
                url: `${url_operaciones}usuarios/eliminar_usuario.php`,
                data: {
                    id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        tabla_usuarios(false);
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    });
}