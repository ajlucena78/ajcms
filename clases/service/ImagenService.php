<?php
	require_once 'clases/util/Imagenes.php';
	require_once 'clases/util/Cadena.php';
	require_once 'clases/model/Contenido.php';
	require_once 'clases/service/ContenidoService.php';
	class ImagenService extends Service
	{
		public function subir_imagen(Imagen & $imagen, $marca = false)
		{
			if ((!$imagen->idImagen or $imagen->tmp_dir()) and !is_uploaded_file($imagen->tmp_dir()))
			{
				$this->error = 'No se ha podido subir la imagen al servidor';
				return false;
			}
			if ($imagen->tmp_dir())
			{
				list($width, $height) = getimagesize($imagen->tmp_dir());
				if ($width < ANCHO_IMG or $height < ALTO_IMG)
				{
					$this->error = 'La imagen debe tener como mínimo ' . ANCHO_IMG . 'px de ancho por ' 
							. ALTO_IMG. 'px de alto';
					return false;
				}
			}
			$this->inicia_transaccion();
			if (!$this->save($imagen, $imagen->idImagen, true))
			{
				$this->error = $this->error();
				$this->cancela_transaccion();
				return false;
			}
			if (trim($imagen->titulo))
			{
				$imagen->permalink = Cadena::genera_permalink($imagen->titulo);
				$img = new Imagen();
				$img->permalink = $imagen->permalink;
				$img = $this->find($img);
				if ($img and $img[0])
				{
					if ($img[0]->idImagen != $imagen->idImagen)
					{
						$imagen->permalink .= '-' . $imagen->idImagen;
					}
				}
				unset($img);
			}
			$cont = new Contenido();
			$cont->permalink = $imagen->permalink;
			$contenidoService = new ContenidoService();
			$cont = $contenidoService->find($cont);
			if ($cont and $cont[0])
			{
				$imagen->permalink .= '-' . $imagen->idImagen;
			}
			unset($cont);
			$this->save($imagen, true, true);
			if (!$imagen->idImagen or $imagen->tmp_dir())
			{
				$directorio = floor($imagen->idImagen / 1000);
				$ruta = APP_ROOT . 'res/upload/' . $directorio;
				if (!is_dir($ruta))
					mkdir($ruta);
				if ($imagen->ampliable())
					$uploadfile = $ruta . '/original_' . $imagen->idImagen . '.' . $imagen->extension;
				else
					$uploadfile = $ruta . '/' . $imagen->idImagen . '.' . $imagen->extension;
				$imagenes = new Imagenes();
				if (!move_uploaded_file($imagen->tmp_dir(), $uploadfile))
				{
					$this->error = 'No se ha podido guardar la imagen subida';
					$this->cancela_transaccion();
					return false;
				}
				if (!$res = chmod($uploadfile, 0777))
				{
					$this->error = 'No ha sido posible cambiar los permisos de la imagen añadida';
					$this->cancela_transaccion();
					return false;
				}
				if ($imagen->ampliable())
				{
					//si el ancho de la foto es demasiado grande, se reduce hasta el máximo permitido:
					list($width_orig, $height_orig) = getimagesize($uploadfile);
					if ($width_orig > TAM_IMAGENES_ANCHO_AMPLIADA or $height_orig > TAM_IMAGENES_ALTO_AMPLIADA)
					{
						$width = TAM_IMAGENES_ANCHO_AMPLIADA;
						$height = TAM_IMAGENES_ALTO_AMPLIADA;
						$ratio_orig = $width_orig / $height_orig;
						if (($width / $height) > $ratio_orig)
							$width = $height * $ratio_orig;
						else
							$height = $width / $ratio_orig;
						$image_p = imagecreatetruecolor($width, $height);
						$image = imagecreatefromjpeg($uploadfile);
						if ($marca)
							Imagenes::marca($image);
						imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig
								, $height_orig);
						if (!imagejpeg($image_p, $uploadfile, 75))
						{
							$this->error = 'No ha sido posible guardar el archivo de la imagen original';
							$this->error .= ' reescalada para reducir su tamaño';
							$this->cancela_transaccion();
							return false;
						}
						if (!$res = chmod($uploadfile, 0777))
						{
							$this->error = 'No ha sido posible cambiar los permisos de la imagen reescalada';
							$this->cancela_transaccion();
							return false;
						}
					}
					elseif ($marca)
					{
						$image_p = imagecreatetruecolor($width_orig, $height_orig);
						$image = imagecreatefromjpeg($uploadfile);
						Imagenes::marca($image);
						imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width_orig, $height_orig, $width_orig
								, $height_orig);
						if (!imagejpeg($image_p, $uploadfile, 75))
						{
							$this->error = 'No ha sido posible guardar el archivo de la imagen original para';
							$this->error .= ' añadir la marca';
							$this->cancela_transaccion();
							return false;
						}
						if (!$res = chmod($uploadfile, 0777))
						{
							$this->error = 'No ha sido posible cambiar los permisos de la imagen añadida';
							$this->cancela_transaccion();
							return false;
						}
					}
					//generación de la imagen reducida para las fotos ampliables
					Imagenes::thumb_jpeg($uploadfile, $ruta . '/' . $imagen->idImagen . '.' . $imagen->extension
							, ANCHO_IMG);
				}
				else
				{
					//se borra la posible foto ampliable
					@unlink($ruta . '/original_' . $imagen->idImagen . '.' . $imagen->extension);
				}
			}
			if (!$this->cierra_transaccion())
			{
				$this->error = self::$conexion->error();
				$this->cancela_transaccion();
				return false;
			}
			return true;
		}
		
		public function valida_imagen(Imagen $imagen)
		{
			if (!$imagen->titulo)
			{
				$this->error = 'Falta el título de la imagen';
				return false;
			}
			if ($imagen->tipo)
			{
				if (!$imagen->extension)
				{
					$this->error = 'Falta la extensión de la imagen';
					return false;
				}
				if (!$imagen->tam)
				{
					$this->error = 'Falta el tamaño de la imagen';
					return false;
				}
				if (!$imagen->tipo)
				{
					$this->error = 'Falta el tipo de la imagen';
					return false;
				}
				if ($imagen->tipo != 'image/jpeg' and $imagen->tipo != 'image/pjpeg' 
						and $imagen->tipo != 'image/gif')
				{
					$this->error = 'La imagen debe estar en formato JPEG o GIF';
					return false;
				}
			}
			return true;
		}
	}