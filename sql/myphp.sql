-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 09-01-2017 a las 21:05:34
-- Versión del servidor: 5.5.53
-- Versión de PHP: 5.4.44

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `myphp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Configuracion`
--

CREATE TABLE IF NOT EXISTS `Configuracion` (
  `nombre` varchar(50) NOT NULL,
  `valor` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `Configuracion`
--

INSERT INTO `Configuracion` (`nombre`, `valor`) VALUES
('hoy', NULL),
('id_ultimo_email', NULL),
('mensajes_enviados_dia', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Contenido`
--

CREATE TABLE IF NOT EXISTS `Contenido` (
  `idContenido` int(4) NOT NULL AUTO_INCREMENT,
  `referencia` varchar(20) NOT NULL,
  `servido` int(12) NOT NULL DEFAULT '0',
  `descripcion` varchar(255) NOT NULL,
  `tipo` int(2) NOT NULL DEFAULT '0',
  `permalink` varchar(100) DEFAULT NULL,
  `idUsuario` int(4) DEFAULT NULL,
  `privado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idContenido`),
  UNIQUE KEY `referencia` (`referencia`),
  UNIQUE KEY `permalink` (`permalink`),
  KEY `tipo` (`tipo`),
  KEY `idUsuario` (`idUsuario`),
  KEY `permalink_2` (`permalink`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='Rutas de las páginas de contenidos' AUTO_INCREMENT=197 ;

--
-- Volcado de datos para la tabla `Contenido`
--

INSERT INTO `Contenido` (`idContenido`, `referencia`, `servido`, `descripcion`, `tipo`, `permalink`, `idUsuario`, `privado`) VALUES
(2, 'index_', 0, 'Página principal', 0, 'pagina-principal', 1, 0),
(14, '513702', 0, 'Datos de contacto', 0, 'informacion-telefono-email-contacto-localizacion-mapa-gps-coordenadas-fax', 1, 0),
(81, 'emacab', 0, 'Cabecera', 3, NULL, 1, 0),
(82, 'emapie', 0, 'Pie', 3, NULL, 1, 0),
(126, 'cookie', 0, 'Información sobre cookies', 0, 'informacion-cookies', 1, 0),
(127, '176062', 0, 'Aviso legal y polí­tica de privacidad de datos', 0, 'aviso-legal', 1, 0),
(141, '373151', 0, 'Localización de nuestras sedes', 2, 'localizacion-coordenadas-gps-mapa-plano-callejero', 1, 0),
(156, '331917', 0, 'Formulario de contacto', 2, 'formulario-contacto', 1, 0),
(163, '224267', 0, 'Administración', 2, 'adm', 1, 0),
(165, '796670', 0, 'INFORMACIÓN Y CONTACTO', 0, 'informacion-contacto', 1, 0),
(172, '837066', 0, 'Polí­tica de calidad y medio ambiente', 0, 'politica-calidad-medio-ambiente', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ContenidoCorreo`
--

CREATE TABLE IF NOT EXISTS `ContenidoCorreo` (
  `idContenido` int(4) NOT NULL,
  `texto` text NOT NULL,
  `tipo` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idContenido`),
  KEY `tipo` (`tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `ContenidoCorreo`
--

INSERT INTO `ContenidoCorreo` (`idContenido`, `texto`, `tipo`) VALUES
(81, '', 1),
(82, '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ContenidoEnlace`
--

CREATE TABLE IF NOT EXISTS `ContenidoEnlace` (
  `idContenido` int(4) NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL DEFAULT '',
  `h1` varchar(255) DEFAULT NULL COMMENT 'Etiqueta de cabecera <h1>',
  `metadesc` text COMMENT 'Etiqueta <meta-description>',
  `tipoEnlace` int(2) NOT NULL DEFAULT '1' COMMENT '1: directo. 2: oculto.',
  PRIMARY KEY (`idContenido`),
  KEY `url` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `ContenidoEnlace`
--

INSERT INTO `ContenidoEnlace` (`idContenido`, `url`, `h1`, `metadesc`, `tipoEnlace`) VALUES
(141, 'localizacion', NULL, NULL, 1),
(156, 'formulario-de-contacto', NULL, NULL, 1),
(163, 'contenidos-texto', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ContenidoFichero`
--

CREATE TABLE IF NOT EXISTS `ContenidoFichero` (
  `idContenido` int(4) NOT NULL,
  `ruta` varchar(255) NOT NULL,
  `menu` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idContenido`),
  UNIQUE KEY `ruta` (`ruta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ContenidoImagen`
--

CREATE TABLE IF NOT EXISTS `ContenidoImagen` (
  `idImagen` int(8) NOT NULL,
  `idContenido` int(4) NOT NULL,
  `orden` int(2) NOT NULL DEFAULT '1',
  `alineamiento` int(1) NOT NULL DEFAULT '0',
  `tamano` int(2) NOT NULL DEFAULT '33',
  `oculta` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idImagen`,`idContenido`),
  KEY `idContenido` (`idContenido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='Relación entre imágenes y contenidos de texto';

--
-- Volcado de datos para la tabla `ContenidoImagen`
--

INSERT INTO `ContenidoImagen` (`idImagen`, `idContenido`, `orden`, `alineamiento`, `tamano`, `oculta`) VALUES
(1, 14, 1, 2, 33, 1),
(24, 127, 1, 2, 33, 1),
(25, 172, 1, 2, 33, 1),
(26, 126, 1, 2, 33, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ContenidoOferta`
--

CREATE TABLE IF NOT EXISTS `ContenidoOferta` (
  `idContenido` int(4) NOT NULL,
  `texto` text NOT NULL,
  `precio` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idContenido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ContenidoTexto`
--

CREATE TABLE IF NOT EXISTS `ContenidoTexto` (
  `idContenido` int(4) NOT NULL,
  `texto` text NOT NULL,
  `encabezado` varchar(255) NOT NULL,
  `texto2` text NOT NULL,
  `metadesc` text,
  `pie` text COMMENT 'Texto que sale al final de la página',
  `textoMovil` tinyint(1) NOT NULL DEFAULT '0',
  `pieMovil` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idContenido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `ContenidoTexto`
--

INSERT INTO `ContenidoTexto` (`idContenido`, `texto`, `encabezado`, `texto2`, `metadesc`, `pie`, `textoMovil`, `pieMovil`) VALUES
(2, '', 'Presentación', '', '', '', 1, 0),
(14, '<p>Para solicitar informaci&oacute;n o contactar con nosotros, puede hacerlo a trav&eacute;s de los siguientes medios:</p>\r\n<p>...</p>\r\n<p>Tambi&eacute;n puede ponerse en contacto con nosotros a trav&eacute;s de este <strong><a href="formulario-de-contacto">formulario de contacto</a></strong>.</p>\r\n<p>Puede conocer el uso que damos al tratamiento de sus datos personales en nuestro <a href="aviso-legal">AVISO LEGAL (clic para mostrar)</a>. El uso de todos los mecanismos de contacto de nuestra p&aacute;gina implican la aceptaci&oacute;n de nuestra pol&iacute;tica de privacidad recogida en el enlace aportado.</p>', 'Datos de Contacto', '', '', '', 1, 0),
(126, '', 'Información sobre cookies', '', '', '', 1, 0),
(127, '', 'Aviso legal y Polí­tica de privacidad de datos', '', '', '', 1, 0),
(165, '', 'Información y Contacto', '', '', '', 1, 0),
(172, '', 'Polí­tica de calidad y medio ambiente', '', '', '', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ContenidoVideo`
--

CREATE TABLE IF NOT EXISTS `ContenidoVideo` (
  `id_video` int(6) NOT NULL,
  `idContenido` int(4) NOT NULL,
  `orden` int(2) NOT NULL DEFAULT '1',
  `alineamiento` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_video`,`idContenido`),
  KEY `idContenido` (`idContenido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='Relación entre imágenes y contenidos de texto';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Correo`
--

CREATE TABLE IF NOT EXISTS `Correo` (
  `id_correo` int(12) NOT NULL AUTO_INCREMENT,
  `email_correo` varchar(255) NOT NULL,
  `referencia_correo` varchar(255) NOT NULL,
  `baja` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_correo`),
  UNIQUE KEY `email_correo` (`email_correo`),
  UNIQUE KEY `referencia_correo` (`referencia_correo`),
  KEY `baja` (`baja`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CorreoListaCorreo`
--

CREATE TABLE IF NOT EXISTS `CorreoListaCorreo` (
  `id_lista_correo` int(4) NOT NULL,
  `id_correo` int(12) NOT NULL,
  PRIMARY KEY (`id_lista_correo`,`id_correo`),
  KEY `id_correo` (`id_correo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `EnvioCorreo`
--

CREATE TABLE IF NOT EXISTS `EnvioCorreo` (
  `id_envio_correo` int(12) NOT NULL AUTO_INCREMENT,
  `fecha_programa_envio` datetime NOT NULL,
  `idContenido` int(4) NOT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `resultado` text,
  `ok` tinyint(1) DEFAULT NULL,
  `fichero_adjunto` varchar(255) DEFAULT NULL,
  `idUsuario` int(4) DEFAULT NULL,
  PRIMARY KEY (`id_envio_correo`),
  KEY `fecha_programa_envio` (`fecha_programa_envio`),
  KEY `id_contenido` (`idContenido`),
  KEY `fecha_inicio` (`fecha_inicio`,`fecha_fin`),
  KEY `ok` (`ok`),
  KEY `idUsuario` (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `EnvioCorreoLista`
--

CREATE TABLE IF NOT EXISTS `EnvioCorreoLista` (
  `id_envio_correo` int(12) NOT NULL,
  `id_lista_correo` int(4) NOT NULL,
  PRIMARY KEY (`id_envio_correo`,`id_lista_correo`),
  KEY `id_lista_correo` (`id_lista_correo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Imagen`
--

CREATE TABLE IF NOT EXISTS `Imagen` (
  `idImagen` int(8) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) DEFAULT NULL,
  `extension` varchar(10) NOT NULL,
  `tam` int(12) NOT NULL DEFAULT '0',
  `tipo` varchar(50) DEFAULT NULL,
  `idUsuario` int(4) DEFAULT NULL,
  `permalink` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idImagen`),
  UNIQUE KEY `permalink` (`permalink`),
  KEY `idUsuario` (`idUsuario`),
  KEY `permalink_2` (`permalink`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='Imágenes de los contenidos' AUTO_INCREMENT=140 ;

--
-- Volcado de datos para la tabla `Imagen`
--

INSERT INTO `Imagen` (`idImagen`, `titulo`, `extension`, `tam`, `tipo`, `idUsuario`, `permalink`) VALUES
(1, 'Teléfonos de contacto', 'jpg', 500576, 'image/jpeg', NULL, 'telefonos-contacto'),
(2, 'Horarios de apertura', 'jpg', 70355, 'image/jpeg', NULL, 'horarios-apertura'),
(24, 'Política de protección de datos', 'jpg', 18253, 'image/jpeg', NULL, 'politica-proteccion-datos'),
(25, 'Política medioambiental', 'jpg', 52258, 'image/jpeg', NULL, 'politica-medioambiental'),
(26, 'Información sobre el uso de cookies', 'jpg', 27501, 'image/jpeg', NULL, 'informacion-sobre-uso-cookies');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ListaCorreo`
--

CREATE TABLE IF NOT EXISTS `ListaCorreo` (
  `id_lista_correo` int(4) NOT NULL AUTO_INCREMENT,
  `nombre_lista_correo` varchar(255) NOT NULL,
  `idUsuario` int(4) DEFAULT NULL,
  PRIMARY KEY (`id_lista_correo`),
  UNIQUE KEY `nombre_lista_correo` (`nombre_lista_correo`),
  KEY `idUsuario` (`idUsuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Menu`
--

CREATE TABLE IF NOT EXISTS `Menu` (
  `idMenu` int(6) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) NOT NULL,
  `idPadre` int(6) DEFAULT NULL,
  `idContenido` int(4) DEFAULT NULL,
  `orden` int(4) NOT NULL DEFAULT '0',
  `idUsuario` int(4) DEFAULT NULL,
  PRIMARY KEY (`idMenu`),
  UNIQUE KEY `idPadre` (`idPadre`,`orden`),
  KEY `id_padre` (`idPadre`),
  KEY `idContenido` (`idContenido`),
  KEY `idUsuario` (`idUsuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='Menú de la web' AUTO_INCREMENT=308 ;

--
-- Volcado de datos para la tabla `Menu`
--

INSERT INTO `Menu` (`idMenu`, `titulo`, `idPadre`, `idContenido`, `orden`, `idUsuario`) VALUES
(1, 'Información y Contacto', NULL, 165, 1, NULL),
(188, 'Presentación', 1, 2, 7, NULL),
(192, 'Contacto - Email', 1, 14, 1, NULL),
(193, 'Localizaciones - MAPAS', 1, 141, 3, NULL),
(249, 'Formulario de contacto', 1, 156, 2, NULL),
(284, 'Aviso legal', 1, 127, 4, 1),
(285, 'Información sobre cookies', 1, 126, 5, 1),
(288, 'Política medio ambiental', 1, 172, 6, 1),
(307, 'Página principal', NULL, 2, 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Noticia`
--

CREATE TABLE IF NOT EXISTS `Noticia` (
  `idNoticia` int(12) NOT NULL AUTO_INCREMENT,
  `referencia` varchar(6) NOT NULL DEFAULT '',
  `servido` int(12) NOT NULL DEFAULT '0',
  `descripcion` varchar(255) NOT NULL DEFAULT '',
  `permalink` varchar(100) DEFAULT NULL,
  `texto` text NOT NULL,
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`idNoticia`),
  UNIQUE KEY `referencia` (`referencia`),
  UNIQUE KEY `permalink` (`permalink`),
  KEY `fecha` (`fecha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='Rutas de las páginas de contenidos' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `NoticiaImagen`
--

CREATE TABLE IF NOT EXISTS `NoticiaImagen` (
  `idImagen` int(8) NOT NULL DEFAULT '0',
  `idNoticia` int(12) NOT NULL DEFAULT '0',
  `orden` int(2) NOT NULL DEFAULT '1',
  `alineamiento` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idImagen`,`idNoticia`),
  KEY `idContenido` (`idNoticia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='Relación entre imágenes y contenidos de texto';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Permiso`
--

CREATE TABLE IF NOT EXISTS `Permiso` (
  `idPermiso` int(2) NOT NULL AUTO_INCREMENT,
  `permiso` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idPermiso`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `Permiso`
--

INSERT INTO `Permiso` (`idPermiso`, `permiso`) VALUES
(1, 'Administrador'),
(2, 'Editor'),
(3, 'Socio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuario`
--

CREATE TABLE IF NOT EXISTS `Usuario` (
  `idUsuario` int(4) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `pwd` varchar(50) NOT NULL,
  `fechaAcceso` datetime DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `idPermiso` int(2) NOT NULL DEFAULT '2',
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `login` (`login`),
  KEY `idPermiso` (`idPermiso`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `Usuario`
--

INSERT INTO `Usuario` (`idUsuario`, `login`, `pwd`, `fechaAcceso`, `ip`, `idPermiso`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '2017-01-09 21:55:27', '127.0.0.1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Video`
--

CREATE TABLE IF NOT EXISTS `Video` (
  `id_video` int(6) NOT NULL AUTO_INCREMENT,
  `titulo_video` varchar(255) NOT NULL,
  `activo_video` tinyint(1) NOT NULL DEFAULT '0',
  `ancho_video` int(6) DEFAULT NULL,
  `alto_video` int(6) DEFAULT NULL,
  `extension` varchar(10) NOT NULL,
  `tam` int(12) NOT NULL DEFAULT '0',
  `tipo` varchar(50) DEFAULT NULL,
  `idUsuario` int(4) DEFAULT NULL,
  PRIMARY KEY (`id_video`),
  KEY `idUsuario` (`idUsuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=14 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Contenido`
--
ALTER TABLE `Contenido`
  ADD CONSTRAINT `Contenido_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`idUsuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `ContenidoCorreo`
--
ALTER TABLE `ContenidoCorreo`
  ADD CONSTRAINT `ContenidoCorreo_ibfk_1` FOREIGN KEY (`idContenido`) REFERENCES `Contenido` (`idContenido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ContenidoEnlace`
--
ALTER TABLE `ContenidoEnlace`
  ADD CONSTRAINT `ContenidoEnlace_ibfk_2` FOREIGN KEY (`idContenido`) REFERENCES `Contenido` (`idContenido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ContenidoFichero`
--
ALTER TABLE `ContenidoFichero`
  ADD CONSTRAINT `ContenidoFichero_ibfk_2` FOREIGN KEY (`idContenido`) REFERENCES `Contenido` (`idContenido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ContenidoImagen`
--
ALTER TABLE `ContenidoImagen`
  ADD CONSTRAINT `ContenidoImagen_ibfk_5` FOREIGN KEY (`idContenido`) REFERENCES `Contenido` (`idContenido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ContenidoImagen_ibfk_6` FOREIGN KEY (`idImagen`) REFERENCES `Imagen` (`idImagen`);

--
-- Filtros para la tabla `ContenidoOferta`
--
ALTER TABLE `ContenidoOferta`
  ADD CONSTRAINT `ContenidoOferta_ibfk_2` FOREIGN KEY (`idContenido`) REFERENCES `Contenido` (`idContenido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ContenidoTexto`
--
ALTER TABLE `ContenidoTexto`
  ADD CONSTRAINT `ContenidoTexto_ibfk_2` FOREIGN KEY (`idContenido`) REFERENCES `Contenido` (`idContenido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ContenidoVideo`
--
ALTER TABLE `ContenidoVideo`
  ADD CONSTRAINT `ContenidoVideo_ibfk_5` FOREIGN KEY (`id_video`) REFERENCES `Video` (`id_video`),
  ADD CONSTRAINT `ContenidoVideo_ibfk_6` FOREIGN KEY (`idContenido`) REFERENCES `Contenido` (`idContenido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `CorreoListaCorreo`
--
ALTER TABLE `CorreoListaCorreo`
  ADD CONSTRAINT `CorreoListaCorreo_ibfk_4` FOREIGN KEY (`id_lista_correo`) REFERENCES `ListaCorreo` (`id_lista_correo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `CorreoListaCorreo_ibfk_5` FOREIGN KEY (`id_correo`) REFERENCES `Correo` (`id_correo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `EnvioCorreo`
--
ALTER TABLE `EnvioCorreo`
  ADD CONSTRAINT `EnvioCorreo_ibfk_4` FOREIGN KEY (`idContenido`) REFERENCES `Contenido` (`idContenido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `EnvioCorreo_ibfk_5` FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`idUsuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `EnvioCorreoLista`
--
ALTER TABLE `EnvioCorreoLista`
  ADD CONSTRAINT `EnvioCorreoLista_ibfk_3` FOREIGN KEY (`id_envio_correo`) REFERENCES `EnvioCorreo` (`id_envio_correo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `EnvioCorreoLista_ibfk_4` FOREIGN KEY (`id_lista_correo`) REFERENCES `ListaCorreo` (`id_lista_correo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Imagen`
--
ALTER TABLE `Imagen`
  ADD CONSTRAINT `Imagen_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`idPermiso`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `ListaCorreo`
--
ALTER TABLE `ListaCorreo`
  ADD CONSTRAINT `ListaCorreo_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`idUsuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `Menu`
--
ALTER TABLE `Menu`
  ADD CONSTRAINT `Menu_ibfk_11` FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`idUsuario`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `Menu_ibfk_12` FOREIGN KEY (`idContenido`) REFERENCES `Contenido` (`idContenido`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `Menu_ibfk_9` FOREIGN KEY (`idPadre`) REFERENCES `Menu` (`idMenu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `NoticiaImagen`
--
ALTER TABLE `NoticiaImagen`
  ADD CONSTRAINT `NoticiaImagen_ibfk_3` FOREIGN KEY (`idImagen`) REFERENCES `Imagen` (`idImagen`),
  ADD CONSTRAINT `NoticiaImagen_ibfk_4` FOREIGN KEY (`idNoticia`) REFERENCES `Noticia` (`idNoticia`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Usuario`
--
ALTER TABLE `Usuario`
  ADD CONSTRAINT `Usuario_ibfk_1` FOREIGN KEY (`idPermiso`) REFERENCES `Permiso` (`idPermiso`);

--
-- Filtros para la tabla `Video`
--
ALTER TABLE `Video`
  ADD CONSTRAINT `Video_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`idUsuario`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
