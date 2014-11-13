<?php include ($rootDocumentos . "vistas/html/bloques/admin/cab_admin.php"); ?>
<script type="text/javascript" src="<?php echo $path_view; ?>js/jscalendar-1.0/calendar.js"></script>
<script type="text/javascript" 
		src="<?php echo $path_view; ?>js/jscalendar-1.0/lang/calendar-es.js"></script>
<script type="text/javascript" 
		src="<?php echo $path_view; ?>js/jscalendar-1.0/calendar-setup.js"></script>
<form action="?m=admin/correos/edicion_programa" method="post" name="form1" id="form1" 
		enctype="multipart/form-data">
	<input type="hidden" name="test" id="test" value="0" />
	<input type="hidden" name="id_envio_correo" value="<?php echo $envioVO->get_id_envio_correo(); ?>" />
	<input type="hidden" name="guardar" value="1" />
	<div style="float: left; width: 25%;">
		<label for="fecha_programa_envio">Fecha de env&iacute;o:</label>
	</div>
	<div style="float: right; text-align: left; width: 75%;">
		<input type="text" name="fecha_programa_envio" id="fecha_programa_envio" style="width: 140px;" 
				value="<?php echo $envioVO->get_fecha_programa_envio(); ?>" maxlength="16" />
		<img style="cursor:pointer; vertical-align: middle;" id="trigger_fecha_programa_envio" 
				src="<?php echo $path_view; ?>imagenes/admin/iconos/calendar.png" alt="Elegir Fecha" 
				title="Elegir Fecha Progama" />
	</div>
	<div style="height: 10px; clear: left;">
	</div>
	<div style="float: left; width: 25%;">
		<label for="id_contenido">Mensaje:</label>
	</div>
	<div style="float: right; text-align: right; width: 75%;">
		<select name="id_contenido" id="id_contenido" style="width: 100%;">
			<option value="">...</option>
			<?php foreach ($correos_view as $correoVO) { ?>
				<option value="<?php echo $correoVO->get_idContenido(); ?>" <?php
						if ($correoVO->get_idContenido() == $envioVO->get_id_contenido())
							{echo "selected=\"selected\"";} ?>><?php 
						echo formato_html($correoVO->get_descripcion()); ?></option>
			<?php } ?>
		</select>
	</div>
	<div style="height: 10px; clear: left;">
	</div>
	<div style="float: left; width: 25%;">
		<label for="fichero_adjunto">Fichero adjunto (opcional):</label>
	</div>
	<div style="float: right; text-align: left; width: 75%;">
		<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
		<input type="file" name="fichero_adjunto" id="fichero_adjunto" style="width: 99%;" value="" 
				maxlength="255" />
	</div>
	<div style="height: 10px; clear: left;">
	</div>
	<div style="float: left; width: 25%;">
		<label for="email_test">Email de prueba:</label>
	</div>
	<div style="float: right; text-align: left; width: 75%;">
		<input type="text" name="email_test" id="email_test" style="width: 99%;" 
				value="<?php echo $envioVO->get_email_test(); ?>" maxlength="255" />
	</div>
	<div style="height: 10px; clear: left;">
	</div>
	<div style="float: left; width: 25%;">
		<label for="listas">Destinatarios:</label>
	</div>
	<div style="float: right; text-align: right; width: 75%;">
		<select name="listas[]" id="listas" style="width: 100%;" size="20" multiple="multiple">
			<?php foreach ($listas_view as $listaVO) { ?>
				<option value="<?php echo $listaVO->get_id_lista_correo(); ?>" <?php
						if ($envioVO->is_lista($listaVO))
							{echo "selected=\"selected\"";} ?>><?php 
						echo formato_html($listaVO->get_nombre_lista_correo()); ?></option>
			<?php } ?>
		</select>
	</div>
	<div style="height: 10px; clear: left;">
	</div>
	<div style="height: 40px; float: right">
		<br />
		<input type="button" value="Enviar al email de prueba" name="opcion" 
				onclick="document.getElementById('test').value = '1'; document.getElementById('form1').submit();" />
		<input type="submit" value="Guardar" />
		<input type="button" value="Volver" onclick="window.location.href = '?m=admin/correos/envios';" />
	</div>
	<div style="clear: left;">
	</div>
</form>
<script type="text/javascript">
	document.getElementById("fecha_programa_envio").focus();
	Calendar.setup
	({
		inputField: "fecha_programa_envio", ifFormat: "%d/%m/%Y %H:%M", button: "trigger_fecha_programa_envio"
    });
</script>
<?php include ($rootDocumentos . "vistas/html/bloques/admin/pie_admin.php"); ?>