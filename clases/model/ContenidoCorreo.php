<?php
	require_once APP_ROOT . 'clases/model/Contenido.php';
	class ContenidoCorreo extends Contenido
	{
		protected $texto;
		protected $tipo;
		
		public function texto_procesado($ruta = null, $rutaFisica = null)
		{
			if (!$ruta)
				$ruta = HOST_APP . URL_APP;
			if (!$rutaFisica)
				$rutaFisica = APP_ROOT;
			$html = $this->texto;
			$pos = 0;
			$contDivImagenes = 1;
			$imagenes = $this->imagenes();
			$maxHeight = 0;
			for ($i = 0; $i < count($imagenes); $i++)
			{
				$imagen = $imagenes[$i];
				if (!$imagen)
					break;
				$directorio = floor($imagen->idImagen / 1000);
				$imagenFile = $rutaFisica . "res/upload/" . $directorio . "/" . $imagen->idImagen . "." 
						. $imagen->extension;
				$archivoOriginal = $rutaFisica . "res/upload/" . $directorio . "/original_" . $imagen->idImagen 
						. "." . $imagen->extension;
				//pintar la imagen o imágenes
				//cuantas imágenes pintar en la capa contando todas las consecutivas y pintar así la capa
				$nImagenesPintar = 0;
				$pos = strpos($html, "[imagen]", $pos);
				if ($pos === false)
					break;
				$nImagenesPintar++;
				$posAux = $pos;
				do
				{
					$pos += 8;
					if ($pos > (strlen($html) - 8))
						break;
					if (substr($html, $pos, 8) != "[imagen]")
						break;
					$nImagenesPintar++;
				}
				while (true);
				//se genera el html con las imágenes
				$htmlImagen = "";
				for ($cont = 0; $cont < $nImagenesPintar; $cont++)
				{
					//html por cada imagen
					$ampliable = false;
					$htmlImagenAux = "";
					if (file_exists($archivoOriginal))
					{
						$ampliable = true;
						$htmlImagenAux .= "<a href=\"" . $ruta . "?action=ver_img&amp;id=" . $imagen->idImagen . "\">";
					}
					list($width_img, $height_img) = getimagesize($imagenFile);
					if (is_object($imagen) and $imagen->alineamiento != 2)
					{
						if ($imagen->alineamiento == 0)
							$alineamiento = " float: right;";
						else
							$alineamiento = " float: left;";
					}
					else
						$alineamiento = '';
					$htmlImagenAux .= "<img style=\"border: 0px; margin: 2px;$alineamiento\" src=\"" . 
							$ruta . "res/upload/" . $directorio . "/" . $imagen->idImagen . "." . 
							$imagen->extension . "\" alt=\"" . formato_html($imagen->titulo) . "\" />";
					if ($ampliable)
						$htmlImagenAux .= "</a>";
					$htmlImagen .= $htmlImagenAux . "\n";
					//si hay más de una imagen
					if ($nImagenesPintar > 1 and $cont < ($nImagenesPintar - 1))
					{
						$i++;
						$imagen = $imagenes[$i];
						if (!$imagen)
							break;
						$directorio = floor($imagen->idImagen / 1000);
						$imagenFile = $rutaFisica . "res/upload/" . $directorio . "/" . $imagen->idImagen . "." 
								. $imagen->extension;
						$archivoOriginal = $rutaFisica . "res/upload/" . $directorio . "/original_" 
								. $imagen->idImagen . "." . $imagen->extension;
					}
				}
				$htmlImagen .= "\n";
				//se cambia la info
				$pos = $posAux;
				$html = substr_replace($html, $htmlImagen, $pos, (8 * $nImagenesPintar));
				$pos += strlen($htmlImagen);
			}
			return $html;
		}
	}