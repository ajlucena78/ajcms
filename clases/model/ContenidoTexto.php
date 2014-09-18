<?php
	require_once APP_ROOT . 'clases/model/Contenido.php';
	class ContenidoTexto extends Contenido
	{
		protected $texto;
		protected $encabezado;
		
		public function texto_procesado($ruta = null, $rutaFisica = null)
		{
			if (!$ruta)
				$ruta = URL_APP;
			if (!$rutaFisica)
				$rutaFisica = APP_ROOT;
			$html = $this->texto;
			$html = str_replace('<p>', '<div style="height: 10px; clear: both;"><!-- capa salto --></div><div>'
					, $html);
			$html = str_replace('<p ', '<div style="height: 10px; clear: both;"><!-- capa salto --></div><div '
					, $html);
			$html = str_replace('/p>', '/div>', $html);
			//imágenes
			$pos = 0;
			$contDivImagenes = 1;
			$imagenes = $this->imagenes();
			$maxHeight = 0;
			$contImg = 0;
			for ($i = 0; $i < count($imagenes); $i++)
			{
				$imagen = $imagenes[$i];
				if (!$imagen)
					break;
				$directorio = floor($imagen->idImagen / 1000);
				$rutaImagen = $rutaFisica . '/res/upload/' . $directorio . '/' . $imagen->idImagen 
						. '.' . $imagen->extension;
				$archivoOriginal = $rutaFisica . '/res/upload/' . $directorio . '/original_' . 
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
					list($width_img, $height_img) = @getimagesize($rutaImagen);
					if ($height_img <= ALTO_IMG)
						$htmlImagenAux .= '<div style="height: ' . (ALTO_IMG - $height_img) . 'px;"></div>';
					if (file_exists($archivoOriginal))
					{
						$ampliable = true;
						$htmlImagenAux .= '<a href="' . $ruta . '?action=ver_imagen&amp;id=' 
								. $imagen->idImagen . '#verimagen" onclick=\'ver_imagen(' . $imagen->idImagen 
								. '); return false;\'>';
					}
					$htmlImagenAux .= '<img src="' . $ruta . 'res/upload/' . $directorio . '/' 
							. $imagen->idImagen . '.' . $imagen->extension . '" alt="' 
							. formato_html($imagen->titulo) . '" title="' . formato_html($imagen->titulo) 
							. '" />';
					if ($ampliable)
						$htmlImagenAux .= '</a>';
					$htmlImagenAux .= '<div style="clear: left;"></div>';
					$htmlImagenAux .= '<div style="width: 20%; text-align: center; font-size: 180%;'
							. ' float: left; padding-top: 6px; color: #AAA;"><strong>' . ++$contImg 
							. '</strong></div>';
					$tituloCortado = substr($imagen->titulo, 0, TITULO_IMG);
					if (strlen($imagen->titulo) > TITULO_IMG)
						$tituloCortado .= '...';
					$htmlImagenAux .= '<div style="width: 80%; text-align: center; font-size: 0.8em;'
							. ' float: left;" title="' . formato_html($imagen->titulo) 
							. '"><span style="margin-left: 4px;">' . formato_html($tituloCortado) 
							. "</span>\n</div>";
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
					$htmlImagen .= '<script type="text/javascript"><!-- ' . "\n";
					$htmlImagen .= 'imagenes[imagenes.length] = new Imagen("' . $ruta . 'res/upload/' 
							. $directorio . '/original_' . $imagen->idImagen . '.' . $imagen->extension 
							. '", "' . formato_html($imagen->titulo) . '", "' . $ruta 
							. 'res/upload/' . $directorio . '/' . $imagen->idImagen . '.' 
							. $imagen->extension . '", ' . $imagen->idImagen . ');';
					$htmlImagen .= "\n" . ' //--></script>';
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
						$rutaImagen = $rutaFisica . '/res/upload/' . $directorio . '/' 
								. $imagen->idImagen . '.' . $imagen->extension;
						$archivoOriginal = $rutaFisica . '/res/upload/' . $directorio . '/original_' 
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
			//el resto de fotos no colocadas anteriormente se ubican al final
			if ($i < count($imagenes))
			{
				$html .= '<div style="clear: both;"></div>';
				$html .= '<div id="imagenes_' . $contDivImagenes . '" style="margin: 0px auto; width: 100%;">';
				$nImagenesPintar = count($imagenes) - $i;
				$html .= '<input type="hidden" id="nImagenes_' . $contDivImagenes . '" value="' 
						. $nImagenesPintar . '" />';
				for ($i = $contImg; $i < count($imagenes); $i++)
				{
					$imagen = $imagenes[$i];
					if (!$imagen)
						break;
					$directorio = floor($imagen->idImagen / 1000);
					$rutaImagen = $rutaFisica . '/res/upload/' . $directorio . '/' . $imagen->idImagen 
							. '.' . $imagen->extension;
					$archivoOriginal = $rutaFisica . '/res/upload/' . $directorio . '/original_' . 
							$imagen->idImagen . '.' . $imagen->extension;
					$htmlImagen = '';
					//html por cada imagen
					$ampliable = false;
					$htmlImagenAux = '';
					list($width_img, $height_img) = @getimagesize($rutaImagen);
					if ($height_img <= ALTO_IMG)
						$htmlImagenAux .= '<div style="height: ' . (ALTO_IMG - $height_img) . 'px;"></div>';
					if (file_exists($archivoOriginal))
					{
						$ampliable = true;
						$htmlImagenAux .= '<a href="' . $ruta . '?action=ver_imagen&amp;id=' 
								. $imagen->idImagen . '#verimagen" onclick=\'ver_imagen(' . $imagen->idImagen 
								. '); return false;\'>';
					}
					$htmlImagenAux .= '<img src="' . $ruta . 'res/upload/' . $directorio . '/' 
							. $imagen->idImagen . '.' . $imagen->extension . '" alt="' 
							. formato_html($imagen->titulo) . '" title="' . formato_html($imagen->titulo) 
							. '" />';
					if ($ampliable)
						$htmlImagenAux .= '</a>';
					$htmlImagenAux .= '<div style="clear: left;"></div>';
					$htmlImagenAux .= '<div style="width: 20%; text-align: center; font-size: 180%;'
							. ' float: left; padding-top: 6px; color: #AAA;"><strong>' . ++$contImg 
							. '</strong></div>';
					$tituloCortado = substr($imagen->titulo, 0, TITULO_IMG);
					if (strlen($imagen->titulo) > TITULO_IMG)
						$tituloCortado .= '...';
					$htmlImagenAux .= '<div style="width: 80%; text-align: center; font-size: 0.8em;'
							. ' float: left;" title="' . formato_html($imagen->titulo) 
							. '"><span style="margin-left: 4px;">' . formato_html($tituloCortado) 
							. "</span>\n</div>";
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
					$htmlImagen .= '<script type="text/javascript"><!-- ' . "\n";
					$htmlImagen .= 'imagenes[imagenes.length] = new Imagen("' . $ruta . 'res/upload/' 
							. $directorio . '/original_' . $imagen->idImagen . '.' . $imagen->extension 
							. '", "' . formato_html($imagen->titulo) . '", "' . $ruta 
							. 'res/upload/' . $directorio . '/' . $imagen->idImagen . '.' 
							. $imagen->extension . '", ' . $imagen->idImagen . ');';
					$htmlImagen .= "\n" . ' //--></script>';
					//se cambia la info
					$html .= $htmlImagen;
				}
				$html .= '</div><div style="clear: left;"></div>';
			}
			//vídeos
			$pos = 0;
			$contDivVideos = 1;
			$videos = $this->videos();
			$maxHeight = 0;
			for ($i = 0; $i < count($videos); $i++)
			{
				$video = $videos[$i];
				if (!$video)
					break;
				$directorio = floor($video->id_video / 1000);
				$rutaVideo = $rutaFisica . '/res/upload/' . $directorio . '/' . $video->id_video . "." 
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
					$htmlVideoAux = "<div style=\"width: " . (($video->ancho_video) 
							? $video->ancho_video : ANCHO_VIDEO) . "px; $margin $alineamiento\">";
					$w = ($video->ancho_video) ? $video->ancho_video : ANCHO_VIDEO;
					$h = ($video->alto_video) ? $video->alto_video : ALTO_VIDEO;
					$htmlVideoAux .= "<div style=\"\">";
					$htmlVideoAux .= "<a href=\"" . $ruta . "res/upload/" . $directorio . "/"
							. $video->id_video . "." . $video->extension . "\"" 
							. " style=\"display: block; width: " . $w . "px; height: " 
							. $h . "px;\"  class=\"myPlayer\">";
					if (file_exists($rutaFisica . "res/upload/" . $directorio . "/" 
							. "video_" . $video->id_video . ".jpg") and count($videos) > 1)
					{
						$htmlVideoAux .= ""
								. "	<img src=\"" . $ruta . "res/imagenes/web/play.png" . "\" alt=\""
								. "Play\" style=\"position: absolute; margin-top: " . (round($h / 2) - 100) 
								. "px; margin-left: " . (round($w / 2) - 100) 
								. "px; width: 200px; height: 200px; "
								. "\" title=\"Ver v&iacute;deo\" />";
						$htmlVideoAux .= "<img src=\"" . $ruta . "res/upload/" . $directorio . "/"
								. "video_" . $video->id_video . ".jpg" . "\" alt=\""
								. formato_html($video->titulo_video) . "\" "
								. "style=\"position: absolute; width: " . $w . "px; height: " . $h 
								. "px; opacity: 0.6; filter:alpha(opacity=60);\" />";
					}
					$htmlVideoAux .= "</a>\n";
					$htmlVideoAux .= "</div>";
					$htmlVideoAux .= "<div style=\"text-align: center; font-size: 0.8em; color: gray;\">\n" 
							. formato_html($video->titulo_video) . "\n</div>\n";
					$htmlVideoAux .= "</div>";
					$htmlVideo .= $htmlVideoAux . "\n";
					//si hay más de un vídeo
					if ($nVideosPintar > 1 and $cont < ($nVideosPintar - 1))
					{
						$i++;
						$video = $videos[$i];
						if (!$video)
							break;
						$directorio = floor($video->id_video / 1000);
						$video = $rutaFisica . "res/upload/" . $directorio . "/" . $video->id_video . "." 
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
						. "res/flash/flowplayer/flowplayer-3.2.5.swf\"";
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
	}