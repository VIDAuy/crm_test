function tabla_menu() {
    $("#tabla_menu").DataTable({
        ajax: `${url_operaciones}menu/tabla_menu.php`,
        columns: [
            { data: "id" },
            { data: "area" },
            { data: "item" },
            { data: "acciones" },
        ],
        bDestroy: true,
        order: [[0, "asc"]],
        language: { url: url_lenguage },
    });
}


function agregar_menu(openModal = false) {
    if (openModal == true) {
        $("#select_area_am").val('');
        $("#select_item_am").val('');
        select_areas("Agregar", "select_area_am", null, null);
        select_items("select_item_am");
        $("#modal_agregarMenu").modal('show');
    } else {
        let select_area = $("#select_area_am").val();
        let select_item = $("#select_item_am").val();

        if (select_area == "") {
            error("Debe seleccionar un área");
        } else if (select_item == "") {
            error("Debe seleccionar un item");
        } else {

            $.ajax({
                type: "POST",
                url: `${url_operaciones}menu/agregar_menu.php`,
                data: {
                    select_area,
                    select_item
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        $("#select_area_am").val('');
                        $("#select_item_am").val('');
                        tabla_menu(false);
                        $("#modal_agregarMenu").modal('hide');
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    }
}


function eliminar_menu(id) {
    Swal.fire({
        title: "Estas seguro?",
        text: `Vas a eliminar el menú #${id}!`,
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
                url: `${url_operaciones}menu/eliminar_menu.php`,
                data: {
                    id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        tabla_menu(false);
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    });
}