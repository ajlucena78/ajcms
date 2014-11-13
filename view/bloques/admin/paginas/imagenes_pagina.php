<?php if (count($contenido->imagenes) > 0) { ?>
	<a name="imagenes"></a>
	<div style="float: left">
		<h4>Im&aacute;genes asociadas al contenido</h4>
	</div>
	<div style="float: right;">
		<div style="height: 15px;"></div>
		<strong><?php echo count($contenido->imagenes); ?></strong> imagen/es
	</div>
	<div style="clear: both;"></div>
	<?php $cont = 1; ?>
	<?php foreach ($contenido->imagenes as $imagen) { ?>
		<?php $directorio = floor($imagen->idImagen / 1000); ?>
		<a name="imagen_<?php echo $imagen->idImagen; ?>"></a>
		<form name="edicionImagen<?php echo $imagen->idImagen; ?>" 
				action="<?php vlink('edicion-contenido-texto'); ?>#imagen_<?php echo $imagen->idImagen; ?>" 
				method="post" enctype="multipart/form-data" id="edicionImagen<?php echo $imagen->idImagen; ?>">
			<input type="hidden" name="id" value="<?php echo $contenido->idContenido; ?>" />
			<input type="hidden" name="idImagen" value="<?php echo $imagen->idImagen; ?>" />
			<input type="hidden" name="guardarImagen" value="1" />
			<input type="hidden" name="borrarImagen" value="0" />
			<div style="height: 20px;"></div>
			<div style="float: left; width: 25%;">
				<img src="<?php echo URL_RES; ?>upload/<?php echo $directorio; ?>/<?php 
						echo $imagen->idImagen; ?>.<?php echo $imagen->extension; ?>?rand=<?php 
						echo rand(1, 10000); ?>" border="0" alt="<?php echo formato_html($imagen->titulo); ?>" 
						style="width: 90%;" />
				<br />
				Posici&oacute;n: <strong><?php echo $cont; ?></strong>
			</div>
			<div style="float: right; width: 75%;">
				<div style="float: left; width: 35%;">
					<label for="imagen">Localizaci&oacute;n del archivo *:</label>
				</div>
				<div style="float: right; text-align: right; width: 65%;">
					<input type="hidden" name="MAX_FILE_SIZE" value="8000000" />
					<input type="file" name="imagen" id="imagen<?php echo $cont; ?>" style="width: 100%;" />
				</div>
				<div style="clear: both;">
					<span style="color: #999;">* Sólo indicar si se va a cambiar por otro archivo de 
						imagen</span>
				</div>
				<div style="height: 10px; clear: both;"></div>
				<div style="float: left; width: 35%;">
					<label for="titulo">T&iacute;tulo:</label>
				</div>
				<div style="float: right; text-align: right; width: 65%;">
					<input type="text" name="titulo" id="titulo<?php echo $cont; ?>" 
							value="<?php echo formato_html($imagen->titulo); ?>" style="width: 100%;" 
							maxlength="255" />
				</div>
				<div style="height: 10px; clear: both;"></div>
				<div style="float: left; width: 35%;">
					<label for="tamano">Tama&ntilde;o en porcentaje (1 - 100):</label>
				</div>
				<div style="float: right; width: 65%;">
					<input type="text" name="tamano" id="tamano<?php echo $cont; ?>" 
							value="<?php echo $imagen->tamano; ?>" style="width: 10%;" maxlength="3" /> %
				</div>
				<div style="height: 10px; clear: both;"></div>
				<div style="float: left; width: 35%;">
					<label for="alineamiento_1">Alineamiento:</label>
				</div>
				<div style="float: right; width: 65%;">
					<input type="radio" name="alineamiento" id="alineamiento<?php echo $cont; ?>_1" value="1" 
							<?php if ($imagen->alineamiento == 1){echo "checked='checked' ";} ?> />
							<label for="alineamiento_1">A la izquierda</label>
					<input type="radio" name="alineamiento" id="alineamiento<?php echo $cont; ?>_0" value="0" 
							<?php if ($imagen->alineamiento == 0){echo "checked='checked' ";} ?> />
							<label for="alineamiento_0">A la derecha</label>
					<input type="radio" name="alineamiento" id="alineamiento<?php echo $cont; ?>_2" value="2" 
							<?php if ($imagen->alineamiento == 2){echo "checked='checked' ";} ?> />
							<label for="alineamiento_2">Sin alinear</label>
				</div>
				<div style="height: 10px; clear: both;"></div>
				<div style="float: left; width: 35%;">
					<label for="ampliable">Ampliable *:</label>
				</div>
				<div style="float: right; width: 65%;">
					<input type="checkbox" name="ampliable" id="ampliable<?php echo $cont; ?>" value="1" 
							checked="checked" /> 
					<span style="color: #999;">Marcar esta casilla si la foto que se va a subir se debe mostrar 
						reducida y ampliable</span>
				</div>
				<div style="height: 10px; clear: both;"></div>
				<div style="float: left; width: 60%;">
					<select name="id_contenido_destino" id="id_contenido_destino<?php  echo $cont; ?>" 
							style="width: 45%;">
						<option value="">Mover al contenido...</option>
						<?php foreach ($contenidos as $VO) { ?>
							<option value="<?php echo $VO->idContenido; ?>">
								<?php echo $VO->encabezado; ?>
							</option>
						<?php } ?>
					</select>
					<input type="button" value="Mover" 
							onclick="moverImagen(<?php echo $imagen->idImagen; ?>);" />
					<input type="button" value="Cambiar orden" 
							onclick="cambiarOrden(<?php echo $imagen->idImagen; ?>);" />
				</div>
				<div style="float: right; width: 40%; text-align: right;">
					<input type="submit" value="Guardar imagen" />
					<input type="button" value="Borrar" style="color: red;" 
							onclick="if (window.confirm('¿Desvincular esta imagen del contenido?'))
									{document.edicionImagen<?php echo $imagen->idImagen; 
							?>.guardarImagen.value = 0; document.edicionImagen<?php 
							echo $imagen->idImagen; ?>.borrarImagen.value = 1; document.edicionImagen<?php 
							echo $imagen->idImagen; ?>.submit();}" />
				</div>
				<div style="clear: both;"></div>
			</div>
			<div style="clear: both;"></div>
		</form>
		<div style="height: 20px;"></div>
		<div style="clear: both;">
			<hr />
		</div>
		<?php $cont++; ?>
	<?php } ?>
<?php } ?>