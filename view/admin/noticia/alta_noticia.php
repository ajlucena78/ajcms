<?php include ($rootDocumentos . "vistas/html/bloques/admin/cab_admin.php"); ?>
<form action="?m=admin/noticias/alta_noticia" method="post" enctype="multipart/form-data">
	<input type="hidden" name="guardar" value="1" />
	<div style="float: left; width: 20%;">
		<label for="descripcion">Titular:</label>
	</div>
	<div style="float: right; text-align: right; width: 80%;">
		<input type="text" name="descripcion" id="descripcion" style="width: 100%;" 
				value="<?php echo $noticiaVO->get_descripcion(); ?>" maxlength="255" />
	</div>
	<div style="height: 10px; clear: left;">
	</div>
	<div style="float: left; width: 20%;">
		<label for="descripcion">Permalink:</label>
	</div>
	<div style="float: right; text-align: right; width: 80%;">
		<input type="text" name="permalink" id="permalink" style="width: 100%;" 
				value="<?php echo $noticiaVO->get_permalink(); ?>" maxlength="50" />
	</div>
	<div style="height: 10px; clear: left;">
	</div>
	<div>
		<label for="texto">Texto:</label>
	</div>
	<div style="text-align: right;">
		<textarea name="texto" id="texto" style="width: 100%;" cols="40"
				rows="22"><?php echo $noticiaVO->get_texto(); ?></textarea>
	</div>
	<div style="height: 10px; clear: left;">
	</div>
	<div style="float: right">
		<input type="submit" value="Guardar" />
		<input type="button" value="Cancelar" onclick="window.location.href = '?m=admin/noticias/index';" />
	</div>
</form>
<script type="text/javascript">
	document.getElementById("descripcion").focus();
</script>
<?php include ($rootDocumentos . "vistas/html/bloques/admin/pie_admin.php"); ?>