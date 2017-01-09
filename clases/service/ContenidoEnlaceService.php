<?php
	require_once APP_ROOT . 'clases/service/ContenidoService.php';
	class ContenidoEnlaceService extends ContenidoService
	{
		public function valida(ContenidoEnlace $model)
		{
			if (!parent::valida_contenido($model))
			{
				return false;
			}
			if (!$model->url)
			{
				$this->error = 'Es necesaria la URL del enlace';
				return false;
			}
			if ($model->tipoEnlace < 1 or $model->tipoEnlace > 2)
			{
				$this->error = 'El tipo de enlace no es correcto';
				return false;
			}
			if ($model->tipoEnlace == 2)
			{
				if (!$model->h1 or !$model->metadesc)
				{
					$this->error = 'El tipo de enlace duplicado debe tener un encabezado y su meta-descripción';
					return false;
				}
			}
			return true;
		}
	}