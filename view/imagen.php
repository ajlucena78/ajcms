<?php $directorio = floor($imagen->idImagen / 1000); ?>
<h1 style="font-size: 160%;"><?php echo formato_html($imagen->titulo); ?></h1>
<p style="text-align: center;">
	<img src="<?php echo URL_RES; ?>upload/<?php echo $directorio; ?>/original_<?php 
			echo $imagen->idImagen; ?>.<?php echo $imagen->extension; ?>" 
			alt="<?php echo formato_html($imagen->titulo); ?>" style="border: 0; width: 95%;" />
</p>
<?php if (isset($contenido) and $contenido) { ?>
	<div style="font-size: 90%;">
		<h2 style="font-weight: bold;">
			<?php if ($contenido->permalink) { ?>
				<a href="<?php echo URL_APP; ?><?php echo $contenido->permalink; ?>">
			<?php } ?>
				<?php echo formato_html($contenido->encabezado); ?>
			<?php if ($contenido->permalink) { ?>
				</a>
			<?php } ?>
		</h2>
		<?php echo str_replace('[imagen]', '', str_replace('[video]', '', $contenido->texto . $contenido->texto2)); ?>
	</div>
<?php } ?>