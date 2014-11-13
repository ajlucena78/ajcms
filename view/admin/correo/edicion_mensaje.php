<script type="text/javascript">
	function cambiarOrden(id)
	{
		var total = <?php echo count($contenido->imagenes); ?>;
		var mensaje = "Indique la nueva posición de la imagen en el contenido (1 - " + total + "):";
		mensaje += "\n\nEjemplo: \nSi hay 3 imágenes, indicará 1 para que sea la primera, 2 para que sea la de enmedio y 3 para que sea la última.";
		var res = null;
		if (res = 0 + window.prompt(mensaje, ""))
		{
			if (res === null)
				return(false);
			if (res < 1 || res > total)
			{
				window.alert("Debe indicar un número entre 1 y " + total);
				cambiarOrden(id);
			}
			else
			{
				document.edicion.guardar.value = 0;
				document.edicion.cambiarOrdenImagen.value = 1;
				document.edicion.orden.value = res;
				document.edicion.idImagen.value = id;
				document.edicion.action += "#imagen_" + id;
				document.edicion.submit();
			}
		}
	}
</script>
<form name="edicion" action="<?php vlink('edicion-mensaje'); ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?php echo $contenido->idContenido; ?>" />
	<input type="hidden" name="guardar" value="1" />
	<input type="hidden" name="cambiarOrdenImagen" value="0" />
	<input type="hidden" name="orden" value="0" />
	<input type="hidden" name="idImagen" value="0" />
	<div style="float: left; width: 20%;">
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
				rows="24"><?php echo $contenido->texto; ?></textarea>
	</div>
	<div style="height: 10px; clear: both;"></div>
	<h5>Nueva imagen</h5>
	<div style="float: left; width: 30%;">
		<label for="imagen">Localizaci&oacute;n en disco:</label>
	</div>
	<div style="float: right; text-align: right; width: 70%;">
		<input type="hidden" name="MAX_FILE_SIZE" value="4000000" />
		<input type="file" name="imagen" id="imagen" style="width: 100%;" />
	</div>
	<div style="height: 5px; clear: both;"></div>
	<div style="float: left; width: 30%;">
		<label for="titulo">T&iacute;tulo:</label>
	</div>
	<div style="float: right; text-align: right; width: 70%;">
		<input type="text" name="titulo" id="titulo" value="" style="width: 100%;" maxlength="255" />
	</div>
	<div style="height: 5px; clear: both;"></div>
	<div style="float: left">
		<label for="alineamiento_1">Alineamiento:</label>
	</div>
	<div style="float: right">
		<input type="radio" name="alineamiento" id="alineamiento_1" value="1" /><label 
				for="alineamiento_1">A la izquierda</label>
		<input type="radio" name="alineamiento" id="alineamiento_0" value="0" /><label 
				for="alineamiento_0">A la derecha</label>
		<input type="radio" name="alineamiento" id="alineamiento_2" value="2" checked='checked' /><label 
				for="alineamiento_2">Sin alinear</label>
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="height: 40px; float: right">
		<input type="submit" value="Guardar mensaje" />
		<input type="button" value="Cancelar" onclick="window.location.href = '<?php vlink('mensajes'); ?>';" />
	</div>
	<div style="clear: both;"></div>
</form>
<script type="text/javascript">
	document.getElementById("descripcion").focus();
</script>
<?php $cont = 0; ?>
<?php foreach ($contenido->imagenes as $imagen) { ?>
	<?php $directorio = floor($imagen->idImagen / 1000); ?>
	<a name="imagen_<?php echo $imagen->idImagen; ?>"></a>
	<form name="edicionImagen<?php echo $imagen->idImagen; ?>" 
			action="<?php vlink('edicion-mensaje'); ?>#imagen_<?php echo $imagen->idImagen; ?>" 
			method="post" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?php echo $contenido->idContenido; ?>" />
		<input type="hidden" name="idImagen" value="<?php echo $imagen->idImagen; ?>" />
		<input type="hidden" name="guardarImagen" value="1" />
		<input type="hidden" name="borrarImagen" value="0" />
		<div style="clear: both;"></div>
		<div style="clear: both; height: 20px;">
			<hr />
		</div>
		<div style="float: left; width: 25%;">
			<img src="<?php echo URL_RES; ?>upload/<?php echo $directorio; ?>/<?php 
					echo $imagen->idImagen; ?>.<?php echo $imagen->extension; ?>"  
					alt="<?php echo formato_html($imagen->titulo); ?>" style="width: 120px; height: 100px;" />
			<br />
			Posici&oacute;n: <strong><?php echo $imagen->orden; ?></strong>
		</div>
		<div style="float: right; width: 75%;">
			<div style="float: left; width: 35%;">
				<label for="imagen">Localizaci&oacute;n en disco:</label>
			</div>
			<div style="float: right; text-align: right; width: 65%;">
				<input type="hidden" name="MAX_FILE_SIZE" value="8000000" />
				<input type="file" name="imagen" id="imagen<?php echo ++$cont; ?>" style="width: 100%;" />
			</div>
			<div style="height: 5px; clear: both;"></div>
			<div style="float: left; width: 35%;">
				<label for="titulo">T&iacute;tulo:</label>
			</div>
			<div style="float: right; text-align: right; width: 65%;">
				<input type="text" name="titulo" id="titulo<?php echo $cont; ?>" 
						value="<?php echo $imagen->titulo; ?>" style="width: 100%" maxlength="255" />
			</div>
			<div style="height: 10px; clear: both;">
			</div>
			<div style="float: left">
				<label for="alineamiento_1">Alineamiento:</label>
			</div>
			<div style="float: right">
				<input type="radio" name="alineamiento" id="alineamiento<?php echo $cont; ?>_1" 
						value="1" <?php if ($imagen->alineamiento == 1){echo "checked='checked' ";} ?> />
					<label for="alineamiento_1">A la izquierda</label>
				<input type="radio" name="alineamiento" id="alineamiento<?php echo $cont; ?>_0" 
						value="0" <?php if ($imagen->alineamiento == 0){echo "checked='checked' ";} ?> />
					<label for="alineamiento_0">A la derecha</label>
				<input type="radio" name="alineamiento" id="alineamiento<?php echo $cont; ?>_2" 
						value="2" <?php if ($imagen->alineamiento == 2){echo "checked='checked' ";} ?> />
					<label for="alineamiento_2">Sin alinear</label>
			</div>
			<div style="height: 5px; clear: both;"></div>
			<div style="text-align: right;">
				<span style="color: #999;">* S&oacute;lo indicar si se va a cambiar por otro archivo de 
						imagen</span>
			</div>
			<div style="float: left;">
				<input type="button" value="Cambiar el orden de la imagen" 
						onclick="cambiarOrden(<?php echo $imagen->idImagen; ?>);" />
			</div>
			<div style="float: right;">
				<input type="submit" value="Guardar imagen" />
				<input type="button" value="Borrar imagen" style="color: red;" 
						onclick="if (window.confirm('¿Desvincular esta imagen del contenido?')){document.edicionImagen<?php
						echo $imagen->idImagen; ?>.guardarImagen.value = 0; document.edicionImagen<?php 
						echo $imagen->idImagen; ?>.borrarImagen.value = 1; document.edicionImagen<?php 
						echo $imagen->idImagen; ?>.submit();}" />
			</div>
		</div>
		<div style="clear: both;"></div>
	</form>
<?php } ?>