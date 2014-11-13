<script type="text/javascript" src="<?php echo URL_RES; ?>js/menus.js"></script>
<div>
	<?php if ($menuPadre->idMenu) { ?>
		<h3>
			<span style="color: gray;">Submen&uacute;:</span> <?php echo formato_html($menuPadre->titulo); ?>
		</h3>
	<?php } ?>
	<h5>Alta de un nuevo men&uacute;:</h5>
	<form action="<?php vlink('menus', array('idPadre' => $idPadre)); ?>" method="post">
		<div>
			<div style="width: 35%; text-align: center; float: left;">
				T&iacute;tulo
			</div>
			<div style="width: 35%; text-align: center; float: left;">
				Contenido enlazado (opcional)
			</div>
			<div style="clear: left;"></div>
		</div>
		<div>
			<input type="hidden" name="alta" value="1" />
			<input type="hidden" name="idPadre" value="<?php echo $idPadre; ?>" />
			<input type="text" name="titulo" id="titulo" style="width: 35%;" 
					value="<?php echo formato_html($menu->titulo); ?>" maxlength="50" />
			<select name="idContenido" style="width: 35%;">
				<option value="">&nbsp;</option>
				<?php foreach ($contenidos as $contenido) { ?>
					<option value="<?php echo $contenido->idContenido; ?>"<?php 
							if ($menu->contenido and $contenido->idContenido == $menu->contenido->idContenido)
								{ echo "selected"; } ?>><?php echo substr($contenido->descripcion, 0, 30) 
								. '...'; ?>
					</option>
				<?php } ?>
			</select>
			<input type="submit" value="Guardar" style="width: 15%;" />
			<?php if ($idPadre) { ?>
				<input type="button" value="Atr&aacute;s" style="width: 11%;" 
						onclick="window.location = '<?php vlink('menus', 
						array('idPadre' => ($menuPadre->padre) ? $menuPadre->padre->idMenu : '0')); ?>';" />
			<?php } ?>
		</div>
	</form>
</div>
<?php if (count($menus) > 0) { ?>
	<div>
		<h5>Men&uacute;s creados:</h5>
		<div>
			<div style="width: 35%; text-align: center; float: left;">
				T&iacute;tulo
			</div>
			<div style="width: 35%; text-align: center; float: left;">
				Contenido enlazado (opcional)
			</div>
			<div style="clear: left;"></div>
		</div>
		<?php $cont = 1; $contMenus = 0; ?>
		<?php foreach ($menus as $menu) { ?>
			<div>
				<form id="formMenu<?php echo $menu->idMenu; ?>" 
						action="<?php vlink('menus', array('idPadre' => $idPadre)); ?>#menu<?php 
						echo $menu->idMenu; ?>" method="post">
					<input type="hidden" name="idMenu" value="<?php echo $menu->idMenu; ?>" />
					<input type="hidden" name="guardar" value="1" />
					<input type="hidden" name="borrar" value="0" />
					<input type="hidden" name="subir" value="0" />
					<input type="hidden" name="bajar" value="0" />
					<input type="hidden" name="idPadre" 
							value="<?php if ($menu->padre) echo $menu->padre->idMenu; ?>" />
					<div>
						<input type="text" name="titulo" style="width: 35%;" id="titulo<?php echo $cont; ?>" 
								value="<?php echo $menu->titulo; ?>" maxlength="50" 
								onkeypress="activa_form_menu(<?php echo $cont; ?>);" />
						<select name="idContenido" style="width: 35%;" class="fuenteMin1" 
								id="idContenido<?php echo $cont; ?>" 
								onchange="activa_form_menu(<?php echo $cont; ?>);">
							<option value="">&nbsp;</option>
							<?php foreach ($contenidos as $contenido) { ?>
								<option value="<?php echo $contenido->idContenido; ?>"<?php 
										if ($menu->contenido and $contenido->idContenido == $menu->contenido->idContenido){
											echo "selected='selected'"; } ?>><?php 
											echo substr($contenido->descripcion, 0, 30) . '...'; ?></option>
							<?php } ?>
						</select>
						<input type="text" disabled="disabled" style="text-align: right; width: 5%;" 
								value="<?php echo $numHijosMenu[$contMenus++]; ?>" title="Submen&uacute;s" />
						<input type="button" value=">>" id="submenus<?php echo $cont; ?>"
								onclick="window.location = '<?php vlink('menus'
								, array('idPadre' => $menu->idMenu)); ?>';" 
								style="width: 10%;" title="Ver los submen&uacute;s" />
						<input type="button" value="Opciones" style="width: 10%;" 
								onclick="ver_opciones_menu(<?php echo $cont; ?>);" />
					</div>
					<div id="editar_menu_<?php echo $cont; ?>" 
							style="text-align: center; margin: 2%; display: none;">
						<input type="submit" value="Guardar Cambios" style="width: 20%;" 
								id="editar<?php echo $cont; ?>" disabled="disabled" />
						<input type="button" value="Cancelar" style="width: 10%;" 
								onclick="cancelar_form_menu(<?php echo $idPadre; ?>);"
								id="cancelar<?php echo $cont; ?>" disabled="disabled" />
						&nbsp;
						<input type="button" value="Subir" style="width: 10%;" title="Subir una posici&oacute;n"
								onclick="subir_menu(<?php echo $menu->idMenu; ?>);" 
								id="subir<?php echo $cont; ?>" />
						<input type="button" value="Bajar" style="width: 10%;" title="Bajar una posici&oacute;n"
								onclick="bajar_menu(<?php echo $menu->idMenu; ?>);" 
								id="bajar<?php echo $cont; ?>" />
						&nbsp;
						<input type="button" value="Borrar" style="color: red; width: 8%;"
								onclick="borrar_menu(<?php echo $menu->idMenu; ?>);"
								id="borrar<?php echo $cont; ?>" />
					</div>
				</form>
			</div>
			<?php $cont++; ?>
		<?php } ?>
	</div>
<?php } ?>
<script type="text/javascript">
	document.getElementById('titulo').focus();
</script>