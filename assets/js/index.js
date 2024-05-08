function getAfiliacionesCompetencia() {
    $.ajax({
        url: 'PHP/AJAX/afiliaciones_competencia.php',
        dataType: 'json',
        success: (res) => {
            if (res.success) {
                $('#badgeAfiliacionesCompetencia').html(res.cantidad + "+");
            }
        }
    });
}