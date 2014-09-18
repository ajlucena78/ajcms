<?php
	require_once APP_ROOT . 'clases/service/ContenidoService.php';
	class ContenidoOfertaService extends ContenidoService
	{
		public function valida(ContenidoOferta $model)
		{
			if (!parent::valida($model))
			{
				return false;
			}
			if (!$model->texto)
			{
				$this->error = 'Es necesario el texto de la oferta';
				return false;
			}
			return true;
		}
	}