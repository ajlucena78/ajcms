<div id="sidebar-first">
	<div id="menu_izq" style="position: relative;">
		<div id="logo_menu" style="display: none;">
			<a href="/" title="Ir a la p&aacute;gina principal">
				<img src="<?php echo URL_RES; ?>imagenes/web/logo_m.png" style="width: 100%;" 
						alt="Logo de MyPHP" />
			</a>
		</div>
		<?php if (isset($menuContenido) and (count($menuContenido->hijos) > 0 or (isset($menuContenidoPadre) 
				and count($menuContenidoPadre->hijos) > 0))) { ?>
			<div class="block-wrapper odd" id="panel_menu_izq">
				<div class="rounded-block">
					<div class="rounded-block-top-left"></div>
					<div class="rounded-block-top-right"></div>
					<div class="rounded-outside">
						<div class="rounded-inside">
							<p class="rounded-topspace"></p>
							<div id="block-user-1" class="block block-user">
								<div class="block-icon pngfix">
								</div>
								<div class="title block-title pngfix"><?php 
										echo formato_html($menuContenido->titulo); ?></div>
								<div class="content">
									<?php if (isset($menuContenidoPadre) 
											and count($menuContenidoPadre->hijos) > 0) { ?>
										<?php foreach ($menuContenidoPadre->hijos as $submenuPadre) { ?>
											<?php if ($submenuPadre->idMenu == $menuContenido->idMenu) { ?>
												<?php if (count($menuContenido->hijos) > 0) { ?>
													<ul class="menu">
														<?php foreach ($menuContenido->hijos as $submenu) { ?>
															<li>
																<?php if (isset($contenido->menus[0]) 
																		and $submenu->idMenu == $contenido->menus[0]->idMenu) { ?>
																	<span style="color: #999; font-weight: bold;">
																		<?php echo formato_html($submenu->titulo); ?>
																	</span>
																<?php }else{ ?>
																	<a href="<?php echo $submenu->enlace(); ?>" >
																		<?php echo formato_html($submenu->titulo); ?>
																	</a>
																<?php } ?>
															</li>
														<?php } ?>
													</ul>
												<?php } ?>
											<?php } ?>
										<?php } ?>
									<?php }elseif (count($menuContenido->hijos) > 0) { ?>
										<ul class="menu">
											<?php foreach ($menuContenido->hijos as $submenu) { ?>
												<li>
													<?php if (isset($contenido->menus[0]) and $submenu->idMenu == $contenido->menus[0]->idMenu) { ?>
														<span style="color: #999; font-weight: bold;">
															<?php echo formato_html($submenu->titulo); ?>
														</span>
													<?php }else{ ?>
														<a href="<?php echo $submenu->enlace(); ?>">
															<?php echo formato_html($submenu->titulo); ?>
														</a>
													<?php } ?>
													<?php /* if (count($submenu->hijos) > 0) { ?>
														<ul>
															<?php foreach ($submenu->hijos as $submenu2) { ?>
																<li>
																	<a href="<?php echo $submenu2->enlace(); ?>" style="color: gray;"><?php 
																			echo formato_html($submenu2->titulo); ?></a>
																</li>
															<?php } ?>
														</ul>
													<?php } */ ?>
												</li>
											<?php } ?>
										</ul>
									<?php } ?>
								</div>
							</div>
							<p class="rounded-bottomspace"></p>
						</div>
					</div>
					<div class="rounded-block-bottom-left"></div>
					<div class="rounded-block-bottom-right"></div>
				</div>
			</div>
		<?php } ?>
		<!-- contacto -->
		<div class="block-wrapper odd">
			<div class="rounded-block">
				<div class="rounded-block-top-left"></div>
				<div class="rounded-block-top-right"></div>
				<div class="rounded-outside">
					<div class="rounded-inside">
						<p class="rounded-topspace"></p>
						<div class="block block-search">
							<div class="block-icon pngfix">
							</div>
							<div class="content" style="text-align: left;">
								<?php if (isset($_SESSION['usuario'])) { ?>
									<img src="<?php echo URL_RES; ?>imagenes/web/user.png" style="vertical-align: middle;" alt="Socio" /> 
									<span style="font-weight: bold;"><?php echo $_SESSION['usuario']->login; ?></span>
									<a href="<?php echo link_action('logout'); ?>">[ <span style="color: red;">Cerrar sesi&oacute;n</span> ]</a>
								<?php } else { ?>
									<a href="<?php echo link_action('inicio-sesion'); ?>">
										<img src="<?php echo URL_RES; ?>imagenes/web/user.png" style="vertical-align: middle;" alt="Acceso para socios" /> 
										<span style="font-weight: bold;">Acceso para socios</span>
									</a>
								<?php } ?>
								<br />
								<!--
								<img src="<?php echo URL_RES; ?>imagenes/web/tfno_icono.png" 
										style="vertical-align: middle;" alt="Tel&eacute;fonos de contacto" />
								<span style="font-weight: bold;">
									<a href="tel:???">???</a>
								</span>
								<br />
								-->
								<a href="mailto:<?php echo EMAIL_FROM; ?>">
									<img src="<?php echo URL_RES; ?>imagenes/web/email_icono.png" style="vertical-align: middle;" alt="Email de contacto" />
									<span style="font-weight: bold;"><?php echo EMAIL_FROM; ?></span>
								</a>
							</div>
						</div>
						<p class="rounded-bottomspace"></p>
					</div>
				</div>
				<div class="rounded-block-bottom-left"></div>
				<div class="rounded-block-bottom-right"></div>
			</div>
		</div>
	</div>
	<!-- buscador -->
	<div class="block-wrapper odd">
		<div class="rounded-block">
			<div class="rounded-block-top-left"></div>
			<div class="rounded-block-top-right"></div>
			<div class="rounded-outside">
				<div class="rounded-inside">
					<p class="rounded-topspace"></p>
					<div id="block-search-0" class="block block-search">
						<div class="block-icon pngfix">
						</div>
						<div class="title block-title pngfix">Buscador</div>
						<div class="content">
							<form action="<?php echo vlink('buscar'); ?>" method="get" 
									onsubmit="get('consulta').value = get('consulta').value.replace(' ', '[space]');">
								<input type="hidden" name="action" value="buscar" />
								<p>
									<input name="consulta" style="width: 60%;" type="text" id="consulta" 
											class="form-text" size="16" maxlength="50" 
											value="<?php if (isset($_GET['consulta'])){ 
												echo $_GET['consulta'];} ?>" />
									<input name="buscar" type="submit" id="buscar" value="Buscar" 
											class="form-submit" style="width: 32%;" />
								</p>
							</form>
						</div>
					</div>
					<p class="rounded-bottomspace"></p>
				</div>
			</div>
			<div class="rounded-block-bottom-left"></div>
			<div class="rounded-block-bottom-right"></div>
		</div>
	</div>
	<?php include PATH_VIEW . 'bloques/rss_y_mas.php'; ?>
</div>