<!-- Consultas Cierre De Horas Personalizado -->
<div id="container_cierre_de_horas_personalizado" style="display: none;">
    <div class="alert alert-secondary border-secondary" role="alert">
        <h3 class="text-center mb-5"><u>Cierre de horas personalizado</u></h3>
        <form id="form1" method="post" name="form1">
            <div class="d-flex justify-content-center mb-4">
                <div class="row">
                    <div class="form-group">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">Desde</span>
                                    <input type="date" class="form-control" id="desde" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">Hasta</span>
                                    <input type="date" class="form-control" id="hasta" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="enBruto" name="enBruto">
                    <label class="form-check-label" for="enBruto">
                        Obtener Reporte En Bruto
                    </label>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div class="row">
                    <div class="form-group">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto mb-3">
                                <button type="button" onclick="exportarMVD()" class="btn btn-info mr-4">VIDA/ACOMPAÑAR/INSPIRA</button>
                            </div>
                            <div class="col-auto mb-3">
                                <button type="button" onclick="exportarBR()" class="btn btn-info mr-4">BRASIL</button>
                            </div>
                            <div class="col-auto mb-3">
                                <button type="button" onclick="exportarCOMAP()" class="btn btn-info mr-4">COMAP</button>
                            </div>
                            <div class="col-auto mb-3">
                                <button type="button" onclick="exportarPY()" class="btn btn-info">PARAGUAY</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- End Consultas Cierre De Horas Personalizado -->