<script type="text/javascript">
	function cambiarOrden(id)
	{
		var total = <?php echo count($contenido->imagenes); ?>;
		var mensaje = "Indique la nueva posición de la imagen en el contenido (1 - " + total + "):";
		mensaje += "\n\nEjemplo: \nSi hay 3 imágenes, indicará 1 para que sea la primera, 2 para que sea la de";
		mensaje += " en medio y 3 para que sea la última.";
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
	function cambiarOrdenVideo(id)
	{
		var total = <?php echo count($contenido->videos); ?>;
		var mensaje = "Indique la nueva posición del vídeo en el contenido (1 - " + total + "):";
		mensaje += "\n\nEjemplo: \nSi hay 3 vídeos, indicará 1 para que sea el primera, ";
		mensaje += "2 para que sea el de enmedio y 3 para que sea el último.";
		var res = null;
		if (res = 0 + window.prompt(mensaje, ""))
		{
			if (res === null)
				return(false);
			if (res < 1 || res > total)
			{
				window.alert("Debe indicar un número entre 1 y " + total);
				cambiarOrdenVideo(id);
			}
			else
			{
				document.edicion.guardar.value = 0;
				document.edicion.cambiarOrdenVideo.value = 1;
				document.edicion.orden.value = res;
				document.edicion.id_video.value = id;
				document.edicion.action += "#video_" + id;
				document.edicion.submit();
			}
		}
	}
	function moverImagen(id)
	{
		if (document.getElementById('edicionImagen' + id).id_contenido_destino.value)
		{
			var mensaje = "¿Mover la imagen al contenido indicado?";
			if (window.confirm(mensaje))
			{
				document.edicion.guardar.value = 0;
				document.edicion.moverImagen.value = 1;
				document.edicion.idImagen.value = id;
				document.edicion.id_contenido_destino.value = document.getElementById('edicionImagen' 
						+ id).id_contenido_destino.value;
				document.edicion.submit();
			}
		}
	}
</script>
<div style="text-align: center; padding-bottom: 1%;">
	<a href="#nueva_imagen"><img src="<?php echo URL_RES; ?>imagenes/admin/iconos/image_add.png" 
				style="vertical-align: middle; border: 0px;" alt="Nueva imagen" /> Nueva imagen</a>
	<span style="color: #AAA;"> | </span>
	<a href="#nuevo_video"><img src="<?php echo URL_RES; ?>imagenes/admin/iconos/film_add.png" 
				style="vertical-align: middle; border: 0px;" alt="Nuevo video" /> Nuevo v&iacute;deo</a>
	<span style="color: #AAA;"> | </span>
	<a href="#nuevo_archivo"><img src="<?php echo URL_RES; ?>imagenes/admin/iconos/page_add.png" 
				style="vertical-align: middle; border: 0pt;" alt="Nuevo archivo" /> Nuevo archivo</a>
	<span style="color: #AAA;"> | </span>
	<a href="#videos"><img src="<?php echo URL_RES; ?>imagenes/admin/iconos/film.png" 
				style="vertical-align: middle; border: 0px;" alt="Videos" /> Videos</a>
	<span style="color: #AAA;"> | </span>
	<a href="#imagenes"><img src="<?php echo URL_RES; ?>imagenes/admin/iconos/image.png" 
				style="vertical-align: middle; border: 0px;" alt="Im&aacute;genes" /> Im&aacute;genes</a>
	<span style="color: #AAA;"> | </span>
	<a href="#archivos"><img src="<?php echo URL_RES; ?>imagenes/admin/iconos/page.png" 
				style="vertical-align: middle; border: 0pt;" alt="Archivos adjuntos" /> Archivos</a>
	<span style="color: #AAA;"> | </span>
	<a href="<?php echo URL_APP; ?><?php echo $contenido->permalink; ?>" target="_blank">
		<img src="<?php echo URL_RES; ?>imagenes/admin/iconos/application_view_list.png" 
				style="vertical-align: middle; border: 0px;" alt="Mostrar versi&oacute;n guardada en la web" />
			Ver versi&oacute;n guardada
	</a>
</div>
<form name="edicion" action="<?php vlink('edicion-contenido-texto'); ?>" method="post">
	<input type="hidden" name="id" value="<?php echo $contenido->idContenido; ?>" />
	<input type="hidden" name="guardar" value="1" />
	<input type="hidden" name="cambiarOrdenImagen" value="0" />
	<input type="hidden" name="cambiarOrdenVideo" value="0" />
	<input type="hidden" name="orden" value="0" />
	<input type="hidden" name="idImagen" value="0" />
	<input type="hidden" name="id_video" value="0" />
	<input type="hidden" name="moverImagen" value="0" />
	<input type="hidden" name="id_contenido_destino" value="0" />
	<div style="margin-bottom: 5pt; clear: left;"></div>
	<div style="float: left; width: 25%;">
		<label for="descripcion">T&iacute;tulo:</label>
	</div>
	<div style="float: right; text-align: right; width: 75%;">
		<input type="text" name="descripcion" id="descripcion" style="width: 100%;" 
				value="<?php echo $contenido->descripcion; ?>" maxlength="255" />
	</div>
	<div style="height: 10px; clear: left;">
	</div>
	<div style="float: left; width: 25%;">
		<label for="encabezado">Encabezado (opcional):</label>
	</div>
	<div style="float: right; text-align: right; width: 75%;">
		<input type="text" name="encabezado" id="encabezado" style="width: 100%;" 
				value="<?php echo $contenido->encabezado; ?>" maxlength="255" />
	</div>
	<div style="height: 10px; clear: left;">
	</div>
	<div style="float: left; width: 25%;">
		<label for="descripcion">Permalink (opcional):</label>
	</div>
	<div style="float: right; text-align: right; width: 75%;">
		<input type="text" name="permalink" id="permalink" style="width: 100%;" 
				value="<?php echo $contenido->permalink; ?>" maxlength="255" />
	</div>
	<div style="height: 10px; clear: left;"></div>
	<div style="float: left; width: 25%;">
		<label for="metadesc">Meta descripci&oacute;n (opcional):</label>
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
		<textarea name="texto" id="texto" style="width: 100%;" cols="40" rows="20"><?php 
				echo $contenido->texto; ?></textarea>
	</div>
	<div style="height: 5px; clear: left;"></div>
	<div style="text-align: right;">
		<input type="checkbox" name="textoMovil" id="textoMovil" value="1" <?php if ($contenido->textoMovil) { ?>checked="checked"<?php } ?> />
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
		<input type="checkbox" name="pieMovil" id="pieMovil" value="1" 
				<?php if ($contenido->pieMovil) { ?>checked="checked"<?php } ?> />
		<label for="pieMovil" class="gris">Mostrar el texto del pie en la versi&oacute;n m&oacute;vil</label>
	</div>
	<div style="height: 20px; clear: left;"></div>
	<div style="height: 20px;"></div>
	<div style="float: right">
		<input type="submit" value="Guardar contenido" />
		&nbsp;
		<input type="button" value="Volver" onclick="window.location.href = '<?php 
				vlink('contenidos-texto'); ?>';" />
	</div>
	<div style="clear: both; height: 15px;"></div>
</form>
<div style="clear: both;">
	<hr />
</div>
<a name="nueva_imagen"></a>
<form name="nuevaImagen" action="<?php vlink('edicion-contenido-texto'); ?>" method="post" 
		enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?php echo $contenido->idContenido; ?>" />
	<input type="hidden" name="idImagen" value="0" />
	<input type="hidden" name="nuevaImagen" value="1" />
	<h4>Subir nueva imagen</h4>
	<div style="float: left; width: 30%;">
		<label for="imagen">Localizaci&oacute;n del archivo:</label>
	</div>
	<div style="float: right; text-align: right; width: 70%;">
		<input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
		<input type="file" name="imagen" id="imagen" style="width: 100%;" />
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="float: left; width: 30%;">
		<label for="titulo">T&iacute;tulo (opcional):</label>
	</div>
	<div style="float: right; text-align: right; width: 70%;">
		<input type="text" name="titulo" id="titulo" style="width: 100%;" maxlength="255" 
				value="<?php if (isset($imagen)) echo formato_html($imagen->titulo); ?>" />
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="float: left; width: 30%;">
		<label for="tamano">Tama&ntilde;o en porcentaje (1 - 100):</label>
	</div>
	<div style="float: right; width: 70%;">
		<input type="text" name="tamano" id="tamano" style="width: 10%;" maxlength="3" 
				value="<?php if (isset($imagen) and $imagen->tamano) echo formato_html($imagen->tamano); 
				else echo '33'; ?>" /> %
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="float: left; width: 30%;">
		<label for="alineamiento_1">Alineamiento:</label>
	</div>
	<div style="float: right; width: 70%;">
		<input type="radio" name="alineamiento" id="alineamiento_1" value="1" />
		<label for="alineamiento_1">A la izquierda</label>
		<input type="radio" name="alineamiento" id="alineamiento_0" value="0" />
		<label for="alineamiento_0">A la derecha</label>
		<input type="radio" name="alineamiento" id="alineamiento_2" value="2" checked='checked' />
		<label for="alineamiento_2">Sin alinear</label>
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="float: left; width: 30%;">
		<label for="ampliable">Foto ampliable:</label> 
	</div>
	<div style="float: right; width: 70%;">
		<input type="checkbox" name="ampliable" id="ampliable" value="1" checked="checked" /> 
		<span style="color: #999;">Marcar esta casilla si la foto a subir se debe mostrar reducida y ampliable</span>
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="float: left; width: 30%;">
		<label for="oculta">Ocultar esta imagen:</label>
	</div>
	<div style="float: right; width: 70%;">
		<input type="checkbox" name="oculta" id="oculta" value="1" <?php if (isset($imagen) and $imagen->oculta) { ?>checked="checked"<?php } ?> /> 
		<span style="color: #999;">Marcar esta casilla si la foto no se debe mostrar</span>
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="height: 40px; float: right">
		<input type="submit" value="Subir imagen" />
		&nbsp;
		<input type="button" value="Volver" 
				onclick="window.location.href = '<?php vlink('contenidos-texto'); ?>';" />
	</div>
	<div style="clear: left;"></div>
</form>
<div style="clear: both;">
	<hr />
</div>
<a name="nuevo_video"></a>
<form name="nuevoVideo" action="<?php vlink('edicion-contenido-texto'); ?>" method="post" 
		enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?php echo $contenido->idContenido; ?>" />
	<input type="hidden" name="id_video" value="0" />
	<input type="hidden" name="nuevoVideo" value="1" />
	<h4>Subir nueva pel&iacute;cula de v&iacute;deo</h4>
	<div style="float: left; width: 30%;">
		<label for="video">Localizaci&oacute;n del archivo FLV:</label>
	</div>
	<div style="float: right; text-align: right; width: 70%;">
		<input type="hidden" name="MAX_FILE_SIZE" value="80000000" />
		<input type="file" name="video" id="video" style="width: 100%;" />
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="float: left; width: 30%;">
		<label for="titulo_video">T&iacute;tulo (opcional):</label>
	</div>
	<div style="float: right; text-align: right; width: 70%;">
		<input type="text" name="titulo_video" id="titulo_video" maxlength="255" style="width: 100%;"
				value="<?php if (isset($video)) echo formato_html($video->titulo_video); ?>" />
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="float: left; width: 30%;">
		<label for="ancho_video">Ancho (opcional):</label>
	</div>
	<div style="float: right; text-align: left; width: 70%;">
		<input type="text" name="ancho_video" id="ancho_video" 
				value="<?php echo (isset($video)) ? $video->ancho_video : ""; ?>" style="width: 100px;" 
				maxlength="5" /> px
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="float: left; width: 30%;">
		<label for="alto_video">Alto (opcional):</label>
	</div>
	<div style="float: right; text-align: left; width: 70%;">
		<input type="text" name="alto_video" id="alto_video" 
				value="<?php echo (isset($video)) ? $video->alto_video : ""; ?>" style="width: 100px;" 
				maxlength="5" /> px
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="float: left; width: 30%;">
		<label for="alineamiento_2_1">Alineamiento:</label>
	</div>
	<div style="float: right; width: 70%;">
		<input type="radio" name="alineamiento" id="alineamiento_2_1" value="1" />
		<label for="alineamiento_2_1">A la izquierda</label>
		<input type="radio" name="alineamiento" id="alineamiento_2_0" value="0" />
		<label for="alineamiento_2_0">A la derecha</label>
		<input type="radio" name="alineamiento" id="alineamiento_2_2" value="2" checked='checked' />
		<label for="alineamiento_2_2">Sin alinear</label>
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="height: 40px; float: right">
		<input type="submit" value="Subir video" />
		&nbsp;
		<input type="button" value="Volver" 
				onclick="window.location.href = '<?php vlink('contenidos-texto'); ?>';" />
	</div>
	<div style="clear: left;"></div>
</form>
<div style="clear: both;">
	<hr />
</div>
<a name="nuevo_archivo"></a>
<form name="nuevoArchivo" action="<?php vlink('edicion-contenido-texto'); ?>" method="post" 
		enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?php echo $contenido->idContenido; ?>" />
	<input type="hidden" name="idArchivo" value="0" />
	<input type="hidden" name="nuevoArchivo" value="1" />
	<h4>Subir nuevo archivo</h4>
	<div style="float: left; width: 30%;">
		<label for="archivo">Localizaci&oacute;n del archivo:</label>
	</div>
	<div style="float: right; text-align: right; width: 70%;">
		<input type="hidden" name="MAX_FILE_SIZE" value="80000000" />
		<input type="file" name="archivo" id="archivo" style="width: 100%;" />
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="float: left; width: 30%;">
		<label for="titulo">T&iacute;tulo:</label>
	</div>
	<div style="float: right; text-align: right; width: 70%;">
		<input type="text" name="titulo" id="titulo" style="width: 100%;" maxlength="255" 
				value="<?php if (isset($archivo)) echo formato_html($archivo->titulo); ?>" />
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="height: 40px; float: right">
		<input type="submit" value="Subir archivo" />
		&nbsp;
		<input type="button" value="Volver" 
				onclick="window.location.href = '<?php vlink('contenidos-texto'); ?>';" />
	</div>
	<div style="clear: left;"></div>
</form>
<div style="clear: both;">
	<hr />
</div>
<?php include PATH_VIEW . 'bloques/admin/paginas/videos_pagina.php'; ?>
<?php include PATH_VIEW . 'bloques/admin/paginas/imagenes_pagina.php'; ?>
<?php include PATH_VIEW . 'bloques/admin/paginas/archivos_pagina.php'; ?>