<script type="text/javascript">
	function moverImagen(id)
	{
		if (document.getElementById('edicionImagen' + id).id_contenido_destino.value)
		{
			var mensaje = "¿Mover la imagen a la oferta indicada?";
			if (window.confirm(mensaje))
			{
				document.edicion.guardar.value = 0;
				document.edicion.moverImagen.value = 1;
				document.edicion.idImagen.value = id;
				document.edicion.id_contenido_destino.value = document.getElementById('edicionImagen' + id).id_contenido_destino.value;
				document.edicion.submit();
			}
		}
	}
</script>
<div style="text-align: right; margin-bottom: 10px;">
	<a href="?referencia=<?php echo $oferta->referencia; ?>" target="_blank">
		<img src="<?php echo URL_RES; ?>imagenes/admin/iconos/application_view_list.png" 
				style="vertical-align: middle; border: 0px;" />
		Mostrar versi&oacute;n guardada en la web
	</a>
</div>
<form name="edicion" action="<?php vlink('edicion-oferta'); ?>" method="post">
	<input type="hidden" name="id" value="<?php echo $oferta->idContenido; ?>" />
	<input type="hidden" name="guardar" value="1" />
	<input type="hidden" name="idImagen" value="0" />
	<input type="hidden" name="moverImagen" value="0" />
	<input type="hidden" name="id_contenido_destino" value="0" />
	<div style="float: left; width: 20%;">
		<label for="descripcion">Descripci&oacute;n:</label>
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
	<div style="height: 10px; clear: both;"></div>
	<div>
		<label for="texto">Texto:</label>
	</div>
	<div style="text-align: right; width: 100%;">
		<textarea name="texto" id="texto" style="width: 100%;" cols="40" rows="16"><?php 
				echo $oferta->texto; ?></textarea>
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="height: 40px; float: right;">
		<input type="submit" value="Guardar oferta" />
		<input type="button" value="Volver" onclick="window.location.href = '<?php vlink('ofertas'); ?>';" />
	</div>
	<div style="clear: left;"></div>
</form>
<div style="clear: both;">
	<hr />
</div>
<a name="nueva_imagen"></a>
<form name="nuevaImagen" action="<?php vlink('edicion-oferta'); ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?php echo $oferta->idContenido; ?>" />
	<input type="hidden" name="idImagen" value="0" />
	<input type="hidden" name="nuevaImagen" value="1" />
	<h4>Subir nueva imagen</h4>
	<div style="float: left; width: 30%;">
		<label for="imagen">Localizaci&oacute;n del archivo:</label>
	</div>
	<div style="float: right; text-align: right; width: 70%;">
		<input type="hidden" name="MAX_FILE_SIZE" value="8000000" />
		<input type="file" name="imagen" id="imagen" style="width: 100%;" />
	</div>
	<input type="hidden" name="titulo" value="-" />
	<input type="hidden" name="alineamiento" value="2" />
	<input type="hidden" name="ampliable" value="1" />
	<input type="hidden" name="tamano" value="100" />
	<div style="height: 20px; clear: both;"></div>
	<div style="height: 40px; float: right;">
		<input type="submit" value="Subir imagen" />
		<input type="button" value="Volver" onclick="window.location.href = '<?php vlink('ofertas'); ?>';" />
	</div>
	<div style="clear: left;"></div>
</form>
<div style="clear: both;">
	<hr />
</div>
<?php if (count($oferta->imagenes) > 0) { ?>
	<div style="float: left">
		<h4>Im&aacute;genes asociadas a la oferta</h4>
	</div>
	<div style="float: right;">
		<div style="height: 15px;"></div>
		<strong><?php echo count($oferta->imagenes); ?></strong> imagen/es
	</div>
	<div style="clear: both;"></div>
	<?php $cont = 0; ?>
	<?php foreach ($oferta->imagenes as $imagen) { ?>
		<?php $cont++; ?>
		<?php $directorio = floor($imagen->idImagen / 1000); ?>
		<a name="imagen_<?php echo $imagen->idImagen; ?>"></a>
		<form name="edicionImagen<?php echo $imagen->idImagen; ?>" 
				action="<?php vlink('edicion-oferta'); ?>#imagen_<?php echo $imagen->idImagen; ?>" 
				method="post" enctype="multipart/form-data" id="edicionImagen<?php echo $imagen->idImagen; ?>">
			<input type="hidden" name="id" value="<?php echo $oferta->idContenido; ?>" />
			<input type="hidden" name="idImagen" value="<?php echo $imagen->idImagen; ?>" />
			<input type="hidden" name="guardarImagen" value="1" />
			<input type="hidden" name="borrarImagen" value="0" />
			<div style="height: 20px;"></div>
			<div style="float: left; width: 25%;">
				<img src="<?php echo URL_RES; ?>upload/<?php echo $directorio; ?>/<?php 
						echo $imagen->idImagen; ?>.<?php echo $imagen->extension; ?>" 
						alt="<?php echo formato_html($imagen->titulo); ?>" style="width: 90%;" />
			</div>
			<div style="float: right; width: 75%;">
				<div style="float: left; width: 35%;">
					<label for="imagen">Localizaci&oacute;n del archivo *:</label>
				</div>
				<div style="float: right; text-align: right; width: 65%;">
					<input type="hidden" name="MAX_FILE_SIZE" value="8000000" />
					<input type="file" name="imagen" id="imagen<?php echo $cont; ?>" style="width: 100%;" />
				</div>
				<input type="hidden" name="titulo" value="-" />
				<input type="hidden" name="alineamiento" value="2" />
				<input type="hidden" name="ampliable" value="1" />
				<input type="hidden" name="tamano" value="100" />
				<div style="height: 10px; clear: both;"></div>
				<div style="text-align: right;">
					<span style="color: #999;">* S&oacute;lo indicar si se va a cambiar por otro archivo de 
						imagen</span>
				</div>
				<div style="height: 40px; clear: both;"></div>
				<div style="float: right">
					<select name="id_contenido_destino" id="id_contenido_destino" style="width: 200px;">
						<option value="">Mover a la oferta...</option>
						<?php foreach ($ofertas as $oferta2) { ?>
							<?php if ($oferta->idContenido == $oferta2->idContenido) continue; ?>
							<option value="<?php echo $oferta2->idContenido; ?>"><?php 
									echo formato_html($oferta2->descripcion); ?></option>
						<?php } ?>
					</select>
					<input type="button" value="Mover" 
							onclick="moverImagen(<?php echo $imagen->idImagen; ?>);" />
					&nbsp;
					<input type="submit" value="Guardar imagen" />
					<input type="button" value="Borrar imagen" style="color: red;" 
							onclick="if (window.confirm('¿Desvincular esta imagen de la oferta?')){document.edicionImagen<?php 
							echo $imagen->idImagen; ?>.guardarImagen.value = 0; document.edicionImagen<?php 
							echo $imagen->idImagen; ?>.borrarImagen.value = 1; document.edicionImagen<?php 
							echo $imagen->idImagen; ?>.submit();}" />
				</div>
			</div>
			<div style="clear: both;"></div>
		</form>
		<div style="height: 20px;"></div>
		<div style="clear: both;">
			<hr />
		</div>
	<?php } ?>
<?php } ?>