<?php include ($rootDocumentos . "vistas/html/bloques/admin/cab_admin.php"); ?>
<form name="buscar" action="?m=admin/noticias/index" method="post">
	<div style="text-align: right;">
		Buscar:
		<input type="text" name="descripcion" id="descripcion" 
				value="<?php echo $_SESSION["descripcion_noticias"]; ?>" size="20" maxlength="40" />
		<input type="submit" value=" Ir " />
	</div>
</form>
<?php if (count($noticias_view) > 0) { ?>
	<br />
	<form name="consulta" action="?m=admin/noticias/index" method="post">
		<div style="text-align: left;">
			<table border="0" style="width: 100%;">
				<thead>
					<tr class="cabecera_tabla">
						<th>
							<strong>Titular</strong>
						</th>
						<th width="80">
							<strong>Referencia</strong>
						</th>
						<th width="140">
							<strong>Fecha</strong>
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
					<?php foreach ($noticias_view as $noticiaVO) { ?>
						<?php if ($i++ % 2 == 0) { ?>
							<tr class="par_tabla">
						<?php }else{ ?>
							<tr class="impar_tabla">
						<?php } ?>
							<td>
								<a href="?m=admin/noticias/edicion_noticia&amp;idNoticia=<?php echo $noticiaVO->get_idNoticia(); ?>">
									<?php echo $noticiaVO->get_descripcion(); ?>
								</a>
							</td>
							<td style="text-align: center;"><?php echo $noticiaVO->get_referencia(); ?></td>
							<td style="text-align: center;"><?php echo $noticiaVO->get_fecha(); ?></td>
							<td style="text-align: center;">
								<a href="?m=admin/noticias/edicion_noticia&amp;idNoticia=<?php 
										echo $noticiaVO->get_idNoticia(); ?>"><img src="<?php echo $path_view; ?>imagenes/admin/iconos/page_edit.png" 
										border="0" alt="Editar" /></a>
							</td>
							<td style="text-align: center;">
								<a href="?m=admin/noticias/baja_noticia&amp;idNoticia=<?php 
										echo $noticiaVO->get_idNoticia(); ?>"><img src="<?php echo $path_view; ?>imagenes/admin/iconos/page_delete.png" 
										border="0" alt="Borrar" /></a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</form>
<?php } ?>
<script type="text/javascript">
	document.getElementById("descripcion").focus();
</script>
<?php include ($rootDocumentos . "vistas/html/bloques/admin/pie_admin.php"); ?>