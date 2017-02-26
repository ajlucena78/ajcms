<?php
	class ContenidoArchivoService extends Service
	{
		public function valida(ContenidoArchivo $archivo)
		{
			if (!$archivo->titulo)
			{
				$this->error = 'Falta el título del archivo';
				return false;
			}
			if ($archivo->tipo)
			{
				if (!$archivo->extension)
				{
					$this->error = 'Falta la extensión del archivo';
					return false;
				}
				if (!$archivo->tam)
				{
					$this->error = 'Falta el tamaño del archivo';
					return false;
				}
				if (!$archivo->tipo)
				{
					$this->error = 'Falta el tipo del archivo';
					return false;
				}
			}
			if (!$archivo->nombre)
			{
				$this->error = 'Falta la descripción del archivo';
				return false;
			}
			if (!$archivo->titulo)
			{
				$this->error = 'Falta el nombre del archivo';
				return false;
			}
			if (!$archivo->codigo)
			{
				//$archivo->codigo = md5(date('YmdHis'));
				$archivo->codigo = uniqid();
			}
			return true;
		}
		
		public function subir_archivo(ContenidoArchivo & $archivo)
		{
			if ((!$archivo->idArchivo or $archivo->tmp_dir()) and !is_uploaded_file($archivo->tmp_dir()))
			{
				$this->error = 'No se ha podido subir el archivo al servidor';
				return false;
			}
			$this->inicia_transaccion();
			$id = $this->save($archivo, $archivo->idArchivo, true);
			if (!$id)
			{
				$this->error = $this->error();
				$this->cancela_transaccion();
				return false;
			}
			if (!$archivo->idArchivo)
			{
				$archivo->idArchivo = $id;
			}
			if ($archivo->tmp_dir())
			{
				$directorio = floor($archivo->idArchivo / 1000);
				$ruta = APP_ROOT . 'res/upload/' . $directorio;
				if (!is_dir($ruta))
				{
					mkdir($ruta);
				}
				$uploadfile = $ruta . '/' . $archivo->codigo . '.' . $archivo->extension;
				if (!move_uploaded_file($archivo->tmp_dir(), $uploadfile))
				{
					$this->error = 'No se ha podido guardar el archivo subido';
					$this->cancela_transaccion();
					return false;
				}
				if (!$res = chmod($uploadfile, 0777))
				{
					$this->error = 'No ha sido posible cambiar los permisos del archivo añadido';
					$this->cancela_transaccion();
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
	}