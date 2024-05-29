function busqueda_avanzada(openModal = false) {
    if (openModal == true) {
        $("#div_contenedor_busqueda_avanzada").css("display", "none");
        $("#txt_cedula_busqueda_avanzada").val('');
        $("#txt_numero_referencia_mercadopago_busqueda_avanzada").val('');
        $("#contenedor_datos").html('');
        $("#div_btn_buscar_busqueda_avanzada").html(`<button class="btn btn-danger" id="btn_buscar_busqueda_avanzada" onclick="busqueda_avanzada(false)">🔍</button>`);
        $("#modal_busquedaAvanzada").modal("show");
    } else {

        let cedula = $("#txt_cedula_busqueda_avanzada").val();
        let id_pago = $("#txt_numero_referencia_mercadopago_busqueda_avanzada").val();


        if (cedula == "" && id_pago == "") {
            error("Debe completar la cédula o el número de referencia");
        } else if (cedula != "" && id_pago != "") {
            error("La busqueda debe ser solo por cédula o por número de referencia");
        } else if (!comprobarCI(cedula) && cedula != "") {
            error("Cédula incorrecta o mal formada");
        } else {

            $.ajax({
                type: "POST",
                url: `http://192.168.1.250:82/ene3/ajax/buscarSocio.php`,
                data: {
                    cedula: cedula,
                    id_pago: id_pago,
                },
                dataType: "JSON",
                beforeSend: function () {
                    $("#div_contenedor_busqueda_avanzada").css("display", "none");
                    btn_cargando("div_btn_buscar_busqueda_avanzada", "primary");
                    $("#contenedor_datos").html('');
                },
                complete: function () {
                    $("#div_btn_buscar_busqueda_avanzada").html(`<button class="btn btn-danger" id="btn_buscar_busqueda_avanzada" onclick="busqueda_avanzada(false)">🔍</button>`);
                },
                success: function (response) {
                    if (response.error === false) {
                        $("#nav_contenedor_datos-tab").click();
                        $("#div_contenedor_busqueda_avanzada").css("display", "block");
                        $("#contenedor_datos").append(response.datos);
                        tabla_datos_socio_busqueda_avanzada(cedula);
                        tabla_datos_producto_busqueda_avanzada(cedula);
                    } else {
                        error(response.mensaje);
                    }
                }
            });

        }
    }
}


function tabla_datos_socio_busqueda_avanzada(cedula) {
    $("#tabla_datos_socio_busqueda_avanzada tbody").html("");

    $.ajax({
        type: "GET",
        url: `http://192.168.1.250:82/ene3/generarJSON.php?ced=${cedula}`,
        dataType: "JSON",
        success: function (response) {

            if (response.length > 0) {
                $.each(response, function (i, socio) {
                    let newRow = `
                    <tr>
                        <td>${socio.nombre}</td>
                        <td>${socio.tel}</td>
                        <td>${socio.cedula}</td>
                        <td>${socio.direccion}</td>
                        <td>${socio.sucursal}</td>
                        <td>${socio.ruta}</td>
                        <td>${socio.radio}</td>
                        <td>${socio.fecha_nacimiento}</td>
                        <td>${socio.tarjeta}</td>
                        <td>${socio.tipo_tarjeta}</td>
                        <td>${socio.numero_tarjeta}</td>
                        <td>${socio.nombre_titular}</td>
                        <td>${socio.cedula_titular}</td>
                        <td>${socio.telefono_titular}</td>
                        <td>${socio.observaciones}</td>
                        <td>${socio.origen_venta}</td>
                        <td>${socio.total_importe}</td>
                    </tr>`;
                    $(newRow).appendTo("#tabla_datos_socio_busqueda_avanzada tbody");
                });
            } else {
                let newRow = `
                    <tr>
                        <td class="text-center" colspan="17">Ningún dato disponible en esta tabla</td>
                    </tr>`;
                $(newRow).appendTo("#tabla_datos_socio_busqueda_avanzada tbody");
            }

        }
    });
}


function tabla_datos_producto_busqueda_avanzada(cedula) {
    $("#tabla_datos_producto_busqueda_avanzada tbody").html("");
    let fechaemi = "";

    $.ajax({
        type: "GET",
        url: `http://192.168.1.250:82/ene3/generarJSON2.php?ced=${cedula}&fechaemi=${fechaemi}`,
        dataType: "JSON",
        success: function (response) {

            if (response.length > 0) {
                $.each(response, function (i, producto) {
                    let newRow = `
                <tr>
                    <td>${producto.cedula}</td>
                    <td>${producto.servicio}</td>
                    <td>${producto.hora}</td>
                    <td>${producto.importe}</td>
                    <td>${producto.cod_promo}</td>
                    <td>${producto.fecha_afiliacion}</td>
                    <td>${producto.observaciones}</td>
                    <td>${producto.movimiento}</td>
                    <td>${producto.numero_vendedor}</td>
                    <td>${producto.keepprice1}</td>
                    <td>${producto.empresa}</td>
                    <td>${producto.count}</td>
                    <td>${producto.abm}</td>
                </tr>`;
                    $(newRow).appendTo("#tabla_datos_producto_busqueda_avanzada tbody");
                });
            } else {
                let newRow = `
                <tr>
                    <td class="text-center" colspan="17">Ningún dato disponible en esta tabla</td>
                </tr>`;
                $(newRow).appendTo("#tabla_datos_producto_busqueda_avanzada tbody");
            }

        }
    });
}