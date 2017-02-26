<?php
	require_once APP_ROOT . 'clases/model/Contenido.php';
	
	class ContenidoTexto extends Contenido
	{
		protected $texto;
		protected $texto2;
		protected $encabezado;
		protected $metadesc;
		protected $pie;
		protected $textoMovil;
		protected $pieMovil;
		
		private function imagen($imagen, & $contImg = 0, $rutaFisica = null, $ruta = null)
		{
			$contImg++;
			$directorio = floor($imagen->idImagen / 1000);
			$archivoOriginal = $imagen->ruta(true);
			$htmlImagen = '';
			if (file_exists($archivoOriginal))
			{
				$rutaImagen = $imagen->ruta();
				list($width_img, $height_img) = @getimagesize($rutaImagen);
				$htmlImagenAux = '';
				if ($height_img <= ALTO_IMG)
				{
					$htmlImagenAux .= '<div style="height: ' . (ALTO_IMG - $height_img) . 'px;"></div>';
				}
				$htmlImagenAux = '<a href="' . $imagen->enlace() . '#verimagen" onclick=\'ver_imagen(' 
						. $imagen->idImagen . '); return false;\'>';
				$htmlImagenAux .= '<img src="' . $imagen->url() . '" alt="' . formato_html($imagen->titulo) 
						. '" title="' . formato_html($imagen->titulo) . '" style="width: 100%;" />';
				$htmlImagenAux .= '</a>';
				$htmlImagenAux .= '<div style="clear: left;"></div>';
				/*
				$htmlImagenAux .= '<div style="width: 20%; text-align: center; font-size: 180%;'
						. ' float: left; padding-top: 6px; color: #AAA;"><strong>' . $contImg 
						. '</strong></div>';
				*/
				$tituloCortado = substr($imagen->titulo, 0, TITULO_IMG);
				if (strlen($imagen->titulo) > TITULO_IMG)
					$tituloCortado .= '...';
				$htmlImagenAux .= '<div style="width: 100%; text-align: center; font-size: 0.9em; height: 25pt;'
						. ' float: left;" title="' . formato_html($imagen->titulo) 
						. '"><span style="margin-left: 2pt;">' . formato_html($tituloCortado) 
						. "</span>\n</div>";
				$htmlImagenAux .= '<div style="clear: left;"></div>';
				if (!$imagen->tamano)
					$imagen->tamano = 33;
				$htmlImagen .= '<div class="sidebar-first-imagen" style="width: ' . $imagen->tamano . '%">';
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
				$htmlImagen .= 'imagenes[imagenes.length] = new Imagen("' . $imagen->url(true) . '", "' 
						. formato_html($imagen->titulo) . '", "' . $imagen->url() . '", ' . $imagen->idImagen 
						. ');';
				$htmlImagen .= "\n" . ' //--></script>';
			}
			else
			{
				$htmlImagen .= '<img src="' . $imagen->url() . '" alt="' . formato_html($imagen->titulo) 
						. '" style="width: ' . $imagen->tamano 
						. '%; margin-top: 4pt; margin-bottom: 4pt;" title="' 
						. formato_html($imagen->titulo) . '"/><br />' . formato_html($imagen->titulo);
				$htmlImagen .= '<div style="clear: both;"></div>';
			}
			return $htmlImagen;
		}
		
		public function texto_procesado($ruta = null, $rutaFisica = null, $html = '', $verImagenes = true
				, & $contImg = 0)
		{
			if (!$ruta)
				$ruta = URL_APP;
			if (!$rutaFisica)
				$rutaFisica = APP_ROOT;
			$contDivImagenes = 1;
			$i = $contImg;
			if ($html)
			{
				$html = str_replace('<p>', '<div style="height: 10px; clear: both;"><!-- capa salto --></div><div>', $html);
				$html = str_replace('<p ', '<div style="height: 10px; clear: both;"><!-- capa salto --></div><div ', $html);
				$html = str_replace('/p>', '/div>', $html);
				$imagenes = $this->imagenes();
				$pos = 0;
				for (; $i < count($imagenes); $i++)
				{
					$imagen = $imagenes[$i];
					if (!$imagen)
						break;
					if ($imagen->oculta)
					{
						$contImg++;
						continue;
					}
					//pintar la imagen o imágenes
					//cuantas imágenes pintar en la capa contando todas las consecutivas y pintar así la capa
					$nImagenesPintar = 0;
					$htmlImagen = '';
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
						$htmlImagen .= $this->imagen($imagen, $contImg, $rutaFisica, $ruta);
						//si hay más de una imagen
						if ($nImagenesPintar > 1 and $cont < ($nImagenesPintar - 1))
						{
							$i++;
							if (!isset($imagenes[$i]))
								break;
							$imagen = $imagenes[$i];
							if (!$imagen)
								break;
							if ($imagen->oculta())
							{
								continue;
								$contImg++;
							}
						}
					}
					if (is_object($imagen) and $imagen->alineamiento == 2)
					{
						$htmlImagen .= '</div>';
						$htmlImagen .= '<div style="clear: left;"></div>';
					}
					//se cambia la info
					if (isset($posAux))
					{
						$pos = $posAux;
					}
					$html = substr_replace($html, $htmlImagen, $pos, (8 * $nImagenesPintar));
					$pos += strlen($htmlImagen);
				}
			}
			//el resto de fotos no colocadas anteriormente se ubican al final
			if ($verImagenes)
			{
				if (!isset($imagenes))
				{
					$imagenes = $this->imagenes();
				}
				if ($i < count($imagenes))
				{
					$html .= '<div style="clear: both;"></div>';
					$html .= '<div id="imagenes_' . $contDivImagenes 
							. '" style="margin: 0px auto; width: 100%;">';
					$nImagenesPintar = count($imagenes) - $i;
					$html .= '<input type="hidden" id="nImagenes_' . $contDivImagenes . '" value="' 
							. $nImagenesPintar . '" />';
					for ($i = $contImg; $i < count($imagenes); $i++)
					{
						$imagen = $imagenes[$i];
						if (!$imagen)
							break;
						if ($imagen->oculta())
						{
							$contImg++;
							continue;
						}
						$html .= $htmlImagen = $this->imagen($imagen, $contImg, $rutaFisica, $ruta);
					}
					$html .= '</div><div style="clear: left;"></div>';
				}
			}
			//vídeos
			$pos = 0;
			$contDivVideos = 1;
			$videos = $this->videos();
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
				if (is_object($video) and $video->alineamiento == 2)
				{
					$alineamiento = '';
				}
				else
				{
					if ($video->alineamiento == 0)
						$alineamiento = ' float: right;';
					else
						$alineamiento = ' float: left;';
				}
				$htmlVideo = '';
				$anchoVideos = 0;
				for ($cont = 0; $cont < $nVideosPintar; $cont++)
				{
					//html por cada vídeo
					if ($video->alineamiento == 2)
						$margin = ' margin: 10px;';
					else
						$margin = ' margin: 20px;';
					$htmlVideoAux = "<div style=\"float: left; width: " . (($video->ancho_video) 
							? $video->ancho_video : ANCHO_VIDEO) . "px; $margin $alineamiento\">";
					$w = ($video->ancho_video) ? $video->ancho_video : ANCHO_VIDEO;
					$anchoVideos += $w + 20;
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
								. "style=\"width: " . $w . "px; height: " . $h 
								. "px; opacity: 0.5; filter:alpha(opacity=60);\""
								. " title=\"Clic para ver video\" />";
					}
					$htmlVideoAux .= "</a>\n";
					$htmlVideoAux .= "</div>";
					$htmlVideoAux .= "<div style=\"text-align: center; font-size: 80%; color: gray;\">\n" 
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
					}
				}
				//se genera el html con los vídeos
				if (is_object($video) and $video->alineamiento == 2)
				{
					//html de un vídeo
					$htmlVideos = '<div style="clear: both;"></div>';
					$htmlVideos .= '<div id="videos_' . $contDivVideos 
							. '" style="margin: 0 auto; width: ' . $anchoVideos . 'px;">';
					$htmlVideos .= '<input type="hidden" id="nVideos_' . $contDivVideos . '" value="' 
							. $nVideosPintar . '" />';
					$htmlVideos .= $htmlVideo;
					$htmlVideos .= "</div>\n";
					$htmlVideos .= "<div style=\"clear: left;\"></div>\n";
					$contDivVideos++;
				}
				else
				{
					$htmlVideos = $htmlVideo;
				}
				//se cambia la info
				$pos = $posAux;
				$html = substr_replace($html, $htmlVideos, $pos, (7 * $nVideosPintar));
				$pos += strlen($htmlVideos);
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
		
		public function texto_procesado_movil($html = '', $verImagenes = true, & $contImg = 0, $ruta = null
				, $rutaFisica = null)
		{
			if (!$ruta)
				$ruta = URL_APP;
			if (!$rutaFisica)
				$rutaFisica = APP_ROOT;
			if ($html)
			{
				$html = trim(str_replace('[video]', '', $html));
				$html = str_replace('<iframe width="425" height="350" src="http://www.youtube', 
					'<iframe width="100%" height="300" src="http://www.youtube', $html);
				$pos = 0;
				$imagenes = $this->imagenes();
				for ($i = $contImg; $i < count($imagenes); $i++)
				{
					$imagen = $imagenes[$i];
					if (!$imagen)
						break;
					if ($imagen->oculta)
					{
						$contImg++;
						continue;
					}
					$pos = strpos($html, '[imagen]', $pos);
					if ($pos === false)
						break;
					$rutaImagen = $imagen->ruta();
					//pintar la imagen o imágenes
					//cuantas imágenes pintar en la capa contando todas las consecutivas y pintar así la capa
					$nImagenesPintar = 0;
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
					$htmlImagen = '';
					for ($cont = 0; $cont < $nImagenesPintar; $cont++)
					{
						$htmlImagen .= $this->imagen_movil($imagen, $contImg);
						//si hay más de una imagen
						if ($nImagenesPintar > 1 and $cont < ($nImagenesPintar - 1))
						{
							$i++;
							if (!isset($imagenes[$i]))
								break;
							$imagen = $imagenes[$i];
							if (!$imagen)
								break;
						}
						$contImg++;
						if ($contImg % 2 == 0)
							$htmlImagen .= '<div style="clear: both;"></div>';
					}
					$htmlImagen .= '<div style="clear: both;"></div>';
					//se cambia la info
					$pos = $posAux;
					$html = substr_replace($html, $htmlImagen, $pos, (8 * $nImagenesPintar));
					$pos += strlen($htmlImagen);
				}
			}
			//el resto de fotos no colocadas anteriormente se ubican al final
			if ($verImagenes)
			{
				$html .= $this->mostrar_imagenes($contImg, $ruta, $rutaFisica);
			}
			return $html;
		}
		
		private function imagen_movil($imagen, $contImg)
		{
			$ruta = URL_APP;
			$rutaFisica = APP_ROOT;
			$directorio = floor($imagen->idImagen / 1000);
			$rutaImagen = $imagen->ruta();
			$ampliable = file_exists($imagen->ruta(true));
			list($w, $h) = @getimagesize($rutaImagen);
			if ($ampliable)
			{
				if ($h > $w)
					$tam = 56;
				else
					$tam = 100;
				$style = '';
			}
			else
			{
				$tam = $imagen->tamano;
				$style = 'margin-top: 4pt;';
			}
			$html = '';
			if ($ampliable)
			{
				$html .= '<div id="foto_' . $contImg . '" class="foto">';
				$html .= '<a href="' . $ruta . $imagen->enlace() . '" target="_blank">';
			}
			$html .= '<img src="' . $imagen->url() . '" alt="' . formato_html($imagen->titulo) 
					. '" style="width: ' . $tam . '%; ' . $style . '" />';
			if ($ampliable)
			{
				$tituloCortado = substr($imagen->titulo, 0, TITULO_IMG_MOVIL);
				if (strlen($imagen->titulo) > TITULO_IMG_MOVIL)
					$tituloCortado .= '...';
				//$html .= '<div class="pie_foto"> ' . formato_html($tituloCortado) . '</div></a></div>';
				$html .= '<div class="pie_foto"><strong>' . ++$contImg . '</strong>. ' . formato_html($tituloCortado) . '</div></a></div>';
			}
			else
			{
				$html .= '<div class="pie_foto">' . formato_html($imagen->titulo) . '</div></a></div>';
			}
			return $html;
		}
		
		public function mostrar_imagenes(& $contImg)
		{
			$this->imagenes = null;
			$this->imagenes(null, NUM_FOTOS_MOVIL, $contImg);
			$html = '<div style="clear: both;"></div>';
			foreach ($this->imagenes as $imagen)
			{
				if (!$imagen)
					break;
				if ($imagen->oculta())
				{
					$contImg++;
					continue;
				}
				$html .= $this->imagen_movil($imagen, $contImg);
				$contImg++;
			}
			$total = $this->imagenes(null, null, 0, null, true, array('oculta' => '0'));
			if ($contImg < $total)
			{
				$html .= '<div style="clear: both;"></div>';
				$html .= '<div id="mas_fotos" style="text-align: center; margin: 0; padding: 0;"></div>';
				$html .= '<div id="ver_mas_fotos_' . $contImg . '" class="texto_cen"';
				$html .= ' style="margin: 10pt;"';
				$html .= ' onclick="ocultar_obj(\'ver_mas_fotos_' . $contImg . '\');"><a href="'
						. vlinkAjax('mas-fotos', 'mas_fotos'
								, array('id' => $this->idContenido, 'cont' => $contImg), false, 'reloadwin'
								, true) . '" class="boton">CARGAR M&Aacute;S FOTOS...</a>';
								$html .= '</div>';
				$html .= '<noscript><div class="rojo texto_cen" style="margin-bottom: 10pt;">Debe activar';
				$html .= ' javascript para ver el resto de fotos</div></noscript>';
			}
			else
			{
				$html .= '<div style="clear: both;"></div>';
			}
			$html .= '<div style="clear: both;"></div>';
			return $html;
		}
	}