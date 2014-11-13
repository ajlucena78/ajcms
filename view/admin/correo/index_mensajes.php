<form name="buscar" action="<?php vlink('mensajes'); ?>" method="get">
	<input type="hidden" name="action" value="mensajes" />
	<div style="text-align: right;">
		<label for="descripcion">Buscar:</label>
		<input type="text" name="descripcion" id="descripcion" 
				value="<?php echo $_SESSION['criterios']['descripcion_correos']; ?>" size="20" maxlength="40" />
		<input type="submit" value=" Buscar " />
	</div>
</form>
<br />
<div style="text-align: left;">
	<?php if (count($contenidos) > 0) { ?>
		<table border="0" style="width: 100%;">
			<thead>
				<tr class="cabecera_tabla">
					<th>
						<strong>Asunto</strong>
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
						<tr class="par_tabla">
					<?php }else{ ?>
						<tr class="impar_tabla">
					<?php } ?>
						<td>
							<a href="<?php vlink('edicion-mensaje', array('id' => $contenido->idContenido)); ?>">
								<?php echo formato_html($contenido->descripcion); ?>
							</a>
						</td>
						<td style="text-align: center;">
							<a href="<?php vlink('edicion-mensaje', array('id' => $contenido->idContenido)); ?>">
								<img src="<?php echo URL_RES; ?>imagenes/admin/iconos/page_edit.png" 
										alt="Editar" />
							</a>
						</td>
						<td style="text-align: center;">
							<?php if ($contenido->referencia != 'emacab' 
									and $contenido->referencia != 'emapie') { ?>
								<a href="<?php vlink('baja-contenido'
										, array('id' => $contenido->idContenido)); ?>">
									<img src="<?php echo URL_RES; ?>imagenes/admin/iconos/page_delete.png"
											 alt="Borrar" />
								</a>
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php } ?>
</div>
<script type="text/javascript">
	document.getElementById("descripcion").focus();
</script>