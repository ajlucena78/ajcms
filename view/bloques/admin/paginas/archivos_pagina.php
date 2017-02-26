<?php if (count($contenido->archivos) > 0) { ?>
	<a name="archivos"></a>
	<div style="float: left">
		<h4>Archivos asociados al contenido</h4>
	</div>
	<div style="float: right;">
		<div style="height: 15px;"></div>
		<strong><?php echo count($contenido->archivos); ?></strong> archivo/s
	</div>
	<div style="clear: both;"></div>
	<?php $cont = 1; ?>
	<?php foreach ($contenido->archivos as $archivo) { ?>
		<a name="archivo_<?php echo $archivo->idArchivo; ?>"></a>
		<form name="edicionArchivo<?php echo $archivo->idArchivo; ?>" 
				action="<?php vlink('edicion-contenido-texto'); ?>#archivo_<?php echo $archivo->idArchivo; ?>" 
				method="post" enctype="multipart/form-data" id="edicionArchivo<?php 
				echo $archivo->idArchivo; ?>">
			<input type="hidden" name="id" value="<?php echo $contenido->idContenido; ?>" />
			<input type="hidden" name="idArchivo" value="<?php echo $archivo->idArchivo; ?>" />
			<input type="hidden" name="guardarArchivo" value="1" />
			<input type="hidden" name="borrarArchivo" value="0" />
			<div style="float: left; width: 30%;">
				Archivo actual:
			</div>
			<div style="float: right; width: 70%;">
				<img src="<?php echo URL_RES; ?>imagenes/admin/iconos/page.png" style="vertical-align: middle; border: 0pt;" alt="Archivos adjuntos" /> 
				<a href="<?php echo $archivo->enlace(); ?>" style="color: blue;"><?php 
						echo formato_html($archivo->nombre); ?>.<?php echo formato_html($archivo->extension); ?></a>
			</div>
			<div style="height: 10px; clear: both;"></div>
			<div style="float: left; width: 30%;">
				<label for="archivo">Localizaci&oacute;n del archivo *:</label>
			</div>
			<div style="float: right; width: 70%;">
				<input type="hidden" name="MAX_FILE_SIZE" value="80000000" />
				<input type="file" name="archivo" id="archivo<?php echo $cont; ?>" style="width: 100%;" />
				<br />
				<span style="color: #999;">* S&oacute;lo indicar si se va a cambiar por otro archivo</span>
			</div>
			<div style="height: 10px; clear: both;"></div>
			<div style="float: left; width: 30%;">
				<label for="titulo">T&iacute;tulo del enlace:</label>
			</div>
			<div style="float: right; text-align: right; width: 70%;">
				<input type="text" name="titulo" id="titulo<?php echo $cont; ?>" 
						value="<?php echo formato_html($archivo->titulo); ?>" style="width: 100%;" 
						maxlength="255" />
			</div>
			<div style="height: 10px; clear: both;"></div>
			<div style="float: right; width: 25%; text-align: right;">
				<input type="submit" value="Guardar" />
				<input type="button" value="Borrar" style="color: red;" 
						onclick="if (window.confirm('¿Desvincular este archivo del contenido?'))
								{document.edicionArchivo<?php echo $archivo->idArchivo; 
						?>.guardarArchivo.value = 0; document.edicionArchivo<?php 
						echo $archivo->idArchivo; ?>.borrarArchivo.value = 1; document.edicionArchivo<?php 
						echo $archivo->idArchivo; ?>.submit();}" />
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