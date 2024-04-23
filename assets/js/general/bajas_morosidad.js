$(document).on('change', '#file_uploader_bajas_morosidad', function () {
    $("#btn_uploader_bajas_morosidad").addClass("btn btn-success");
    $("#btn_uploader_bajas_morosidad").html("Cargar archivo");
    const nombre_archivo = this.files[0].name;
    const tamaño_archivo = this.files[0].size;
    let extencion_archivo = nombre_archivo.split('.');
    extencion_archivo = extencion_archivo[extencion_archivo.length - 1];

    if (["xlsx", "xls", "csv"].includes(extencion_archivo) === false) {
        error("La extención del archivo solo puede ser <span class='text-danger fw-bolder'>xlsx</span>, <span class='text-danger fw-bolder'>xls</span> o <span class='text-danger fw-bolder'>csv</span>");
        $('#file_uploader_bajas_morosidad').val("");
    }
});


function uploader_bajas_morosidad(openModal = false) {
    if (openModal == true) {
        $("#file_uploader_bajas_morosidad").val("");
        cambiar_div("btn_uploader_bajas_morosidad", "btn btn-success", "Cargar archivo");
        $("#modal_uploaderBajasMorosidad").modal("show");
    } else {

        if ($("#file_uploader_bajas_morosidad").val() === "") {
            error('Debe de seleccionar un archivo');
            cambiar_div("btn_uploader_bajas_morosidad", "btn btn-success", "Cargar archivo");
        } else {
            const form_data = new FormData();
            const file_data = $("#file_uploader_bajas_morosidad").prop("files")[0];
            form_data.append("file", file_data);

            $.ajax({
                type: "POST",
                url: `${url_ajax}bajas_morosidad/uploader_bajas_morosidad.php`,
                cache: false,
                processData: false,
                contentType: false,
                enctype: 'multipart/form-data',
                data: form_data,
                dataType: "JSON",
                beforeSend: function () {
                    cambiar_div("btn_uploader_bajas_morosidad", "btn btn-info disabled", "Subiendo archivo ...");
                    cargando("M", "Aguarde por favor, este proceso puede tardar unos segundos.");
                },
                success: function (response) {
                    if (response.error === false) {
                        cargando("O");
                        correcto(response.mensaje);
                        $("#file_uploader_bajas_morosidad").val("");
                        $("#modal_uploaderBajasMorosidad").modal("hide");
                    } else {
                        cargando("O");
                        error(response.mensaje);
                        cambiar_div("btn_uploader_bajas_morosidad", "btn btn-danger", "Reintentar");
                    }
                }
            });

        }
    }
}


function registros_bajas_morosidad() {

    $("#tabla_registros_bajas_morosidad").DataTable({
        ajax: `${url_ajax}bajas_morosidad/tabla_registros_bajas_morosidad.php`,
        columns: [
            { data: "id" },
            { data: "cedula" },
        ],
        order: [[0, "asc"]],
        bDestroy: true,
        language: { url: url_lenguage },
    });

    $("#modal_registrosBajasMorosidad").modal("show");
}