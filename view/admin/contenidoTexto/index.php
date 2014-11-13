<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Consulta de contenidos - <?php echo APPNAME; ?></title>
		<?php include $_SESSION['config']->getPathView() . '/includes/admin/head.php'; ?>
	</head>
	<body>
		<?php include $_SESSION['config']->getPathView() . '/includes/admin/cab_admin.php'; ?>
		<form action="<?php vlink('consulta_contenidos_texto'); ?>" method="post">
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
			<form name="consulta" action="<?php vlink('consulta_contenidos_texto'); ?>" method="post">
				<div style="text-align: left;">
					<table border="0" style="width: 100%;">
						<thead>
							<tr class="cabecera_tabla">
								<th>
									<strong>T&iacute;tulo</strong>
								</th>
								<th width="80">
									<strong>Referencia</strong>
								</th>
								<th width="120">
									<strong>Men&uacute;</strong>
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
										<a href="?m=admin/contenidos/edicion_contenido&amp;idContenido=<?php 
												echo $contenido->idContenido; ?>"><?php 
												echo $contenido->descripcion; ?></a>
									</td>
									<td><?php echo $contenido->referencia; ?></td>
									<td>
										<?php //mostrar los menus a los que apunta el contenido si hay
										/*
										<?php if ($contenido->menus) { ?>
											<?php echo formato_html($contenido->menus->titulo); ?>
										<?php } ?>
										*/ ?>
									</td>
									<td style="text-align: center;">
										<a href="?m=admin/contenidos/edicion_contenido&amp;idContenido=<?php 
												echo $contenido->idContenido; ?>">
											<img src="<?php echo $_SESSION['config']->getPathApp(); 
													?>/res/imagenes/admin/iconos/page_edit.png" border="0" 
												alt="Editar" />
										</a>
									</td>
									<td style="text-align: center;">
										<a href="?m=admin/contenidos/baja_contenido&amp;idContenido=<?php 
												echo $contenidoVO->get_idContenido(); ?>">
											<img src="<?php echo $_SESSION['config']->getPathApp(); 
													?>/res/imagenes/admin/iconos/page_delete.png" border="0" 
												alt="Borrar" />
										</a>
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
		<?php include $_SESSION['config']->getPathView() . 'includes/admin/pie_admin.php'; ?>
	</body>
</html>