<?php
	if (!isset($XML_KEY) or $XML_KEY != date('Ymdh'))
		exit();
	echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<packages>
	<package name="contenido">
    	<action name="index" method="index" class="contenidoAction">
            <result name="success">index.php</result>
            <result name="error">error.php</result>
            <result name="imagen" frame="index">imagen.php</result>
            <result name="login">inicio-sesion</result>
        </action>
        <action name="sitemap" method="sitemap" class="contenidoAction">
            <result name="success">sitemap.php</result>
            <result name="error">error.php</result>
        </action>
		<action name="baja-contenido" method="baja" class="contenidoAction" frame="admin">
			<result name="success">admin/contenido/baja_contenido.php</result>
            <result name="error">admin/contenido/baja_contenido.php</result>
            <result name="fatal">admin/error.php</result>
            <result name="enlaces">enlaces</result>
            <result name="mensajes">mensajes</result>
            <result name="paginas">contenidos-texto</result>
            <result name="ofertas">ofertas</result>
        </action>
	</package>
	<package name="contenido-texto">
    	<action name="contenidos-texto" method="consulta" class="contenidoTextoAction" frame="admin">
            <result name="success">admin/contenidoTexto/index_paginas.php</result>
            <result name="error">admin/error.php</result>
        </action>
        <action name="alta-contenido-texto" method="alta" class="contenidoTextoAction" frame="admin">
            <result name="success">edicion-contenido-texto</result>
            <result name="error">admin/contenidoTexto/alta_pagina.php</result>
            <result name="fatal">admin/error.php</result>
        </action>
        <action name="edicion-contenido-texto" method="edicion" class="contenidoTextoAction" frame="admin">
            <result name="success">admin/contenidoTexto/edicion_pagina.php</result>
            <result name="error">admin/contenidoTexto/edicion_pagina.php</result>
            <result name="fatal">admin/error.php</result>
            <result name="menus">menus</result>
        </action>
        <action name="buscar" method="buscador" class="contenidoTextoAction" frame="index">
            <result name="success">buscador.php</result>
            <result name="error">error.php</result>
        </action>
	</package>
	<package name="enlace">
    	<action name="enlaces" method="consulta" class="contenidoEnlaceAction" frame="admin">
            <result name="success">admin/enlace/index_enlaces.php</result>
            <result name="error">admin/error.php</result>
        </action>
        <action name="alta-enlace" method="alta" class="contenidoEnlaceAction" frame="admin">
            <result name="success">admin/enlace/alta_enlace.php</result>
            <result name="error">admin/enlace/alta_enlace.php</result>
            <result name="fatal">admin/error.php</result>
            <result name="ok">enlaces</result>
        </action>
        <action name="edicion-enlace" method="edicion" class="contenidoEnlaceAction" frame="admin">
            <result name="success">admin/enlace/edicion_enlace.php</result>
            <result name="error">admin/enlace/edicion_enlace.php</result>
            <result name="fatal">admin/error.php</result>
            <result name="ok">enlaces</result>
        </action>
	</package>
	<package name="menu">
    	<action name="menus" method="consulta" class="menuAction" frame="admin">
            <result name="success">admin/menu/index_menus.php</result>
            <result name="error">admin/menu/index_menus.php</result>
            <result name="fatal">admin/error.php</result>
            <result name="contenido">edicion-contenido-texto</result>
        </action>
    </package>
	<package name="imagen">
		<action name="ver_imagen" method="show" class="contenidoImagenAction" frame="index">
            <result name="success">imagen.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="sitemap-imagenes" method="sitemap" class="contenidoImagenAction">
            <result name="success">sitemap-imagenes.php</result>
            <result name="error">error.php</result>
        </action>
	</package>
	<package name="contenido-oferta">
        <action name="ofertas-promociones" method="index" class="contenidoOfertaAction" frame="index">
            <result name="success">oferta/ofertas.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="oferta" method="show" class="contenidoOfertaAction" frame="index">
            <result name="success">oferta/oferta.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="ofertas" method="consulta" class="contenidoOfertaAction" frame="admin">
            <result name="success">admin/oferta/index_ofertas.php</result>
            <result name="error">admin/error.php</result>
        </action>
        <action name="alta-oferta" method="alta" class="contenidoOfertaAction" frame="admin">
            <result name="success">admin/oferta/alta_oferta.php</result>
            <result name="error">admin/oferta/alta_oferta.php</result>
            <result name="fatal">admin/error.php</result>
        </action>
        <action name="edicion-oferta" method="edicion" class="contenidoOfertaAction" frame="admin">
            <result name="success">admin/oferta/edicion_oferta.php</result>
            <result name="error">admin/oferta/edicion_oferta.php</result>
            <result name="fatal">admin/error.php</result>
        </action>
	</package>
	<package name="correo">
    	<action name="envios" method="index" class="envioCorreoAction" frame="admin">
            <result name="success">admin/correo/envios.php</result>
            <result name="error">admin/error.php</result>
        </action>
        <action name="programa" method="programa" class="envioCorreoAction" frame="admin">
            <result name="success">admin/correo/alta_envio.php</result>
            <result name="error">admin/correo/alta_envio.php</result>
            <result name="fatal">admin/error.php</result>
            <result name="envios">envios</result>
        </action>
        <action name="mensajes" method="consulta" class="contenidoCorreoAction" frame="admin">
            <result name="success">admin/correo/index_mensajes.php</result>
            <result name="error">admin/error.php</result>
        </action>
        <action name="alta-mensaje" method="alta" class="contenidoCorreoAction" frame="admin">
            <result name="success">admin/correo/alta_mensaje.php</result>
            <result name="error">admin/correo/alta_mensaje.php</result>
            <result name="fatal">admin/error.php</result>
        </action>
        <action name="edicion-mensaje" method="edicion" class="contenidoCorreoAction" frame="admin">
            <result name="success">admin/correo/edicion_mensaje.php</result>
            <result name="error">admin/correo/edicion_mensaje.php</result>
            <result name="fatal">admin/error.php</result>
        </action>
        <action name="baja-envio" method="baja" class="envioCorreoAction" frame="admin">
            <result name="success">admin/correo/baja_envio.php</result>
            <result name="error">admin/error.php</result>
            <result name="ok">envios</result>
        </action>
        <action name="listas-correo" method="consulta" class="listaCorreoAction" frame="admin">
            <result name="success">admin/correo/listas.php</result>
            <result name="error">admin/error.php</result>
        </action>
        <action name="alta-lista" method="alta" class="listaCorreoAction" frame="admin">
            <result name="success">admin/correo/alta_lista.php</result>
            <result name="error">admin/correo/alta_lista.php</result>
            <result name="fatal">admin/error.php</result>
            <result name="ok">listas-correo</result>
        </action>
        <action name="edicion-lista" method="edicion" class="listaCorreoAction" frame="admin">
            <result name="success">admin/correo/edicion_lista.php</result>
            <result name="error">admin/correo/edicion_lista.php</result>
            <result name="fatal">admin/error.php</result>
            <result name="ok">listas-correo</result>
        </action>
        <action name="baja-lista" method="baja" class="listaCorreoAction" frame="admin">
            <result name="success">admin/correo/baja_lista.php</result>
            <result name="error">admin/error.php</result>
            <result name="ok">listas-correo</result>
        </action>
        <action name="buscar-email" method="email" class="correoAction" frame="admin">
            <result name="success">admin/correo/buscar_email.php</result>
            <result name="error">admin/error.php</result>
        </action>
        <action name="ver-email" method="ver_email" class="correoAction" frame="admin">
            <result name="success">admin/correo/ver_email.php</result>
            <result name="error">admin/error.php</result>
        </action>
        <action name="baja-correo" method="baja" class="correoAction" frame="admin">
            <result name="success">admin/correo/baja_correo.php</result>
            <result name="error">admin/error.php</result>
            <result name="listas">listas-correo</result>
        </action>
        <action name="alta-correo" method="alta" class="correoAction" frame="admin">
            <result name="success">admin/correo/alta_correo.php</result>
            <result name="error">admin/correo/alta_correo.php</result>
            <result name="fatal">admin/error.php</result>
            <result name="listas">listas-correo</result>
        </action>
        <action name="edicion-correo" method="edicion" class="correoAction" frame="admin">
            <result name="success">admin/correo/edicion_correo.php</result>
            <result name="error">admin/correo/edicion_correo.php</result>
            <result name="fatal">admin/error.php</result>
            <result name="listas">listas-correo</result>
        </action>
		<action name="informe-envio" method="informe" class="envioCorreoAction" frame="admin">
            <result name="success">admin/correo/informe_programa.php</result>
            <result name="error">error.php</result>
        </action>
		<action name="baja-email-usuario" method="baja_email" class="correoAction">
            <result name="success">correos/baja_email.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="exportar-lista-correo" method="exportar" class="listaCorreoAction">
            <result name="success">admin/correo/exportar_lista.php</result>
            <result name="fatal">admin/error.php</result>
        </action>
    </package>
	<package name="public">
        <action name="formulario-de-contacto" method="contacto" class="publicAction" frame="index">
            <result name="success">contacto.php</result>
        </action>
        <action name="gracias" method="envio_contacto" class="publicAction" frame="index">
            <result name="success">gracias.php</result>
            <result name="error">contacto.php</result>
            <result name="fatal">error.php</result>
        </action>
        <action name="localizacion-sevilla" method="mapa" class="publicAction" frame="index">
            <result name="success">mapa.php</result>
        </action>
		<action name="movil" method="version_movil" class="publicAction">
            <result name="success">index</result>
        </action>
	</package>
	<package name="usuario">
		<action name="logout" method="logout" class="usuarioAction">
            <result name="success">logout.php</result>
            <result name="error">error.php</result>
        </action>
    	<action name="usuarios" method="consulta" class="usuarioAction" frame="admin">
            <result name="success">admin/usuario/index_usuarios.php</result>
            <result name="error">admin/error.php</result>
        </action>
        <action name="alta-usuario" method="alta" class="usuarioAction" frame="admin">
            <result name="success">admin/usuario/alta_usuario.php</result>
            <result name="error">admin/usuario/alta_usuario.php</result>
            <result name="fatal">admin/error.php</result>
            <result name="ok">usuarios</result>
        </action>
        <action name="edicion-usuario" method="edicion" class="usuarioAction" frame="admin">
            <result name="success">admin/usuario/edicion_usuario.php</result>
            <result name="error">admin/usuario/edicion_usuario.php</result>
            <result name="fatal">admin/error.php</result>
            <result name="ok">usuarios</result>
        </action>
        <action name="baja-usuario" method="baja" class="usuarioAction" frame="admin">
            <result name="success">admin/usuario/baja_usuario.php</result>
            <result name="error">admin/error.php</result>
            <result name="ok">usuarios</result>
        </action>
        <action name="inicio-sesion" method="inicio" class="usuarioAction" frame="index">
            <result name="success"></result>
            <result name="error">inicio-sesion.php</result>
        </action>
        <action name="inicio-sesion-adm" method="inicio_adm" class="usuarioAction" frame="admin">
            <result name="success"></result>
            <result name="error">inicio-sesion.php</result>
        </action>
	</package>
	<package name="archivo">
		<action name="descarga-archivo" method="descarga" class="contenidoArchivoAction">
            <result name="success">descarga.php</result>
            <result name="error">error.php</result>
        </action>
    </package>
</packages>