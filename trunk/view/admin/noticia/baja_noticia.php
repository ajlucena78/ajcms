<?php include ($rootDocumentos . "vistas/html/bloques/admin/cab_admin.php"); ?>
<form name="edicion" action="?m=admin/noticias/baja_noticia" method="post">
	<input type="hidden" name="idNoticia" value="<?php echo $noticiaVO->get_idNoticia(); ?>" />
	<input type="hidden" name="borrar" value="1" />
	<div style="float: left; width: 20%;">
		<strong>Tipo:</strong>
	</div>
	<div style="float: right; text-align: left; width: 80%;">
		Noticia
	</div>
	<div style="height: 10px; clear: both;">
	</div>
	<div style="float: left; width: 20%;">
		<strong>Nombre:</strong>
	</div>
	<div style="float: right; text-align: left; width: 80%;">
		<?php echo $noticiaVO->get_descripcion(); ?>
	</div>
	<div style="height: 10px; clear: both;">
	</div>
	<div style="height: 40px; float: right">
		<input type="submit" value="Borrar" style="color: red;" />
		<input type="button" value="Cancelar" onclick="window.location.href = '?m=admin/noticias/index';" />
	</div>
</form>
<?php include ($rootDocumentos . "vistas/html/bloques/admin/pie_admin.php"); ?>