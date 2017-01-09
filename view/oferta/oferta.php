<h1 class="title"><?php echo formato_html($oferta->descripcion); ?></h1>
<div style="color: red;">
	<strong><?php echo formato_html($oferta->precio); ?></strong>
</div>
<div>
	<?php echo str_replace("\n", "\n<br/>\n", formato_html($oferta->texto)); ?>
</div>
<?php if (count($oferta->imagenes) > 0) { ?>
<div>
	<br />
	<?php foreach ($oferta->imagenes as $imagen) {  ?>
		<?php $directorio = floor($imagen->idImagen / 1000); ?>
		<div style="clear: both;"></div>
		<div>
			<img src="<?php echo URL_RES; ?>upload/<?php echo $directorio; ?>/original_<?php 
					echo $imagen->idImagen; ?>.<?php echo $imagen->extension; ?>"
					alt="<?php echo formato_html($oferta->descripcion); ?>" style="width: 100%;" />
		</div>
	<?php } ?>
</div>
<?php } ?>