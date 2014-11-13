<script type="text/javascript">
	var htmlNews = null;
	var idNews = null;
	function cargaNew(contenedor)
	{
		htmlNews = contenedor.responseText;
		if (htmlNews)
		{
			ocultar("news");
			setTimeout("document.getElementById('news').innerHTML = htmlNews;", 5000);
			setTimeout("idNews = document.getElementById('idNews').value; mostrar('news');", 5001);
			setTimeout("carga('<?php echo $pathRelativo; ?>?m=home/noticias/news\u0026idNoticia=' + idNews, 'cargaNew');", 12000);
		}
		else
			carga("<?php echo $pathRelativo; ?>?m=home/noticias/news\u0026reload=on", "cargaNew");
	}
</script>
<div id="news" style="opacity: 0.0; filter:alpha(opacity=0);">
	<?php include($rootDocumentos . "vistas/html/bloques/noticias/newsAjax.php"); ?>
</div>
<script type="text/javascript" src="<?php echo $path_view; ?>js/ajax.js"></script>
<script type="text/javascript" src="<?php echo $path_view; ?>js/opacity.js"></script>
<script type="text/javascript">
	mostrar("news");
	setTimeout("carga('<?php echo $pathRelativo; ?>?m=home/noticias/news\u0026idNoticia=<?php echo $noticiaVO->get_idNoticia(); ?>', 'cargaNew');", 12000);
</script>