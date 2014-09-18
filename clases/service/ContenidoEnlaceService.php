<?php
	require_once APP_ROOT . 'clases/service/ContenidoService.php';
	class ContenidoEnlaceService extends ContenidoService
	{
		public function valida(ContenidoEnlace $model)
		{
			if (!parent::valida($model))
			{
				return false;
			}
			if (!$model->url)
			{
				$this->error = 'Es necesaria la URL del enlace';
				return false;
			}
			return true;
		}
	}