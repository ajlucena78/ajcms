<?php include ($rootDocumentos . "vistas/html/bloques/admin/cab_admin.php"); ?>
<h2>Borrar la oferta</h2>
<form name="edicion" action="?m=admin/ofertas/baja_oferta" method="post">
	<input type="hidden" name="idContenido" value="<?php echo $contenidoVO->get_idContenido(); ?>" />
	<input type="hidden" name="borrar" value="1" />
	<div style="float: left; width: 20%;">
		<strong>T&iacute;tulo:</strong>
	</div>
	<div style="float: right; text-align: left; width: 80%;">
		<?php echo $contenidoVO->get_descripcion(); ?>
	</div>
	<div style="height: 10px; clear: both;">
	</div>
	<div style="height: 40px; float: right">
		<input type="submit" value="Borrar" style="color: red;" />
		<input type="button" value="Cancelar" onclick="window.location.href = '?m=admin/ofertas/index';" />
	</div>
</form>
<?php include ($rootDocumentos . "vistas/html/bloques/admin/pie_admin.php"); ?>