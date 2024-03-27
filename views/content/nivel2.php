<input type="hidden" id="sector" value="<?= ucfirst($_SESSION['usuario']) ?>">
<input type="hidden" id="nivel" value="<?= $_SESSION['nivel'] ?>">
<input type="hidden" id="idrelacion">



<div class="container">

	<br>

	<div class="row">
		<div class="col-lg-6">
			<div class="col-auto">
				<div class="input-group mb-3">
					<span class="input-group-text" id="basic-addon1">Cédula:</span>

					<input type="text" class="form-control solo_numeros" id="ci" name="ci" placeholder="Ingrese cédula a buscar ..." aria-label="Ingrese cédula a buscar ..." aria-describedby="basic-addon1" oninput="ocultarContenido()" maxlength="8">

					<button class="btn btn-danger input-group-text" id="buscarCI" onclick="buscarDatos(false)">Buscar 🔍</button>
				</div>
			</div>
		</div>
	</div>

	<br>

</div>