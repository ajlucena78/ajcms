<div id="primary-menu-wrapper" class="clearfix">
	<?php if (isset($menus) and is_array($menus)) { ?>
		<div id="primary-menu" style="width: <?php echo ((ANCHO_PESTANA * PESTANAS_FILA + 14 * (PESTANAS_FILA - 1))); ?>pt;">
			<div class="primary-menu-inner inner clearfix" id="primary-menu-inner">
				<ul class="menu sf-menu sf-js-enabled">
					<?php $cont = 0; ?>
					<?php foreach ($menus as $menu) { ?>
						<?php $claseMenu1 = "collapse" ?>
						<?php if ($cont == 0){ $claseMenu1 = "leaf first"; } ?>
						<?php if ($cont == (count($menus) - 1)){ $claseMenu1 = "leaf last"; } ?>
						<?php if (isset($MENU_01) and $menu->idMenu == $MENU_01){ $claseMenu1 .= " active-trail"; } ?>
						<li class="<?php echo $claseMenu1; ?><?php if (!$cont) { ?> menu_rojo<?php } ?>" 
								style="text-align:center; width: <?php 
								echo ANCHO_PESTANA; ?>pt; float:right;"><a <?php if (!$cont) { ?>class="menu_rojo"<?php } ?> 
								href="<?php echo $menu->enlace(); ?>"><?php echo formato_html($menu->titulo); ?></a>
							<?php if (count($menu->hijos) > 0) { ?>
								<ul class="menu" style="display: none; visibility: hidden;  width: <?php echo (ANCHO_PESTANA + 5); ?>pt;">
									<?php foreach ($menu->hijos as $submenu) { ?>
										<li title="<?php echo formato_html($submenu->titulo); ?>" 
												style="background-color: #D1DFEF; width: <?php 
												echo ANCHO_PESTANA; ?>pt;"><a href="<?php echo $submenu->enlace(); ?>"><?php 
												echo formato_html($submenu->titulo); ?></a>
										</li>
									<?php } ?>
								</ul>
							<?php } ?>
						</li>
						<?php $cont++; ?>
					<?php } ?>
				</ul>
			</div>
		</div>
	<?php } ?>
</div>
<div id="preface"></div>