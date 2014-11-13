<form action="<?php vlink('baja-correo'); ?>" method="post">
	<input type="hidden" name="id" value="<?php echo $correo->id_correo; ?>" />
	<input type="hidden" name="id_lista_correo" value="<?php echo $lista->id_lista_correo; ?>" />
	<input type="hidden" name="borrar" value="1" />
	<div style="float: left; width: 20%;">
		Lista de correo:
	</div>
	<div style="float: right; text-align: left; width: 80%;">
		<?php $res = $correo->listas(0); ?>
		<?php echo $res->nombre_lista_correo; ?>
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="float: left; width: 20%;">
		Email:
	</div>
	<div style="float: right; text-align: left; width: 80%;">
		<strong><?php echo formato_html($correo->email_correo); ?></strong>
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="height: 40px; float: right">
		<input type="submit" value="Dar de baja" style="color: red;" />
		<input type="button" value="Cancelar" 
				onclick="window.location.href = '<?php vlink('edicion-lista'
				, array('id' => $res->id_lista_correo)); ?>';" />
	</div>
</form>