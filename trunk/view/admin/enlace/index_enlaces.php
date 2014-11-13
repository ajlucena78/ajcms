<?php if (count($enlaces) > 0) { ?>
	<div style="text-align: left;">
		<table border="0" style="width: 100%;">
			<thead>
				<tr class="cabecera_tabla">
					<th>
						<strong>T&iacute;tulo</strong>
					</th>
					<th>
						<strong>Enlace</strong>
					</th>
					<th width="80" align="center">
						<strong>Referencia</strong>
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
				<?php foreach ($enlaces as $enlace) { ?>
					<?php if ($i++ % 2 == 0) { ?>
						<tr class="par_tabla">
					<?php }else{ ?>
						<tr class="impar_tabla">
					<?php } ?>
						<td>
							<a href="<?php vlink('edicion-enlace', array('id' => $enlace->idContenido)); ?>">
								<?php echo formato_html($enlace->descripcion); ?>
							</a>
						</td>
						<td>
							<a href="<?php echo $enlace->url; ?>" style="color: blue;" title="Abrir URL" 
									target="_blank"><?php echo $enlace->url; ?></a>
						</td>
						<td style="text-align: center;"><?php echo $enlace->referencia; ?></td>
						<td style="text-align: center;">
							<a href="<?php vlink('edicion-enlace', array('id' => $enlace->idContenido)); ?>">
								<img src="<?php echo URL_RES; ?>imagenes/admin/iconos/page_edit.png" border="0" 
										alt="Editar" />
							</a>
						</td>
						<td style="text-align: center;">
							<a href="<?php vlink('baja-contenido', array('id' => $enlace->idContenido)); ?>">
								<img src="<?php echo URL_RES; ?>imagenes/admin/iconos/page_delete.png" border="0"
										alt="borrar" /></a>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
<?php } ?>