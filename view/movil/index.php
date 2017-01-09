<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include PATH_VIEW . 'bloques/google_tag_manager_head.php'; ?>
		<meta http-equiv="Content-Type" content="text/xhtml; charset=utf-8" />
		<title><?php
			if (isset($enlace))
				echo formato_html($enlace->h1);
			elseif (isset($imagen))
				echo formato_html($imagen->titulo) . '. REF:' . $imagen->idImagen;
			elseif (isset($contenido))
				echo formato_html($contenido->descripcion);
			else
				echo formato_html(TITULO);
			if (isset($menuContenido) and isset($_GET['idMenu']))
				echo ' - ' . formato_html($menuContenido->titulo);
		?></title>
		<meta name="keywords" content="MyPHP" />
		<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_RES; ?>css/movil.css" />
		<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_RES; ?>css/slidesjs.css" />
		<?php if (isset($imagen)) { ?>
			<meta name="description" content="<?php echo str_replace('"', "'", $imagen->titulo); ?>. REF:<?php 
					echo $imagen->idImagen; ?>. <?php 
					if (isset($contenido) and $contenido) echo $contenido->encabezado; ?>" />
		<?php } elseif (isset($contenido) and $contenido->tipo != CONTENIDO_FICHERO) { ?>
			<?php $res = $contenido->texto_procesado_movil($contenido->texto . $contenido->texto2 
					. $contenido->pie, false); ?>
			<?php if (isset($enlace)) { ?>
				<meta name="description" content="<?php echo str_replace('"', "'", $enlace->metadesc); ?>" />
			<?php }elseif ($contenido->metadesc){ ?>
				<meta name="description" content="<?php echo str_replace('"', "'", $contenido->metadesc); ?>" />
			<?php }elseif (!isset($_GET['permalink']) or $_GET['permalink'] == '') { ?>
				<meta name="description" content="MyPHP" />
			<?php }else{ ?>
				<meta name="description" content="<?php 
						if (isset($menuContenido) and isset($_GET['idMenu']))
							echo $menuContenido->titulo . ': ';
						echo str_replace("\r\n", " ", str_replace('"', "'"
								, substr(formato_texto(strip_tags($res)), 0, 200))) . "..."; ?>" />
			<?php } ?>
		<?php } ?>
		<script type="text/javascript" src="<?php echo URL_RES; ?>js/ajax.js"></script>
		<script type="text/javascript" src="<?php echo URL_RES; ?>js/funciones.js"></script>
		<script type="text/javascript" src="<?php echo URL_RES; ?>js/funciones_capas.js"></script>
		<script type="text/javascript" src="<?php echo URL_RES; ?>js/movil.js"></script>
		<script type="text/javascript">
			function reload_win()
			{
				reloadwin();
			}
			window.onresize = reload_win;
			function scroll_win()
			{
				scrollwin();
			}
			window.onscroll = scroll_win;
		</script>
	</head>
	<body>
		<?php include PATH_VIEW . 'bloques/google_tag_manager_body.php'; ?>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.8";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		<?php if (!isset($_SESSION['uso_cookies'])) { ?>
			<div id="cookies">
				<strong>USO DE COOKIES:</strong> Usamos cookies propias y de terceros para mejorar la 
				prestaci&oacute;n de nuestros servicios. Al utilizar nuestros servicios, aceptas el uso 
				que hacemos de las cookies. <a href="<?php echo URL_APP; ?>informacion-cookies">M&aacute;s 
				informaci&oacute;n</a>.
				<br />
				<a href="<?php echo URL_APP; ?>aceptar-cookies.php">
					<strong>ACEPTO LAS COOKIES (Cerrar mensaje)</strong>
				</a>
			</div>
		<?php } ?>
		<div id="top">
			<div id="logo">
				<a href="<?php echo URL_APP; ?>" style="width: 70%; float: left; padding-bottom: 5pt;">
					<img src="<?php echo URL_RES; ?>imagenes/web/logo_m.png" alt="Logo de COTA CERO" 
							style="width: 100%;" />
				</a>
				<a href="<?php vlink('menu'); ?>" style="color: black; float: right; width: 30%; 
						text-align: right; padding-top: 10pt;">
					<strong>MEN&Uacute;</strong> 
					<img src="<?php echo URL_RES; ?>imagenes/web/menu_m.jpg" alt="Menu" style="width: 20%;" />
				</a>
			</div>
			<div style="clear: both;"></div>
			<div id="preface"></div>
		</div>
		<div class="texto_cen" style="font-size: 140%; margin-top: 10pt;">
			<!--
			<img src="<?php echo URL_RES; ?>imagenes/web/tfno_icono.png" style="vertical-align: middle;" 
					alt="Tel&eacute;fonos de contacto" />
			<span style="font-weight: bold;">
				<a href="tel:"></a>
			</span>
			-->
		</div>
		<?php if (isset($FILE_VIEW)) { ?>
			<?php include($FILE_VIEW); ?>
		<?php }else{ ?>
			<div>
				<?php if ($contenido->descripcion) { ?>
					<h1>
						<?php
							if ($contenido->tipo == 0)
							{
								if (isset($enlace))
								{
									echo formato_html($enlace->h1);
								}
								elseif ($contenido->encabezado)
								{
									echo formato_html($contenido->encabezado);
								}
							}
							else
								echo formato_html($contenido->descripcion);
						?>
					</h1>
				<?php } ?>
				<?php if ($contenido->tipo == CONTENIDO_FICHERO) { ?>
					<?php include(APP_ROOT . "modulos/" . $contenido->ruta . ".php"); ?>
				<?php }else{ ?>
					<?php $i = 0; ?>
					<?php if ($contenido->texto and $contenido->textoMovil) { ?>
						<div class="texto_mas_visible div">
							<?php echo $contenido->texto_procesado_movil($contenido->texto, false, $i); ?>
						</div>
					<?php } ?>
					<?php if (($contenido->texto and !$contenido->textoMovil) or $contenido->texto2) { ?>
						<div id="leer_mas_boton" class="div" style="margin-top: 10pt;">
							<a href="javascript:leer_mas_movil();">[ + ] Leer m&aacute;s informaci&oacute;n</a>
						</div>
						<div id="mas_info_movil" class="texto_mas div">
							<?php if (!$contenido->textoMovil) 
									echo $contenido->texto_procesado_movil($contenido->texto, false, $i); ?>
							<?php echo $contenido->texto_procesado_movil($contenido->texto2, false, $i); ?>
						</div>
					<?php }else{ ?>
						<div id="leer_mas_boton"></div>
					<?php } ?>
					<?php include PATH_VIEW . 'movil/categorias.php'; ?>
					<?php echo $contenido->texto_procesado_movil('', true, $i); ?>
					<?php if (trim($contenido->pie)) { ?>
						<?php if ($contenido->pieMovil) { ?>
							<div class="texto_mas_visible div">
								<?php echo $contenido->texto_procesado_movil($contenido->pie, false, $i); ?>
							</div>
						<?php } else { ?>
							<div id="leer_mas_boton2" class="div">
								<a href="javascript:leer_pie_movil();">[ + ] Leer m&aacute;s 
										informaci&oacute;n</a>
							</div>
							<div id="mas_info_movil2" class="texto_mas div" style="margin-top: 5pt;">
								<?php echo $contenido->texto_procesado_movil($contenido->pie, false, $i); ?>
							</div>
						<?php } ?>
					<?php } else { ?>
						<div id="leer_mas_boton"></div>
					<?php } ?>
				<?php } ?>
			</div>
		<?php } ?>
		<div style="height: 10pt;"></div>
		<div class="fb-like" data-href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" data-layout="button_count" data-action="like" 
				data-show-faces="false" data-share="false"></div>
		<div style="height: 10pt;"></div>
		<?php if (!isset($menuCont) or count($menuCont->hijos) == 0) { ?>
			<?php if (isset($menuContenido) and (count($menuContenido->hijos) > 0 or (isset($menuContenidoPadre) 
					and count($menuContenidoPadre->hijos) > 0))) { ?>
				<?php if (isset($menuContenidoPadre) and count($menuContenidoPadre->hijos) > 0) { ?>
					<?php foreach ($menuContenidoPadre->hijos as $submenuPadre) { ?>
						<?php if ($submenuPadre->idMenu == $menuContenido->idMenu) { ?>
							<?php if (count($menuContenido->hijos) > 0) { ?>
								<?php foreach ($menuContenido->hijos as $submenu) { ?>
									<hr />
									<div class="menu">
										<?php if (isset($contenido->menus[0]) 
												and $submenu->idMenu == $contenido->menus[0]->idMenu) { ?>
											<span style="color: #999;">
												<?php echo formato_html($submenu->titulo); ?>
											</span>
										<?php }else{ ?>
											<a href="<?php echo $submenu->enlace(); ?>" >
												<?php echo formato_html($submenu->titulo); ?>
											</a>
										<?php } ?>
									</div>
								<?php } ?>
							<?php } ?>
						<?php } ?>
					<?php } ?>
				<?php }elseif (count($menuContenido->hijos) > 0) { ?>
					<?php foreach ($menuContenido->hijos as $submenu) { ?>
						<hr />
						<div class="menu">
							<?php if (isset($contenido->menus[0]) 
									and $submenu->idMenu == $contenido->menus[0]->idMenu) { ?>
								<span style="color: #999;">
									<?php echo formato_html($submenu->titulo); ?>
								</span>
							<?php }else{ ?>
								<a href="<?php echo $submenu->enlace(); ?>" >
									<?php echo formato_html($submenu->titulo); ?>
								</a>
							<?php } ?>
						</div>
						<?php /* if (count($submenu->hijos) > 0) { ?>
							<?php foreach ($submenu->hijos as $submenu2) { ?>
								<hr />
								<div class="menu">
									<a href="<?php echo $submenu2->enlace(); ?>" style="color: gray;">
										<?php echo formato_html($submenu2->titulo); ?>
									</a>
								</div>
							<?php } ?>
						<?php } */ ?>
					<?php } ?>
				<?php } ?>
			<?php } ?>
		<?php } ?>
		<?php if (isset($menus) and count($menus) > 0) { ?>
			<?php $cont = 0; ?>
			<?php foreach ($menus as $menu) { ?>
				<hr />
				<div class="menu2">
					<a href="<?php echo $menu->enlace(); ?>" <?php if (!$cont) { ?>style="color: red;"<?php } ?>>
						<?php echo formato_html($menu->titulo); ?>
					</a>
				</div>
				<?php $cont++; ?>
			<?php } ?>
		<?php } ?>
		<hr />
		<div class="menu2">
			<a href="<?php echo URL_APP; ?>aviso-legal">AVISO LEGAL</a>
		</div>
		<hr />
		<div class="menu2">
			<a href="<?php echo URL_APP; ?>informacion-cookies">INFORMACI&Oacute;N SOBRE EL USO DE COOKIES</a>
		</div>
		<hr />
		<div class="menu2">
			<a href="<?php echo URL_APP; ?>politica-calidad-medio-ambiente">POL&Iacute;TICA DE CALIDAD Y MEDIO 
			AMBIENTE</a>
		</div>
		<hr />
		<div class="menu2">
			<?php if (isset($_SESSION['usuario'])) { ?>
				<span style="font-weight: bold;"><?php echo $_SESSION['usuario']->login; ?></span>
				<a href="<?php echo link_action('logout'); ?>">[ <span 
						style="color: red;">Cerrar sesi&oacute;n</span> ]</a>
			<?php } else { ?>
				<a href="<?php echo link_action('inicio-sesion'); ?>">
					<span style="font-weight: bold;">Acceso para socios</span>
				</a>
			<?php } ?>
		</div>
		<hr />
		<div class="pie">
			<strong>MyPHP</strong>
		</div>
		<script type="text/javascript">
			reloadwin();
			scrollwin();
		</script>
		<?php include PATH_VIEW . 'bloques/analytics.php'; ?>
	</body>
</html>