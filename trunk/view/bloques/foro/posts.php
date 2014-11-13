<script type="text/javascript">
	var htmlPosts = null;
	var idPosts = null;
	function cargaPost(contenedor)
	{
		htmlPosts = contenedor.responseText;
		if (htmlPosts)
		{
			ocultar("posts");
			setTimeout("document.getElementById('posts').innerHTML = htmlPosts;", 5000);
			setTimeout("idPosts = document.getElementById('idPosts').value; mostrar('posts');", 5001);
			setTimeout("carga('<?php echo $pathRelativo; ?>?m=home/foro/posts\u0026idPost=' + idPosts, 'cargaPost');", 12000);
		}
		else
			carga("<?php echo $pathRelativo; ?>?m=home/foro/posts\u0026reload=on", "cargaPost");
	}
</script>
<div id="posts" style="opacity: 0.0; filter:alpha(opacity=0);">
	<?php include($rootDocumentos . "vistas/html/bloques/foro/postsAjax.php"); ?>
</div>
<script type="text/javascript" src="<?php echo $path_view; ?>js/ajax.js"></script>
<script type="text/javascript" src="<?php echo $path_view; ?>js/opacity.js"></script>
<script type="text/javascript">
	mostrar("posts");
	setTimeout("carga('<?php echo $pathRelativo; ?>?m=home/foro/posts\u0026idPost=<?php echo $postVO->get_idPost(); ?>', 'cargaPost');", 12000);
</script>