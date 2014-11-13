<?php if (count($contenido->videos) > 0) { ?>
	<a name="videos"></a>
	<div style="float: left">
		<h4>V&iacute;deos asociados al contenido</h4>
	</div>
	<div style="float: right;">
		<div style="height: 15px;"></div>
		<strong><?php echo count($contenido->videos); ?></strong> v&iacute;deo/s
	</div>
	<div style="clear: both;"></div>
	<?php $cont = 1; ?>
	<?php foreach ($contenido->videos as $video) { ?>
		<?php $directorio = floor($video->id_video / 1000); ?>
		<a name="video_<?php echo $video->id_video; ?>"></a>
		<form name="edicionVideo<?php echo $video->id_video; ?>" 
				action="<?php vlink('edicion-contenido-texto'); ?>#video_<?php echo $video->id_video; ?>" 
				method="post" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $contenido->idContenido; ?>" />
			<input type="hidden" name="id_video" value="<?php echo $video->id_video; ?>" />
			<input type="hidden" name="guardarVideo" value="1" />
			<input type="hidden" name="borrarVideo" value="0" />
			<div style="height: 20px;"></div>
			<div style="float: left; width: 25%;">
				<a class="myPlayer" href="<?php echo URL_RES; ?>upload/<?php echo $directorio; ?>/<?php 
						echo $video->id_video; ?>.<?php echo $video->extension; ?>" 
						style="display: block; width: 90%; height: 150px;"></a>
				<?php if (file_exists(APP_ROOT . 'media/upload/' . $directorio . '/video_' . $video->id_video 
						. ".jpg")) { ?>
					<br />
					<img src="<?php echo URL_RES; ?>upload/<?php echo $directorio; ?>/video_<?php 
							echo $video->id_video; ?>.jpg" alt="Imagen del vídeo"
							style="border: 0px; display: block; width: 90%;" />
				<?php } ?>
			</div>
			<div style="float: right; width: 75%;">
				<div style="float: left; width: 35%;">
					<label for="video">Localizaci&oacute;n del archivo *:</label>
				</div>
				<div style="float: right; text-align: right; width: 65%;">
					<input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
					<input type="file" name="video" id="video<?php echo $cont; ?>" style="width: 100%;" />
				</div>
				<div style="height: 10px; clear: both;"></div>
				<div style="float: left; width: 35%;">
					<label for="titulo_video">T&iacute;tulo:</label>
				</div>
				<div style="float: right; text-align: right; width: 65%;">
					<input type="text" name="titulo_video" id="titulo_video<?php echo $cont; ?>" 
							value="<?php echo formato_html($video->titulo_video); ?>" style="width: 100%;" 
							maxlength="255" />
				</div>
				<div style="height: 10px; clear: both;"></div>
				<div style="float: left; width: 35%;">
					<label for="ancho_video">Ancho (opcional):</label>
				</div>
				<div style="float: right; text-align: left; width: 65%;">
					<input type="text" name="ancho_video" id="ancho_video<?php echo $cont; ?>" 
							value="<?php echo $video->ancho_video; ?>" style="width: 100px;" maxlength="5" /> px
				</div>
				<div style="height: 10px; clear: both;"></div>
				<div style="float: left; width: 35%;">
					<label for="alto_video">Alto (opcional):</label>
				</div>
				<div style="float: right; text-align: left; width: 65%;">
					<input type="text" name="alto_video" id="alto_video<?php echo $cont; ?>" 
							value="<?php echo $video->alto_video; ?>" style="width: 100px;" maxlength="5" /> px
				</div>
				<div style="height: 10px; clear: both;"></div>
				<div style="float: left">
					<label for="alineamiento_1">Alineamiento:</label>
				</div>
				<div style="float: right">
					<input type="radio" name="alineamiento" id="alineamiento<?php echo $cont; ?>_1" value="1" 
							<?php if ($video->alineamiento == 1) { echo "checked='checked' "; } ?> />
							<label for="alineamiento_1">A la izquierda</label>
					<input type="radio" name="alineamiento" id="alineamiento<?php echo $cont; ?>_0" value="0" 
							<?php if ($video->alineamiento == 0) { echo "checked='checked' "; } ?> />
							<label for="alineamiento_0">A la derecha</label>
					<input type="radio" name="alineamiento" id="alineamiento<?php echo $cont; ?>_2" value="2" 
							<?php if ($video->alineamiento == 2) { echo "checked='checked' "; } ?> />
							<label for="alineamiento_2">Sin alinear</label>
				</div>
				<div style="height: 10px; clear: both;"></div>
				<div style="text-align: right;">
					<span style="color: #999;">* S&oacute;lo indicar si se va a cambiar por otro archivo de 
						v&iacute;deo</span>
				</div>
				<div style="float: left">
					<input type="button" value="Cambiar orden del video" 
							onclick="cambiarOrdenVideo(<?php echo $video->id_video; ?>);" />
				</div>
				<div style="float: right">
					<input type="submit" value="Guardar video" />
					&nbsp;
					<input type="button" value="Borrar video" style="color: red;" 
							onclick="if (window.confirm('¿Desvincular esteste vídeo del contenido?')){document.edicionVideo<?php 
									echo $video->id_video; ?>.guardarVideo.value = 0; document.edicionVideo<?php
									echo $video->id_video; ?>.borrarVideo.value = 1; document.edicionVideo<?php 
									echo $video->id_video; ?>.submit();}" />
				</div>
			</div>
			<div style="clear: both;"></div>
		</form>
		<div style="height: 20px;"></div>
		<div style="clear: both;">
			<hr />
		</div>
		<?php $cont++; ?>
	<?php } ?>
	<script type="text/javascript">
		flowplayer("a.myPlayer", "<?php echo URL_RES; ?>flash/flowplayer/flowplayer-3.2.5.swf", 
		{
			onLoad: function()
			{
				this.mute();
			}
		});
	</script>
<?php } ?>