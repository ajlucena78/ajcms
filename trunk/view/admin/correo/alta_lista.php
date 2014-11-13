<form action="<?php vlink('alta-lista'); ?>" method="post">
	<input type="hidden" name="guardar" value="1" />
	<div style="float: left; width: 20%;">
		<label for="nombre_lista_correo">Nombre:</label>
	</div>
	<div style="float: right; text-align: right;width: 80%;">
		<input type="text" name="nombre_lista_correo" id="nombre_lista_correo" style="width: 100%;" 
				value="<?php echo $lista->nombre_lista_correo; ?>" maxlength="255" />
	</div>
	<div style="height: 10px; clear: left;"></div>
	<div style="float: right">
		<br />
		<input type="submit" value="Guardar la lista" />
		<input type="button" value="Cancelar" onclick="window.location.href = '<?php vlink('listas'); ?>';" />
	</div>
</form>
<script type="text/javascript">
	document.getElementById("nombre_lista_correo").focus();
</script>