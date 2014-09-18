<?php
	require_once 'clases/util/Imagenes.php';
	class ImagenService extends Service
	{
		public function subir_imagen(Imagen & $imagen, $marca = false)
		{
			if ((!$imagen->idImagen or $imagen->tmp_dir()) and !is_uploaded_file($imagen->tmp_dir()))
			{
				$this->error = 'No se ha podido subir la imagen al servidor';
				return false;
			}
			$this->inicia_transaccion();
			if (!$this->save($imagen, $imagen->idImagen, true))
			{
				$this->error = $this->error();
				$this->cancela_transaccion();
				return false;
			}
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
					imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
					if (!imagejpeg($image_p, $uploadfile, 75))
					{
						$this->error = 'No ha sido posible guardar el archivo de la imagen original reescalada';
						$this->error .= ' para reducir su tamaño';
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
						$this->error = 'No ha sido posible guardar el archivo de la imagen original para añadir';
						$this->error .= ' la marca';
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
				if ($imagen->ampliable())
				{
					//generación de la imagen reducida para las fotos ampliables
					$width = 200;
					$height = 149;
					list($width_orig, $height_orig) = getimagesize($uploadfile);
					$ratio_orig = $width_orig / $height_orig;
					if (($width / $height) > $ratio_orig)
						$width = $height * $ratio_orig;
					else
						$height = $width / $ratio_orig;
					$image_p = imagecreatetruecolor($width, $height);
					$image = imagecreatefromjpeg($uploadfile);
					imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
					if (!imagejpeg($image_p, $ruta . '/' . $imagen->idImagen . '.' . $imagen->extension, 85))
					{
						$this->error = 'No ha sido posible guardar el archivo de la imagen reducida';
						return false;
					}
					if (!$res = chmod($ruta . '/' . $imagen->idImagen . '.' . $imagen->extension, 0777))
					{
						$this->error = 'No ha sido posible cambiar los permisos de la imagen reducida';
						return false;
					}
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
		
		public function valida(Imagen $imagen)
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