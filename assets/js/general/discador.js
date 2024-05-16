$(document).on('change', '#file_uploader_discador', function () {
    $("#btn_uploader_discador").addClass("btn btn-success");
    $("#btn_uploader_discador").html("Cargar archivo");
    const nombre_archivo = this.files[0].name;
    const tamaño_archivo = this.files[0].size;
    let extencion_archivo = nombre_archivo.split('.');
    extencion_archivo = extencion_archivo[extencion_archivo.length - 1];

    if (["xlsx", "xls", "csv"].includes(extencion_archivo) === false) {
        error("La extención del archivo solo puede ser <span class='text-danger fw-bolder'>xlsx</span>, <span class='text-danger fw-bolder'>xls</span> o <span class='text-danger fw-bolder'>csv</span>");
        $('#file_uploader_discador').val("");
    }
});


function uploader_discador(openModal = false) {
    if (openModal == true) {
        $("#file_uploader_discador").val("");
        $("#select_uploader_discador").val("");
        cambiar_div("btn_uploader_discador", "btn btn-success", "Cargar archivo");
        $("#modal_uploaderDiscador").modal("show");
    } else {

        let select_discador = $("#select_uploader_discador").val();

        if (select_discador == "") {
            error("Debe seleccionar un tipo de discador");
        } else if ($("#file_uploader_discador").val() === "") {
            error('Debe seleccionar un archivo');
            cambiar_div("btn_uploader_discador", "btn btn-success", "Cargar archivo");
        } else {
            const form_data = new FormData();
            const file_data = $("#file_uploader_discador").prop("files")[0];
            form_data.append("file", file_data);
            form_data.append("tipo_discador", select_discador);

            $.ajax({
                type: "POST",
                url: `${url_ajax}discador/uploader_discador.php`,
                cache: false,
                processData: false,
                contentType: false,
                enctype: 'multipart/form-data',
                data: form_data,
                dataType: "JSON",
                beforeSend: function () {
                    cambiar_div("btn_uploader_discador", "btn btn-info disabled", "Subiendo archivo ...");
                    cargando("M", "Aguarde por favor, este proceso puede tardar unos segundos.");
                },
                success: function (response) {
                    if (response.error === false) {
                        cargando("O");
                        correcto(response.mensaje);
                        $("#file_uploader_discador").val("");
                        $("#modal_uploaderDiscador").modal("hide");
                    } else {
                        cargando("O");
                        error(response.mensaje);
                        cambiar_div("btn_uploader_discador", "btn btn-danger", "Reintentar");
                    }
                }
            });

        }
    }
}


function verificar_envio_discador() {
    let cedula = $("#ci").val();
    $("#div_envio_discador").html("");

    if (controlCedula(cedula) === true) {
        $.ajax({
            type: "GET",
            url: `${url_ajax}discador/verificar_envio_discador.php?cedula=${cedula}`,
            dataType: "JSON",
            success: function (response) {
                if (response.error === false) {
                    $("#div_envio_discador").html(`<button class='btn btn-warning' onclick='registros_discador()'>Discadores Enviados</button>`);
                } else if (response.error == 222) {
                    error(response.mensaje);
                }
            }
        });
    }
}


function registros_discador() {
    let cedula = $("#ci").val();

    $(`#tabla_registros_discador`).DataTable({
        ajax: `${url_ajax}discador/tabla_registros_discador.php?cedula=${cedula}`,
        columns: [
            { data: "id" },
            { data: "tipo_discador" },
            { data: "telefono" },
            { data: "estado" },
            { data: "fecha_recibido" },
            { data: "description" },
        ],
        order: [[0, "asc"]],
        bDestroy: true,
        language: { url: url_lenguage },
    });


    $("#modal_registrosDiscador").modal("show");
}