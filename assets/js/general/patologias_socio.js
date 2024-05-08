$(document).ready(function () {

    $('#select_patologia_socio').select2({
        dropdownParent: $('#modalAgregarPatologiaSocio')
    });

    $(".patologias_socio").css("display", "none");

});



function tabla_patologias_socio() {
    let cedula = $("#ci").val();

    $("#tabla_patologias_socio").DataTable({
        ajax: `${url_ajax}patologias_socio/tabla_patologias_socio.php?cedula=${cedula}`,
        columns: [
            { data: "id" },
            { data: "patologia" },
            { data: "observacion" },
            { data: "fecha" },
        ],
        order: [[0, "asc"]],
        bDestroy: true,
        language: { url: url_lenguage },
    });


    $(".patologias_socio").css("display", "block");
}


function mostrar_agregar_patologia_socio() {
    $("#btn_agregar_patologia_socio").css("display", "block");
}


function agregar_patologia_socio(openModal = false) {

    if (openModal == true) {
        select_patologias_socio();
        $("#select_patologia_socio").val('');
        $("#txt_observacion_patologia_socio").val('');

        $("#modalAgregarPatologiaSocio").modal("show");
    } else {
        let cedula = $("#ci").val();
        let patologia = $("#select_patologia_socio").val();
        let observacion = $("#txt_observacion_patologia_socio").val();
        let id_sub_usuario = localStorage.getItem("id_sub_usuario");
        let sector = localStorage.getItem("sector");

        let nombre_socio =
            $("#nombreNSR").text() != "" ? $("#nombreNSR").text() :
                $("#nombreNS").text() != "" ? $("#nombreNS").text() :
                    $("#nom").text() != "" ? $("#nom").text() : "";

        let telefono_socio =
            $("#telefonoNSR").text() != "" ? $("#telefonoNSR").text() :
                $("#telefonoNS").text() != "" ? $("#telefonoNS").text() :
                    $("#telefono").text() != "" ? $("#telefono").text() : "";


        if (patologia == "") {
            error("Debe seleccionar una patología");
        } else if (observacion == "") {
            error("Debe ingresar una observación");
        } else {

            $.ajax({
                type: "POST",
                url: `${url_ajax}patologias_socio/agregar_patologia_socio.php`,
                data: {
                    cedula,
                    patologia,
                    observacion,
                    id_sub_usuario,
                    sector,
                    nombre_socio,
                    telefono_socio
                },
                dataType: "JSON",
                beforeSend: function () {
                    mostrarLoader();
                },
                complete: function () {
                    mostrarLoader("O");
                },
                success: function (response) {
                    if (response.error === false) {
                        correcto(response.mensaje);
                        $("#select_patologia_socio").val('');
                        $("#txt_observacion_patologia_socio").val('');

                        tabla_patologias_socio();
                        historiaComunicacionDeCedula();
                        $("#modalAgregarPatologiaSocio").modal("hide");
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    }

}

function select_patologias_socio() {

    let cedula = $("#ci").val();
    document.getElementById("select_patologia_socio").innerHTML = '<option value="" selected>Seleccione una patología:</option>';

    $.ajax({
        type: "GET",
        url: `${url_ajax}patologias_socio/select_patologia_socio.php?cedula=${cedula}`,
        dataType: "JSON",
        beforeSend: function () {
            mostrarLoader();
        },
        complete: function () {
            mostrarLoader("O");
        },
        success: function (response) {
            let datos = response.datos;
            datos.map((val) => {
                document.getElementById("select_patologia_socio").innerHTML += `<option value="${val['id']}">${val['nombre']}</option>`;
            });
        }
    });

}