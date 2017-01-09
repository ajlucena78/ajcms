<h1>Inicio de sesi&oacute;n de usuario</h1>
<hr />
<?php if ($error) { ?>
	<p style="text-align: center; margin-top: 20pt;">
		<h2 style="color: red;"><?php echo formato_html($error); ?></h2>
	</p>
<?php } ?>
<div style="width: 250pt; margin: auto; text-align: left; margin-bottom: 100pt;">
	<form method="post" action="<?php vlink($actionForm); ?>">
		<br />&nbsp;
		<div style="padding-bottom: 1%;">
			<div style="float: left; width: 36%;">Usuario:</div>
			<div style="float: right; width: 56%;">
				<input type="text" name="PHP_AUTH_USER" id="PHP_AUTH_USER" class="form-text" maxlength="20" 
						value="<?php if (isset($_POST['PHP_AUTH_USER'])) echo $_POST['PHP_AUTH_USER']; ?>" 
						style="width: 100%;" />
			</div>
			<div style="clear: both;"></div>
		</div>
		<div style="padding-bottom: 1%;">
			<div style="float: left; width: 36%;">Contrase&ntilde;a:</div>
			<div style="float: right; width: 56%;">
				<input type="password" name="PHP_AUTH_PW" class="form-text" id="PHP_AUTH_PW" maxlength="20" 
				value="" style="width: 100%;" /></div>
			<div style="clear: both;"></div>
		</div>
		<div style="float: right;">
			<br />
			<input type="submit" value=" Iniciar sesi&oacute;n " id="enviar" name="enviar" />
		</div>
	</form>
</div>
<script type="text/javascript">
	<!--
		get('PHP_AUTH_USER').focus();
	//-->
</script>