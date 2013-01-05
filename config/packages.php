<?php 
	if (!isset($_SESSION['key']) or !isset($key) or $key != $_SESSION['key'])
		exit();
	echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<packages>
	<package name="contenido">
    	<action name="index" method="index" class="contenidoAction">
            <result name="success">/index.php</result>
            <result name="error">/error.php</result>
        </action>
	</package>
	<package name="contenidoTexto">
    	<action name="consulta_contenidos_texto" method="index" class="contenidoTextoAction">
            <result name="success">/admin/contenidoTexto/index.php</result>
            <result name="error">/admin/error.php</result>
        </action>
	</package>
</packages>