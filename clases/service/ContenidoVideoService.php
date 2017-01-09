<?php
	require_once APP_ROOT . 'clases/service/VideoService.php';
	class ContenidoVideoService extends VideoService
	{
		public function cambiar_orden_video(ContenidoVideo $video)
		{
			if (!$video->idContenido)
			{
				$this->error = 'Id de contenido no informado';
				return false;
			}
			if (!$video->id_video)
			{
				$this->error = 'Id de video no informado';
				return false;
			}
			if ($video->orden <= 0)
			{
				$this->error = 'El orden debe ser un número entre 1 y el total de videos mostrados';
				return false;
			}
			$videoAux = new ContenidoVideo();
			$videoAux->idContenido = $video->idContenido;
			$videoAux->id_video = $video->id_video;
			$videoAux = $this->find($videoAux);
			if ($videoAux === false)
				return false;
			if (!$videoAux)
			{
				$this->error = 'No se localiza en la base de datos el video a cambiar de orden';
				return false;
			}
			$videoAux = $videoAux[0];
			if ($videoAux->orden == $video->orden)
				return true;
			$idVideo = $video->id_video;
			$idContenido = $video->idContenido;
			$orden = intVal($video->orden);
			$ordenActual = intVal($videoAux->orden);
			$this->inicia_transaccion();
			if ($orden > $ordenActual)
			{
				//baja
				$sql = "update ContenidoVideo set orden = orden -1 where idContenido = $idContenido";
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
				$sql = "update ContenidoVideo set orden = orden + 1 where idContenido = $idContenido";
				$sql .= " and orden >= $orden and orden < $ordenActual";
				if (self::$conexion->ejecuta($sql) === false)
				{
					$this->error = self::$conexion->error();
					$this->cancela_transaccion();
					return false;
				}
			}
			//se mueve el que se desea:
			$sql = "update ContenidoVideo set orden = $orden where id_video = $idVideo";
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
		
		public function valida(ContenidoVideo $video)
		{
			if (!parent::valida_video($video))
				return false;
			if (!$video->orden)
			{
				$this->error = 'Falta el orden del video';
				return false;
			}
			return true;
		}
		
		public function max_orden(ContenidoVideo $video)
		{
			$idContenido = $video->idContenido;
			$sql = 'select max(orden) as orden from ContenidoVideo where idContenido = ' . $idContenido;
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
	}