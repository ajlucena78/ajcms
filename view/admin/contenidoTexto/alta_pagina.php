<form action="<?php vlink('alta-contenido-texto'); ?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="guardar" value="1" />
	<div style="float: left; width: 25%;">
		<label for="descripcion">T&iacute;tulo:</label>
	</div>
	<div style="float: right; text-align: right; width: 75%;">
		<input type="text" name="descripcion" id="descripcion" style="width: 100%;" 
				value="<?php echo $contenido->descripcion; ?>" maxlength="255" />
	</div>
	<div style="height: 10px; clear: left;"></div>
	<div style="float: left; width: 25%;">
		<label for="encabezado">Encabezado (opcional):</label>
	</div>
	<div style="float: right; text-align: right; width: 75%;">
		<input type="text" name="encabezado" id="encabezado" style="width: 100%;" 
				value="<?php echo $contenido->encabezado; ?>" maxlength="255" />
	</div>
	<div style="height: 10px; clear: left;"></div>
	<div style="float: left; width: 25%;">
		<label for="permalink">Permalink (opcional):</label>
	</div>
	<div style="float: right; text-align: right; width: 75%;">
		<input type="text" name="permalink" id="permalink" style="width: 100%;" 
				value="<?php echo $contenido->permalink; ?>" maxlength="255" />
	</div>
	<div style="height: 10px; clear: left;"></div>
	<div style="float: left; width: 25%;">
		<label for="metadesc">Meta-descripci&oacute;n (opcional):</label>
	</div>
	<div style="float: right; text-align: right; width: 75%;">
		<input type="text" name="metadesc" id="metadesc" style="width: 100%;" 
				value="<?php echo $contenido->metadesc; ?>" />
	</div>
	<div style="height: 10px; clear: left;"></div>
	<div>
		<label for="texto">Texto principal (opcional):</label>
	</div>
	<div style="text-align: right; width: 100%;">
		<textarea name="texto" id="texto" style="width: 100%;" cols="40" rows="12"><?php 
				echo $contenido->texto; ?></textarea>
	</div>
	<div style="height: 5px; clear: left;"></div>
	<div style="text-align: right;">
		<input type="checkbox" name="textoMovil" id="textoMovil" value="1" <?php if ($contenido->textoMovil or $contenido->textoMovil === null) { ?>checked="checked"<?php } ?> />
		<label for="textoMovil" class="gris">Mostrar el texto principal en la versi&oacute;n m&oacute;vil</label>
	</div>
	<div style="height: 10px; clear: left;"></div>
	<div>
		<label for="texto2">Texto secundario (opcional):</label>
	</div>
	<div style="text-align: right; width: 100%;">
		<textarea name="texto2" id="texto2" style="width: 100%;" cols="40" rows="20"><?php 
				echo $contenido->texto2; ?></textarea>
	</div>
	<div style="height: 10px; clear: left;"></div>
	<div>
		<label for="pie">Texto al pie de p&aacute;gina (opcional):</label>
	</div>
	<div style="text-align: right; width: 100%;">
		<textarea name="pie" id="pie" style="width: 100%;" cols="40" rows="20"><?php 
				echo $contenido->pie; ?></textarea>
	</div>
	<div style="height: 5px; clear: left;"></div>
	<div style="text-align: right;">
		<input type="checkbox" name="pieMovil" id="pieMovil" value="1" <?php if ($contenido->pieMovil) { ?>checked="checked"<?php } ?> />
		<label for="pieMovil" class="gris">Mostrar el texto del pie en la versi&oacute;n m&oacute;vil</label>
	</div>
	<div style="height: 20px; clear: left;"></div>
	<div style="float: right">
		<input type="submit" value="Guardar contenido" />
		&nbsp;
		<input type="button" value="Cancelar" 
				onclick="window.location.href = '<?php vlink('contenidos-texto'); ?>';" />
	</div>
</form>
<div style="height: 20pt;"></div>
<script type="text/javascript">
	document.getElementById("descripcion").focus();
</script>