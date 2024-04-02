const url_operaciones = 'http://192.168.1.250:82/' + app + '/php/ajax/operaciones/';



$(document).ready(function () {
    tabla_registros();
});

function tabla_registros() {

    $("#tabla_registros").DataTable({
        ajax: `${url_operaciones}tabla_registros.php`,
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
    Swal.fire({
        title: "Observación!",
        html: observacion,
        icon: "info"
    });
}

function confirmar_eliminar_registro(id) {
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
            eliminar_registro(id);
        }
    });
}

function eliminar_registro(id) {
    $.ajax({
        type: "POST",
        url: `${url_operaciones}eliminar_registro.php`,
        data: {
            id
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

function desestimar_baja() {
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