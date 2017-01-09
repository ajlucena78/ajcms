<?php
	class CorreoService extends Service
	{
		public function valida(Correo & $model)
		{
			if (!$model->email_correo)
			{
				$this->error = 'Debe indicar el email del correo';
				return false;
			}
			require_once APP_ROOT . 'clases/util/Email.php';
			if (!Email::check_email_address($model->email_correo))
			{
				$this->error = 'La dirección de correo no es correcta';
				return false;
			}
			if ($model->baja === null)
				$model->baja = false;
			return true;
		}
		
		public function guardar(Correo & $model)
		{
			if (!$this->valida($model))
				return false;
			if (!is_object($model->listas(0)) or !$model->listas(0)->id_lista_correo)
			{
				$this->error = 'Debe indicar el ID de la lista de correo';
				return false;
			}
			$correo = new Correo();
			$correo->email_correo = $model->email_correo;
			$correo = $this->find($correo);
			if ($correo)
			{
				//el correo ya existe, se añade a la lista indicada
				$correo = $correo[0];
				$model->id_correo = $correo->id_correo;
			}
			else
			{
				//nuevo correo
				while(true)
				{
					$referencia = strVal(rand(0, 999999));
					$referencia = str_repeat('0', (6 - strlen($referencia))) . $referencia;
					$referencia = md5($model->email_correo . $referencia);
					$model->referencia_correo = $referencia;
					if (!$this->find($model))
						break;
				}
				$this->inicia_transaccion();
				if (!$id = $this->save($model))
				{
					return false;
				}
				$model->id_correo = $id;
			}
			//se guarda la relación del correo con la lista de correos indicada
			if (!$this->save_relation($model, 'listas'))
			{
				return false;
			}
			if ($this->transaccion)
			{
				if (!$this->cierra_transaccion())
				{
					$this->cancela_transaccion();
					return false;
				}
			}
			return true;
		}
		
		public function baja(Correo $model, $total = false)
		{
			if (!$model->id_correo)
			{
				$this->msgError = 'Debe indicar el ID del correo a dar de baja';
				return false;
			}
			if (!$total and (!is_object($model->listas(0)) or !$model->listas(0)->id_lista_correo))
			{
				$this->error = 'Debe indicar el ID de la lista de correo del correo a dar de baja';
				return false;
			}
			$id_correo = $model->id_correo;
			if (!$total)
			{
				$id_lista_correo = $model->listas(0)->id_lista_correo;
				$sql = 'delete from CorreoListaCorreo where id_correo = ' . $model->id_correo;
				$sql .= ' and id_lista_correo = ' . $id_lista_correo;
			}
			else
				$sql = 'update Correo set baja = true where id_correo = ' . $model->id_correo;
			$consulta = new Consulta(self::$conexion);
			if (!$consulta->ejecuta($sql))
			{
				$this->error = $consulta->error();
				return false;
			}
			return true;
		}
	}