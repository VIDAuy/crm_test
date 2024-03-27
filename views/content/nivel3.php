<script>
	$(function() {
		$('#ci').keypress(function(e) {
			if (e.which == 13) {
				buscarDatos(false);
			}
		});
	})
</script>
<input type="hidden" id="sector" value="<?= ucfirst($_SESSION['usuario']) ?>">
<input type="hidden" id="nivel" value="<?= $_SESSION['nivel'] ?>">
<input type="hidden" id="idrelacion">

<?php
$areas_nivel_3 = $_SESSION["usuario"] == 'Rrhh_coord' || $_SESSION['usuario'] == 'Morosos' || $_SESSION['usuario'] == 'Calidad_interna';

?>

<div class="d-flex justify-content-center">
	<div class="container mt-5 mb-3">
		<div class="row">
			<div class="col-lg-6">
				<div class="col-auto">
					<div class="input-group mb-3">
						<span class="input-group-text" id="basic-addon1">Cédula:</span>
						<?php
						if ($areas_nivel_3) {
							echo '<input type="text" class="form-control" id="ci" name="ci" placeholder="Ingrese cédula a buscar ..." aria-label="Ingrese cédula a buscar ..." aria-describedby="basic-addon1" oninput="ocultarContenido()" maxlength="8">

							<button class="btn btn-danger input-group-text" id="buscarCI" onclick="buscarDatos(true);">Buscar 🔍</button>';
						} else {
							echo '<input type="text" class="form-control solo_numeros" id="ci" name="ci" placeholder="Ingrese cédula a buscar ..." aria-label="Ingrese cédula a buscar ..." aria-describedby="basic-addon1" oninput="ocultarContenido()" maxlength="8">

							<button class="btn btn-danger input-group-text" id="buscarCI" onclick="buscarDatos(false);">Buscar 🔍</button>';
						}
						?>
					</div>
				</div>
			</div>
			<?php
			if ($areas_nivel_3) {
				echo '<div class="col-lg-3"><div class="form-check">
					<input class="form-check-input" type="radio" name="radioBuscar" id="rbtBuscarSocio" value="socio" checked>
					<label class="form-check-label" for="rbtBuscarSocio">
						Socio
					</label>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="form-check">
					<input class="form-check-input" type="radio" name="radioBuscar" id="rbtBuscarFuncionario" value="funcionario">
					<label class="form-check-label" for="rbtBuscarFuncionario">
						Funcionario
					</label>
				</div>
			</div>';
			}
			?>
		</div>
	</div>
</div>
<div class="container">
	<span style="float: right">
		<?php
		if ($_SESSION['usuario'] == 'Calidad' || $_SESSION['usuario'] == 'Bajas')
			echo '<input type="button" class="btn btn-success" value="Gestionar bajas" onclick="corroborarBajas();">';
		?>
	</span>

	<input type="button" class="btn btn-danger" value="Solicitar la baja" onclick="listarDatos($('#ci').val());">
</div>


<br>