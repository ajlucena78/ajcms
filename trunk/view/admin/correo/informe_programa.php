<?php include ($rootDocumentos . "vistas/html/bloques/admin/cab_admin.php"); ?>
<div>
	<?php echo str_replace("\n", "\n<br />\n", formato_html($envioVO->get_resultado())); ?>
</div>
<div style="height: 40px; float: right">
	<br />
	<input type="button" value="Volver" onclick="window.location.href = '?m=admin/correos/envios';" />
</div>
<?php include ($rootDocumentos . "vistas/html/bloques/admin/pie_admin.php"); ?>