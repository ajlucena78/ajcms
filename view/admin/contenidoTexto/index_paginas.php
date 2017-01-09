<form action="#" method="get">
	<input type="hidden" name="action" value="contenidos-texto" />
	<div style="text-align: right;">
		<input type="text" name="descripcion" id="descripcion" 
				value="<?php echo $_SESSION['criterios']['descripcion_contenidos']; ?>" size="20" 
				maxlength="40" />
		<input type="submit" value="Buscar" /> 
		<input type="submit" value="X" onclick="get('descripcion').value = '';" />
	</div>
</form>
<?php if (count($contenidos) > 0) { ?>
	<br />
	<div style="text-align: left;">
		<table border="0" style="width: 100%;" summary="Contenidos">
			<thead>
				<tr class="cabecera_tabla">
					<th>
						<strong>T&iacute;tulo</strong>
					</th>
					<th width="60" align="center">
						<strong>Privada</strong>
					</th>
					<th width="60" align="center">
						<strong>Editar</strong>
					</th>
					<th width="60" align="center">
						<strong>Eliminar</strong>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 0; ?>
				<?php foreach ($contenidos as $contenido) { ?>
					<?php if ($i++ % 2 == 0) { ?>
						<tr class="par_tabla" <?php if ($contenido->referencia == 'index_') { 
								?>style="font-weight: bold;"<?php } ?>>
					<?php }else{ ?>
						<tr class="impar_tabla" <?php if ($contenido->referencia == 'index_') { 
								?>style="font-weight: bold;"<?php } ?>>
					<?php } ?>
						<td>
							<a href="<?php vlink('edicion-contenido-texto', array('id' => $contenido->idContenido)); ?>" <?php 
									if ($contenido->privado) { ?>style="color: red;"<?php } ?>>
								<?php echo formato_html($contenido->descripcion); ?>
							</a>
						</td>
						<td style="text-align: center;">
							<form action="<?php link_action('contenidos-texto'); ?>" id="privado_<?php echo $contenido->idContenido; ?>" method="post">
								<input name="id" type="hidden" value="<?php echo $contenido->idContenido; ?>" />
								<input type="checkbox" name="privada" value="1" onclick="get('privado_<?php echo $contenido->idContenido; ?>').submit();"
										<?php if ($contenido->privado) { ?>checked="checked"<?php } ?> />
							</form>
						</td>
						<td style="text-align: center;">
							<a href="<?php vlink('edicion-contenido-texto'
									, array('id' => $contenido->idContenido)); ?>">
								<img src="<?php echo URL_RES; ?>imagenes/admin/iconos/page_edit.png" 
										border="0" alt="Editar" title="Editar: <?php 
										echo formato_html($contenido->descripcion); ?>" />
							</a>
						</td>
						<td style="text-align: center;">
							<?php if ($contenido->referencia != 'index_') { ?>
								<a href="<?php vlink('baja-contenido'
										, array('id' => $contenido->idContenido)); ?>">
									<img src="<?php echo URL_RES; ?>imagenes/admin/iconos/page_delete.png" 
											border="0" alt="Borrar" title="Borrar: <?php 
											echo formato_html($contenido->descripcion); ?>" />
								</a>
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
<?php }else{ ?>
	<div class="texto_centrado rojo">
		<br />
		No hay p&aacute;ginas con los criterios indicados
	</div>
<?php } ?>
<script type="text/javascript">
	get('descripcion').focus();
</script>