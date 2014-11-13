<form action="<?php vlink('buscar-email'); ?>" method="get">
	<div style="text-align: right;">
		<input type="hidden" name="action" value="buscar-email" />
		<input type="text" name="email" value="Buscar un email..." size="40" maxlength="255"
				onfocus="if (this.value == 'Buscar un email...') {this.value = ''; this.style.color = 'black';}" 
				style="color: #AAA;" />
		<input type="submit" value="Buscar" />
	</div>
</form>
<br />
<div style="text-align: left;">
	<?php if (count($listas) > 0) { ?>
		<table border="0" style="width: 100%;">
			<thead>
				<tr class="cabecera_tabla">
					<th>
						<strong>Nombre</strong>
					</th>
					<th width="80">
						<strong>Destinatarios</strong>
					</th>
					<th width="80" align="center">
						<strong>A&ntilde;adir email</strong>
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
				<?php foreach ($listas as $lista) { ?>
					<?php if ($i++ % 2 == 0) { ?>
						<tr class="par_tabla">
					<?php }else{ ?>
						<tr class="impar_tabla">
					<?php } ?>
						<td>
							<a href="<?php vlink('edicion-lista', array('id' => $lista->id_lista_correo)); ?>">
								<?php echo formato_html($lista->nombre_lista_correo); ?>
							</a>
						</td>
						<td style="text-align: center;">
							<?php echo $lista->correos; ?>
						</td>
						<td style="text-align: center;">
							<a href="<?php vlink('alta-correo', array('id' => $lista->id_lista_correo)); ?>">
								<img src="<?php echo URL_RES; ?>imagenes/admin/iconos/email_add.png" 
										alt="A&ntilde;adir email" title="A&ntilde;adir email" />
							</a>
						</td>
						<td style="text-align: center;">
							<a href="<?php vlink('edicion-lista', array('id' => $lista->id_lista_correo)); ?>">
								<img src="<?php echo URL_RES; ?>imagenes/admin/iconos/page_edit.png" 
										alt="Editar lista" title="Editar" />
							</a>
						</td>
						<td style="text-align: center;">
							<a href="<?php vlink('baja-lista', array('id' => $lista->id_lista_correo)); ?>">
								<img src="<?php echo URL_RES; ?>imagenes/admin/iconos/page_delete.png" 
										alt="Borrar lista" title="Borrar" />
							</a>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php } ?>
</div>