<?php $directorio = floor($imagen->idImagen / 1000); ?>
<a name="verimagen"></a>
<p style="text-align: center;">
	<img src="<?php echo URL_RES; ?>upload/<?php echo $directorio; ?>/original_<?php 
			echo $imagen->idImagen; ?>.<?php echo $imagen->extension; ?>" border="0" 
			alt="<?php echo formato_html($imagen->titulo); ?>" />
	<br />
	<?php echo formato_html($imagen->titulo); ?>
</p>