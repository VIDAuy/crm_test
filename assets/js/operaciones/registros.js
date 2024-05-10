function ejecutar_tabla_registros(formatiarInputsFecha = false) {
    let fecha = new Date();
    let fecha_actual = fecha.toJSON().slice(0, 10);

    if (formatiarInputsFecha == true) {
        $("#txt_fecha_desde_r").val(`${fecha_actual}`);
        $("#txt_fecha_hasta_r").val(`${fecha_actual}`);
        $("#txt_filtro_cedula_r").val('');
    }


    let cedula = $("#txt_filtro_cedula_r").val();
    if (cedula == "") {
        let fecha_desde = $("#txt_fecha_desde_r").val();
        let fecha_hasta = $("#txt_fecha_hasta_r").val();

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
            tabla_registros(fecha_desde, fecha_hasta);
        }
    } else {

        let cedula = $("#txt_filtro_cedula_r").val();

        if (cedula == "") {
            error("Ingrese una cédula para filtrar");
        } else if (comprobarCI(cedula) === false) {
            error("Debe ingresar una cédula válida");
        } else {
            tabla_registros(null, null, cedula);
        }
    }
}


function tabla_registros(fecha_desde = null, fecha_hasta = null, cedula = null) {

    $("#tabla_registros").DataTable({
        ajax: `${url_operaciones}registros/tabla_registros.php?fecha_desde=${fecha_desde}&fecha_hasta=${fecha_hasta}&cedula=${cedula}`,
        columns: [
            { data: "id" },
            { data: "cedula" },
            { data: "nombre" },
            { data: "telefono" },
            { data: "fecha_registro" },
            { data: "sector" },
            { data: "usuario" },
            { data: "socio" },
            { data: "baja" },
            { data: "observacion" },
            { data: "envio_sector" },
            { data: "acciones" },
        ],
        bDestroy: true,
        order: [[0, "desc"]],
        language: { url: url_lenguage },
    });
}


function abrirModalVerMas(observacion) {
    $("#todo_comentario_funcionarios").val("");
    $("#todo_comentario_funcionarios").val(observacion);

    $("#modalVerMasFuncionarios").modal("show");
}


function modal_ver_imagen_registro(ruta, imagenes) {
    let imagen = imagenes.split(', ');
    let div = document.getElementById('mostrar_imagenes_relamos');
    div.innerHTML = "";

    imagen.map((val) => {
        let separar_nombre_archivo = val.split('.');
        let extencion_archivo = separar_nombre_archivo[1];
        div.innerHTML +=
            extencion_archivo != 'pdf' ?
                `<img src="${ruta}/${val}" class="mb-3" style="width: 100%; height: auto">` :
                `<iframe src="${ruta}/${val}" class="mb-3" width=100% height=600></iframe>`;
    });

    $("#modalVerImagenesRegistro").modal("show");
}


function eliminar_registro(id) {
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
                url: `${url_operaciones}registros/eliminar_registro.php`,
                data: {
                    id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        ejecutar_tabla_registros(true);
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    });
}