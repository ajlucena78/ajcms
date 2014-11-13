<?php foreach ($noticias_view as $noticiaVO) { ?>
	<strong>
		<a href="<?php echo $pathRelativo; ?>?m=home/noticias/noticia&amp;referencia=<?php 
				echo $noticiaVO->get_referencia(); ?>">
			<?php echo $noticiaVO->get_descripcion(); ?>
		</a>
	</strong>
	<br />
	<?php echo $noticiaVO->get_fecha(); ?>
	<br />
	<?php echo $noticiaVO->get_texto(); ?>
	<input type="hidden" name="idNews" id="idNews" value="<?php echo $noticiaVO->get_idNoticia(); ?>" />
<?php } ?>