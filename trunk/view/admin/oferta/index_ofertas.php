<form name="buscar" action="<?php vlink('ofertas'); ?>" method="get">
	<input type="hidden" name="action" value="ofertas" />
	<div style="text-align: right;">
		Buscar:
		<input type="text" name="descripcion" id="descripcion" 
				value="<?php echo $_SESSION['criterios']['descripcion_ofertas']; ?>" size="20" maxlength="40" />
		<input type="submit" value=" Ir " />
	</div>
</form>
<?php if (count($ofertas) > 0) { ?>
	<br />
	<div style="text-align: left;">
		<table border="0" style="width: 100%;">
			<thead>
				<tr class="cabecera_tabla">
					<th>
						<strong>T&iacute;tulo</strong>
					</th>
					<th>
						<strong>Precio</strong>
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
				<?php foreach ($ofertas as $oferta) { ?>
					<?php if ($i++ % 2 == 0) { ?>
						<tr class="par_tabla">
					<?php }else{ ?>
						<tr class="impar_tabla">
					<?php } ?>
						<td>
							<a href="<?php vlink('edicion-oferta', array('id' => $oferta->idContenido)); ?>">
								<?php echo formato_html($oferta->descripcion); ?>
							</a>
						</td>
						<td>
							<a href="<?php vlink('edicion-oferta', array('id' => $oferta->idContenido)); ?>">
								<?php echo formato_html($oferta->precio); ?>
							</a>
						</td>
						<td style="text-align: center;">
							<a href="<?php vlink('edicion-oferta', array('id' => $oferta->idContenido)); ?>">
								<img src="<?php echo URL_RES; ?>imagenes/admin/iconos/page_edit.png" 
										alt="Editar" />
							</a>
						</td>
						<td style="text-align: center;">
							<a href="<?php vlink('baja-contenido', array('id' => $oferta->idContenido)); ?>">
								<img src="<?php echo URL_RES; ?>imagenes/admin/iconos/page_delete.png"  
									alt="Borrar" />
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