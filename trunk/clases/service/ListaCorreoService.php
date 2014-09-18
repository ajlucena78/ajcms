<?php
	class ListaCorreoService extends Service
	{
		public function num_correos(ListaCorreo $lista)
		{
			$sql = 'select count(id_correo) as total from CorreoListaCorreo where id_lista_correo = ' 
					. $lista->id_lista_correo;
			$consulta = new Consulta(self::$conexion);
			if (!$consulta->ejecuta($sql))
			{
				$this->error = $consulta->error();
				return false;
			}
			$res = $consulta->lee_registro();
			if (!$res)
			{
				$this->error = $consulta->error();
				return false;
			}
			$consulta->libera();
			return $res['total'] + 0;
		}
	}