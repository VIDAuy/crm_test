$(document).on('change', '#file_uploader_equifax', function () {
    $("#btn_uploader_equifax").addClass("btn btn-success");
    $("#btn_uploader_equifax").html("Cargar archivo");
    const nombre_archivo = this.files[0].name;
    const tamaño_archivo = this.files[0].size;
    let extencion_archivo = nombre_archivo.split('.');
    extencion_archivo = extencion_archivo[extencion_archivo.length - 1];

    if (["xlsx", "xls", "csv"].includes(extencion_archivo) === false) {
        error("La extención del archivo solo puede ser <span class='text-danger fw-bolder'>xlsx</span>, <span class='text-danger fw-bolder'>xls</span> o <span class='text-danger fw-bolder'>csv</span>");
        $('#file_uploader_equifax').val("");
    }
});


function uploader_equifax(openModal = false) {
    if (openModal == true) {
        $("#file_uploader_equifax").val("");
        cambiar_div("btn_uploader_equifax", "btn btn-success", "Cargar archivo");
        $("#modal_uploaderEquifax").modal("show");
    } else {

        if ($("#file_uploader_equifax").val() === "") {
            error('Debe de seleccionar un archivo');
            cambiar_div("btn_uploader_equifax", "btn btn-success", "Cargar archivo");
        } else {
            const form_data = new FormData();
            const file_data = $("#file_uploader_equifax").prop("files")[0];
            form_data.append("file", file_data);

            $.ajax({
                type: "POST",
                url: `${url_ajax}equifax/uploader_equifax.php`,
                cache: false,
                processData: false,
                contentType: false,
                enctype: 'multipart/form-data',
                data: form_data,
                dataType: "JSON",
                beforeSend: function () {
                    cambiar_div("btn_uploader_equifax", "btn btn-info disabled", "Subiendo archivo ...");
                    cargando("M", "Aguarde por favor, este proceso puede tardar unos segundos.");
                },
                success: function (response) {
                    if (response.error === false) {
                        cargando("O");
                        correcto(response.mensaje);
                        $("#file_uploader_equifax").val("");
                        $("#modal_uploaderEquifax").modal("hide");
                    } else {
                        cargando("O");
                        error(response.mensaje);
                        cambiar_div("btn_uploader_equifax", "btn btn-danger", "Reintentar");
                    }
                }
            });

        }
    }
}


function registros_equifax(cedula = false) {

    let todos_los_meses = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    let mes_actual = fecha_actual("mes");
    let anio_actual = fecha_actual("anio");

    todos_los_meses.map((mes) => {
        let html = mes > mes_actual ? anio_actual - 1 : anio_actual;
        let div = $(`#span_anio_cuota_${mes}`);
        div.html("");
        div.html(`<span class="text-danger">(${html})</span>`);
    });

    tabla_registros_equifax(cedula);

    $("#modal_registrosEquifax").modal("show");
}


function tabla_registros_equifax(cedula) {

    cedula = cedula != false ? `?cedula=${cedula}` : "";

    $("#tabla_registros_equifax").DataTable({
        ajax: `${url_ajax}equifax/tabla_registros_equifax.php${cedula}`,
        columns: [
            { data: "id" },
            { data: "cedula" },
            { data: "bajas" },
            { data: "convenio" },
            { data: "enero" },
            { data: "febrero" },
            { data: "marzo" },
            { data: "abril" },
            { data: "mayo" },
            { data: "junio" },
            { data: "julio" },
            { data: "agosto" },
            { data: "septiembre" },
            { data: "octubre" },
            { data: "noviembre" },
            { data: "diciembre" },
            { data: "total_general" },
        ],
        order: [[0, "asc"]],
        bDestroy: true,
        language: { url: url_lenguage },
    });
}


function verificar_socio_equifax() {

    let cedula = $("#ci").val();
    $("#div_socio_equifax").html("");

    if (controlCedula(cedula) === true) {
        $.ajax({
            type: "GET",
            url: `${url_ajax}equifax/verificar_socio_en_clering.php?cedula=${cedula}`,
            dataType: "JSON",
            success: function (response) {
                if (response.error === false) {
                    $("#div_socio_equifax").html(`<button class='btn btn-info' onclick='registros_equifax(${cedula})'>Socio en Clering </button>`);
                } else if (response.error == 222) {
                    error(response.mensaje);
                }
            }
        });
    }

}