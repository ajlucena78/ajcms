<h1>Formulario de contacto</h1>
<hr />
<?php if ($error) { ?>
	<p style="color: red; text-align: center;">
		<br />
		<?php echo formato_html($error); ?>
	</p>
<?php } ?>
<div style="width: 100%;">
	<form method="post" action="<?php vlink('gracias'); ?>">
		<br />
		<div style="padding-bottom: 1%;">
			<div style="float: left; width: 30%;">Nombre de la persona de contacto:</div>
			<div style="float: right; width: 70%;">
				<input type="text" name="nombre" id="nombre" class="form-text" 
						value="<?php if (isset($_POST['nombre'])) echo $_POST['nombre']; ?>" 
						style="width: 100%;" />
			</div>
			<div style="clear: both;"></div>
		</div>
		<div style="padding-bottom: 1%;">
			<div style="float: left; width: 30%;">Tel&eacute;fono:</div>
			<div style="float: right; width: 70%;">
				<input type="text" name="telefono" class="form-text" id="telefono" 
						value="<?php if (isset($_POST['telefono'])) echo $_POST['telefono']; ?>" 
						style="width: 100%;" /></div>
			<div style="clear: both;"></div>
		</div>
		<div style="padding-bottom: 1%;">
			<div style="float: left; width: 30%;">Correo electr&oacute;nico:</div>
			<div style="float: right; width: 70%;">
				<input type="text" name="email" id="email" class="form-text" 
						value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" 
						style="width: 100%;" />
			</div>
			<div style="clear: both;"></div>
		</div>
		<div>
			<div>Mensaje:</div>
			<div>
				<textarea name="comentario" id="comentario" rows="6" cols="40" class="form-textarea" 
						style="width: 100%;"><?php if (isset($_POST['comentario'])) 
						echo $_POST['comentario']; ?></textarea>
				</div>
		</div>
		<div style="float: right;">
			<br />
			<input type="submit" class="form-submit" value="Enviar mensaje" 
					id="enviar" name="enviar" />
		</div>
	</form>
	<p>
		<span style="font-size: x-small;">Puede conocer el uso que damos al tratamiento de sus datos personales 
			en nuestro <a href="aviso-legal">AVISO LEGAL (clic para mostrar)</a>. El uso de todos los 
			mecanismos de contacto de nuestra p&aacute;gina implican la aceptaci&oacute;n de nuestra 
			pol&iacute;tica de privacidad recogida en el enlace aportado.</span>
	</p>
</div>
<?php if ($error) { ?>
	<script type="text/javascript">
	<!--
		window.alert('<?php echo $error; ?>');
	//-->
	</script>
<?php } ?>