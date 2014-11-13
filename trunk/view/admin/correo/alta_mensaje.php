<form name="alta" action="<?php vlink('alta-mensaje'); ?>" method="post">
	<input type="hidden" name="guardar" value="1" />
	<div style="float: left;  width: 20%;">
		<label for="descripcion">Asunto:</label>
	</div>
	<div style="float: right; text-align: right; width: 80%;">
		<input type="text" name="descripcion" id="descripcion" style="width: 100%;" 
				value="<?php echo $contenido->descripcion; ?>" maxlength="255" />
	</div>
	<div style="height: 5px; clear: both;"></div>
	<div style="float: left; width: 20%;">
		<label for="permalink">Permalink:</label>
	</div>
	<div style="float: right; text-align: right; width: 80%;">
		<input type="text" name="permalink" id="permalink" style="width: 100%;" 
				value="<?php echo $contenido->permalink; ?>" maxlength="50" />
	</div>
	<div style="height: 5px; clear: both;"></div>
	<div>
		<label for="texto">Texto:</label>
	</div>
	<div style="text-align: right;">
		<textarea name="texto" id="texto" style="width: 100%;" cols="40" 
				rows="20"><?php echo $contenido->texto; ?></textarea>
	</div>
	<div style="height: 5px; clear: both;"></div>
	<div style="margin-top: 20px; float: right">
		<input type="submit" value="Guardar mensaje" />
		<input type="button" value="Cancelar" onclick="window.location.href = '<?php vlink('mensajes'); ?>';" />
	</div>
	<div style="clear: left;"></div>
</form>
<script type="text/javascript">
	document.getElementById("descripcion").focus();
</script>