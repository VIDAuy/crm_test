<?php
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
				"general/consultas_acompanantes.js",
				"general/alertas_de_vida_te_lleva.js",
				"general/cargar_registros.js",
				"general/historia_comunicacion_de_cedula.js",
				"general/patologias_socio.js",
				"general/etiqueta_socio.js",
				"general/crmessage.js",
				"general/equifax.js",
				"general/bajas_morosidad.js",
			];

			/** JS General **/
			foreach ($array_cargar_js as $archivo) {
				echo '<script src="./assets/js/' . $archivo . $version . '"></script>';
			}
			/** END JS General **/


			include('./views/content/contenido_niveles.php');


			include('views/content/etiquetas_de_socio.php');
			include('views/content/contenido_no_es_socio_registros.php');
			include('views/content/contenido_no_es_socio.php');
			include('views/content/contenido_si_es_socio.php');
			include('views/content/contenido_funcionarios.php');
			include('views/content/historial_registros_socio.php');
			include('views/content/historial_patologias_socio.php');
			include('views/content/cobranza_abitab.php');
			include('views/content/administrar_pendientes.php');


			$array_cargar_modals = [
				"alertas/modal_datos_alertas.html",
				"alertas/modal_asignar_alerta_pendiente.html",
				"alertas/modal_historial_registros_de_alertas.html",
				"alertas/modal_asignar_alertas_generales.html",
				"datos_socio/modalDatosCobranza.html",
				"datos_socio/modalDatosCoordina.html",
				"datos_socio/modalDatosProductos.html",
				"datos_socio/modalServiciosContratados.html",
				"bajas/modal_informacion_detallada_baja.html",
				"bajas/modal_historial_de_bajas.html",
				"bajas/modal_solicitar_baja_filiales.html",
				"bajas_morosidad/modal_upload_bajas_morosidad.html",
				"bajas_morosidad/modal_registros_bajas_morosidad.html",
				"modalHistoriaComunicacionDeCedula.html",
				"datos_acompanantes/modal_horas_acompanantes.html",
				"volver_a_llamar/modal_asignar_llamada_a_usuario.html",
				"volver_a_llamar/modal_historial_registros_volver_a_llamar.html",
				"volver_a_llamar/modal_cambiar_fecha_y_hora_volver_a_llamar.html",
				"etiquetas_socio/modal_ver_etiquetas_socio.html",
				"etiquetas_socio/modal_agregar_etiquetas_socio.html",
				"auditorias/modal_auditorias_socio_registradas.html",
				"auditorias/modal_ver_comentarios_auditoria_socio.html",
				"auditorias/modal_registrar_comentario_auditoria.html",
				"auditorias/modal_editar_auditorias.html",
				"auditorias/modal_editar_comentario_auditoria.html",
				"modal_agregar_patologia_socio.html",
				"modal_identificar_persona_logueada.html",
				"modalSesionExpirada.html",
				"modal_mostrar_imagenes.html",
				"crmessage/modal_crmessage.html",
				"crmessage/modal_historial_crmessage.html",
				"crmessage/modal_mensajes_crmessage.html",
				"crmessage/modal_reasignar_crmessage.html",
				"alertas/modal_alertas_generales.html",
			];

			/** Carga Modals **/
			foreach ($array_cargar_modals as $modal) {
				include('./views/modals/' . $modal);
			}
			/** END Carga Modals **/


			break;
		case 2:

			$array_cargar_js = [
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
				"general/consultas_acompanantes.js",
				"general/alertas_de_vida_te_lleva.js",
				"general/cargar_registros.js",
				"general/historia_comunicacion_de_cedula.js",
				"general/patologias_socio.js",
				"general/etiqueta_socio.js",
				"general/crmessage.js",
				"general/equifax.js",
				"general/bajas_morosidad.js",
			];

			/** JS General **/
			foreach ($array_cargar_js as $archivo) {
				echo '<script src="./assets/js/' . $archivo . $version . '"></script>';
			}
			/** END JS General **/


			include('./views/content/contenido_niveles.php');


			include('views/content/etiquetas_de_socio.php');
			include('views/content/contenido_no_es_socio_registros.php');
			include('views/content/contenido_no_es_socio.php');
			include('views/content/contenido_si_es_socio.php');
			include('views/content/contenido_funcionarios.php');
			include('views/content/historial_patologias_socio.php');
			include('views/content/cobranza_abitab.php');
			include('views/content/administrar_pendientes.php');


			$array_cargar_modals = [
				"alertas/modal_datos_alertas.html",
				"alertas/modal_asignar_alertas_generales.html",
				"datos_socio/modalDatosCobranza.html",
				"datos_socio/modalDatosCoordina.html",
				"datos_socio/modalDatosProductos.html",
				"bajas/modal_informacion_detallada_baja.html",
				"bajas/modal_solicitar_baja.html",
				"datos_socio/modalServiciosContratados.html",
				"modal_identificar_persona_logueada.html",
				"modalSesionExpirada.html",
				"volver_a_llamar/modal_asignar_llamada_a_usuario.html",
				"alertas/modal_asignar_alerta_pendiente.html",
				"alertas/modal_historial_registros_de_alertas.html",
				"volver_a_llamar/modal_historial_registros_volver_a_llamar.html",
				"etiquetas_socio/modal_ver_etiquetas_socio.html",
				"modal_mostrar_imagenes.html",
				"etiquetas_socio/modal_agregar_etiquetas_socio.html",
				"crmessage/modal_crmessage.html",
				"crmessage/modal_historial_crmessage.html",
				"crmessage/modal_mensajes_crmessage.html",
				"crmessage/modal_reasignar_crmessage.html",
				"auditorias/modal_auditorias_socio_registradas.html",
				"auditorias/modal_ver_comentarios_auditoria_socio.html",
				"auditorias/modal_registrar_comentario_auditoria.html",
				"auditorias/modal_editar_auditorias.html",
				"auditorias/modal_editar_comentario_auditoria.html",
				"bajas_morosidad/modal_upload_bajas_morosidad.html",
				"bajas_morosidad/modal_registros_bajas_morosidad.html",
				"alertas/modal_alertas_generales.html",
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
				"general/consultas_acompanantes.js",
				"general/alertas_de_vida_te_lleva.js",
				"general/cargar_registros.js",
				"general/historia_comunicacion_de_cedula.js",
				"general/patologias_socio.js",
				"general/etiqueta_socio.js",
				"general/auditorias_socios.js",
				"general/crmessage.js",
				"general/equifax.js",
				"general/bajas_morosidad.js",
				"general/consultas_generales.js",
				"general/cierre_de_horas_personalizado.js",
				"general/alertas_generales.js",
			];

			/** Carga JS **/
			foreach ($array_ruta_cargar_js as $ruta_archivo) {
				echo '<script src="./assets/js/' . $ruta_archivo . $version . '"></script>';
			}
			/** END Carga JS **/


			include('./views/content/contenido_niveles.php');


			include('views/content/etiquetas_de_socio.php');
			include('views/content/contenido_no_es_socio_registros.php');
			include('views/content/contenido_no_es_socio.php');
			include('views/content/contenido_si_es_socio.php');
			include('views/content/contenido_funcionarios.php');
			include('views/content/historial_registros_socio.php');
			include('views/content/historial_registros_funcionarios.php');
			include('views/content/historial_patologias_socio.php');
			include('views/content/cobranza_abitab.php');
			include('views/content/administrar_pendientes.php');
			include('views/content/consultas_generales.php');
			include('views/content/cierre_de_horas_personalizado.php');


			$array_cargar_modals = [
				"alertas/modal_alertas_funcionarios.html",
				"alertas/modal_asignar_alerta_pendiente.html",
				"alertas/modal_datos_alertas.html",
				"alertas/modal_historial_registros_de_alertas.html",
				"alertas/modal_asignar_alertas_generales.html",
				"auditorias/modal_auditorias_socio_registradas.html",
				"auditorias/modal_auditorias_socio.html",
				"auditorias/modal_registrar_auditoria_socio.html",
				"auditorias/modal_registrar_comentario_auditoria.html",
				"auditorias/modal_editar_auditorias.html",
				"auditorias/modal_editar_comentario_auditoria.html",
				"auditorias/modal_ver_comentarios_auditoria_socio.html",
				"bajas/modal_historial_de_bajas.html",
				"bajas/modal_informacion_detallada_baja.html",
				"bajas/modal_listar_bajas.html",
				"bajas/modal_solicitar_baja.html",
				"datos_acompanantes/modal_faltas_acompanantes.html",
				"datos_acompanantes/modal_horas_acompanantes.html",
				"datos_acompanantes/modal_licencia_acompanantes.html",
				"datos_acompanantes/modal_todas_licencias_acompanantes.html",
				"datos_acompanantes/modal_todas_las_horas_acompanantes_personal.html",
				"datos_acompanantes/modal_todos_registros_faltas_acompanantes_personal.html",
				"datos_acompanantes/modal_capacitacion_acompanantes.html",
				"datos_socio/modalDatosCobranza.html",
				"datos_socio/modalDatosCoordina.html",
				"datos_socio/modalDatosProductos.html",
				"datos_socio/modalServiciosContratados.html",
				"equifax/modal_registros_equifax.html",
				"equifax/modal_upload_equifax.html",
				"etiquetas_socio/modal_agregar_etiquetas_socio.html",
				"etiquetas_socio/modal_ver_etiquetas_socio.html",
				"volver_a_llamar/modal_agenda_volver_a_llamar.html",
				"volver_a_llamar/modal_agendar_volver_a_llamar.html",
				"volver_a_llamar/modal_asignar_llamada_a_usuario.html",
				"volver_a_llamar/modal_cambiar_fecha_y_hora_volver_a_llamar.html",
				"volver_a_llamar/modal_cargar_registro_volver_a_llamar.html",
				"volver_a_llamar/modal_historial_registros_volver_a_llamar.html",
				"modal_agregar_patologia_socio.html",
				"crmessage/modal_crmessage.html",
				"crmessage/modal_historial_crmessage.html",
				"crmessage/modal_mensajes_crmessage.html",
				"crmessage/modal_reasignar_crmessage.html",
				"modal_enviar_terminos_y_condiciones.html",
				"modal_identificar_persona_logueada.html",
				"modal_mostrar_imagenes.html",
				"modal_ver_mas_comentarios.html",
				"modalCargarDocumentos.html",
				"modalHistoriaComunicacionDeCedula.html",
				"modalSesionExpirada.html",
				"bajas_morosidad/modal_upload_bajas_morosidad.html",
				"bajas_morosidad/modal_registros_bajas_morosidad.html",
				"alertas/modal_alertas_generales.html",
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
				"general/sesion.js",
				"general/crmessage.js",
				"general/equifax.js",
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
				"volver_a_llamar/modal_asignar_llamada_a_usuario.html",
				"alertas/modal_asignar_alerta_pendiente.html",
				"alertas/modal_historial_registros_de_alertas.html",
				"volver_a_llamar/modal_historial_registros_volver_a_llamar.html",
				"etiquetas_socio/modal_ver_etiquetas_socio.html",
				"modal_mostrar_imagenes.html",
				"etiquetas_socio/modal_agregar_etiquetas_socio.html",
				"crmessage/modal_crmessage.html",
				"crmessage/modal_historial_crmessage.html",
				"crmessage/modal_mensajes_crmessage.html",
				"crmessage/modal_reasignar_crmessage.html",
				"auditorias/modal_auditorias_socio_registradas.html",
				"auditorias/modal_ver_comentarios_auditoria_socio.html",
				"auditorias/modal_registrar_comentario_auditoria.html",
				"auditorias/modal_editar_auditorias.html",
				"auditorias/modal_editar_comentario_auditoria.html",
				"bajas/modal_solicitar_baja.html",
				"alertas/modal_alertas_generales.html",
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
				"general/sesion.js",
				"general/crmessage.js",
				"general/equifax.js",
				"general/bajas_morosidad.js",
			];

			/** Carga JS **/
			foreach ($array_ruta_cargar_js as $ruta_archivo) {
				echo '<script src="./assets/js/' . $ruta_archivo . $version . '"></script>';
			}
			/** END Carga JS **/


			include('./views/content/nivel5.php');


			$array_cargar_modals = [
				"datos_socio/modalDatosCobranza.html",
				"datos_socio/modalDatosCoordina.html",
				"datos_socio/modalDatosCRM.html",
				"datos_socio/modalDatosProductos.html",
				"modalGestionCentralizado.html",
				"modalGestionDomiciliario.html",
				"modalHistoriaComunicacionDeCedula.html",
				"bajas/modal_historial_de_bajas.html",
				"bajas/modal_solicitar_baja.html",
				"volver_a_llamar/modalLlamadasPendientes.html",
				"datos_socio/modalServiciosContratados.html",
				"modal_identificar_persona_logueada.html",
				"modalSesionExpirada.html",
				"volver_a_llamar/modal_asignar_llamada_a_usuario.html",
				"alertas/modal_asignar_alerta_pendiente.html",
				"alertas/modal_historial_registros_de_alertas.html",
				"volver_a_llamar/modal_historial_registros_volver_a_llamar.html",
				"etiquetas_socio/modal_ver_etiquetas_socio.html",
				"modal_mostrar_imagenes.html",
				"etiquetas_socio/modal_agregar_etiquetas_socio.html",
				"crmessage/modal_crmessage.html",
				"crmessage/modal_historial_crmessage.html",
				"crmessage/modal_mensajes_crmessage.html",
				"crmessage/modal_reasignar_crmessage.html",
				"auditorias/modal_auditorias_socio_registradas.html",
				"auditorias/modal_ver_comentarios_auditoria_socio.html",
				"auditorias/modal_registrar_comentario_auditoria.html",
				"auditorias/modal_editar_auditorias.html",
				"auditorias/modal_editar_comentario_auditoria.html",
				"alertas/modal_alertas_generales.html",
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
