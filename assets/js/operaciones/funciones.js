const url_operaciones = `${url_app}/php/ajax/operaciones/`;



function desestimar_baja(openModal = false) {
    if (openModal == true) {
        $("#modal_desestimarBaja").modal("show");
    } else {
        let cedula = $("#txt_cedula").val();

        if (cedula == "") {
            error("Debe ingresar una cédula");
        } else if (controlCedula(cedula) == false) {
            error("Debe ingresar una cédula válida");
        } else {

            $.ajax({
                type: "POST",
                url: `${url_operaciones}desestimar_baja.php`,
                data: {
                    cedula
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        tabla_registros();
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    }
}




function select_areas(opcion, div, id_area, nombre_area) {

    let option = opcion == "Agregar" ? `<option value='' selected>Seleccione un área</option>` : `<option value='${id_area}' selected>${nombre_area}</option>`;
    let params = opcion == "Agregar" ? "" : `id_area=${id_area}`;

    document.getElementById(div).innerHTML = `${option}`;

    $.ajax({
        type: "GET",
        url: `${url_operaciones}select_areas.php?${params}`,
        dataType: "JSON",
        beforeSend: function () {
            loading(true);
        },
        complete: function () {
            loading(false);
        },
        success: function (response) {
            let datos = response.datos;
            datos.map((val) => {
                document.getElementById(div).innerHTML += `<option value="${val['id']}">${val['usuario']}</option>`;
            });
        }
    });

}



function select_items() {
    let div = document.getElementById("select_item_am");
    div.innerHTML = '<option selected value="">Seleccione una opción</option>';

    $.ajax({
        url: `${url_operaciones}select_items.php`,
        dataType: 'JSON',
        beforeSend: function () {
            loading(true);
        },
        complete: function () {
            loading(false);
        },
        success: function (r) {
            $.each(r.datos, function (i, v) {
                div.innerHTML += `<option value="${v.id}">${v.nombre}</option>`;
            });
        },
    });
}