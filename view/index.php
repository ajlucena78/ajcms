<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
			"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
	<head>
		<?php include PATH_VIEW . 'bloques/google_tag_manager_head.php'; ?>
		<?php if (isset($imagen)) { ?>
			<meta name="description" content="<?php echo str_replace('"', "'", $imagen->titulo); ?>. REF:<?php 
					echo $imagen->idImagen; ?>. <?php 
					if (isset($contenido) and $contenido) echo $contenido->encabezado; ?>" />
		<?php } elseif (isset($contenido) and $contenido->tipo != CONTENIDO_FICHERO) { ?>
			<?php if (isset($enlace)) { ?>
				<meta name="description" content="<?php echo str_replace('"', "'", $enlace->metadesc); ?>" />
			<?php } elseif ($contenido->metadesc){ ?>
				<meta name="description" content="<?php echo str_replace('"', "'", $contenido->metadesc); ?>" />
			<?php } elseif (!isset($_GET['permalink']) or $_GET['permalink'] == '') { ?>
				<meta name="description" content="MyPHP" />
			<?php } else { ?>
				<meta name="description" content="<?php 
						if (isset($menuContenido) and isset($_GET['idMenu']))
						{
							echo $menuContenido->titulo . ': ';
						}
						$res = $contenido->texto . $contenido->texto2 . $contenido->pie;
						$res = $contenido->texto_procesado(null, null, $res, false);
						echo str_replace("\r\n", " ", str_replace('"', "'"
								, substr(formato_texto(strip_tags($res)), 0, 200))) . "..."; ?>" />
			<?php } ?>
		<?php } ?>
		<?php include(PATH_VIEW . "/bloques/cabecera_index.php") ?>
		<script type="text/javascript" src="<?php echo URL_RES; ?>js/funciones_capas.js"></script>
		<script type="text/javascript" src="<?php echo URL_RES; ?>js/imagenes.js"></script>
		<script type="text/javascript" src="<?php echo URL_RES; ?>js/opacity.js"></script>
		<script type="text/javascript">
			function reload_win()
			{
				reloadwin();
			}
			window.onresize = reload_win;
		</script>
		<script type="text/javascript" src="<?php echo URL_RES; ?>js/scrollwin.js"></script>
		<script type="text/javascript">
			function scroll_win()
			{
				scrollwin();
			}
			window.onscroll = scroll_win;
		</script>
	</head>
	<body class="logged-in front layout-first-main" onkeydown="mover_imagen(event);">
		<?php include PATH_VIEW . 'bloques/google_tag_manager_body.php'; ?>
		<div id="fondo_imagenes" style="display: none; position: absolute; width: 100%; z-index: 100;
				height: 100%; background-color: black; opacity: .5; filter: alpha(opacity=50); position: fixed;"
				onclick="quitar_imagen();">
		</div>
		<div id="imagenes" style="display: none; position: fixed; height: 100%; width: 100%; left: 0; top: 0;
				z-index: 101;">
			<div style="display: table-cell; position: static; text-align: center; vertical-align: middle;">
				<div style="margin: 0 auto; position: relative; z-index: 101; background-color: white;
						width: 920px; height: 580px; padding: 6px;">
					<div id="capa_imagen" style="position: relative;">
						<div>
							<div style="float: left; height: 100%; margin: auto; margin-top: 45pt;">
								<img onclick="ver_anterior();" style="cursor: pointer;" 
										src="<?php echo URL_RES; ?>imagenes/web/flecha_izq.png" 
												alt="Ver la imagen anterior" />
							</div>
							<div style="float: left; width: 740px;">
								<div id="capa_solo_imagen">
									<img id="imagen" src="javascript:void();" 
											alt="Clic en la imagen para cerrar" 
											title="Clic en la imagen para cerrar" onclick="quitar_imagen();" />
								</div>
								<div id="loading_image" style="position: absolute; left: 350px; top: 150px; 
										opacity: .7; filter: alpha(opacity=70); display: none;">
									<img src="<?php echo URL_RES; ?>imagenes/web/loading.gif" 
											alt="Cargando" />
								</div>
							</div>
							<div style="float: right;  margin-top: 45pt;">
								<img onclick="ver_siguiente();" style="cursor: pointer;" src="<?php 
										echo URL_RES; ?>imagenes/web/flecha_der.png" 
										alt="Ver la imagen siguiente" />
							</div>
						</div>
						<div id="capa_titulo_imagen" 
								style="text-align: center; background-color: white; clear: left;">
							<span id="titulo_imagen" style="color: black;"></span>
							<span><strong><a href="javascript:quitar_imagen();">[Cerrar]</a></strong></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php if (!isset($_SESSION['uso_cookies'])) { ?>
			<div style="background: #F3F781; text-align: center; width: 100%; z-index: 200;">
				<div style="background: url(<?php echo URL_RES; ?>imagenes/web/pixel-blanco.png) top left repeat; padding: 1%;">
					<div style="float: left; width: 70%;">
						<strong>USO DE COOKIES: Usamos cookies propias y de terceros para mejorar la 
						prestaci&oacute;n de nuestros servicios. Al utilizar nuestros servicios, aceptas el uso 
						que hacemos de las cookies. <a href="<?php echo URL_APP; 
						?>informacion-cookies">M&aacute;s informaci&oacute;n</a></strong>.
					</div>
					<div style="float: right; width: 30%; margin-top: 1%;">
						<form action="<?php echo URL_APP; ?>aceptar-cookies.php">
							<input type="submit" value="Aceptar y no mostrar mensaje" class="form-submit" />
						</form>
					</div>
					<div style="clear: both;"></div>
				</div>
			</div>
		<?php } ?>
		<div id="page" class="clearfix">
			<div id="foto-fondo-motos">
				<?php include PATH_VIEW . 'bloques/cabecera.php'; ?>
				<?php include PATH_VIEW . 'bloques/pestanas.php'; ?>
			</div>
			<div id="main-wrapper" <?php if (isset($colorFondo)){ 
					echo "style=\"background-color: $colorFondo;\"";} ?>>
				<div id="main" class="clearfix">
					<?php include PATH_VIEW . 'bloques/menu_izq.php'; ?>
					<div id="content-wrapper">
						<div id="content">
							<div id="content-inner">
								<div id="content-content">
									<div id="first-time">
										<?php if (isset($FILE_VIEW)) { ?>
											<?php include($FILE_VIEW); ?>
										<?php }else{ ?>
											<?php if ($contenido->descripcion) { ?>
												<h1 class="title">
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
												<?php echo $contenido->texto_procesado(null, null, $contenido->texto, false, $i); ?>
												<?php echo $contenido->texto_procesado(null, null, $contenido->texto2, false, $i); ?>
												<?php include PATH_VIEW . 'bloques/categorias.php'; ?>
												<?php echo $contenido->texto_procesado(null, null, '', true, $i); ?>
												<?php echo $contenido->texto_procesado(null, null, $contenido->pie, false, $i); ?>
											<?php } ?>
											<div style="text-align: center; margin-top: 20px;">
												<script src="http://connect.facebook.net/es_ES/all.js#xfbml=1" 
														type="text/javascript"></script>
												<script type="text/javascript" src="<?php 
														echo URL_RES; ?>js/facebook.js"></script>
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
						<div id="footer" class="clearfix">
							<?php include PATH_VIEW . 'bloques/pie_index.php'; ?>
						</div>
					</div>
				</div>
			</div>
			<?php include PATH_VIEW . 'bloques/pie.php'; ?>
		</div>
		<script type="text/javascript">
			reload_win();
			scroll_win();
		</script>
		<?php include(PATH_VIEW . "/bloques/analytics.php") ?>
	</body>
</html>