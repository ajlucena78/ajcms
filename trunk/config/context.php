<?php 
	if (!isset($_SESSION['key']) or !isset($key) or $key != $_SESSION['key'])
		exit();
	echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<context>
	<appname>Madera y Arte</appname>
	<!-- Origen de datos -->
    <db>
        <url value="mysql:dbname=maderayarte.com;host=localhost" />
        <username value="root" />
        <password value="bioh" />
    </db>
	<!-- Services -->
	<service id="menuService" class="MenuService" />
	<service id="contenidoService" class="ContenidoService" />
	<service id="contenidoTextoService" class="ContenidoTextoService" />
	<!-- Actions -->
	<action id="contenidoAction" class="ContenidoAction">
		<service ref="menuService" />
		<service ref="contenidoService" />
		<service ref="contenidoTextoService" />
    </action>
    <action id="contenidoTextoAction" class="ContenidoTextoAction">
		<service ref="contenidoTextoService" />
    </action>
</context>