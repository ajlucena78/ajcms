<?php
	header('Content-Type:text/plain');
	header('Content-Disposition: attachment; filename="' . $lista->nombre_lista_correo . '.csv"');
?>
<?php foreach ($lista->correos as $correo) { ?><?php if ($correo->baja) continue; ?><?php 
		echo $correo->email_correo; ?>;<?php } ?>