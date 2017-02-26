<script type="text/javascript">
	function cerrar()
	{
		if (!window.close())
			window.history.back();
	}
</script>
<div class="texto_cen">
	<h1 style="font-size: 100%;"><?php echo formato_html($imagen->titulo); ?></h1>
	<img src="<?php echo $imagen->url(true); ?>" border="0" alt="<?php echo formato_html($imagen->titulo); ?>" 
			style="width: 100%;"/>
	<div style="height: 10pt;"></div>
	<a href="javascript:cerrar();" class="boton" style="margin-bottom: 20pt;">CERRAR VENTANA</a>
</div>
<?php if (isset($contenido) and $contenido) { ?>
	<div style="font-size: 80%;">
		<h2 style="font-weight: bold;">
			<?php if ($contenido->permalink) { ?>
				<a href="<?php echo URL_APP; ?><?php echo $contenido->permalink; ?>">
			<?php } ?>
				<?php echo formato_html($contenido->encabezado); ?>
			<?php if ($contenido->permalink) { ?>
				</a>
			<?php } ?>
		</h2>
		<?php echo str_replace('[imagen]', '', str_replace('[video]', '', $contenido->texto 
				. $contenido->texto2)); ?>
	</div>
<?php } ?>