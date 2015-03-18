<?php
	class VideoService extends Service
	{
		public function subir_video(Video & $video)
		{
			if (!$video->ancho_video)
				$video->ancho_video = ANCHO_VIDEO;
			if (!$video->alto_video)
				$video->alto_video = ALTO_VIDEO;
			$this->inicia_transaccion();
			if (!$this->save($video, $video->id_video, true))
			{
				$this->error = $this->error();
				$this->cancela_transaccion();
				return false;
			}
			if ($video->tmp_dir())
			{
				if (!is_uploaded_file($video->tmp_dir()))
				{
					$this->error = 'No se ha podido subir el archivo del video al servidor';
					return false;
				}
				$directorio = floor($video->id_video / 1000);
				$ruta = APP_ROOT . 'res/upload/' . $directorio;
				if (!is_dir($ruta))
					mkdir($ruta);
				$uploadfile = $ruta . '/' . $video->id_video . '.' . $video->extension;
				if (!$res = move_uploaded_file($video->tmp_dir(), $uploadfile))
				{
					$this->error = 'El vídeo no ha podido ser guardado en el servidor';
					return false;
				}
				if (!$res = chmod($uploadfile, 0777))
				{
					$this->error = 'No ha sido posible cambiar los permisos del vídeo añadido';
					return false;
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
		
		public function valida(Video $video)
		{
			if (!$video->titulo_video)
			{
				$this->error = 'Falta el título del video';
				return false;
			}
			if ($video->ancho_video and !is_numeric($video->ancho_video))
			{
				$this->error = 'El ancho especificado no es correcto';
				return false;
			}
			if ($video->alto_video and !is_numeric($video->alto_video))
			{
				$this->error = 'El alto especificado no es correcto';
				return false;
			}
			if ($video->tipo)
			{
				if (!$video->extension)
				{
					$this->error = 'Falta la extensión del video';
					return false;
				}
				if (!$video->tam)
				{
					$this->error = 'Falta el tamaño del video';
					return false;
				}
				if (strtoupper($video->extension) != 'FLV' or ($video->tipo != 'video/x-flv' 
						and $video->tipo != 'application/octet-stream' and $video->tipo != 'application/octet-st'))
				{
					$this->error = 'El video debe estar en formato FLV';
					return false;
				}
			}
			return true;
		}
	}