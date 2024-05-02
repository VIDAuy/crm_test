/** Cierre De Horas Personalizado Vida/Acompañar/Inspira **/
function exportarMVD() {
    let fecha_desde = $('#desde').val();
    let fecha_hasta = $('#hasta').val();

    if (fecha_desde == '') {
        alerta("Debe ingresar una fecha desde");
    } else if (fecha_hasta == '') {
        alerta("Debe ingresar una fecha hasta");
    } else if (fecha_desde > fecha_hasta) {
        error("La fecha desde tiene que ser menor a la fecha hasta");
    } else {

        $('#form1').attr('action', `${url_ajax}cierre_de_horas_personalizado/procesoMVD.php`);
        $('#form1').submit();

    }
}
/** End Cierre De Horas Personalizado Vida/Acompañar/Inspira **/


/** Cierre De Horas Personalizado Brasil **/
function exportarBR() {
    let fecha_desde = $('#desde').val();
    let fecha_hasta = $('#hasta').val();

    if (fecha_desde == '') {
        alerta("Debe ingresar una fecha desde");
    } else if (fecha_hasta == '') {
        alerta("Debe ingresar una fecha hasta");
    } else if (fecha_desde > fecha_hasta) {
        error("La fecha desde tiene que ser menor a la fecha hasta");
    } else {

        $('#form1').attr('action', `${url_ajax}cierre_de_horas_personalizado/procesoBR.php`);
        $('#form1').submit();

    }
}
/** End Cierre De Horas Personalizado Brasil **/


/** Cierre De Horas Personalizado Comap **/
function exportarCOMAP() {
    let fecha_desde = $('#desde').val();
    let fecha_hasta = $('#hasta').val();

    if (fecha_desde == '') {
        alerta("Debe ingresar una fecha desde");
    } else if (fecha_hasta == '') {
        alerta("Debe ingresar una fecha hasta");
    } else if (fecha_desde > fecha_hasta) {
        error("La fecha desde tiene que ser menor a la fecha hasta");
    } else {

        $('#form1').attr('action', `${url_ajax}cierre_de_horas_personalizado/procesoCOMAG.php`);
        $('#form1').submit();

    }
}
/** End Cierre De Horas Personalizado Comap **/


/** Cierre De Horas Personalizado Paraguay **/
function exportarPY() {
    let fecha_desde = $('#desde').val();
    let fecha_hasta = $('#hasta').val();

    if (fecha_desde == '') {
        alerta("Debe ingresar una fecha desde");
    } else if (fecha_hasta == '') {
        alerta("Debe ingresar una fecha hasta");
    } else if (fecha_desde > fecha_hasta) {
        error("La fecha desde tiene que ser menor a la fecha hasta");
    } else {

        $('#form1').attr('action', `${url_ajax}cierre_de_horas_personalizado/procesoPY.php`);
        $('#form1').submit();

    }
}
/** End Cierre De Horas Personalizado Paraguay **/