<form action="<?php vlink('alta-oferta'); ?>" method="post">
	<input type="hidden" name="guardar" value="1" />
	<div style="float: left; width: 20%;">
		<label for="descripcion">T&iacute;tulo:</label>
	</div>
	<div style="float: right; text-align: right; width: 80%;">
		<input type="text" name="descripcion" id="descripcion" style="width: 100%;" 
				value="<?php echo $oferta->descripcion; ?>" maxlength="255" />
	</div>
	<div style="height: 10px; clear: left;"></div>
	<div style="float: left; width: 20%;">
		<label for="permalink">Permalink (opcional):</label>
	</div>
	<div style="float: right; text-align: right; width: 80%;">
		<input type="text" name="permalink" id="permalink" style="width: 100%;" 
				value="<?php echo $oferta->permalink; ?>" maxlength="255" />
	</div>
	<div style="height: 10px; clear: left;"></div>
	<div style="float: left; width: 20%;">
		<label for="precio">Precio (opcional):</label>
	</div>
	<div style="float: right; text-align: right; width: 80%;">
		<input type="text" name="precio" id="precio" style="width: 100%;" value="<?php echo $oferta->precio; ?>" 
				maxlength="255" />
	</div>
	<div style="height: 10px; clear: left;"></div>
	<div>
		<label for="texto">Texto:</label>
	</div>
	<div style="text-align: right; width: 100%;">
		<textarea name="texto" id="texto" style="width: 100%;" cols="16" rows="18"><?php 
				echo $oferta->texto; ?></textarea>
	</div>
	<div style="height: 10px; clear: left;"></div>
	<div style="float: right;">
		<input type="submit" value="Guardar oferta" />
		<input type="button" value="Cancelar" onclick="window.location.href = '<?php vlink('ofertas'); ?>';" />
	</div>
</form>
<script type="text/javascript">
	document.getElementById("descripcion").focus();
</script>