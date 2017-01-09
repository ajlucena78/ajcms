<?php
	require_once APP_ROOT . 'clases/service/ContenidoService.php';
	
	class ContenidoTextoService extends ContenidoService
	{
		public function valida(ContenidoTexto $model)
		{
			if (!$model->encabezado)
			{
				if (!$model->descripcion)
				{
					$this->error = 'Es necesaria la descripción de la página';
					return false;
				}
				else
				{
					$model->encabezado = $model->descripcion;
				}
			}
			if (!$model->texto)
			{
				$model->texto = '';
			}
			if (!$model->texto2)
			{
				$model->texto2 = '';
			}
			if (!$model->pie)
			{
				$model->pie = '';
			}
			if (!parent::valida_contenido($model))
			{
				return false;
			}
			return true;
		}
		
		public function buscar($consulta)
		{
			if (!$consulta)
			{
				$this->error = 'Texto de consulta no indicado';
				return false;
			}
			$sql = 'select * from Contenido c, ContenidoTexto ct ';
			$sql .= 'where (c.descripcion like \'%' . $consulta . '%\' ';
			$sql .= 'or ct.texto like \'%' . $consulta . '%\' ';
			$sql .= 'or ct.texto2 like \'%' . $consulta . '%\') ';
			$sql .= 'and c.idContenido = ct.idContenido';
			$consulta = new Consulta(self::$conexion);
			if (!$consulta->ejecuta($sql))
			{
				$this->error = $consulta->error();
				return false;
			}
			$res = array();
			while ($reg = $consulta->lee_registro())
			{
				$res[] = new ContenidoTexto($reg);
			}
			$consulta->libera();
			return $res;
		}
	}