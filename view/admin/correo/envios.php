<?php require_once APP_ROOT . 'clases/util/Fecha.php'; ?>
<form name="buscar" action="<?php vlink('envios'); ?>" method="get">
	<input type="hidden" name="action" value="envios" />
	<div style="text-align: right;">
		Buscar:
		<input type="text" name="descripcion" id="descripcion" 
				value="<?php echo $_SESSION['criterios']['descripcion_envios']; ?>" size="20" maxlength="40" />
		<input type="submit" value=" Buscar " />
	</div>
</form>
<br />
<div style="text-align: left;">
	<?php if (count($envios) > 0) { ?>
		<table border="0" style="width: 100%;">
			<thead>
				<tr class="cabecera_tabla">
					<th>
						<strong>Mensaje</strong>
					</th>
					<!--
					<th width="120" style="text-align: center;">
						<strong>Fecha de env&iacute;o</strong>
					</th>
					-->
					<th width="120" style="text-align: center;">
						<strong>Fecha de inicio</strong>
					</th>
					<th width="120" style="text-align: center;">
						<strong>Fecha de fin</strong>
					</th>
					<th width="60" style="text-align: center;">
						<strong>Estado</strong>
					</th>
					<th width="60" style="text-align: center;">
						<strong>Informe</strong>
					</th>
					<th width="60" style="text-align: center;">
						<strong>Editar</strong>
					</th>
					<th width="60" style="text-align: center;">
						<strong>Eliminar</strong>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 0; ?>
				<?php foreach ($envios as $envio) { ?>
					<?php if ($i++ % 2 == 0) { ?>
						<tr class="par_tabla">
					<?php }else{ ?>
						<tr class="impar_tabla">
					<?php } ?>
						<td>
							<a href="<?php vlink('programa', array('id' => $envio->id_envio_correo)); ?>"><?php 
									echo formato_html($envio->contenido->descripcion); ?></a>
						</td>
						<!--
						<td style="text-align: center;">
							<?php echo $envio->fecha_programa_envio ?>
						</td>
						-->
						<td style="text-align: center;">
							<?php if ($envio->fecha_inicio) { ?>
								<?php echo Fecha::convierte_BBDD_a_spa($envio->fecha_inicio, true); ?>
							<?php } ?>
						</td>
						<td style="text-align: center;">
							<?php if ($envio->fecha_fin) { ?>
								<?php echo Fecha::convierte_BBDD_a_spa($envio->fecha_fin, true); ?>
							<?php } ?>
						</td>
						<td style="text-align: center;">
							<?php if ($envio->ok) { ?>
								<span style="color: green;">Ok</span>
							<?php }elseif ($envio->ok === '0'){ ?>
								<span style="color: red;">Error</span>
							<?php } ?>
						</td>
						<td style="text-align: center;">
							<?php if ($envio->ok === '0') { ?>
								<a href="<?php vlink('informe-envio'
										, array('id' => $envio->id_envio_correo)); ?>"><img 
										src="<?php echo URL_RES; ?>imagenes/admin/iconos/page.png" 
										alt="Informe" /></a>
							<?php } ?>
						</td>
						<td style="text-align: center;">
							<a href="<?php vlink('programa', array('id' => $envio->id_envio_correo)); ?>"><img 
									src="<?php echo URL_RES; ?>imagenes/admin/iconos/page_edit.png" 
									alt="Editar" /></a>
						</td>
						<td style="text-align: center;">
							<a href="<?php vlink('baja-envio'
									, array('id' => $envio->id_envio_correo)); ?>"><img 
									src="<?php echo URL_RES; ?>imagenes/admin/iconos/page_delete.png" 
									alt="Borrar" /></a>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php }else{ ?>
		No hay env&iacute;os registrados con los criterios indicados
	<?php } ?>
</div>
<script type="text/javascript">
	document.getElementById("descripcion").focus();
</script>