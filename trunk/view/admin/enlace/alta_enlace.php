<form action="<?php vlink('alta-enlace'); ?>" method="post">
	<input type="hidden" name="guardar" value="1" />
	<div style="float: left; width: 20%;">
		<label for="descripcion">Descripci&oacute;n:</label>
	</div>
	<div style="float: right; text-align: right; width: 80%;">
		<input type="text" name="descripcion" id="descripcion" style="width: 100%;" 
				value="<?php echo $enlace->descripcion; ?>" maxlength="255" />
	</div>
	<div style="height: 10px; clear: left;">
	</div>
	<div style="float: left; width: 20%;">
		<label for="descripcion">Permalink:</label>
	</div>
	<div style="float: right; text-align: right; width: 80%;">
		<input type="text" name="permalink" id="permalink" style="width: 100%;" 
				value="<?php echo $enlace->permalink; ?>" maxlength="50" />
	</div>
	<div style="height: 10px; clear: left;">
	</div>
	<div style="float: left; width: 20%;">
		<label for="url">URL:</label>
	</div>
	<div style="float: right; text-align: right; width: 80%;">
		<input type="text" name="url" id="url" style="width: 100%;" 
				value="<?php echo $enlace->url; ?>" maxlength="255" />
	</div>
	<div style="height: 10px; clear: left;">
	</div>
	<div style="float: right">
		<input type="submit" value="Guardar enlace" />
		<input type="button" value="Cancelar" onclick="window.location.href = '<?php vlink('enlaces'); ?>';" />
	</div>
</form>
<script type="text/javascript">
	document.getElementById("descripcion").focus();
</script>