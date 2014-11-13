<div>
	<div>
		<div style="text-align: left;">
			<?php if (count($correos) > 0) { ?>
				<div>
					Se han encontrado los siguientes correos con la palabra <strong><?php 
							echo formato_html($_GET['email']); ?></strong>:
					<br />&nbsp;
				</div>
				<table border="0" style="width: 100%;">
					<thead>
						<tr class="cabecera_tabla">
							<th>
								<strong>Email</strong>
							</th>
							<th>
								<strong>Listas donde no encuentra</strong>
							</th>
							<th width="80" align="center">
								<strong>Mostrar</strong>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 0; ?>
						<?php foreach ($correos as $correo) { ?>
							<?php if ($i++ % 2 == 0) { ?>
								<tr class="par_tabla">
							<?php }else{ ?>
								<tr class="impar_tabla">
							<?php } ?>
								<td>
									<a href="<?php vlink('ver-email', array('id' => $correo->id_correo)); ?>">
										<?php echo formato_html($correo->email_correo); ?>
									</a>
								</td>
								<td>
									<ol>
										<?php foreach ($correo->listas as $lista) { ?>
											<li><?php echo formato_html($lista->nombre_lista_correo); ?></li>
										<?php } ?>
									</ol>
								</td>
								<td style="text-align: center;">
									<a href="<?php vlink('ver-email', array('id' => $correo->id_correo)); ?>">
										<img src="<?php echo URL_RES; ?>imagenes/admin/iconos/page_edit.png" 
												alt="Mostrar email" title="Mostrar" />
									</a>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php } ?>
		</div>
	</div>
	<div style="height: 40px; float: right;">
		<br />
		<input type="button" value="Volver" onclick="window.location.href = '<?php 
				vlink('listas-correo'); ?>';" />
	</div>
</div>