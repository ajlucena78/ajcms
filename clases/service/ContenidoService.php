<?php
	require_once 'clases/util/Cadena.php';
	require_once 'clases/model/Imagen.php';
	require_once 'clases/service/ImagenService.php';
	
	class ContenidoService extends Service
	{
		public function valida_contenido(Contenido & $contenido)
		{
			if (!$contenido->descripcion)
			{
				$this->error = 'Debe indicar el título del contenido';
				return false;
			}
			if (!$contenido->usuario or !$contenido->usuario->idUsuario)
			{
				$this->error = 'Debe indicar el autor del contenido';
				return false;
			}
			if (!$contenido->idContenido)
			{
				//nueva referencia
				while(true)
				{
					$referencia = strVal(rand(0, 999999));
					$referencia = str_repeat('0', (6 - strlen($referencia))) . $referencia;
					$aux = new Contenido();
					$aux->referencia = $referencia;
					if (!$this->find($aux))
						break;
				}
				$contenido->referencia = $referencia;
			}
			else
			{
				//se trata de una edición
				if (!$contenido->referencia)
				{
					$this->error = 'La referencia del contenido no ha sido indicada';
					return false;
				}
				if (!$contenido->idContenido)
				{
					$this->error = 'Debe indicar el ID del contenido';
					return false;
				}
			}
			if (!$contenido->permalink)
			{
				$contenido->permalink = Cadena::genera_permalink($contenido->descripcion);
			}
			else
			{
				$contenido->permalink = Cadena::genera_permalink($contenido->permalink);
			}
			//el permalink no se puede repetir
			$model = new Contenido();
			$model->permalink = $contenido->permalink;
			$res = $this->find($model);
			if ($res)
			{
				$model = $res[0];
				if ($model->idContenido != $contenido->idContenido)
				{
					$this->error = 'El permalink indicado ya está en uso';
					return false;
				}
			}
			$img = new Imagen();
			$img->permalink = $model->permalink;
			$imagenService = new ImagenService();
			$img = $imagenService->find($img);
			if ($img and $img[0])
			{
				$this->error = 'El permalink indicado ya está en uso por una foto';
				return false;
			}
			if (!$contenido->privado)
			{
				$contenido->privado = false;
			}
			return true;
		}
	}