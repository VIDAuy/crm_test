<?php
$version = '?v=1.0.81';
session_start();
date_default_timezone_set('America/Montevideo');

//	DEPENDIENDO DE CON QUE USUARIO ESTÉ LOGUEADO LA PÁGINA QUE CARGA

if (isset($_SESSION['nivel'])) {

	include('views/header.php');

	$fecha = date("Y-m-d");
	include 'PHP/conexiones/conexion2.php';
	$id = $_SESSION['id'];
	switch ($_SESSION['nivel']) {
		case 1:

			$array_cargar_js = [
				"funciones.js",
				"masDatos/datosAlertas.js",
				"masDatos/datosCobranza.js",
				"masDatos/datosCoordina.js",
				"masDatos/datosProductos.js",
				"sistemaBajas/historialDeBajas.js",
				"sistemaBajas/solicitarBaja.js",
				"serviciosContratados/listar_servicios.js",
				"general/cobranza_abitab.js",
				"general/volver_a_llamar.js",
				"general/sesion.js",
				"general/alertas_de_otras_areas.js",
				"general/buscar_socio_o_funcionario.js",
				"general/consultas_datos_socio_o_funcionario.js",
				"general/identificacion_usuario.js",
				"general/alertas_de_vida_te_lleva.js",
				"general/cargar_registros.js",
				"general/historia_comunicacion_de_cedula.js",
				"general/historial_registros_alertas.js",
				"general/patologias_socio.js",
				"general/etiqueta_socio.js",
				"general/crmessage.js",
			];

			/** JS General **/
			foreach ($array_cargar_js as $archivo) {
				echo '<script src="./assets/js/' . $archivo . $version . '"></script>';
			}
			/** END JS General **/


			include('./views/content/nivel1.php');


			echo '<div id="contenido1" style="display: none;">';
			include('views/content/etiquetas_de_socio.html');
			include('views/content/no_es_socio_registros.php');
			include('views/content/no_es_socio.php');
			include('views/content/si_es_socio.php');
			echo '</div>';
			include('views/content/funcionarios.html');
			include('views/content/registros_socio.html');
			echo '<div id="contenido2" style="display: none;">';
			include('views/content/patologias_socio.html');
			include('views/content/cobranza_abitab.html');
			echo '</div>';
			include('views/content/administrar_alertas_y_llamadas_pendientes.html');


			$array_cargar_modals = [
				"modalDatosAlertas.html",
				"modalDatosCobranza.html",
				"modalDatosCoordina.html",
				"modalDatosProductos.html",
				"modalInformacionDetalladaBaja.html",
				"modalHistoriaComunicacionDeCedula.html",
				"modalHistorialDeBajas.html",
				"modalSolicitarBajaFiliales.html",
				"modalServiciosContratados.html",
				"modal_identificar_persona_logueada.html",
				"modalSesionExpirada.html",
				"modal_asignar_llamada_a_usuario.html",
				"modal_asignar_alerta_pendiente.html",
				"modal_historial_registros_de_alertas.html",
				"modal_historial_registros_volver_a_llamar.html",
				"modal_agregar_patologia_socio.html",
				"modal_cambiar_fecha_y_hora_volver_a_llamar.html",
				"modal_ver_etiquetas_socio.html",
				"modal_mostrar_imagenes.html",
				"modal_agregar_etiquetas_socio.html",
				"modal_crmessage.html",
				"modal_auditorias_socio_registradas.html",
				"modal_ver_comentarios_auditoria_socio.html",
				"modal_registrar_comentario_auditoria.html",
			];

			/** Carga Modals **/
			foreach ($array_cargar_modals as $modal) {
				include('./views/modals/' . $modal);
			}
			/** END Carga Modals **/


			break;
		case 2:

			$array_cargar_js = [
				"funciones.js",
				"masDatos/datosAlertas.js",
				"masDatos/datosCobranza.js",
				"masDatos/datosCoordina.js",
				"masDatos/datosProductos.js",
				"serviciosContratados/listar_servicios.js",
				"general/cobranza_abitab.js",
				"general/volver_a_llamar.js",
				"general/sesion.js",
				"general/alertas_de_otras_areas.js",
				"general/buscar_socio_o_funcionario.js",
				"general/consultas_datos_socio_o_funcionario.js",
				"general/identificacion_usuario.js",
				"general/alertas_de_vida_te_lleva.js",
				"general/cargar_registros.js",
				"general/historia_comunicacion_de_cedula.js",
				"general/historial_registros_alertas.js",
				"general/patologias_socio.js",
				"general/etiqueta_socio.js",
				"general/crmessage.js",
			];

			/** JS General **/
			foreach ($array_cargar_js as $archivo) {
				echo '<script src="./assets/js/' . $archivo . $version . '"></script>';
			}
			/** END JS General **/


			include('./views/content/nivel2.php');


			echo '<div id="contenido1" style="display: none;">';
			include('views/content/etiquetas_de_socio.html');
			include('views/content/no_es_socio_registros.php');
			include('views/content/no_es_socio.php');
			include('views/content/si_es_socio.php');
			echo '</div>';
			include('views/content/funcionarios.html');
			echo '<div id="contenido2" style="display: none;">';
			include('views/content/patologias_socio.html');
			include('views/content/cobranza_abitab.html');
			echo '</div>';
			include('views/content/administrar_alertas_y_llamadas_pendientes.html');


			$array_cargar_modals = [
				"modalDatosAlertas.html",
				"modalDatosCobranza.html",
				"modalDatosCoordina.html",
				"modalDatosProductos.html",
				"modalInformacionDetalladaBaja.html",
				"modalServiciosContratados.html",
				"modal_identificar_persona_logueada.html",
				"modalSesionExpirada.html",
				"modal_asignar_llamada_a_usuario.html",
				"modal_asignar_alerta_pendiente.html",
				"modal_historial_registros_de_alertas.html",
				"modal_historial_registros_volver_a_llamar.html",
				"modal_ver_etiquetas_socio.html",
				"modal_mostrar_imagenes.html",
				"modal_agregar_etiquetas_socio.html",
				"modal_crmessage.html",
				"modal_auditorias_socio_registradas.html",
				"modal_ver_comentarios_auditoria_socio.html",
				"modal_registrar_comentario_auditoria.html",
			];

			/** Carga Modals **/
			foreach ($array_cargar_modals as $modal) {
				include('./views/modals/' . $modal);
			}
			/** END Carga Modals **/


			break;


		case 3:
			$array_ruta_cargar_js = [
				"index.js",
				"funciones.js",
				"masDatos/datosAlertas.js",
				"masDatos/datosCobranza.js",
				"masDatos/datosCoordina.js",
				"masDatos/datosProductos.js",
				"sistemaBajas/historialDeBajas.js",
				"sistemaBajas/gestionarBajas.js",
				"sistemaBajas/solicitarBaja.js",
				"serviciosContratados/listar_servicios.js",
				"enviar_documento_y_alerta/js.js",
				"general/cobranza_abitab.js",
				"general/volver_a_llamar.js",
				"general/sesion.js",
				"general/alertas_de_otras_areas.js",
				"general/buscar_socio_o_funcionario.js",
				"general/consultas_datos_socio_o_funcionario.js",
				"general/identificacion_usuario.js",
				"general/alertas_de_vida_te_lleva.js",
				"general/cargar_registros.js",
				"general/historia_comunicacion_de_cedula.js",
				"general/historial_registros_alertas.js",
				"general/patologias_socio.js",
				"general/etiqueta_socio.js",
				"general/auditorias_socios.js",
				"general/crmessage.js",
			];

			/** Carga JS **/
			foreach ($array_ruta_cargar_js as $ruta_archivo) {
				echo '<script src="./assets/js/' . $ruta_archivo . $version . '"></script>';
			}
			/** END Carga JS **/


			include('./views/content/nivel3.php');


			echo '<div id="contenido1" style="display: none;">';
			include('views/content/etiquetas_de_socio.html');
			include('views/content/auditorias_socio.html');
			include('views/content/no_es_socio_registros.php');
			include('views/content/no_es_socio.php');
			include('views/content/si_es_socio.php');
			echo '</div>';
			include('views/content/funcionarios.html');
			include('views/content/registros_socio.html');
			include('views/content/registros_funcionario.html');
			echo '<div id="contenido2" style="display: none;">';
			include('views/content/patologias_socio.html');
			include('views/content/cobranza_abitab.html');
			echo '</div>';
			include('views/content/administrar_alertas_y_llamadas_pendientes.html');


			$array_cargar_modals = [
				"modalDatosAlertas.html",
				"modalDatosCobranza.html",
				"modalDatosCoordina.html",
				"modalDatosProductos.html",
				"modal_ver_mas_comentarios.html",
				"modal_licencia_acompanantes.html",
				"modal_faltas_acompanantes.html",
				"modal_horas_acompanantes.html",
				"modal_agendar_volver_a_llamar.html",
				"modal_agenda_volver_a_llamar.html",
				"modal_cargar_registro_volver_a_llamar.html",
				"modal_enviar_terminos_y_condiciones.html",
				"modal_mostrar_imagenes.html",
				"modal_historial_registros_volver_a_llamar.html",
				"modal_historial_registros_de_alertas.html",
				"modal_ver_etiquetas_socio.html",
				"modal_agregar_etiquetas_socio.html",
				"modalInformacionDetalladaBaja.html",
				"modalHistoriaComunicacionDeCedula.html",
				"modalHistorialDeBajas.html",
				"modalListarBajas.html",
				"modalSolicitarBaja.html",
				"modalServiciosContratados.html",
				"modalCargarDocumentos.html",
				"modal_alertas_funcionarios.html",
				"modal_identificar_persona_logueada.html",
				"modalSesionExpirada.html",
				"modal_asignar_llamada_a_usuario.html",
				"modal_asignar_alerta_pendiente.html",
				"modal_historial_registros_de_alertas.html",
				"modal_historial_registros_volver_a_llamar.html",
				"modal_agregar_patologia_socio.html",
				"modal_cambiar_fecha_y_hora_volver_a_llamar.html",
				"modal_registrar_auditoria_socio.html",
				"modal_crmessage.html",
				"modal_auditorias_socio.html",
				"modal_auditorias_socio_registradas.html",
				"modal_ver_comentarios_auditoria_socio.html",
				"modal_registrar_comentario_auditoria.html",
			];


			/** Carga Modals **/
			foreach ($array_cargar_modals as $modal) {
				include('./views/modals/' . $modal);
			}
			/** END Carga Modals **/


			break;
		case 4:

			$array_ruta_cargar_js = [
				"nivel4/js.js",
				"funciones.js",
				"general/sesion.js",
				"general/crmessage.js",
			];

			/** Carga JS **/
			foreach ($array_ruta_cargar_js as $ruta_archivo) {
				echo '<script src="./assets/js/' . $ruta_archivo . $version . '"></script>';
			}
			/** END Carga JS **/


			include('./views/content/nivel4.php');


			$array_cargar_modals = [
				"modal_identificar_persona_logueada.html",
				"modalSesionExpirada.html",
				"modal_asignar_llamada_a_usuario.html",
				"modal_asignar_alerta_pendiente.html",
				"modal_historial_registros_de_alertas.html",
				"modal_historial_registros_volver_a_llamar.html",
				"modal_ver_etiquetas_socio.html",
				"modal_mostrar_imagenes.html",
				"modal_agregar_etiquetas_socio.html",
				"modal_crmessage.html",
				"modal_auditorias_socio_registradas.html",
				"modal_ver_comentarios_auditoria_socio.html",
				"modal_registrar_comentario_auditoria.html",
			];


			/** Carga Modals **/
			foreach ($array_cargar_modals as $modal) {
				include('./views/modals/' . $modal);
			}
			/** END Carga Modals **/


			break;
		case 5:

			$array_ruta_cargar_js = [
				"nivel5/js.js",
				"masDatos/datosCobranza.js",
				"masDatos/datosCoordina.js",
				"masDatos/datosCRM.js",
				"masDatos/datosProductos.js",
				"sistemaBajas/historialDeBajas.js",
				"sistemaBajas/gestionarBajas.js",
				"serviciosContratados/listar_servicios.js",
				"funciones.js",
				"general/sesion.js",
				"general/crmessage.js",
			];

			/** Carga JS **/
			foreach ($array_ruta_cargar_js as $ruta_archivo) {
				echo '<script src="./assets/js/' . $ruta_archivo . $version . '"></script>';
			}
			/** END Carga JS **/


			include('./views/content/nivel5.php');


			$array_cargar_modals = [
				"modalDatosCobranza.html",
				"modalDatosCoordina.html",
				"modalDatosCRM.html",
				"modalDatosProductos.html",
				"modalGestionCentralizado.html",
				"modalGestionDomiciliario.html",
				"modalHistoriaComunicacionDeCedula.html",
				"modalHistorialDeBajas.html",
				"modalLlamadasPendientes.html",
				"modalServiciosContratados.html",
				"modal_identificar_persona_logueada.html",
				"modalSesionExpirada.html",
				"modal_asignar_llamada_a_usuario.html",
				"modal_asignar_alerta_pendiente.html",
				"modal_historial_registros_de_alertas.html",
				"modal_historial_registros_volver_a_llamar.html",
				"modal_ver_etiquetas_socio.html",
				"modal_mostrar_imagenes.html",
				"modal_agregar_etiquetas_socio.html",
				"modal_crmessage.html",
				"modal_auditorias_socio_registradas.html",
				"modal_ver_comentarios_auditoria_socio.html",
				"modal_registrar_comentario_auditoria.html",
			];


			/** Carga Modals **/
			foreach ($array_cargar_modals as $modal) {
				include('./views/modals/' . $modal);
			}
			/** END Carga Modals **/


			break;


		case 6:

			$array_ruta_cargar_js = [
				"nivel6/js.js",
				"nivel6/alertas/js.js",
				"general/sesion.js",
				"nivel6/crmessage.js",
			];

			/** Carga JS **/
			foreach ($array_ruta_cargar_js as $ruta_archivo) {
				echo '<script src="./assets/js/' . $ruta_archivo . $version . '"></script>';
			}
			/** END Carga JS **/


			include('./views/content/nivel6.php');


			$array_cargar_modals = [
				"nivel6/modal_licencia_acompanantes.html",
				"nivel6/modal_horas_acompanantes_personal.html",
				"nivel6/modal_faltas_acompanantes_personal.html",
				"nivel6/modalDatosCoordina_personal.html",
				"nivel6/modalDatosCobranza_personal.html",
				"nivel6/modalDatosProductos_personal.html",
				"nivel6/modal_todas_licencias_acompanantes.html",
				"nivel6/modal_todas_las_horas_acompanantes_personal.html",
				"nivel6/modal_todos_registros_faltas_acompanantes_personal.html",
				"nivel6/modal_alertas_funcionarios.html",
				"nivel6/modal_capacitacion_acompanantes.html",
				"modal_identificar_persona_logueada.html",
				"modalSesionExpirada.html",
				"modal_asignar_llamada_a_usuario.html",
				"modal_asignar_alerta_pendiente.html",
				"modal_historial_registros_de_alertas.html",
				"modal_historial_registros_volver_a_llamar.html",
				"modal_ver_etiquetas_socio.html",
				"modal_mostrar_imagenes.html",
				"modal_agregar_etiquetas_socio.html",
				"modal_crmessage.html",
				"modal_auditorias_socio_registradas.html",
				"modal_ver_comentarios_auditoria_socio.html",
				"modal_registrar_comentario_auditoria.html",
			];


			/** Carga Modals **/
			foreach ($array_cargar_modals as $modal) {
				include('./views/modals/' . $modal);
			}
			/** END Carga Modals **/


			break;
	}




	include('views/footer.php');
} else {
	echo '<script>window.location.replace("login.php");</script>';
}
