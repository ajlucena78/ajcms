<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Administraci&oacute;n</title>
		<link href="<?php echo URL_RES; ?>css/admin.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="<?php echo URL_RES; ?>js/funciones_capas.js"></script>
		<script type="text/javascript" src="<?php echo URL_RES; ?>js/loader.js"></script>
		<?php
			if (!isset($INCLUYE_TINYMCE))
				$INCLUYE_TINYMCE = false;
			if ($INCLUYE_TINYMCE) { ?>
			<!-- tinyMCE -->
			<script type="text/javascript" 
					src="<?php echo URL_RES; ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
			<script type="text/javascript">
				tinyMCE.init({

					mode : "textareas",
							theme : "advanced",
							plugins : "safari,spellchecker,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,pagebreak",
							theme_advanced_buttons1_add_before : "save,newdocument,separator",
							theme_advanced_buttons1_add : "fontselect,fontsizeselect",
							theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,separator,forecolor,backcolor",
							theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
							theme_advanced_buttons3_add_before : "tablecontrols,separator",
							theme_advanced_buttons3_add : "emotions,iespell,media,advhr,separator,print,separator,ltr,rtl,separator,fullscreen",
							theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,spellchecker,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
							theme_advanced_toolbar_location : "top",
							theme_advanced_toolbar_align : "left",
							theme_advanced_statusbar_location : "bottom",
							content_css : "<?php echo $path_view; ?>css/style.css",
							plugin_insertdate_dateFormat : "%d/%m/%Y",
							plugin_insertdate_timeFormat : "%H:%M:%S",
							theme_advanced_resize_horizontal : false,
							theme_advanced_resizing : true,
							apply_source_formatting : true,
							language : "es",
							valid_elements : "@[id|class|style|title|dir|ltr|rtl|lang|xml::lang|onclick|ondblclick|"
                                + "onmousedown|onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|"
                                + "onkeydown|onkeyup],a[rel|rev|charset|hreflang|tabindex|accesskey|type|"
                                + "name|href|target|title|class|onfocus|onblur],strong/b,em/i,strike,u,"
                                + "#p,-ol[type|compact],-ul[type|compact],-li,br,img[longdesc|usemap|"
                                + "src|border|alt=|title|hspace|vspace|width|height|align],-sub,-sup,"
                                + "-blockquote,-table[border=0|cellspacing|cellpadding|width|frame|rules|"
                                + "height|align|summary|bgcolor|background|bordercolor],-tr[rowspan|width|"
                                + "height|align|valign|bgcolor|background|bordercolor],tbody,thead,tfoot,"
                                + "#td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor"
                                + "|scope],#th[colspan|rowspan|width|height|align|valign|scope],caption,-div,"
                                + "-span,-code,-pre,address,-h1,-h2,-h3,-h4,-h5,-h6,hr[size|noshade],-font[face"
                                + "|size|color],dd,dl,dt,cite,abbr,acronym,del[datetime|cite],ins[datetime|cite],"
                                + "object[classid|width|height|codebase|*],param[name|value|_value],embed[type|width"
                                + "|height|src|*],script[src|type],map[name],area[shape|coords|href|alt|target],bdo,"
                                + "button,col[align|char|charoff|span|valign|width],colgroup[align|char|charoff|span|"
                                + "valign|width],dfn,fieldset,form[action|accept|accept-charset|enctype|method],"
                                + "input[accept|alt|checked|disabled|maxlength|name|readonly|size|src|type|value],"
                                + "kbd,label[for],legend,noscript,optgroup[label|disabled],option[disabled|label|selected|value],"
                                + "q[cite],samp,select[disabled|multiple|name|size],small,"
                                + "textarea[cols|rows|disabled|name|readonly],tt,var,big,iframe[*]"
				});
			</script>
			<!-- /tinyMCE -->
		<?php } ?>
		<link rel="stylesheet" type="text/css" media="all" 
				href="<?php echo URL_RES; ?>js/jscalendar-1.0/calendar-fps.css" />
		<script type="text/javascript" src="<?php echo URL_RES; ?>js/flowplayer-3.2.4.min.js"></script>
		<!-- <link rel="stylesheet" type="text/css" href="<?php echo URL_RES; ?>css/flowplayer.css"> -->
		<style type="text/css">
			a.myPlayer
			{
				display:block;
				border:1px solid #999;
			}
			a.myPlayer img
			{
				margin-top:70px;
				border:0px;
			}
			a.myPlayer:hover
			{
				border:1px solid #000;
			}
		</style>
	</head>
	<body onload="close_loader();">
		<?php if (isset($mensajeEstado) and $mensajeEstado) { ?>
			<script type="text/javascript">
				window.alert("Ok: <?php echo $mensajeEstado;?>");
			</script>
		<?php } ?>
		<?php if (isset($mensajeError) and $mensajeError) { ?>
			<script type="text/javascript">
				window.alert("Error: <?php echo $mensajeError;?>");
			</script>
		<?php } ?>
		<div id="loader">
		</div>
		<div id="alert_loader" style="display: none; top: 300px;">
			<br />
			<img src="<?php echo $path_view; ?>imagenes/ajax/ajax_loading2.gif" border="0" alt="Cargando..." />
			Cargando, por favor espere...
		</div>
		<script type="text/javascript">
			document.getElementById("alert_loader").style.display = "block";
			redim_loader();
		</script>
		<div id="fondo">
			<div id="cabecera">
				<div id="panelCabDerecho">
					<div style="float: left; width: 80px;">
						<img src="<?php echo $path_view; ?>imagenes/admin/iconos/Settings.png" 
								style="height: 60px; vertical-align: middle;" border="0" 
								alt="Panel de administraci&oacute;n" />
					</div>
					<div style="float: left;">
						<h1 style="color: white;">MyPHP <span 
								style="font-size: 0.4em; color: black;">Panel de Administraci&oacute;n</span></h1>
					</div>
				</div>
			</div>
			<div style="clear: left;">
			</div>
			<div id="cabmenu">
				<!-- contenidos -->
				<?php if (strpos($_GET["m"], "admin/contenidos") === 0) { ?>
					<div id="submenu_1" class="menu_activo">
				<?php }else{ ?>
					<div id="submenu_1" class="menu">
				<?php } ?>
					<a href="<?php echo $pathRelativo; ?>?m=admin/contenidos/index">
						<img src="<?php echo $path_view; ?>imagenes/admin/iconos/page.png" border="0" alt="Contenidos" 
								style="vertical-align: middle;" />
						Contenidos
					</a>
				</div>
				<?php if (strpos($_GET["m"], "admin/contenidos") === 0) { ?>
					<?php if ($_GET["m"] == "admin/contenidos/index") { ?>
						<div id="submenu_1_1" class="submenu_activo">
					<?php }else{ ?>
						<div id="submenu_1_1" class="submenu">
					<?php } ?>
						<a href="<?php echo $pathRelativo; ?>?m=admin/contenidos/index">
							<img src="<?php echo $path_view; ?>imagenes/admin/iconos/application_view_list.png" 
									border="0" alt="Consulta de contenidos" style="vertical-align: middle;" />
							Consulta
						</a>
					</div>
					<?php if ($_GET["m"] == "admin/contenidos/alta_contenido") { ?>
						<div id="submenu_1_2" class="submenu_activo">
					<?php }else{ ?>
						<div id="submenu_1_2" class="submenu">
					<?php } ?>
						<a href="<?php echo $pathRelativo; ?>?m=admin/contenidos/alta_contenido">
							<img src="<?php echo $path_view; ?>imagenes/admin/iconos/page_add.png" border="0" 
									alt="Alta de contenido" style="vertical-align: middle;" />
							Nuevo
						</a>
					</div>
					<?php if ($_GET["m"] == "admin/contenidos/edicion_contenido") { ?>
						<div id="submenu_1_3" class="submenu_activo">
							<img src="<?php echo $path_view; ?>imagenes/admin/iconos/page_edit.png" border="0" 
									alt="Edici&oacute;n de contenido" style="vertical-align: middle;" />
							Edici&oacute;n
						</div>
					<?php } ?>
				<?php } ?>
				<!-- enlaces -->
				<?php if (strpos($_GET["m"], "admin/enlaces") === 0) { ?>
					<div id="submenu_2" class="menu_activo">
				<?php }else{ ?>
					<div id="submenu_2" class="menu">
				<?php } ?>
					<a href="<?php echo $pathRelativo; ?>?m=admin/enlaces/index">
						<img src="<?php echo $path_view; ?>imagenes/admin/iconos/link.png" border="0" alt="Enlaces" 
								style="vertical-align: middle;" />
						Enlaces
					</a>
				</div>
				<?php if (strpos($_GET["m"], "admin/enlaces") === 0) { ?>
					<?php if ($_GET["m"] == "admin/enlaces/index") { ?>
						<div id="submenu_2_1" class="submenu_activo">
					<?php }else{ ?>
						<div id="submenu_2_1" class="submenu">
					<?php } ?>
						<a href="<?php echo $pathRelativo; ?>?m=admin/enlaces/index">
							<img src="<?php echo $path_view; ?>imagenes/admin/iconos/application_view_list.png" 
									border="0" alt="Consulta de enlaces" style="vertical-align: middle;" />
							Consulta
						</a>
					</div>
					<?php if ($_GET["m"] == "admin/enlaces/alta_enlace") { ?>
						<div id="submenu_2_2" class="submenu_activo">
					<?php }else{ ?>
						<div id="submenu_2_2" class="submenu">
					<?php } ?>
						<a href="<?php echo $pathRelativo; ?>?m=admin/enlaces/alta_enlace">
							<img src="<?php echo $path_view; ?>imagenes/admin/iconos/link_add.png" border="0" 
									alt="Alta de enlace" style="vertical-align: middle;" />
							Nuevo
						</a>
					</div>
					<?php if ($_GET["m"] == "admin/enlaces/edicion_enlace") { ?>
						<div id="submenu_2_3" class="submenu_activo">
							<img src="<?php echo $path_view; ?>imagenes/admin/iconos/link_edit.png" border="0" 
									alt="Edici&oacute;n de enlace" style="vertical-align: middle;" />
							Edici&oacute;n
						</div>
					<?php } ?>
				<?php } ?>
				<!-- menus -->
				<?php if (strpos($_GET["m"], "admin/menus") === 0) { ?>
					<div id="submenu_3" class="menu_activo">
				<?php }else{ ?>
					<div id="submenu_3" class="menu">
				<?php } ?>
					<a href="<?php echo $pathRelativo; ?>?m=admin/menus/index">
						<img src="<?php echo $path_view; ?>imagenes/admin/iconos/book.png" border="0" 
								alt="Men&uacute;s" style="vertical-align: middle;" />
						Men&uacute;s
					</a>
				</div>
				<!-- noticias -->
				<?php if (strpos($_GET["m"], "admin/noticias") === 0) { ?>
					<div id="submenu_4" class="menu_activo">
				<?php }else{ ?>
					<div id="submenu_4" class="menu">
				<?php } ?>
					<a href="<?php echo $pathRelativo; ?>?m=admin/noticias/index">
						<img src="<?php echo $path_view; ?>imagenes/admin/iconos/feed.png" border="0" 
								alt="noticias" style="vertical-align: middle;" />
						Noticias
					</a>
				</div>
				<?php if (strpos($_GET["m"], "admin/noticias") === 0) { ?>
					<?php if ($_GET["m"] == "admin/noticias/index") { ?>
						<div id="submenu_4_1" class="submenu_activo">
					<?php }else{ ?>
						<div id="submenu_4_1" class="submenu">
					<?php } ?>
						<a href="<?php echo $pathRelativo; ?>?m=admin/noticias/index">
							<img src="<?php echo $path_view; ?>imagenes/admin/iconos/application_view_list.png" 
									border="0" alt="Consulta de noticias" style="vertical-align: middle;" />
							Consulta
						</a>
					</div>
					<?php if ($_GET["m"] == "admin/noticias/alta_noticias") { ?>
						<div id="submenu_4_2" class="submenu_activo">
					<?php }else{ ?>
						<div id="submenu_4_2" class="submenu">
					<?php } ?>
						<a href="<?php echo $pathRelativo; ?>?m=admin/noticias/alta_noticia">
							<img src="<?php echo $path_view; ?>imagenes/admin/iconos/feed_add.png" border="0" 
									alt="Alta de noticia" style="vertical-align: middle;" />
							Nueva
						</a>
					</div>
					<?php if ($_GET["m"] == "admin/noticias/edicion_noticia") { ?>
						<div id="submenu_4_3" class="submenu_activo">
							<img src="<?php echo $path_view; ?>imagenes/admin/iconos/feed_edit.png" border="0" 
									alt="Edici&oacute;n de noticia" style="vertical-align: middle;" />
							Edici&oacute;n
						</div>
					<?php } ?>
				<?php } ?>
				<!-- facebook -->
				<?php if (strpos($_GET["m"], "admin/facebook") === 0) { ?>
					<div id="submenu_5" class="menu_activo">
				<?php }else{ ?>
					<div id="submenu_5" class="menu">
				<?php } ?>
					<a href="https://www.facebook.com" target="_blank">
						<img src="<?php echo $path_view; ?>imagenes/web/facebook.png" border="0" 
								alt="Facebook" style="vertical-align: middle;" />
						Facebook
					</a>
				</div>
				<!-- correos -->
				<?php if ($_SESSION['usuario']->get_idPermiso() == PERMISO_ADMINISTRADOR) { ?>
					<?php if (strpos($_GET["m"], "admin/correos") === 0) { ?>
						<div id="submenu_6" class="menu_activo">
					<?php }else{ ?>
						<div id="submenu_6" class="menu">
					<?php } ?>
						<a href="<?php echo $pathRelativo; ?>?m=admin/correos/index">
							<img src="<?php echo $path_view; ?>imagenes/admin/iconos/email.png" border="0" 
									alt="Env&iacute;o de correo" style="vertical-align: middle;" />
							Env&iacute;o de correo
						</a>
					</div>
					<?php if (strpos($_GET["m"], "admin/correos") === 0) { ?>
						<?php if ($_GET["m"] == "admin/correos/index") { ?>
							<div id="submenu_6_1" class="submenu_activo">
						<?php }else{ ?>
							<div id="submenu_6_1" class="submenu">
						<?php } ?>
							<a href="<?php echo $pathRelativo; ?>?m=admin/correos/index">
								<img src="<?php echo $path_view; ?>imagenes/admin/iconos/application_view_list.png" 
										border="0" alt="Consulta de mensajes" style="vertical-align: middle;" />
								Mensajes
							</a>
						</div>
						<?php if ($_GET["m"] == "admin/correos/alta_mensaje") { ?>
							<div id="submenu_6_2" class="submenu_activo">
						<?php }else{ ?>
							<div id="submenu_6_2" class="submenu">
						<?php } ?>
							<a href="<?php echo $pathRelativo; ?>?m=admin/correos/alta_mensaje">
								<img src="<?php echo $path_view; ?>imagenes/admin/iconos/email_add.png" border="0" 
										alt="Nuevo mensaje" style="vertical-align: middle;" />
								Nuevo mensaje
							</a>
						</div>
						<?php if ($_GET["m"] == "admin/correos/edicion_mensaje") { ?>
							<div id="submenu_6_3" class="submenu_activo">
								<img src="<?php echo $path_view; ?>imagenes/admin/iconos/email_edit.png" border="0" 
										alt="Edici&oacute;n de mensaje" style="vertical-align: middle;" />
								Edici&oacute;n de mensaje
							</div>
						<?php } ?>
						<?php if ($_GET["m"] == "admin/correos/envios") { ?>
							<div id="submenu_6_4" class="submenu_activo">
						<?php }else{ ?>
							<div id="submenu_6_4" class="submenu">
						<?php } ?>
							<a href="<?php echo $pathRelativo; ?>?m=admin/correos/envios">
								<img src="<?php echo $path_view; ?>imagenes/admin/iconos/application_view_list.png" 
										border="0" alt="Consulta de env&iacute;os" style="vertical-align: middle;" />
								Env&iacute;os
							</a>
						</div>
						<?php if ($_GET["m"] == "admin/correos/programa" 
								or $_GET["m"] == "admin/correos/edicion_programa") { ?>
							<div id="submenu_6_5" class="submenu_activo">
						<?php }else{ ?>
							<div id="submenu_6_5" class="submenu">
						<?php } ?>
							<a href="<?php echo $pathRelativo; ?>?m=admin/correos/programa">
								<img src="<?php echo $path_view; ?>imagenes/admin/iconos/email_go.png" border="0" 
										alt="Programar env&iacute;o" style="vertical-align: middle;" />
								Programar env&iacute;o
							</a>
						</div>
						<?php if ($_GET["m"] == "admin/correos/listas") { ?>
							<div id="submenu_6_6" class="submenu_activo">
						<?php }else{ ?>
							<div id="submenu_6_6" class="submenu">
						<?php } ?>
							<a href="<?php echo $pathRelativo; ?>?m=admin/correos/listas">
								<img src="<?php echo $path_view; ?>imagenes/admin/iconos/book_addresses.png" border="0" 
										alt="Listas de correos" style="vertical-align: middle;" />
								Listas de correos
							</a>
						</div>
						<?php if ($_GET["m"] == "admin/correos/alta_lista") { ?>
							<div id="submenu_6_7" class="submenu_activo">
						<?php }else{ ?>
							<div id="submenu_6_7" class="submenu">
						<?php } ?>
							<a href="<?php echo $pathRelativo; ?>?m=admin/correos/alta_lista">
								<img src="<?php echo $path_view; ?>imagenes/admin/iconos/page_add.png" border="0" 
										alt="Nueva lista de correo" style="vertical-align: middle;" />
								Nueva lista
							</a>
						</div>
						<?php if ($_GET["m"] == "admin/correos/edicion_lista" 
								or $_GET["m"] == "admin/correos/alta_correo" 
								or $_GET["m"] == "admin/correos/edicion_correo"
								or $_GET["m"] == "admin/correos/baja_correo") { ?>
							<div id="submenu_6_8" class="submenu_activo">
								<img src="<?php echo $path_view; ?>imagenes/admin/iconos/page_edit.png" border="0" 
										alt="Edici&oacute;n de lista de correo" style="vertical-align: middle;" />
								Edici&oacute;n de lista
							</div>
						<?php } ?>
					<?php } ?>
				<?php } ?>
				<!-- ofertas -->
				<?php if (strpos($_GET["m"], "admin/ofertas") === 0) { ?>
					<div id="submenu_1" class="menu_activo">
				<?php }else{ ?>
					<div id="submenu_1" class="menu">
				<?php } ?>
					<a href="<?php echo $pathRelativo; ?>?m=admin/ofertas/index">
						<img src="<?php echo $path_view; ?>imagenes/admin/iconos/award_star_gold.png" border="0" 
								alt="Ofertas" style="vertical-align: middle;" />
						Ofertas
					</a>
				</div>
				<?php if (strpos($_GET["m"], "admin/ofertas") === 0) { ?>
					<?php if ($_GET["m"] == "admin/ofertas/index") { ?>
						<div id="submenu_1_1" class="submenu_activo">
					<?php }else{ ?>
						<div id="submenu_1_1" class="submenu">
					<?php } ?>
						<a href="<?php echo $pathRelativo; ?>?m=admin/ofertas/index">
							<img src="<?php echo $path_view; ?>imagenes/admin/iconos/page_white_star.png" 
									border="0" alt="Consulta de ofertas" style="vertical-align: middle;" />
							Consulta
						</a>
					</div>
					<?php if ($_GET["m"] == "admin/ofertas/alta_oferta") { ?>
						<div id="submenu_1_2" class="submenu_activo">
					<?php }else{ ?>
						<div id="submenu_1_2" class="submenu">
					<?php } ?>
						<a href="<?php echo $pathRelativo; ?>?m=admin/ofertas/alta_oferta">
							<img src="<?php echo $path_view; ?>imagenes/admin/iconos/award_star_add.png" border="0" 
									alt="Alta de oferta" style="vertical-align: middle;" />
							Nueva
						</a>
					</div>
					<?php if ($_GET["m"] == "admin/ofertas/edicion_oferta") { ?>
						<div id="submenu_1_3" class="submenu_activo">
							<img src="<?php echo $path_view; ?>imagenes/admin/iconos/page_edit.png" border="0" 
									alt="Edici&oacute;n de oferta" style="vertical-align: middle;" />
							Edici&oacute;n
						</div>
					<?php } ?>
				<?php } ?>
				<!-- desconectar -->
				<div id="logout" class="menu">
					<a href="<?php echo $pathRelativo; ?>?m=admin/desconectar">
						<img src="<?php echo $path_view; ?>imagenes/admin/iconos/cancel.png" border="0" 
								alt="Desconectar" style="vertical-align: middle;" />
						Desconectar
					</a>
				</div>
			</div>
			<div id="contenido">
				<img src="<?php echo $path_view; ?>imagenes/admin/panel_borde.jpg" alt="Borde" 
						style="vertical-align: top; border: 0px;" />
				<div id="contenido_interior">