function ejecutar_tabla_patologias_socio(formatiarInputsFecha = false) {
    let fecha = new Date();
    let fecha_actual = fecha.toJSON().slice(0, 10);

    if (formatiarInputsFecha == true) {
        $("#txt_fecha_desde_ps").val(`${fecha_actual}`);
        $("#txt_fecha_hasta_ps").val(`${fecha_actual}`);
        $("#txt_filtro_cedula_ps").val('');
    }


    let cedula = $("#txt_filtro_cedula_ps").val();
    if (cedula == "") {
        let fecha_desde = $("#txt_fecha_desde_ps").val();
        let fecha_hasta = $("#txt_fecha_hasta_ps").val();

        if (fecha_desde == "") {
            error("Debe ingresar una fecha desde");
        } else if (fecha_hasta == "") {
            error("Debe ingresar una fecha hasta");
        } else if (fecha_desde > fecha_actual) {
            error("La fecha desde no puede ser mayor a la fecha actual");
        } else if (fecha_hasta > fecha_actual) {
            error("La fecha hasta no puede ser mayor a la fecha actual");
        } else if (fecha_desde > fecha_hasta) {
            error("La fecha desde debe ser menor a la fecha hasta");
        } else {
            tabla_patologias_socio(fecha_desde, fecha_hasta, null);
        }
    } else {

        let cedula = $("#txt_filtro_cedula_ps").val();

        if (cedula == "") {
            error("Ingrese una cédula para filtrar");
        } else {
            tabla_patologias_socio(null, null, cedula);
        }
    }
}


function tabla_patologias_socio(fecha_desde = null, fecha_hasta = null, cedula = null) {

    $("#tabla_patologias_socio").DataTable({
        ajax: `${url_operaciones}patologias_socio/tabla_patologias_socio.php?fecha_desde=${fecha_desde}&fecha_hasta=${fecha_hasta}&cedula=${cedula}`,
        columns: [
            { data: "id" },
            { data: "cedula" },
            { data: "patologia" },
            { data: "observacion" },
            { data: "fecha_registro" },
            { data: "acciones" },
        ],
        bDestroy: true,
        order: [[0, "desc"]],
        language: { url: url_lenguage },
    });
}


function eliminar_patologia_socio(id) {
    Swal.fire({
        title: "Estas seguro?",
        text: `Vas a eliminar el registro #${id}!`,
        icon: "warning",
        reverseButtons: true,
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        cancelButtonColor: "#DC3545",
        confirmButtonText: "Si, eliminar!",
        confirmButtonColor: "#198754",
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                type: "POST",
                url: `${url_operaciones}patologias_socio/eliminar_patologias_socio.php`,
                data: {
                    id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        ejecutar_tabla_patologias_socio(true);
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    });
}