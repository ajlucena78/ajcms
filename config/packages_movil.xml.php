<?php
	if (!isset($XML_KEY) or $XML_KEY != date('Ymdh'))
		exit();
	echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<packages>
	<package name="contenido">
    	<action name="index" method="index" class="contenidoAction">
            <result name="success">movil/index.php</result>
            <result name="error">movil/error.php</result>
        </action>
        <action name="mas-fotos" method="mas_fotos_movil" class="contenidoAction">
            <result name="success">movil/mas-fotos.php</result>
            <result name="error">movil/error.php</result>
        </action>
	</package>
	<package name="contenido-texto">
        <action name="buscar" method="buscador" class="contenidoTextoAction" frame="movil">
            <result name="success">buscador.php</result>
            <result name="error">movil/error.php</result>
        </action>
	</package>
	<package name="imagen">
		<action name="ver_imagen" method="show" class="imagenAction" frame="movil">
            <result name="success">movil/imagen.php</result>
            <result name="error">movil/error.php</result>
        </action>
	</package>
	<package name="correo">
		<action name="baja-email-usuario" method="baja_email" class="CorreoAction" frame="movil">
            <result name="success">correos/baja_email.php</result>
            <result name="error">movil/error.php</result>
        </action>
    </package>
	<package name="public">
        <action name="formulario-de-contacto" method="contacto" class="publicAction" frame="movil">
            <result name="success">movil/contacto.php</result>
        </action>
        <action name="gracias" method="envio_contacto" class="publicAction" frame="movil">
            <result name="success">gracias.php</result>
            <result name="error">movil/contacto.php</result>
            <result name="fatal">movil/error.php</result>
        </action>
        <action name="localizacion-sevilla" method="mapa" class="publicAction" frame="movil">
            <result name="success">movil/mapa.php</result>
        </action>
	</package>
	<package name="menu">
    	<action name="menu" method="index" class="menuAction" frame="movil">
            <result name="success">movil/menu.php</result>
            <result name="error">movil/error.php</result>
        </action>
	</package>
</packages>