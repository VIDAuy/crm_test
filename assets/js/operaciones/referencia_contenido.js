function tabla_referencia_contenido(openModal = false) {
    $("#tabla_referencia_contenido").DataTable({
        ajax: `${url_operaciones}referencia_contenido/tabla_referencia_contenido.php`,
        columns: [
            { data: "id" },
            { data: "nombre" },
            { data: "acciones" },
        ],
        bDestroy: true,
        order: [[0, "asc"]],
        language: { url: url_lenguage },
    });
}


function agregar_referencia_contenido(openModal = false) {
    if (openModal == true) {
        $("#txt_nombre_agregar_referencia_contenido").val('');
        $("#modal_agregarReferenciaContenido").modal("show");
    } else {
        let nombre = $("#txt_nombre_agregar_referencia_contenido").val();

        if (nombre == "") {
            error("Debe ingresar un nombre");
        } else {

            $.ajax({
                type: "POST",
                url: `${url_operaciones}referencia_contenido/agregar_referencia_contenido.php`,
                data: {
                    nombre
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error == false) {
                        correcto(response.mensaje);
                        $("#txt_nombre_agregar_referencia_contenido").val('');
                        tabla_referencia_contenido();
                        $("#modal_agregarReferenciaContenido").modal("hide");
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    }
}

function dar_baja_referencia_contenido(id) {
    Swal.fire({
        title: "Estas seguro?",
        text: `Vas a eliminar el item #${id}!`,
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
                url: `${url_operaciones}referencia_contenido/eliminar_referencia_contenido.php`,
                data: {
                    id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        tabla_referencia_contenido();
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    });
}