<?php
$version = '?v=1.1.50';
const PRODUCCION = false;
$title = PRODUCCION ? "CRM" : "CRM_TEST";
$title_html = PRODUCCION ? "<span class='text-danger'> CRM </span>" : "<span class='text-success'> CRM TEST </span>";
?>



<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="icon" href="./assets/img/favicon.png" type="image/png">


	<!-- Styles CSS-->

	<!-- Bootstrap 4.1.3 -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
	<link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
	<!-- Font Awesome 4.5.0 -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<!-- Ionicons 2.0.1 -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Archivo CSS -->
	<link rel="stylesheet" href="./assets/css/hrstyle.css">
	<!-- Datatables 1.10.16 -->
	<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />
	<link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet" />
	<!-- Select2 4.1.0 -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">

	<link rel="stylesheet" href="./assets/css/estilos.css">

	<link rel="stylesheet" href="./assets/css/card_crmessage.css">

	<title><?php echo $title; ?></title>




	<!-- Scripts JS -->

	<!-- JQUERY 2.2.3 -->
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	<!-- Popper 1.14.3 -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<!-- Bootstrap 4.1.3 -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>
	<!-- SweetAlert 2@10 -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<!-- Datatables 1.10.16 -->
	<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
	<!-- Select2 4.1.0 -->
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<!-- Tinymce -->
	<script src="./assets/lib/tinymce/tinymce.min.js" referrerpolicy="origin"></script>



	<?php
	$js_cargar = [
		"funciones.js",
		"general/menu.js",
		"permisos_usuario.js",
		"general/identificacion_usuario.js",
		"general/buscar_socio_o_funcionario.js",
		"color-modes.js",
	];

	foreach ($js_cargar as $archivo) {
		echo '<script src="./assets/js/' . $archivo . $version . '"></script>';
	}
	?>


</head>

<body>
	<?php include_once 'tema.php'; ?>

	<?php include_once 'menu.php'; ?>

	<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">






</html>