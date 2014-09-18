<?php
	require_once APP_ROOT . 'clases/service/ImagenService.php';
	class ContenidoImagenService extends ImagenService
	{
		public function mover(ContenidoImagen $imagen, $id)
		{
			$sql = 'update ContenidoImagen set idContenido = ' . $id . ' where idContenido = ' 
					. $imagen->idContenido . ' and idImagen = ' . $imagen->idImagen;
			if (!self::$conexion->ejecuta($sql))
			{
				$this->error = self::$conexion->error();
				return false;
			}
			return true;
		}
		
		public function cambiar_orden_imagen(ContenidoImagen $imagen)
		{
			if (!$imagen->idContenido)
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
			$imagenAux->idContenido = $imagen->idContenido;
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
			$idContenido = $imagen->idContenido;
			$orden = intVal($imagen->orden);
			$ordenActual = intVal($imagenAux->orden);
			$this->inicia_transaccion();
			if ($orden > $ordenActual)
			{
				//baja
				$sql = "update ContenidoImagen set orden = orden -1 where idContenido = $idContenido";
				$sql .= " and orden > $ordenActual and orden <= $orden";
				if (!self::$conexion->ejecuta($sql))
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
				if (!self::$conexion->ejecuta($sql))
				{
					$this->error = self::$conexion->error();
					$this->cancela_transaccion();
					return false;
				}
			}
			//se mueve el que se desea:
			$sql = "update ContenidoImagen set orden = $orden where idImagen = $idImagen";
			$sql .= " and idContenido = $idContenido";
			if (!self::$conexion->ejecuta($sql))
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
			if (!parent::valida($imagen))
				return false;
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
			$idContenido = $imagen->idContenido;
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
	}