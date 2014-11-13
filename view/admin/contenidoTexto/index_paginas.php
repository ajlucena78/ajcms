<form action="#" method="get">
	<input type="hidden" name="action" value="contenidos-texto" />
	<div style="text-align: right;">
		Buscar:
		<input type="text" name="descripcion" id="descripcion" 
				value="<?php echo $_SESSION['criterios']['descripcion_contenidos']; ?>" size="20" 
				maxlength="40" />
		<input type="submit" value=" Ir " />
	</div>
</form>
<?php if (count($contenidos) > 0) { ?>
	<br />
	<div style="text-align: left;">
		<table border="0" style="width: 100%;">
			<thead>
				<tr class="cabecera_tabla">
					<th>
						<strong>T&iacute;tulo</strong>
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
							<a href="<?php vlink('edicion-contenido-texto'
									, array('id' => $contenido->idContenido)); ?>"><?php 
									echo formato_html($contenido->descripcion); ?></a>
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
							<a href="<?php vlink('baja-contenido', array('id' => $contenido->idContenido)); ?>">
								<img src="<?php echo URL_RES; ?>imagenes/admin/iconos/page_delete.png" 
										border="0" alt="Borrar" title="Borrar: <?php 
										echo formato_html($contenido->descripcion); ?>" />
							</a>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
<?php } ?>
<script type="text/javascript">
	document.getElementById("descripcion").focus();
</script>