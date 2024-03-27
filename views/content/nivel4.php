<div class="container">

	<form id="buscarCI">
		<div class="row">
			<div class="col-10">
				<input type="text" id="CI" class="solo-numeros form-control" placeholder="Ingrese la cédula del empleado" maxlength="8" oninput="ocultarInformacion()">
			</div>
			<div class="col-2">
				<input type="button" id="enviarCI" class="btn btn-primary btn-block" value="Buscar CI">
			</div>
		</div>
	</form>

	<div id="informacion">
		<h3>Datos personales:</h3>
		<div class="row">
			<div class="col-4">
				<label for="nombreCompleto">Nombre completo:</label>
				<input type="text" id="nombreCompleto" class="form-control" readonly>
			</div>
			<div class="col-2">
				<label for="telefono">Teléfono:</label>
				<input type="text" id="telefono" class="form-control" readonly>
			</div>
			<div class="col-2">
				<label for="cedula">Cédula:</label>
				<input type="text" id="cedula" class="form-control" readonly>
			</div>
			<div class="col-2">
				<label for="fechaNacimiento">Fecha nacimiento:</label>
				<input type="text" id="fechaNacimiento" class="form-control" readonly>
			</div>
			<div class="col-2">
				<label for="departamento">Departamento:</label>
				<input type="text" id="departamento" class="form-control" readonly>
			</div>
		</div>
		<hr>
		<h3>Datos empleado:</h3>
		<div class="row">
			<div class="col-2">
				<label for="fechaIngreso">Fecha ingreso:</label>
				<input type="text" id="fechaIngreso" class="form-control" readonly>
			</div>
			<div class="col-2">
				<label for="fechaEgreso">Fecha egreso:</label>
				<input type="text" id="fechaEgreso" class="form-control" readonly>
			</div>
			<div class="col-2">
				<label for="estado">Estado actual:</label>
				<input type="text" id="estado" class="form-control" readonly>
			</div>
		</div>
		<hr>
		<h3>Datos servicio:</h3>
		<div class="row">
			<div class="col-2">
				<label for="estado">Estado:</label>
				<input type="text" class="form-control" id="estado" readonly>
			</div>
			<div class="col-2">
				<label for="ultimoServicio">Último servicio:</label>
				<input type="text" class="form-control" id="ultimoServicio" readonly>
			</div>
			<div class="col-2">
				<label for="proximoServicio">Proximo servicio:</label>
				<input type="text" class="form-control" id="proximoServicio" readonly>
			</div>
			<div class="col-2">
				<label for="desde">Desde:</label>
				<input type="text" class="form-control" id="desde" readonly>
			</div>
			<div class="col-2">
				<label for="hasta">Hasta:</label>
				<input type="text" class="form-control" id="hasta" readonly>
			</div>
		</div>
	</div>
</div>