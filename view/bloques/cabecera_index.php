<meta http-equiv="Content-Type" content="text/xhtml; charset=utf-8" />
<title><?php
	if (isset($enlace))
		echo formato_html($enlace->h1);
	elseif (isset($imagen))
		echo formato_html($imagen->titulo) . '. REF:' . $imagen->idImagen;
	elseif (isset($contenido))
		echo formato_html($contenido->descripcion);
	elseif (isset($titulo) and $titulo)
		echo formato_html($titulo);
	else
		echo formato_html(TITULO);
	if (isset($menuContenido) and isset($_GET['idMenu']))
		echo ' - ' . formato_html($menuContenido->titulo);
?></title>
<meta name="keywords" content="MyPHP" />
<?php /* <link rel="shortcut icon" href="<?php echo $path_view; ?>favicon.ico" type="image/x-icon" /> */ ?>
<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_RES; ?>css/node.css" />
<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_RES; ?>css/defaults.css" />
<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_RES; ?>css/system.css" />
<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_RES; ?>css/system-menus.css" />
<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_RES; ?>css/user.css" />
<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_RES; ?>css/style.css" />
<script type="text/javascript" src="<?php echo URL_RES; ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo URL_RES; ?>js/drupal.js"></script>
<script type="text/javascript" src="<?php echo URL_RES; ?>js/script.js"></script>
<script type="text/javascript" src="<?php echo URL_RES; ?>js/superfish.js"></script>
<script type="text/javascript" src="<?php echo URL_RES; ?>js/flowplayer-3.2.4.min.js"></script>
<style type="text/css">
	a.myPlayer{display:block;border:1px solid #999;}
	a.myPlayer img{border:0px;}
	a.myPlayer:hover{border:1px solid #000;}
</style>
<link rel="alternate" type="application/atom+xml" title="Feed - Noticias" href="/?m=home/noticias/rss" />
<script type="text/javascript" src="<?php echo URL_RES; ?>js/funciones.js"></script>