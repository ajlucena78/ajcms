<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/xhtml; charset=utf-8" />
		<title>Error</title>
	</head>
	<body>
		<div style="color: red;">
			ERROR
		</div>
		<div>
			<?php if ($error) { ?>
				<span class="error"><?php echo formato_html($error); ?></span>
			<?php }else{ ?>
				Se ha producido un error en la carga de la web
			<?php } ?>
		</div>
	</body>
</html>