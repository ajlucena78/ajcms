<form name="edicion" action="<?php vlink('edicion-correo'); ?>" method="post">
	<input type="hidden" name="id" value="<?php echo $correo->id_correo; ?>" />
	<input type="hidden" name="id_lista_correo" value="<?php echo $lista->id_lista_correo; ?>" />
	<input type="hidden" name="guardar" value="1" />
	<div style="float: left; width: 20%;">
		<label for="email_correo">Email:</label>
	</div>
	<div style="float: right; text-align: right; width: 80%;">
		<input type="text" name="email_correo" id="email_correo" style="width: 99%;" 
				value="<?php echo $correo->email_correo; ?>" maxlength="255" />
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="float: left; width: 20%;">
		<label for="lista">Listas afectadas:</label>
	</div>
	<div style="float: right; text-align: right; width: 80%;">
		<select name="lista" id="lista" style="width: 100%;" disabled="disabled" size="15">
			<?php foreach ($correo->listas as $lista) { ?>
				<option value=""><?php echo formato_html($lista->nombre_lista_correo); ?></option>
			<?php } ?>
		</select>
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="height: 40px; float: right">
		<input type="submit" value="Guardar correo" />
		<input type="button" value="Cancelar" onclick="window.location.href = '?action=edicion-lista&id=<?php 
				echo $lista->id_lista_correo; ?>';" />
	</div>
</form>
<script type="text/javascript">
	document.getElementById("lista").selectedIndex = -1;
	document.getElementById("email_correo").focus();
</script>