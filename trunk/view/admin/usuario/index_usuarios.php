<form name="buscar" action="<?php vlink('usuarios'); ?>" method="get">
	<input type="hidden" name="action" value="usuarios" />
	<div style="text-align: right;">
		Buscar:
		<input type="text" name="login" id="login" 
				value="<?php echo $_SESSION['criterios']['login_usuarios']; ?>" size="20" maxlength="40" />
		<input type="submit" value="Buscar" />
	</div>
</form>
<br />
<?php if (count($usuarios) > 0) { ?>
	<div style="text-align: left;">
		<table border="0" style="width: 100%;">
			<thead>
				<tr class="cabecera_tabla">
					<th width="140">
						<strong>Nombre</strong>
					</th>
					<th width="120" align="center">
						<strong>Permiso</strong>
					</th>
					<th width="160" align="center">
						<strong>Fecha &uacute;ltimo acceso</strong>
					</th>
					<th align="center">
						<strong>IP &uacute;ltimo acceso</strong>
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
				<?php foreach ($usuarios as $usuario) { ?>
					<?php if ($i++ % 2 == 0) { ?>
						<tr class="par_tabla">
					<?php }else{ ?>
						<tr class="impar_tabla">
					<?php } ?>
						<td>
							<a href="<?php vlink('edicion-usuario', array('id' => $usuario->idUsuario)); ?>">
								<?php echo $usuario->login; ?>
							</a>
						</td>
						<td style="text-align: center;">
							<?php if ($usuario->permiso){ ?>
								<?php echo formato_html($usuario->permiso->permiso); ?>
							<?php } ?>
						</td>
						<td style="text-align: center;">
							<?php echo $usuario->fechaAcceso; ?>
						</td>
						<td style="text-align: center;">
							<?php echo $usuario->ip; ?>
						</td>
						<td style="text-align: center;">
							<a href="<?php vlink('edicion-usuario', array('id' => $usuario->idUsuario)); ?>">
								<img src="<?php echo URL_RES; ?>imagenes/admin/iconos/user_edit.png" 
										alt="Editar" />
							</a>
						</td>
						<td style="text-align: center;">
							<a href="<?php vlink('baja-usuario', array('id' => $usuario->idUsuario)); ?>">
								<img src="<?php echo URL_RES; ?>imagenes/admin/iconos/user_delete.png" 
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
	document.getElementById("login").focus();
</script>