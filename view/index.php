<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
			"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
	<head>
		<?php if (isset($contenido) and $contenido->tipo != CONTENIDO_FICHERO) { ?>
			<?php $res = $contenido->texto_procesado(); ?>
			<meta name="description" content="<?php echo str_replace("\r\n", " "
					, substr(formato_html(strip_tags($res)), 0, 200)) . "..."; ?>" />
		<?php } ?>
		<?php include PATH_VIEW . 'bloques/cabecera_index.php'; ?>
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
	<body>
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
							<div style="float: left; height: 100%; margin: auto;">
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
							<div style="float: right;">
								<img onclick="ver_siguiente();" style="cursor: pointer;"
										src="<?php echo URL_RES; ?>imagenes/web/flecha_der.png" 
										alt="Ver la imagen siguiente" />
							</div>
						</div>
						<div id="capa_titulo_imagen" style="text-align: center; background-color: white; 
								clear: left;">
							<span id="titulo_imagen" style="color: black;"></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php if (!isset($_SESSION['uso_cookies'])) { ?>
			<div style="position: fixed; background: url(<?php echo URL_RES; ?>imagenes/web/pixel-blanco.png) 
					top left repeat; text-align: center; width: 100%; z-index: 200;">
				<div style="background: url(<?php echo URL_RES; ?>imagenes/web/pixel-blanco.png) top left 
						repeat; padding: 1%;">
					<div style="float: left; width: 70%;">
						<strong>USO DE COOKIES: Usamos cookies propias y de terceros para mejorar la 
						prestaci&oacute;n de nuestros servicios. Al utilizar nuestros servicios, aceptas el uso 
						que hacemos de las cookies. <a 
						href="/?referencia=cookie">M&aacute;s informaci&oacute;n</a></strong>.
					</div>
					<div style="float: right; width: 30%; margin-top: 1%;">
						<form action="<?php echo URL_APP; ?>aceptar-cookies.php">
							<input type="submit" value="Aceptar" class="form-submit" style="width: 30%;" />
						</form>
					</div>
					<div style="clear: both;"></div>
				</div>
			</div>
		<?php } ?>
		<div>
			<?php include PATH_VIEW . 'bloques/cabecera.php'; ?>
			<?php include PATH_VIEW . 'bloques/pestanas.php'; ?>
			<div>
				<?php include PATH_VIEW . 'bloques/menu_izq.php'; ?>
				<div>
					<?php if (isset($FILE_VIEW)) { ?>
						<?php include($FILE_VIEW); ?>
					<?php }else{ ?>
						<?php if ($contenido->descripcion) { ?>
							<h1 class="title">
								<?php
									if ($contenido->tipo == 0 and $contenido->encabezado)
										echo formato_html($contenido->encabezado);
									else
										echo formato_html($contenido->descripcion);
								?>
							</h1>
						<?php } ?>
						<?php if ($contenido->tipo == CONTENIDO_FICHERO) { ?>
							<?php include(APP_ROOT . "modulos/" . $contenido->ruta . ".php"); ?>
						<?php }else{ ?>
							<?php echo $res; ?>
						<?php } ?>
						<div style="text-align: center; margin-top: 20px;">
							<script src="http://connect.facebook.net/es_ES/all.js#xfbml=1" 
									type="text/javascript"></script>
							<script type="text/javascript" 
									src="<?php echo URL_RES; ?>js/facebook.js"></script>
						</div>
					<?php } ?>
					<div>
						<?php include PATH_VIEW . 'bloques/pie_index.php'; ?>
					</div>
				</div>
			</div>
			<?php include PATH_VIEW . 'bloques/pie.php'; ?>
		</div>
		<script type="text/javascript">
			reload_win();
			scroll_win();
		</script>
	</body>
</html>