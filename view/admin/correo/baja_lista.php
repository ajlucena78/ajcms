<form name="edicion" action="<?php vlink('baja-lista'); ?>" method="post">
	<input type="hidden" name="id" value="<?php echo $lista->id_lista_correo; ?>" />
	<input type="hidden" name="borrar" value="1" />
	<div style="float: left; width: 20%;">
		<strong>Tipo:</strong>
	</div>
	<div style="float: right; text-align: left; width: 80%;">
		Lista de correo
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="float: left; width: 20%;">
		<strong>Nombre:</strong>
	</div>
	<div style="float: right; text-align: left; width: 80%;">
		<?php echo formato_html($lista->nombre_lista_correo); ?>
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="height: 40px; float: right;">
		<input type="submit" value="Borrar la lista" style="color: red;" />
		<input type="button" value="Cancelar" onclick="window.location.href = '<?php 
				vlink('listas-correo'); ?>';" />
	</div>
</form>