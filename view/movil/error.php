<?php header('HTTP/1.0 404 Not Found'); ?>
<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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