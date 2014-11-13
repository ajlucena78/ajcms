<?php require_once APP_ROOT . 'clases/util/Fecha.php'; ?>
<form action="<?php vlink('baja-envio'); ?>" method="post">
	<input type="hidden" name="id" value="<?php echo $envio->id_envio_correo; ?>" />
	<input type="hidden" name="borrar" value="1" />
	<div style="float: left; width: 30%;">
		<strong>Tipo:</strong>
	</div>
	<div style="float: right; text-align: left; width: 70%;">
		Env&iacute;o de correo
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="float: left; width: 30%;">
		<strong>Fecha programada de env&iacute;o:</strong>
	</div>
	<div style="float: right; text-align: left; width: 70%;">
		<?php echo Fecha::convierte_BBDD_a_spa($envio->fecha_programa_envio, true); ?>
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="float: left; width: 30%;">
		<strong>Mensaje:</strong>
	</div>
	<div style="float: right; text-align: left; width: 70%;">
		<?php echo formato_html($envio->contenido->descripcion); ?>
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="height: 40px; float: right">
		<input type="submit" value="Eliminar env&iacute;o" style="color: red;" />
		<input type="button" value="Cancelar" onclick="window.location.href = '<?php vlink('envios'); ?>';" />
	</div>
</form>