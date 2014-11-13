<script type="text/javascript" src="<?php echo URL_RES; ?>js/jscalendar-1.0/calendar.js"></script>
<script type="text/javascript" 
		src="<?php echo URL_RES; ?>js/jscalendar-1.0/lang/calendar-es.js"></script>
<script type="text/javascript" 
		src="<?php echo URL_RES; ?>js/jscalendar-1.0/calendar-setup.js"></script>
<form action="<?php vlink('programa'); ?>" method="post" name="form1" id="form1" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?php echo $envio->id_envio_correo; ?>" />
	<input type="hidden" name="guardar" id="guardar" value="1" />
	<input type="hidden" name="test" id="test" value="0" />
	<div style="float: left; width: 25%;">
		<label for="fecha_programa_envio">Fecha de env&iacute;o:</label>
	</div>
	<div style="float: right; text-align: left;  width: 75%;">
		<input type="text" name="fecha_programa_envio" id="fecha_programa_envio" style="width: 140px;" 
				value="<?php echo $envio->fecha_programa_envio; ?>" maxlength="16" />
		<img style="cursor:pointer; vertical-align: middle;" id="trigger_fecha_programa_envio" 
				src="<?php echo URL_RES; ?>imagenes/admin/iconos/calendar.png" alt="Elegir Fecha" 
				title="Elegir Fecha Progama" />
	</div>
	<div style="height: 10px; clear: left;">
	</div>
	<div style="float: left; width: 25%;">
		<label for="id_contenido">Mensaje:</label>
	</div>
	<div style="float: right; text-align: right; width: 75%;">
		<select name="id_contenido" id="id_contenido" style="width: 100%;">
			<option value="">&nbsp;</option>
			<?php foreach ($correos as $correo) { ?>
				<option value="<?php echo $correo->idContenido; ?>" <?php 
						if ($envio->contenido and $correo->idContenido == $envio->contenido->idContenido) { 
								echo "selected=\"selected\""; } ?>><?php 
						echo formato_html($correo->descripcion); ?></option>
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
		<input type="file" name="fichero_adjunto" id="fichero_adjunto" style="width: 100%;" value="" 
				maxlength="255" />
	</div>
	<div style="height: 10px; clear: left;">
	</div>
	<div style="float: left; width: 25%;">
		<label for="email_test">Email de prueba:</label>
	</div>
	<div style="float: right; text-align: left; width: 75%;">
		<input type="text" name="email_test" id="email_test" style="width: 50%;" 
				value="<?php echo $email_test; ?>" maxlength="255" />
		<input type="button" value="Enviar al email de prueba" name="opcion" 
				onclick="document.getElementById('test').value = '1'; document.getElementById('form1').submit();" />
	</div>
	<div style="height: 10px; clear: left;">
	</div>
	<div style="float: left; width: 25%;">
		<label for="listas">Destinatarios:</label>
	</div>
	<div style="float: right; text-align: right; width: 75%;">
		<select name="listas[]" id="listas" style="width: 100%;" size="20" multiple="multiple">
			<?php foreach ($listas as $lista) { ?>
				<option value="<?php echo $lista->id_lista_correo; ?>" <?php
						if ($envio->is_lista($lista))
							{echo "selected=\"selected\"";} ?>><?php 
						echo formato_html($lista->nombre_lista_correo); ?></option>
			<?php } ?>
		</select>
		<div style="text-align: left; color: #666;">
			Para seleccionar m&aacute;s de una lista, deje pulsada la tecla Ctrl mientras las selecciona
		</div>
	</div>
	<div style="height: 10px; clear: left;">
	</div>
	<div style="float: right">
		<br />
		<input type="submit" value="Guardar el env&iacute;o" />
		<input type="button" value="Cancelar" onclick="window.location.href = '<?php vlink('envios'); ?>';" />
	</div>
</form>
<script type="text/javascript">
	document.getElementById("fecha_programa_envio").focus();
	Calendar.setup
	({
		inputField: "fecha_programa_envio", ifFormat: "%d/%m/%Y %H:%M", button: "trigger_fecha_programa_envio"
    });
</script>