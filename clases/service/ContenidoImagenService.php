<?php
	require_once 'clases/util/Imagenes.php';
	require_once 'clases/util/Cadena.php';
	require_once 'clases/model/Contenido.php';
	require_once 'clases/service/ContenidoService.php';
	
	class ContenidoImagenService extends Service
	{
		public function mover(ContenidoImagen $imagen, $id)
		{
			$imagenAux = new ContenidoImagen();
			$imagenAux->contenido = new Contenido();
			$imagenAux->contenido->idContenido = $id;
			$orden = $this->max_orden($imagenAux);
			$this->inicia_transaccion();
			$sql = 'update ContenidoImagen set idContenido = ' . $id . ', orden = ' . $orden 
					. ' where idContenido = ' . $imagen->contenido->idContenido . ' and idImagen = ' 
					. $imagen->idImagen;
			if (self::$conexion->ejecuta($sql) === false)
			{
				$this->error = self::$conexion->error();
				$this->cancela_transaccion();
				return false;
			}
			$sql = 'update ContenidoImagen set orden = orden - 1 where idContenido = ' 
					. $imagen->contenido->idContenido . ' and orden > ' . $imagen->orden;
			if (!$this->cierra_transaccion())
			{
				$this->cancela_transaccion();
				$this->error = self::$conexion->error();
				return false;
			}
			return true;
		}
		
		public function cambiar_orden_imagen(ContenidoImagen $imagen)
		{
			if (!$imagen->contenido or !$imagen->contenido->idContenido)
			{
				$this->error = 'Id de contenido no informado';
				return false;
			}
			if (!$imagen->idImagen)
			{
				$this->error = 'Id de imagen no informado';
				return false;
			}
			if ($imagen->orden <= 0)
			{
				$this->error = 'El orden debe ser un número entre 1 y el total de imágenes mostradas';
				return false;
			}
			$imagenAux = new ContenidoImagen();
			$imagenAux->contenido = new Contenido();
			$imagenAux->contenido->idContenido = $imagen->contenido->idContenido;
			$imagenAux->idImagen = $imagen->idImagen;
			$imagenAux = $this->find($imagenAux);
			if ($imagenAux === false)
				return false;
			if (!$imagenAux)
			{
				$this->error = 'No se localiza en la base de datos la imagen a cambiar de orden';
				return false;
			}
			$imagenAux = $imagenAux[0];
			if ($imagenAux->orden == $imagen->orden)
				return true;
			$idImagen = $imagen->idImagen;
			$idContenido = $imagen->contenido->idContenido;
			$orden = intVal($imagen->orden);
			$ordenActual = intVal($imagenAux->orden);
			$this->inicia_transaccion();
			if ($orden > $ordenActual)
			{
				//baja
				$sql = "update ContenidoImagen set orden = orden -1 where idContenido = $idContenido";
				$sql .= " and orden > $ordenActual and orden <= $orden";
				if (self::$conexion->ejecuta($sql) === false)
				{
					$this->error = self::$conexion->error();
					$this->cancela_transaccion();
					return false;
				}
			}
			else
			{
				//sube
				$sql = "update ContenidoImagen set orden = orden + 1 where idContenido = $idContenido";
				$sql .= " and orden >= $orden and orden < $ordenActual";
				if (self::$conexion->ejecuta($sql) === false)
				{
					$this->error = self::$conexion->error();
					$this->cancela_transaccion();
					return false;
				}
			}
			//se mueve el que se desea:
			$sql = "update ContenidoImagen set orden = $orden where idImagen = $idImagen";
			$sql .= " and idContenido = $idContenido";
			if (self::$conexion->ejecuta($sql) === false)
			{
				$this->error = self::$conexion->error();
				$this->cancela_transaccion();
				return false;
			}
			if (!$this->cierra_transaccion())
			{
				$this->cancela_transaccion();
				$this->error = self::$conexion->error();
				return false;
			}
			return true;
		}
		
		public function valida(ContenidoImagen $imagen)
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
			if (!$imagen->orden)
			{
				$this->error = 'Falta el orden de la imagen';
				return false;
			}
			if (!$imagen->tamano)
			{
				$this->error = 'Falta el tamaño en % de la imagen';
				return false;
			}
			return true;
		}
		
		public function max_orden(ContenidoImagen $imagen)
		{
			$idContenido = $imagen->contenido->idContenido;
			$sql = 'select max(orden) as orden from ContenidoImagen where idContenido = ' . $idContenido;
			$consulta = new Consulta(self::$conexion);
			if (!$consulta->ejecuta($sql))
			{
				$this->error = $consulta->error();
				return false;
			}
			$reg = $consulta->lee_registro();
			if ($reg['orden'])
				$orden = $reg['orden'] + 1;
			else
				$orden = 1;
			$consulta->libera();
			return $orden;
		}
		
		public function subir_imagen(ContenidoImagen & $imagen, $marca = false)
		{
			if ((!$imagen->idImagen or $imagen->tmp_dir()) and !is_uploaded_file($imagen->tmp_dir()))
			{
				$this->error = 'No se ha podido subir la imagen al servidor';
				return false;
			}
			if ($imagen->idImagen)
			{
				$imagenActual = $this->findById($imagen->idImagen);
			}
			$this->inicia_transaccion();
			$id = $this->save($imagen, $imagen->idImagen, true);
			if (!$id)
			{
				$this->error = $this->error();
				$this->cancela_transaccion();
				return false;
			}
			if (!$imagen->idImagen)
			{
				$imagen->idImagen = $id;
			}
			if ($imagen->titulo)
			{
				$imagen->permalink = Cadena::genera_permalink($imagen->titulo);
				$img = new ContenidoImagen();
				$img->permalink = $imagen->permalink;
				$img = $this->find($img);
				if ($img and $img[0])
				{
					if ($img[0]->idImagen != $imagen->idImagen)
					{
						$imagen->permalink .= '-' . $imagen->idImagen;
					}
				}
				else
				{
					$cont = new Contenido();
					$cont->permalink = $imagen->permalink;
					$contenidoService = new ContenidoService();
					$cont = $contenidoService->find($cont);
					if ($cont and $cont[0])
					{
						$imagen->permalink .= '-' . $imagen->idImagen;
					}
					unset($cont);
				}
				unset($img);
			}
			else
			{
				$contenidoService = new ContenidoService();
				$cont = $contenidoService->findById($imagen->contenido->idContenido);
				if ($cont and $cont[0])
				{
					$imagen->permalink = $cont[0]->permalink . '-' . $imagen->idImagen;
				}
				else
				{
					$this->error = 'No se puede localizar el contenido de la imagen';
					$this->cancela_transaccion();
					return false;
				}
				unset($cont);
			}
			if (!$imagen->permalink)
			{
				$this->error = 'No se puede generar el permalink de la imagen';
				$this->cancela_transaccion();
				return false;
			}
			if (!$this->save($imagen, true, true))
			{
				$this->error = $this->error();
				$this->cancela_transaccion();
				return false;
			}
			if ($imagen->tmp_dir())
			{
				$directorio = floor($imagen->idImagen / 1000);
				$ruta = APP_ROOT . 'res/upload/' . $directorio;
				if (!is_dir($ruta))
				{
					mkdir($ruta);
				}
				if ($imagen->ampliable())
				{
					$uploadfile = $ruta . '/original-' . $imagen->permalink . '.' . $imagen->extension;
				}
				else
				{
					$uploadfile = $ruta . '/' . $imagen->permalink . '.' . $imagen->extension;
				}
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
					//si el ancho de la foto es demasiado grande, se reduce hasta el máximo permitido
					list($width_orig, $height_orig) = getimagesize($uploadfile);
					if ($width_orig > TAM_IMAGENES_ANCHO_AMPLIADA or $height_orig > TAM_IMAGENES_ALTO_AMPLIADA)
					{
						$width = TAM_IMAGENES_ANCHO_AMPLIADA;
						$height = TAM_IMAGENES_ALTO_AMPLIADA;
						$ratio_orig = $width_orig / $height_orig;
						if (($width / $height) > $ratio_orig)
						{
							$width = $height * $ratio_orig;
						}
						else
						{
							$height = $width / $ratio_orig;
						}
						$image_p = imagecreatetruecolor($width, $height);
						$image = imagecreatefromjpeg($uploadfile);
						if ($marca)
						{
							Imagenes::marca($image);
						}
						imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig
								, $height_orig);
						if (!imagejpeg($image_p, $uploadfile, 85))
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
						if (!imagejpeg($image_p, $uploadfile, 85))
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
					$width = ANCHO_IMG;
					Imagenes::thumb_jpeg($uploadfile, $imagen->ruta(), $width);
				}
				else
				{
					//se borra la posible foto ampliable
					@unlink($imagen->ruta(true));
				}
				//se comprueba un posible cambio de permalink para eliminar la foto con el otro nombre
				if (isset ($imagenActual) and $imagenActual->permalink != $imagen->permalink)
				{
					@unlink($imagenActual->ruta());
					if (file_exists($imagenActual->ruta(true)))
					{
						@unlink($imagenActual->ruta(true));
					}
				}
			}
			else
			{
				//no se ha subido una nueva imagen pero se comprueba un posible cambio de permalink
				if (isset ($imagenActual) and $imagenActual->permalink != $imagen->permalink)
				{
					if (file_exists($imagenActual->ruta()))
					{
						rename($imagenActual->ruta(), $imagen->ruta());
					}
					if (file_exists($imagenActual->ruta(true)))
					{
						rename($imagenActual->ruta(true), $imagen->ruta(true));
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
	}