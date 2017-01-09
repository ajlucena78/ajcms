<script type="text/javascript">
	function cambio_tipo_enlace(id)
	{
		if (id == 1)
		{
			get('h1').disabled = true;
			get('metadesc').disabled = true;
		}
		else
		{
			get('h1').disabled = false;
			get('metadesc').disabled = false;
		}
	}
</script>
<form action="<?php vlink('alta-enlace'); ?>" method="post">
	<input type="hidden" name="guardar" value="1" />
	<div style="float: left; width: 30%;">
		<label for="descripcion">Descripci&oacute;n:</label>
	</div>
	<div style="float: right; text-align: right; width: 70%;">
		<input type="text" name="descripcion" id="descripcion" style="width: 100%;" value="<?php 
				echo $enlace->descripcion; ?>" maxlength="255" />
	</div>
	<div style="height: 10px; clear: left;"></div>
	<div style="float: left; width: 30%;">
		<label for="descripcion">Permalink:</label>
	</div>
	<div style="float: right; text-align: right; width: 70%;">
		<input type="text" name="permalink" id="permalink" style="width: 100%;" value="<?php 
				echo $enlace->permalink; ?>" maxlength="255" />
	</div>
	<div style="height: 10px; clear: left;"></div>
	<div style="float: left; width: 30%;">
		<label for="url">URL destino:</label>
	</div>
	<div style="float: right; text-align: right; width: 70%;">
		<input type="text" name="url" id="url" style="width: 100%;" value="<?php echo $enlace->url; ?>" 
				maxlength="255" />
	</div>
	<div style="height: 10px; clear: left;"></div>
	<div style="float: left; width: 30%;">
		Tipo:
	</div>
	<div style="float: left; text-align: left;">
		<input type="radio" name="tipoEnlace" id="tipoEnlace1" value="1" <?php 
				if (!$enlace->tipoEnlace or $enlace->tipoEnlace == 1)  { ?>checked="checked"<?php } ?> 
				onchange="cambio_tipo_enlace(this.value);" />
		<label for="tipoEnlace1">Directo a la otra p&aacute;gina</label>
		<input type="radio" name="tipoEnlace" id="tipoEnlace2" value="2" <?php 
				if ($enlace->tipoEnlace == 2)  { ?>checked="checked"<?php } ?> 
				onchange="cambio_tipo_enlace(this.value);" />
		<label for="tipoEnlace2">Duplicado de la otra p&aacute;gina</label>
	</div>
	<div style="height: 10px; clear: left;"></div>
	<div style="float: left; width: 30%;">
		<label for="h1">Encabezado &lt;h1&gt;:</label>
	</div>
	<div style="float: right; text-align: right; width: 70%;">
		<input type="text" name="h1" id="h1" style="width: 100%;" value="<?php echo $enlace->h1; ?>" 
				maxlength="255" <?php if ($enlace->tipoEnlace != 2)  { ?>disabled="disabled"<?php } ?> />
	</div>
	<div style="height: 10px; clear: left;"></div>
	<div style="float: left; width: 30%;">
		<label for="metadesc">Meta-descripci&oacute;n &lt;meta-description&gt;:</label>
	</div>
	<div style="float: right; text-align: right; width: 70%;">
		<input type="text" name="metadesc" id="metadesc" style="width: 100%;" value="<?php 
				echo $enlace->metadesc; ?>" <?php if ($enlace->tipoEnlace != 2){ ?>disabled="disabled"<?php 
				} ?> />
	</div>
	<div style="height: 20pt; clear: left;"></div>
	<div style="float: right">
		<input type="submit" value="Guardar enlace" />
		<input type="button" value="Cancelar" onclick="window.location.href = '<?php vlink('enlaces'); ?>';" />
	</div>
</form>
<script type="text/javascript">
	document.getElementById("descripcion").focus();
</script>