<?php
	class Contenido extends Model
	{
		protected $idContenido;
		protected $referencia;
		protected $descripcion;
		protected $tipo;
		protected $permalink;
		protected $imagenes;
		protected $videos;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['idContenido'] = 'auto';
			$this->fk['imagenes'] = new FK('Imagen', OneToMany, 'idContenido', null, 'orden');
			$this->fk['videos'] = new FK('Video', OneToMany, 'idContenido', null, 'orden');
		}
		
		public function get_texto_procesado($ruta = '/', $rutaFisica = '/')
		{
			if (!$ruta)
				$ruta = Config::pathApp();
			if ($rutaFisica)
				$rutaFisica = Config::rootApp();
			$html = $this->texto;
			//TODO revisar esto
			$html = str_replace('<p>', '<div style="height: 10px;"><!-- capa salto --></div><div>', $html);
			$html = str_replace('<p ', '<div style="height: 10px;"><!-- capa salto --></div><div ', $html);
			$html = str_replace('/p>', '/div>', $html);
			//imágenes
			$pos = 0;
			$contDivImagenes = 1;
			$imagenes = $this->imagenes;
			$maxHeight = 0;
			$contImg = 0;
			for ($i = 0; $i < count($imagenes); $i++)
			{
				$imagen = $imagenes[$i];
				if (!$imagen)
					break;
				$directorio = floor($imagen->idImagen / 1000);
				$rutaImagen = $rutaFisica . '/res/imagenes/upload/' . $directorio . '/' . $imagen->idImagen 
						. '.' . $imagen->extension;
				$archivoOriginal = $rutaFisica . '/res/imagenes/upload/' . $directorio . '/original_' . 
						$imagen->idImagen . '.' . $imagen->extension;
				//pintar la imagen o imágenes
				//cuantas imágenes pintar en la capa contando todas las consecutivas y pintar así la capa
				$nImagenesPintar = 0;
				$pos = strpos($html, '[imagen]', $pos);
				if ($pos === false)
					break;
				$nImagenesPintar++;
				$posAux = $pos;
				do
				{
					$pos += 8;
					if ($pos > (strlen($html) - 8))
						break;
					if (substr($html, $pos, 8) != '[imagen]')
						break;
					$nImagenesPintar++;
				}
				while (true);
				//se genera el html con las imágenes
				if (is_object($imagen) and $imagen->alineamiento == 2)
				{
					//html de una imagen
					$htmlImagen = '<div style="clear: both;"></div>';
					$htmlImagen .= '<div id="imagenes_' . $contDivImagenes 
							. '" style="margin: 0px auto; width: 100%;">';
					$htmlImagen .= '<input type="hidden" id="nImagenes_' . $contDivImagenes 
							. '" value="' . $nImagenesPintar . '" />';
					$contDivImagenes++;
				}
				else
					$htmlImagen = '';
				for ($cont = 0; $cont < $nImagenesPintar; $cont++)
				{
					//html por cada imagen
					$ampliable = false;
					$htmlImagenAux = '';
					list($width_img, $height_img) = getimagesize($rutaImagen);
					//TODO este valor 149 debería ser un parámetro
					if ($height_img <= 149)
						$htmlImagenAux .= '<div style="height: ' . (149 - $height_img) . 'px;"></div>';
					if (file_exists($archivoOriginal))
					{
						$ampliable = true;
						$htmlImagenAux .= '<a href="' . $ruta . '?referencia=verimg&amp;idImagen=' 
								. $imagen->idImagen . '#imagen" onclick=\'ver_imagen(' . $imagen->idImagen 
								. '); return false;\'>';
					}
					$htmlImagenAux .= '<img src="' . $ruta . 'res/imagenes/upload/' . $directorio . '/' 
							. $imagen->idImagen . '.' . $imagen->extension . '" alt="' 
							. htmlentities($imagen->titulo) . '" title="' . htmlentities($imagen->titulo) 
							. '" />';
					if ($ampliable)
						$htmlImagenAux .= '</a>';
					$htmlImagenAux .= '<div style="clear: left;"></div>';
					$htmlImagenAux .= '<div style="width: 20%; text-align: center; font-size: 180%;'
							. ' float: left; padding-top: 6px; color: #AAA;"><strong>' . ++$contImg 
							. '</strong></div>';
					//TODO este 50 debería ser un parámetro
					$tituloCortado = substr($imagen->titulo, 0, 50);
					if (strlen($imagen->titulo) > 50)
						$tituloCortado .= '...';
					$htmlImagenAux .= '<div style="width: 80%; text-align: center; font-size: 0.8em;'
							. ' float: left;" title="' . htmlentities($imagen->titulo) 
							. '"><span style="margin-left: 4px;">' . htmlspecialchars($tituloCortado) 
							. '</span>\n</div>';
					$htmlImagenAux .= '<div style="clear: left;"></div>';
					$htmlImagen .= '<div class="sidebar-first-imagen">';
					$htmlImagen .= '<div class="block-wrapper odd">';
					$htmlImagen .= '<div class="rounded-block">';
					$htmlImagen .= '<div class="rounded-block-top-left"></div>';
					$htmlImagen .= '<div class="rounded-block-top-right"></div>';
					$htmlImagen .= '<div class="rounded-outside">';
					$htmlImagen .= '<div class="rounded-inside">';
					$htmlImagen .= '<p class="rounded-topspace"></p>';
					$htmlImagen .= '<div class="block-imagen-0 block block-imagen">';
					$htmlImagen .= '<div class="block-icon pngfix"></div>';
					$htmlImagen .= '<div class="content-imagen">';
					$htmlImagen .= $htmlImagenAux;
					$htmlImagen .= '</div>';
					$htmlImagen .= '</div>';
					$htmlImagen .= '<p class="rounded-bottomspace"></p>';
					$htmlImagen .= '</div>';
					$htmlImagen .= '</div>';
					$htmlImagen .= '<div class="rounded-block-bottom-left"></div>';
					$htmlImagen .= '<div class="rounded-block-bottom-right"></div>';
					$htmlImagen .= '</div>';
					$htmlImagen .= '</div>';
					$htmlImagen .= '</div>';
					//código js
					$htmlImagen .= '<script type="text/javascript">';
					$htmlImagen .= 'imagenes[imagenes.length] = new Imagen("' . $ruta . 'res/imagenes/upload/' 
							. $directorio . '/original_' . $imagen->idImagen . '.' . $imagen->extension 
							. '", "' . htmlspecialchars($imagen->titulo) . '", "' . $ruta 
							. 'res/imagenes/upload/' . $directorio . '/' . $imagen->idImagen . '.' 
							. $imagen->extension . '", ' . $imagen->idImagen . ');';
					$htmlImagen .= '</script>';
					//si hay más de una imagen
					if ($nImagenesPintar > 1 and $cont < ($nImagenesPintar - 1))
					{
						$i++;
						if (!isset($imagenes[$i]))
							break;
						$imagen = $imagenes[$i];
						if (!$imagen)
							break;
						$directorio = floor($imagen->idImagen / 1000);
						$rutaImagen = $rutaFisica . '/res/imagenes/upload/' . $directorio . '/' 
								. $imagen->idImagen . '.' . $imagen->extension;
						$archivoOriginal = $rutaFisica . '/res/imagenes/upload/' . $directorio . '/original_' 
								. $imagen->idImagen . '.' . $imagen->extension;
					}
				}
				if (is_object($imagen) and $imagen->alineamiento == 2)
				{
					$htmlImagen .= '</div>';
					$htmlImagen .= '<div style="clear: left;"></div>';
				}
				//se cambia la info
				$pos = $posAux;
				$html = substr_replace($html, $htmlImagen, $pos, (8 * $nImagenesPintar));
				$pos += strlen($htmlImagen);
			}
			//vídeos
			$pos = 0;
			$contDivVideos = 1;
			$videos = $this->videos;
			$maxHeight = 0;
			for ($i = 0; $i < count($videos); $i++)
			{
				$video = $videos[$i];
				if (!$video)
					break;
				$directorio = floor($video->idVideo / 1000);
				$rutaVideo = $rutaFisica . '/res/imagenes/upload/' . $directorio . '/' . $video->idVideo . "." 
						. $video->extension;
				//pintar el vídeo o vídeos
				//cuantos vídeos pintar en la capa contando todos los consecutivos y pintar así la capa
				$nVideosPintar = 0;
				$pos = strpos($html, "[video]", $pos);
				if ($pos === false)
					break;
				$nVideosPintar++;
				$posAux = $pos;
				do
				{
					$pos += 7;
					if ($pos > (strlen($html) - 7))
						break;
					if (substr($html, $pos, 7) != "[video]")
						break;
					$nVideosPintar++;
				}
				while (true);
				//se genera el html con los vídeos
				if (is_object($video) and $video->alineamiento == 2)
				{
					//html de un vídeo
					$htmlVideo = '<div style="clear: both;"></div>';
					$htmlVideo .= '<div id="videos_' . $contDivVideos 
							. '" style="margin: 0px auto; width: 100%;">';
					$htmlVideo .= '<input type="hidden" id="nVideos_' . $contDivVideos . '" value="' 
							. $nVideosPintar . '" />';
					$contDivVideos++;
					$alineamiento = '';
				}
				else
				{
					$htmlVideo = "";
					if ($video->alineamiento == 0)
						$alineamiento = ' float: right;';
					else
						$alineamiento = ' float: left;';
				}
				for ($cont = 0; $cont < $nVideosPintar; $cont++)
				{
					//html por cada vídeo
					if ($video->alineamiento == 2)
						$margin = ' margin: 0 auto;';
					else
						$margin = ' margin: 20px;';
					//TODO las constantes hay que parametrizarlas
					$htmlVideoAux = "<div style=\"width: " . (($video->anchoVideo) 
							? $video->anchoVideo : ANCHO_VIDEO) . "px; $margin $alineamiento\">";
					$w = ($video->anchoVideo) ? $video->anchoVideo : ANCHO_VIDEO;
					$h = ($video->altoVideo) ? $video->altoVideo() : ALTO_VIDEO;
					$htmlVideoAux .= "<div style=\"\">";
					$htmlVideoAux .= "<a href=\"" . $ruta . "res/videos/upload/" . $directorio . "/"
							. $video->idVideo . "." . $video->extension . "\"" 
							. " style=\"display: block; width: " . $w . "px; height: " 
							. $h . "px;\"  class=\"myPlayer\">";
					if (file_exists($rutaFisica . "res/videos/upload/" . $directorio . "/" 
							. "video_" . $video->idVideo . ".jpg") and count($videos) > 1)
					{
						$htmlVideoAux .= ""
								. "	<img src=\"" . $ruta . "res/imagenes/web/play.png" . "\" alt=\""
								. "Play\" style=\"position: absolute; margin-top: " . (round($h / 2) - 100) 
								. "px; margin-left: " . (round($w / 2) - 100) 
								. "px; width: 200px; height: 200px; "
								. "\" title=\"Ver v&iacute;deo\" />";
						$htmlVideoAux .= "<img src=\"" . $ruta . "res/videos/upload/" . $directorio . "/"
								. "video_" . $video->idVideo . ".jpg" . "\" alt=\""
								. htmlspecialchars($video->tituloVideo) . "\" "
								. "style=\"position: absolute; width: " . $w . "px; height: " . $h 
								. "px; opacity: 0.6; filter:alpha(opacity=60);\" />";
					}
					$htmlVideoAux .= "</a>\n";
					$htmlVideoAux .= "</div>";
					$htmlVideoAux .= "<div style=\"text-align: center; font-size: 0.8em; color: gray;\">\n" 
							. htmlspecialchars($video->tituloVideo) . "\n</div>\n";
					$htmlVideoAux .= "</div>";
					$htmlVideo .= $htmlVideoAux . "\n";
					//si hay más de un vídeo
					if ($nVideosPintar > 1 and $cont < ($nVideosPintar - 1))
					{
						$i++;
						$video = $videos[$i];
						if (!$video)
							break;
						$directorio = floor($video->idVideo / 1000);
						$video = $rutaFisica . "res/videos/upload/" . $directorio . "/" . $video->idVideo . "." 
								. $video->extension;
					}
				}
				if (is_object($video) and $video->alineamiento == 2)
				{
					$htmlVideo .= "</div>\n";
					$htmlVideo .= "<div style=\"clear: left;\"></div>\n";
				}
				//se cambia la info
				$pos = $posAux;
				$html = substr_replace($html, $htmlVideo, $pos, (7 * $nVideosPintar));
				$pos += strlen($htmlVideo);
			}
			if (count($videos) > 0)
			{
				$html .= "\n<script type=\"text/javascript\">\n"
						. "	flowplayer(\"a.myPlayer\", \"" . $ruta 
						. "view/flash/flowplayer/flowplayer-3.2.5.swf\"";
				if (count($videos) == 1)
					$html .= ", {\n"
							. "		onLoad: function() {\n"
							. "			this.unMute();\n"
							. "		}}\n";
				$html .= "	);\n"
						. "</script>";
			}
			return $html;
		}
		
		function get_ruta($menu = null)
		{
			if (!$this->idContenido)
				return false;
			$ruta = $this->descripcion;
			//localizamos el menú al que pertenece el contenido
			if (!$menu)
			{
				//TODO hacer en el action
				if (!$menu->idMenu)
					return false;
			}
			elseif ($this->menu)
				$menu = $this->menu;
			if ($menu)
			{
				//se cargan todos los menús superiores hasta el raíz
				while (true)
				{
					if (!$menu->padre)
						break;
					$enlace = $menu->get_enlace();
					$rutaAux = '';
					if ($enlace)
						$rutaAux .= '<a href="' . $enlace . '">';
					$rutaAux .= $menu->titulo;
					if ($enlace)
						$rutaAux .= '</a>';
					$ruta = $rutaAux . ' &gt; ' . $ruta;
					$menu = $menu->padre;
				}
			}
			return $ruta;
		}
	}