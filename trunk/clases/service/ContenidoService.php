<?php
	class ContenidoService extends Service
	{
		public function valida(Contenido & $contenido)
		{
			if (!$contenido->descripcion)
			{
				$this->error = 'Debe indicar el t�tulo del contenido';
				return false;
			}
			if (!$contenido->usuario or !$contenido->usuario->idUsuario)
			{
				$this->error = 'Debe indicar el autor del contenido';
				return false;
			}
			if ($contenido->permalink)
			{
				$contenido->permalink = str_replace(' ', '-', trim($contenido->permalink));
				$contenido->permalink = str_replace('�', 'a', $contenido->permalink);
				$contenido->permalink = str_replace('�', 'e', $contenido->permalink);
				$contenido->permalink = str_replace('�', 'i', $contenido->permalink);
				$contenido->permalink = str_replace('�', 'o', $contenido->permalink);
				$contenido->permalink = str_replace('�', 'u', $contenido->permalink);
				$contenido->permalink = str_replace('�', 'n', $contenido->permalink);
				//el permalink no se puede repetir
				$model = new Contenido();
				$model->permalink = $contenido->permalink;
				$res = $this->find($model);
				if ($res)
				{
					$model = $res[0];
					if ($model->idContenido != $contenido->idContenido)
					{
						$this->error = 'El permalink indicado ya est� en uso';
						return false;
					}
				}
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
				//se trata de una edici�n
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
			return true;
		}
	}