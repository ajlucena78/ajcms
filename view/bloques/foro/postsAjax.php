<?php foreach ($posts_view as $postVO) { ?>
	<strong>
		<a href="/alisado-japones-foros/viewtopic.php?f=<?php echo $postVO->get_idForum(); ?>&amp;t=<?php echo $postVO->get_idTopic(); ?>&amp;p=<?php echo $postVO->get_idPost(); ?>#p<?php echo $postVO->get_idPost(); ?>">
			<?php echo $postVO->get_asunto(); ?>
		</a>
	</strong>
	<br />
	<?php echo date('d/m/Y', $postVO->get_fecha()); ?>
	<br />
	<?php echo $postVO->get_texto(); ?>
	<input type="hidden" name="idPosts" id="idPosts" value="<?php echo $postVO->get_idPost(); ?>" />
<?php } ?>