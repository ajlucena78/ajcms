<div>
	<?php foreach ($ofertas as $oferta) { ?>
		<br />
		<div>
			<?php if (count($oferta->imagenes) > 0) { ?>
				<?php $res = $oferta->imagenes(0); ?>
				<?php $directorio = floor($res->idImagen / 1000); ?>
				<div style="float: left; width: 30%;">
					<a href="<?php echo URL_APP; ?>?action=oferta&amp;id=<?php echo $oferta->idContenido; ?>">
						<img src="<?php echo URL_RES; ?>upload/<?php echo $directorio; ?>/<?php 
								echo $res->idImagen; ?>.<?php 
								echo $res->extension; ?>"
								alt="<?php echo formato_html($oferta->descripcion); ?>" style="width: 95%;" />
					</a>
				</div>
			<?php } ?>
			<div style="float: left; width: 70%;">
				<h2>
					<a href="<?php echo URL_APP; ?>?action=oferta&amp;id=<?php echo $oferta->idContenido; ?>">
						<?php echo formato_html($oferta->descripcion); ?>
					</a>
				</h2>
				<div style="color: red;"><strong><?php echo formato_html($oferta->precio); ?></strong></div>
				<div>
					<?php echo str_replace("\n", "\n<br/>\n", formato_html(substr($oferta->texto, 0, 400))); 
							?>... <a href="<?php echo URL_APP; ?>?action=oferta&amp;id=<?php 
							echo $oferta->idContenido; ?>">Ver m&aacute;s</a></div>
			</div>
			<div style="clear: both;"></div>
		</div>
		<hr />
	<?php } ?>
</div>