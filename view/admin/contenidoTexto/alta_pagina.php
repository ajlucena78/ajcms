<form action="<?php vlink('alta-contenido-texto'); ?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="guardar" value="1" />
	<div style="float: left; width: 20%;">
		<label for="descripcion">T&iacute;tulo:</label>
	</div>
	<div style="float: right; text-align: right; width: 80%;">
		<input type="text" name="descripcion" id="descripcion" style="width: 100%;" 
				value="<?php echo $contenido->descripcion; ?>" maxlength="255" />
	</div>
	<div style="height: 10px; clear: left;">
	</div>
	<div style="float: left; width: 20%;">
		<label for="encabezado">Encabezado:</label>
	</div>
	<div style="float: right; text-align: right; width: 80%;">
		<input type="text" name="encabezado" id="encabezado" style="width: 100%;" 
				value="<?php echo $contenido->encabezado; ?>" maxlength="255" />
	</div>
	<div style="height: 10px; clear: left;">
	</div>
	<div style="float: left; width: 20%;">
		<label for="permalink">Permalink:</label>
	</div>
	<div style="float: right; text-align: right; width: 80%;">
		<input type="text" name="permalink" id="permalink" style="width: 100%;" 
				value="<?php echo $contenido->permalink; ?>" maxlength="255" />
	</div>
	<div style="height: 10px; clear: left;">
	</div>
	<div>
		<label for="texto">Texto:</label>
	</div>
	<div style="text-align: right; width: 100%;">
		<textarea name="texto" id="texto" style="width: 100%;" cols="20" 
				rows="22"><?php echo $contenido->texto; ?></textarea>
	</div>
	<div style="height: 20px; clear: left;">
	</div>
	<div style="float: right">
		<input type="submit" value="Guardar contenido" />
		&nbsp;
		<input type="button" value="Cancelar" 
				onclick="window.location.href = '<?php vlink('contenidos-texto'); ?>';" />
	</div>
</form>
<script type="text/javascript">
	document.getElementById("descripcion").focus();
</script>