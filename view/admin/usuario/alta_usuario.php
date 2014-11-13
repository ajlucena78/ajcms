<form action="<?php vlink('alta-usuario'); ?>" method="post">
	<input type="hidden" name="guardar" value="1" />
	<h2>Nuevo usuario</h2>
	<div style="float: left; width: 20%;">
		<label for="login">Nombre:</label>
	</div>
	<div style="float: right; text-align: right; width: 80%;">
		<input type="text" name="login" id="login" style="width: 100%;" value="<?php echo $usuario->login; ?>" 
				maxlength="20" />
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="float: left; width: 20%;">
		<label for="pwd">Clave:</label>
	</div>
	<div style="float: right; text-align: right; width: 80%;">
		<input type="password" name="pwd" id="pwd" style="width: 100%;" value="" maxlength="20" />
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="float: left; width: 20%;">
		<label for="pwd">Repetir clave:</label>
	</div>
	<div style="float: right; text-align: right; width: 80%;">
		<input type="password" name="pwd2" id="pwd2" style="width: 100%;" value="" maxlength="20" />
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="float: left; width: 20%;">
		<label for="idPermiso">Permiso:</label>
	</div>
	<div style="float: right; text-align: right; width: 80%;">
		<select name="idPermiso" id="idPermiso" style="width: 100%;">
			<option value="">&nbsp;</option>
			<?php foreach ($permisos as $permiso) { ?>
				<option value="<?php echo $permiso->idPermiso; ?>" <?php 
						if ($usuario->permiso and $permiso->idPermiso == $usuario->permiso->idPermiso) { 
						?>selected="selected"<?php } ?>><?php echo formato_html($permiso->permiso); ?></option>
			<?php } ?>
		</select>
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div style="float: right;">
		<input type="submit" value="Guardar usuario" />
		<input type="button" value="Cancelar" onclick="window.location.href = '<?php vlink('usuarios'); ?>';"
				style="color:#A00" />
	</div>
</form>
<script type="text/javascript">
	document.getElementById("login").focus();
</script>