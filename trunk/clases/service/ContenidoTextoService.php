<?php
	require_once APP_ROOT . 'clases/service/ContenidoService.php';
	class ContenidoTextoService extends ContenidoService
	{
		public function valida(ContenidoTexto $model)
		{
			if (!parent::valida($model))
			{
				return false;
			}
			if (!$model->encabezado)
			{
				$this->error = 'Es necesario el encabezado de la página';
				return false;
			}
			if (!$model->texto)
			{
				$model->texto = '';
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
			$sql .= 'or ct.texto like \'%' . $consulta . '%\') ';
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