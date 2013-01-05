-- phpMyAdmin SQL Dump
-- version 3.5.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 22-12-2012 a las 14:20:18
-- Versión del servidor: 5.1.60-community
-- Versión de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `maderayarte.com`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Configuracion`
--

CREATE TABLE IF NOT EXISTS `Configuracion` (
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `valor` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Configuracion`
--

INSERT INTO `Configuracion` (`nombre`, `valor`) VALUES
('hoy', NULL),
('id_ultimo_email', NULL),
('mensajes_enviados_dia', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Contenido`
--

CREATE TABLE IF NOT EXISTS `Contenido` (
  `idContenido` int(12) NOT NULL AUTO_INCREMENT,
  `referencia` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` enum('0','1','2','3') COLLATE utf8_spanish_ci NOT NULL DEFAULT '0' COMMENT '0:texto. 1:archivo. 2:enlace. 3:noticia',
  `permalink` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idContenido`),
  UNIQUE KEY `referencia` (`referencia`),
  UNIQUE KEY `permalink` (`permalink`),
  KEY `tipo` (`tipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Rutas de las páginas de contenidos' AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `Contenido`
--

INSERT INTO `Contenido` (`idContenido`, `referencia`, `descripcion`, `tipo`, `permalink`) VALUES
(1, 'index_', 'Página principal', '0', 'pagina-principal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ContenidoCorreo`
--

CREATE TABLE IF NOT EXISTS `ContenidoCorreo` (
  `idContenido` int(12) NOT NULL,
  `texto` text COLLATE utf8_spanish_ci NOT NULL,
  `tipo` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idContenido`),
  KEY `tipo` (`tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ContenidoEnlace`
--

CREATE TABLE IF NOT EXISTS `ContenidoEnlace` (
  `idContenido` int(12) NOT NULL DEFAULT '0',
  `url` varchar(255) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`idContenido`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ContenidoFichero`
--

CREATE TABLE IF NOT EXISTS `ContenidoFichero` (
  `idContenido` int(12) NOT NULL,
  `ruta` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `menu` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idContenido`),
  UNIQUE KEY `ruta` (`ruta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ContenidoNoticia`
--

CREATE TABLE IF NOT EXISTS `ContenidoNoticia` (
  `idContenido` int(12) NOT NULL,
  `texto` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`idContenido`),
  KEY `fecha` (`fecha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Noticias RSS';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ContenidoTexto`
--

CREATE TABLE IF NOT EXISTS `ContenidoTexto` (
  `idContenido` int(12) NOT NULL,
  `texto` text COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idContenido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ContenidoTexto`
--

INSERT INTO `ContenidoTexto` (`idContenido`, `texto`) VALUES
(1, 'Éste es el texto de la página principal.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Correo`
--

CREATE TABLE IF NOT EXISTS `Correo` (
  `idCorreo` int(12) NOT NULL AUTO_INCREMENT,
  `emailCorreo` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `referenciaCorreo` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `baja` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idCorreo`),
  UNIQUE KEY `email_correo` (`emailCorreo`),
  UNIQUE KEY `referencia_correo` (`referenciaCorreo`),
  KEY `baja` (`baja`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CorreoListaCorreo`
--

CREATE TABLE IF NOT EXISTS `CorreoListaCorreo` (
  `idListaCorreo` int(12) NOT NULL,
  `idCorreo` int(12) NOT NULL,
  PRIMARY KEY (`idListaCorreo`,`idCorreo`),
  KEY `id_correo` (`idCorreo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `EnvioCorreo`
--

CREATE TABLE IF NOT EXISTS `EnvioCorreo` (
  `idEnvioCorreo` int(12) NOT NULL AUTO_INCREMENT,
  `fechaProgramaEnvio` datetime NOT NULL,
  `idContenido` int(12) NOT NULL,
  `fechaInicio` datetime DEFAULT NULL,
  `fechaFin` datetime DEFAULT NULL,
  `resultado` text COLLATE utf8_spanish_ci,
  `ok` tinyint(1) DEFAULT NULL,
  `ficheroAdjunto` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `enviados` int(12) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idEnvioCorreo`),
  KEY `fecha_programa_envio` (`fechaProgramaEnvio`),
  KEY `id_contenido` (`idContenido`),
  KEY `fecha_inicio` (`fechaInicio`,`fechaFin`),
  KEY `ok` (`ok`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `EnvioCorreoLista`
--

CREATE TABLE IF NOT EXISTS `EnvioCorreoLista` (
  `idEnvioCorreo` int(12) NOT NULL,
  `idListaCorreo` int(12) NOT NULL,
  PRIMARY KEY (`idEnvioCorreo`,`idListaCorreo`),
  KEY `id_lista_correo` (`idListaCorreo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Imagen`
--

CREATE TABLE IF NOT EXISTS `Imagen` (
  `idImagen` int(12) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `extension` varchar(3) COLLATE utf8_spanish_ci NOT NULL,
  `tam` int(12) NOT NULL DEFAULT '0',
  `tipo` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `orden` int(6) NOT NULL DEFAULT '1',
  `alineamiento` enum('0','1','2') COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `idContenido` int(12) NOT NULL,
  PRIMARY KEY (`idImagen`),
  UNIQUE KEY `orden` (`orden`,`idContenido`),
  KEY `idContenido` (`idContenido`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Imágenes de los contenidos' AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `Imagen`
--

INSERT INTO `Imagen` (`idImagen`, `titulo`, `extension`, `tam`, `tipo`, `orden`, `alineamiento`, `idContenido`) VALUES
(1, 'Tortuga', 'jpg', 200, 'image/pjpeg', 1, '0', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ListaCorreo`
--

CREATE TABLE IF NOT EXISTS `ListaCorreo` (
  `idListaCorreo` int(12) NOT NULL AUTO_INCREMENT,
  `nombreListaCorreo` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idListaCorreo`),
  UNIQUE KEY `nombre_lista_correo` (`nombreListaCorreo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Menu`
--

CREATE TABLE IF NOT EXISTS `Menu` (
  `idMenu` int(12) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `idPadre` int(12) DEFAULT NULL,
  `idContenido` int(12) DEFAULT NULL,
  PRIMARY KEY (`idMenu`),
  KEY `id_padre` (`idPadre`),
  KEY `idContenido` (`idContenido`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Menú de la web' AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `Menu`
--

INSERT INTO `Menu` (`idMenu`, `titulo`, `idPadre`, `idContenido`) VALUES
(1, 'Menú raíz 1', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuario`
--

CREATE TABLE IF NOT EXISTS `Usuario` (
  `idUsuario` int(12) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `pwd` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `Usuario`
--

INSERT INTO `Usuario` (`idUsuario`, `login`, `pwd`) VALUES
(1, 'antoniojesus', '91529b1fbe632f71c1d8a9c3e729a979');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Video`
--

CREATE TABLE IF NOT EXISTS `Video` (
  `idVideo` int(12) NOT NULL AUTO_INCREMENT,
  `tituloVideo` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `activoVideo` tinyint(1) NOT NULL DEFAULT '0',
  `anchoVideo` int(6) DEFAULT NULL,
  `altoVideo` int(6) DEFAULT NULL,
  `extension` varchar(3) COLLATE utf8_spanish_ci NOT NULL,
  `tam` int(12) NOT NULL DEFAULT '0',
  `tipo` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `orden` int(6) NOT NULL DEFAULT '1',
  `alineamiento` enum('0','1','2') COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `idContenido` int(12) NOT NULL,
  PRIMARY KEY (`idVideo`),
  UNIQUE KEY `orden` (`orden`,`idContenido`),
  KEY `idContenido` (`idContenido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ContenidoCorreo`
--
ALTER TABLE `ContenidoCorreo`
  ADD CONSTRAINT `contenidocorreo_ibfk_1` FOREIGN KEY (`idContenido`) REFERENCES `contenido` (`idContenido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ContenidoEnlace`
--
ALTER TABLE `ContenidoEnlace`
  ADD CONSTRAINT `contenidoenlace_ibfk_1` FOREIGN KEY (`idContenido`) REFERENCES `contenido` (`idContenido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ContenidoFichero`
--
ALTER TABLE `ContenidoFichero`
  ADD CONSTRAINT `contenidofichero_ibfk_1` FOREIGN KEY (`idContenido`) REFERENCES `contenido` (`idContenido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ContenidoNoticia`
--
ALTER TABLE `ContenidoNoticia`
  ADD CONSTRAINT `contenidonoticia_ibfk_1` FOREIGN KEY (`idContenido`) REFERENCES `contenido` (`idContenido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ContenidoTexto`
--
ALTER TABLE `ContenidoTexto`
  ADD CONSTRAINT `contenidotexto_ibfk_1` FOREIGN KEY (`idContenido`) REFERENCES `contenido` (`idContenido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `CorreoListaCorreo`
--
ALTER TABLE `CorreoListaCorreo`
  ADD CONSTRAINT `correolistacorreo_ibfk_1` FOREIGN KEY (`idListaCorreo`) REFERENCES `listacorreo` (`idListaCorreo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `correolistacorreo_ibfk_2` FOREIGN KEY (`idCorreo`) REFERENCES `correo` (`idCorreo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `EnvioCorreo`
--
ALTER TABLE `EnvioCorreo`
  ADD CONSTRAINT `enviocorreo_ibfk_1` FOREIGN KEY (`idContenido`) REFERENCES `contenido` (`idContenido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `EnvioCorreoLista`
--
ALTER TABLE `EnvioCorreoLista`
  ADD CONSTRAINT `enviocorreolista_ibfk_1` FOREIGN KEY (`idEnvioCorreo`) REFERENCES `enviocorreo` (`idEnvioCorreo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `enviocorreolista_ibfk_2` FOREIGN KEY (`idListaCorreo`) REFERENCES `listacorreo` (`idListaCorreo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Imagen`
--
ALTER TABLE `Imagen`
  ADD CONSTRAINT `imagen_ibfk_1` FOREIGN KEY (`idContenido`) REFERENCES `contenido` (`idContenido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Menu`
--
ALTER TABLE `Menu`
  ADD CONSTRAINT `menu_ibfk_3` FOREIGN KEY (`idPadre`) REFERENCES `menu` (`idMenu`) ON DELETE CASCADE,
  ADD CONSTRAINT `menu_ibfk_4` FOREIGN KEY (`idContenido`) REFERENCES `contenido` (`idContenido`) ON DELETE CASCADE;

--
-- Filtros para la tabla `Video`
--
ALTER TABLE `Video`
  ADD CONSTRAINT `video_ibfk_1` FOREIGN KEY (`idContenido`) REFERENCES `contenido` (`idContenido`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
