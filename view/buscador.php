<?php require_once APP_ROOT . 'clases/util/Texto.php'; ?>
<div style="padding-bottom: 20px;">
	B&uacute;squeda de 
	&quot;<span style="color: blue;"><?php echo formato_html($_GET['consulta']); ?></span>&quot;
</div>
<?php if (!$contenidos) { ?>
	<div>
		No hay resultados coincidentes con la/s palabra/s introducida/s
	</div>
<?php }else{ ?>
	<?php foreach ($contenidos as $contenido) { ?>
		<div>
			<h4>
				<a href="<?php echo URL_APP . $contenido->enlace(); ?>">
					<?php echo formato_html($contenido->descripcion); ?>
				</a>
			</h4>
			<div>
				<a href="<?php echo URL_APP . $contenido->enlace(); ?>">
					<?php echo Texto::texto_abreviado(strip_tags($contenido->texto), 400); ?>
				</a>
			</div>
			<?php $ruta = $contenido->ruta(); ?>
			<?php if (strip_tags($ruta) != $contenido->descripcion) { ?>
				<div>
					<span style="color: gray;">Se encuentra en <?php echo $ruta; ?></span>
				</div>
			<?php } ?>
			<br />
		</div>
	<?php } ?>
<?php } ?>