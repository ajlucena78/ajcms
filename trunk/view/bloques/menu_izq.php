<div id="sidebar-first">
	<div id="menu_izq" style="position: relative;">
		<div id="logo_menu" style="display: none;">
			<a href="http://www.ubipol.com" title="Home">
				<img src="<?php echo URL_RES; ?>imagenes/web/logo.png" style="width: 100%;" 
						alt="Logo de UBIPOL" />
			</a>
		</div>
		<?php if (isset($menuContenido) and (count($menuContenido->hijos) > 0 or (isset($menuContenidoPadre) 
				and count($menuContenidoPadre->hijos) > 0))) { ?>
			<div class="block-wrapper odd">
				<div class="rounded-block">
					<div class="rounded-block-top-left"></div>
					<div class="rounded-block-top-right"></div>
					<div class="rounded-outside">
						<div class="rounded-inside">
							<p class="rounded-topspace"></p>
							<div id="block-user-1" class="block block-user">
								<div class="block-icon pngfix">
								</div>
								<h2 class="title block-title pngfix"><?php 
										echo formato_html($menuContenido->titulo); ?></h2>
								<div class="content">
									<?php if (isset($menuContenidoPadre) 
											and count($menuContenidoPadre->hijos) > 0) { ?>
										<?php foreach ($menuContenidoPadre->hijos as $submenuPadre) { ?>
											<?php if ($submenuPadre->idMenu == $menuContenido->idMenu) { ?>
												<?php if (count($menuContenido->hijos) > 0) { ?>
													<ul class="menu">
														<?php foreach ($menuContenido->hijos as $submenu) { ?>
															<li>
																<a href="<?php echo $submenu->enlace(); ?>" >
																	<?php echo formato_html($submenu->titulo); ?>
																</a>
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
													<a href="<?php echo $submenu->enlace(); ?>"><?php 
															echo formato_html($submenu->titulo); ?></a>
													<?php if (count($submenu->hijos) > 0) { ?>
														<ul>
															<?php foreach ($submenu->hijos as $submenu2) { ?>
																<li>
																	<a href="<?php echo $submenu2->enlace(); ?>" 
																			style="color: gray;">
																		<?php echo formato_html($submenu2->titulo); ?>
																	</a>
																</li>
															<?php } ?>
														</ul>
													<?php } ?>
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
							<h2 class="title block-title pngfix">Buscador</h2>
							<div class="content">
								<form action="<?php echo vlink('buscar'); ?>" method="get" 
										onsubmit="get('consulta').value = get('consulta').value.replace(' ', '<space>');">
									<input type="hidden" name="action" value="buscar" />
									<p>
										<input name="consulta" style="width: 120px;" type="text" id="consulta" 
												class="form-text" size="16" maxlength="50" 
												value="<?php if (isset($_GET['consulta'])){ 
													echo $_GET['consulta'];} ?>" />
										<input name="buscar" type="submit" id="buscar" value="Buscar" 
												class="form-submit" />
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
	</div>
	<?php include PATH_VIEW . 'bloques/rss_y_mas.php'; ?>
	<div style="font-size: 0.8em; text-align: center;">Grupo Publicar</div>
	<div>
		<a href="http://www.ubipol.com" target="_blank"><img style="vertical-align: middle;" 
				src="<?php echo URL_RES; ?>imagenes/web/banner_ubipol.jpg" alt="UBIPOL" /></a>
	</div>
	<div>
		&nbsp;
	</div>
	<div>
		<a href="http://www.laboutiquedelregalo.es" target="_blank"><img style="vertical-align: middle;" 
				src="<?php echo URL_RES; ?>imagenes/web/boutique.png" alt="La Boutique del Regalo" /></a>
	</div>
	<div>
		&nbsp;
	</div>
	<div style="font-size: 0.8em; text-align: center;">Colaboramos con...</div>
	<div>
		<a href="http://www.elalbergue.org" target="_blank"><img style="vertical-align: middle;" 
				src="<?php echo URL_RES; ?>imagenes/web/logoelalbergue.png" alt="Logotipo El Albergue" /></a>
		<div style="font-size: 0.8em; text-align: center;">
			<a href="http://www.elalbergue.org" style="color: #4B8A08;">
				<strong>Asociaci&oacute;n para la Protecci&oacute;n Animal
				<br />EL ALBERGUE</strong>
			</a>
		</div>
	</div>
	<div>
		&nbsp;
	</div>
	<div>
		<a href="http://www.pmsv.org" target="_blank"><img style="vertical-align: middle;" 
				src="<?php echo URL_RES; ?>imagenes/web/logo-pmsv.png" 
				alt="Plataforma Motera para la Seguridad Vial" /></a>
	</div>
	<div>
		&nbsp;
	</div>
	<div style="font-size: 0.8em; text-align: center;">
		Empresa incluida en beneficios adicionales 
		<br /><a href="http://www.famedic.es" target="_blank">Famedic Sevilla</a>
	</div>
	<div>
		<a href="http://www.famedic.es" target="_blank"><img style="vertical-align: middle;" 
				src="<?php echo URL_RES; ?>imagenes/web/famedic.jpg" 
				alt="Descuentos a clientes de tarjeta sanitaria Famedic" /></a>
		<div style="font-size: 0.8em; text-align: center;">
			Descuentos a clientes de tarjeta sanitaria Famedic
		</div>
	</div>
</div>