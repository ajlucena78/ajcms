<?php
	if (!isset($XML_KEY) or $XML_KEY != date('Ymdh'))
		exit();
	echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<context>
	<appname>MyPHP</appname>
	<!-- Origen de datos -->
    <db>
        <url value="mysql:dbname=myphp;host=localhost;charset=UTF8" />
        <username value="myphp" />
        <password value="myPhp2017" />
    </db>
	<!-- Services -->
	<service id="menuService" class="MenuService" />
	<service id="contenidoService" class="ContenidoService" />
	<service id="contenidoTextoService" class="ContenidoTextoService" />
	<service id="contenidoFicheroService" class="ContenidoFicheroService" />
	<service id="contenidoEnlaceService" class="ContenidoEnlaceService" />
	<service id="contenidoOfertaService" class="ContenidoOfertaService" />
	<service id="contenidoCorreoService" class="ContenidoCorreoService" />
	<service id="noticiaService" class="NoticiaService" />
	<service id="usuarioService" class="UsuarioService" />
	<service id="contenidoImagenService" class="ContenidoImagenService" />
	<service id="contenidoVideoService" class="ContenidoVideoService" />
	<service id="contenidoVideoService" class="ContenidoVideoService" />
	<service id="envioCorreoService" class="EnvioCorreoService" />
	<service id="listaCorreoService" class="ListaCorreoService" />
	<service id="correoService" class="CorreoService" />
	<service id="contenidoOfertaService" class="ContenidoOfertaService" />
	<service id="permisoService" class="PermisoService" />
	<service id="contenidoArchivoService" class="ContenidoArchivoService" />
	<!-- Actions -->
	<action id="contenidoAction" class="ContenidoAction">
		<service ref="menuService" />
		<service ref="contenidoService" />
		<service ref="contenidoFicheroService" />
		<service ref="usuarioService" />
		<service ref="contenidoImagenService" />
		<service ref="contenidoVideoService" />
		<service ref="contenidoTextoService" />
		<service ref="contenidoCorreoService" />
		<service ref="contenidoEnlaceService" />
		<service ref="contenidoArchivoService" />
    </action>
    <action id="contenidoTextoAction" class="ContenidoTextoAction"></action>
    <action id="contenidoEnlaceAction" class="ContenidoEnlaceAction"></action>
	<action id="contenidoCorreoAction" class="ContenidoCorreoAction"></action>
    <action id="contenidoOfertaAction" class="ContenidoOfertaAction">
		<service ref="contenidoOfertaService" />
    </action>
    <action id="menuAction" class="MenuAction">
		<service ref="menuService" />
		<service ref="contenidoService" />
		<service ref="usuarioService" />
		<service ref="contenidoTextoService" />
    </action>
    <action id="contenidoImagenAction" class="ContenidoImagenAction">
		<service ref="menuService" />
		<service ref="contenidoImagenService" />
    </action>
	<action id="publicAction" class="PublicAction">
		<service ref="menuService" />
    </action>
    <action id="usuarioAction" class="UsuarioAction">
		<service ref="usuarioService" />
		<service ref="permisoService" />
		<service ref="menuService" />
    </action>
    <action id="envioCorreoAction" class="EnvioCorreoAction">
		<service ref="envioCorreoService" />
		<service ref="contenidoCorreoService" />
		<service ref="listaCorreoService" />
		<service ref="usuarioService" />
    </action>
    <action id="listaCorreoAction" class="ListaCorreoAction">
		<service ref="listaCorreoService" />
		<service ref="usuarioService" />
    </action>
    <action id="correoAction" class="CorreoAction">
		<service ref="correoService" />
		<service ref="listaCorreoService" />
		<service ref="usuarioService" />
    </action>
    <action id="contenidoArchivoAction" class="ContenidoArchivoAction">
    	<service ref="contenidoArchivoService" />
    </action>
</context>