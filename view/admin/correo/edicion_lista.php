<form name="edicion" action="<?php vlink('edicion-lista'); ?>" method="post">
	<input type="hidden" name="id" value="<?php echo $lista->id_lista_correo; ?>" />
	<input type="hidden" name="guardar" value="1" />
	<div style="float: left; width: 20%;">
		<label for="nombre_lista_correo">Nombre:</label>
	</div>
	<div style="float: right; text-align: right; width: 80%;">
		<input type="text" name="nombre_lista_correo" id="nombre_lista_correo" style="width: 100%;" 
				value="<?php echo $lista->nombre_lista_correo; ?>" maxlength="255" />
	</div>
	<div style="height: 10px; clear: left;"></div>
	<div style="height: 40px; float: right">
		<input type="submit" value="Guardar lista" />
		<input type="button" value="Volver" onclick="window.location.href = '<?php vlink('listas-correo'); ?>';" />
	</div>
</form>
<?php if (count($lista->correos) > 0) { ?>
	<table border="0" style="width: 100%;">
		<thead>
			<tr class="cabecera_tabla">
				<th>
					<strong>Emails en esta lista</strong>
				</th>
				<th width="90" align="center">
					<strong>Estado</strong>
				</th>
				<th width="60" align="center">
					<strong>Editar</strong>
				</th>
				<th width="90" align="center">
					<strong>Dar de baja</strong>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 0; ?>
			<?php foreach ($lista->correos as $correo) { ?>
				<?php if ($i++ % 2 == 0) { ?>
					<tr class="par_tabla">
				<?php }else{ ?>
					<tr class="impar_tabla">
				<?php } ?>
					<td>
						<a href="<?php vlink('edicion-correo', array('id' => $correo->id_correo)); ?>">
							<?php echo formato_html($correo->email_correo); ?>
						</a>
					</td>
					<td style="text-align: center;">
						<?php if ($correo->baja) { ?>
							<span style="color: red;">Dado de baja</span>
						<?php }else{ ?>
							<span style="color: green;">Activo</span>
						<?php } ?>
					</td>
					<td style="text-align: center;">
						<a href="<?php vlink('edicion-correo', array('id' => $correo->id_correo)); ?>">
							<img src="<?php echo URL_RES; ?>imagenes/admin/iconos/email_edit.png" alt="Editar" 
									title="Editar <?php echo formato_html($correo->email_correo); ?>" />
						</a>
					</td>
					<td style="text-align: center;">
						<?php if (!$correo->baja) { ?>
							<a href="<?php vlink('baja-correo', array('id' => $correo->id_correo
									, 'id_lista_correo' => $lista->id_lista_correo)); ?>">
								<img src="<?php echo URL_RES; ?>imagenes/admin/iconos/email_delete.png" 
										style="vertical-align: middle;" 
										alt="Dar de baja a <?php echo formato_html($correo->email_correo); ?>" 
										title="Dar de baja a <?php 
										echo formato_html($correo->email_correo); ?>" />
							</a>
						<?php } ?>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<?php } ?>
<script type="text/javascript">
	document.getElementById("nombre_lista_correo").focus();
</script>