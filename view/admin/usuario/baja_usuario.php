<form name="edicion" action="<?php vlink('baja-usuario'); ?>" method="post">
	<input type="hidden" name="id" value="<?php echo $usuario->idUsuario; ?>" />
	<input type="hidden" name="borrar" value="1" />
	<h2>Eliminar usuario</h2>
	<div style="float: left; width: 20%;">
		<strong>Nombre:</strong>
	</div>
	<div style="float: right; text-align: left; width: 80%;">
		<?php echo $usuario->login; ?>
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="height: 40px; float: right">
		<input type="submit" value="Borrar usuario" style="color: red;" />
		<input type="button" value="Cancelar" onclick="window.location.href = '<?php vlink('usuarios'); ?>';" />
	</div>
</form>