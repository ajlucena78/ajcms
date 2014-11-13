<form action="<?php vlink('alta-correo'); ?>" method="post" enctype="multipart/form-data" id="form1">
	<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
	<input type="hidden" name="guardar" value="1" />
	<div style="float: left; width: 20%;">
		<label for="lista">Lista:</label>
	</div>
	<div style="float: right; text-align: right; width: 80%;">
		<input type="text" name="lista" id="lista" style="width: 100%;" disabled="disabled" 
				value="<?php echo $correo->listas(0)->nombre_lista_correo; ?>" maxlength="255" />
	</div>
	<div style="height: 10px; clear: left;"></div>
	<div style="float: left; width: 20%;">
		<label for="email_correo">Email:</label>
	</div>
	<div style="float: right; text-align: right; width: 80%;">
		<input type="text" name="email_correo" id="email_correo" style="width: 100%;" 
				value="<?php echo $correo->email_correo; ?>" maxlength="255" />
	</div>
	<div style="height: 10px; clear: left;"></div>
	<div style="float: right;">
		<br />
		<input type="submit" value="Guardar" name="opcion" />
		<input type="button" value="Guardar y volver al listado" 
				onclick="document.getElementById('form1').submit();" />
		<input type="button" value="Volver" onclick="window.location.href = '<?php 
				vlink('listas-correo'); ?>';" />
	</div>
</form>
<script type="text/javascript">
	document.getElementById("email_correo").focus();
</script>