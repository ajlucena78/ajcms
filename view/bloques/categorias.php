<?php if (isset($menuCont)) { ?>
	<?php if (count($menuCont->hijos) > 0) { ?>
		<div class="cont-categorias">
			<?php foreach ($menuCont->hijos as $submenu) { ?>
				<?php if (!$submenu->contenido) { continue; } ?>
				<div class="block-wrapper odd categoria" onclick="ir_a('<?php echo $submenu->enlace(); ?>');" 
						title="Clic para abrir">
					<div class="rounded-block">
						<div class="rounded-block-top-left"></div>
						<div class="rounded-block-top-right"></div>
						<div class="rounded-outside">
							<div class="rounded-inside">
								<p class="rounded-topspace"></p>
								<div class="block block-search">
									<div class="block-icon pngfix"></div>
									<div class="content">
										<div style="float: left; width: 30%;">
											<a href="<?php echo $submenu->enlace(); ?>" >
												<?php if ((!$submenu->contenido->privado or (isset($_SESSION['acceso_usuario_concedido']) 
														and $_SESSION['acceso_usuario_concedido'])) and $submenu->contenido->imagenes(null, 1) 
														and $submenu->contenido->imagenes[0]) { ?>
													<img src="<?php echo $submenu->contenido->imagenes[0]->url(); ?>" 
															class="imagen-submenu" alt="<?php 
															echo formato_html($submenu->contenido->imagenes[0]->titulo); ?>" />
												<?php } elseif ($submenu->contenido->idContenido == 156) { ?>
													<img src="<?php echo URL_RES; ?>imagenes/web/contacto.jpg" class="imagen-submenu" alt="Formulario de contacto" />
												<?php } elseif ($submenu->contenido->idContenido == 141) { ?>
													<img src="<?php echo URL_RES; ?>imagenes/web/mapa.jpg" class="imagen-submenu" alt="Localizaci&oacute;n - Mapa" />
												<?php } else { ?>
													<img src="<?php echo URL_RES; ?>imagenes/web/no-imagen.png" 
															class="imagen-submenu" alt="<?php 
															echo formato_html($submenu->contenido->descripcion); ?>" />
												<?php } ?>
											</a>
										</div>
										<div style="float: left; width: 70%;">
											<h2 class="h2-submenu">
												<a href="<?php echo $submenu->enlace(); ?>" >
													<?php echo formato_html($submenu->contenido->descripcion); ?>
												</a>
											</h2>
											<?php if ($submenu->contenido->privado and (!isset($_SESSION['acceso_usuario_concedido']) 
													or !$_SESSION['acceso_usuario_concedido'])) { ?>
												<div style="color: red;" class="texto-categoria">Este contenido est&aacute; disponible solo para socios</div>
											<?php } ?>
										</div>
										<div style="clear: left;"></div>
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
			<div style="clear: both;"></div>
		</div>
	<?php } ?>
<?php } ?>