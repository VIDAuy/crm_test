function tabla_sub_usuarios() {
    $("#tabla_sub_usuarios").DataTable({
        ajax: `${url_operaciones}sub_usuarios/tabla_sub_usuarios.php`,
        columns: [
            { data: "id" },
            { data: "area" },
            { data: "nombre" },
            { data: "apellido" },
            { data: "cedula" },
            { data: "gestor" },
            { data: "acciones" },
        ],
        bDestroy: true,
        order: [[0, "asc"]],
        language: { url: url_lenguage },
    });
}


function agregar_sub_usuario(openModal = false) {
    if (openModal == true) {
        $("#txt_area_agregar_sub_usuario_admin").val('');
        $("#txt_nombre_agregar_sub_usuario_admin").val('');
        $("#txt_apellido_agregar_sub_usuario_admin").val('');
        $("#txt_cedula_agregar_sub_usuario_admin").val('');
        $("#txt_gestor_agregar_sub_usuario_admin").val('');
        select_areas("Agregar", "txt_area_agregar_sub_usuario_admin", null, null);
        $("#modal_agregarSubUsuario").modal('show');
    } else {
        let id_area = $("#txt_area_agregar_sub_usuario_admin").val();
        let nombre = $("#txt_nombre_agregar_sub_usuario_admin").val();
        let apellido = $("#txt_apellido_agregar_sub_usuario_admin").val();
        let cedula = $("#txt_cedula_agregar_sub_usuario_admin").val();
        let gestor = $("#txt_gestor_agregar_sub_usuario_admin").val();

        if (id_area == "") {
            error("Seleccione un área");
        } else if (nombre == "") {
            error("Ingrese un nombre");
        } else if (apellido == "") {
            error("Ingrese un apellido");
        } else if (cedula == "") {
            error("Ingrese una cédula");
        } else if (comprobarCI(cedula) == false) {
            error("Ingrese una cédula válida");
        } else if (gestor == "") {
            error("Seleccione si es gestor o no");
        } else {

            $.ajax({
                type: "POST",
                url: `${url_operaciones}sub_usuarios/agregar_sub_usuario.php`,
                data: {
                    id_area,
                    nombre,
                    apellido,
                    cedula,
                    gestor
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        $("#txt_area_agregar_sub_usuario_admin").val('');
                        $("#txt_nombre_agregar_sub_usuario_admin").val('');
                        $("#txt_apellido_agregar_sub_usuario_admin").val('');
                        $("#txt_cedula_agregar_sub_usuario_admin").val('');
                        $("#txt_gestor_agregar_sub_usuario_admin").val('');
                        tabla_sub_usuarios(false);
                        $("#modal_agregarSubUsuario").modal('hide');
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    }
}

function editar_sub_usuario(openModal = false, id, id_area, nombre_area, nombre, apellido, cedula, gestor) {
    if (openModal == true) {
        $("#txt_id_editar_sub_usuario_admin").val(id);
        select_areas("Editar", "txt_area_editar_sub_usuario_admin", id_area, nombre_area);
        $("#txt_nombre_editar_sub_usuario_admin").val(nombre);
        $("#txt_apellido_editar_sub_usuario_admin").val(apellido);
        $("#txt_cedula_editar_sub_usuario_admin").val(cedula);
        $("#txt_gestor_editar_sub_usuario_admin").html(
            gestor == 0 ?
                '<option value="0">No</option><option value="1">Si</option>' :
                '<option value="1">Si</option><option value="0">No</option>');
        $("#modal_editarSubUsuarios").modal('show');
    } else {
        let id = $("#txt_id_editar_sub_usuario_admin").val();
        let id_area = $("#txt_area_editar_sub_usuario_admin").val();
        let nombre = $("#txt_nombre_editar_sub_usuario_admin").val();
        let apellido = $("#txt_apellido_editar_sub_usuario_admin").val();
        let cedula = $("#txt_cedula_editar_sub_usuario_admin").val();
        let gestor = $("#txt_gestor_editar_sub_usuario_admin").val();

        if (id == "") {
            error("El campo ID no puede estar vacío");
        } else if (id_area == "") {
            error("Debe seleccionar un área");
        } else if (nombre == "") {
            error("Debe ingresar un nombre");
        } else if (apellido == "") {
            error("Debe ingresar un apellido");
        } else if (cedula == "") {
            error("Debe ingresar un cedula");
        } else if (comprobarCI(cedula) == false) {
            error("Debe ingresar una cédula válida");
        } else if (gestor == "") {
            error("Seleccione si es gestor o no");
        } else {

            $.ajax({
                type: "POST",
                url: `${url_operaciones}sub_usuarios/editar_sub_usuario.php`,
                data: {
                    id,
                    id_area,
                    nombre,
                    apellido,
                    cedula,
                    gestor
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        $("#txt_id_editar_sub_usuario_admin").val('');
                        $("#txt_area_editar_sub_usuario_admin").val('');
                        $("#txt_nombre_editar_sub_usuario_admin").val('');
                        $("#txt_apellido_editar_sub_usuario_admin").val('');
                        $("#txt_cedula_editar_sub_usuario_admin").val('');
                        $("#txt_gestor_editar_sub_usuario_admin").val('');
                        tabla_sub_usuarios(false);
                        $("#modal_editarSubUsuarios").modal('hide');
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    }
}


function eliminar_sub_usuario(id) {
    Swal.fire({
        title: "Estas seguro?",
        text: `Vas a eliminar el sub usuario #${id}!`,
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
                url: `${url_operaciones}sub_usuarios/eliminar_sub_usuario.php`,
                data: {
                    id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        tabla_sub_usuarios(false);
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    });
}