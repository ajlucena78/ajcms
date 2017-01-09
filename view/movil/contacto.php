<h1>FORMULARIO DE CONTACTO</h1>
<hr />
<?php if ($error) { ?>
	<p style="color: red; text-align: center;">
		<br />
		<strong><?php echo formato_html($error); ?></strong>
	</p>
<?php } ?>
<form method="post" action="<?php vlink('gracias'); ?>">
	<div>Nombre de la persona de contacto:</div>
	<div>
		<input type="text" name="nombre" id="nombre" 
				value="<?php if (isset($_POST['nombre'])) echo $_POST['nombre']; ?>" />
	</div>
	<div><br />Tel&eacute;fono:</div>
	<div>
		<input type="text" name="telefono" id="telefono" 
				value="<?php if (isset($_POST['telefono'])) echo $_POST['telefono']; ?>" />
	</div>
	<div><br />Correo electr&oacute;nico:</div>
	<div>
		<input type="text" name="email" id="email" 
				value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" />
	</div>
	<div><br />Mensaje:</div>
	<div>
		<textarea name="comentario" id="comentario" rows="6" cols="40"><?php if (isset($_POST['comentario'])) 
				echo $_POST['comentario']; ?></textarea>
	</div>
	<div class="texto_cen">
		<br />
		<input type="submit" value="ENVIAR MENSAJE" id="enviar" name="enviar" class="boton" />
	</div>
</form>
<div>
	<br />
	<span style="color: gray;">Puede conocer el uso que damos al tratamiento de sus datos personales 
		en nuestro <a href="aviso-legal">AVISO LEGAL (clic para mostrar)</a>. El uso de todos los 
		mecanismos de contacto de nuestra p&aacute;gina implican la aceptaci&oacute;n de nuestra 
		pol&iacute;tica de privacidad recogida en el enlace aportado.</span>
</div>
<div style="height: 10pt;"></div>
<?php if ($error) { ?>
	<script type="text/javascript">
	<!--
		window.alert('<?php echo $error; ?>');
	//-->
	</script>
<?php } ?>