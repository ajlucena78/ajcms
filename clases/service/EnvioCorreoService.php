<?php
class EnvioCorreoService extends Service
{
	public function valida(EnvioCorreo $model)
	{
		if (!$model->fecha_programa_envio)
		{
			$this->error = 'Debe indicar la fecha de envío';
			return false;
		}
		if (!$model->contenido or !$model->contenido->idContenido)
		{
			$this->error = 'Es necesario el mensaje que va a ser enviado';
			return false;
		}
		if (!is_array($model->listas) or count($model->listas) == 0)
		{
			$this->error = 'Es necesario añadir al menos un destinatario para el envío';
			return false;
		}
		if (!$model->usuario or !$model->usuario->idUsuario)
		{
			$this->error = 'Debe indicar el autor del envío';
			return false;
		}
		return true;
	}

	public function guarda(EnvioCorreo & $model, $update = false)
	{
		if (!$this->valida($model))
			return false;
		if ($update)
		{
			if (!$model->id_envio_correo)
			{
				$this->error = 'Debe indicar el ID de envío a editar';
				return false;
			}
		}
		if (isset($_FILES['fichero_adjunto']['tmp_name']) and $_FILES['fichero_adjunto']['tmp_name'])
		{
			if (@is_uploaded_file($_FILES['fichero_adjunto']['tmp_name']))
			{
				$ruta = APP_ROOT . 'temporal/' . md5($_FILES['fichero_adjunto']['tmp_name'] . date('Y-m-d H:i:s'));
				if (!is_dir($ruta))
				if (!@mkdir($ruta))
				{
					$this->error = 'No ha sido posible crear el directorio temporal';
					return false;
				}
				$fichero = $ruta . '/' . $_FILES['fichero_adjunto']['name'];
				if (!@move_uploaded_file($_FILES['fichero_adjunto']['tmp_name'], $fichero))
				{
					$this->error = 'No ha sido posible copiar el fichero subido al directorio temporal';
					return false;
				}
				$model->fichero_adjunto = $fichero;
			}
			else
			{
				$this->error = 'No ha sido posible subir el fichero adjunto al servidor';
				return false;
			}
		}
		$this->inicia_transaccion();
		if (!$id = $this->save($model, $update))
		{
			if (isset($fichero) and file_exists($fichero))
				unlink($fichero);
			$this->cancela_transaccion();
			return false;
		}
		if ($update)
		{
			if (!$this->destroy_relation($model, 'listas', true))
			{
				if (isset($fichero) and file_exists($fichero))
					unlink($fichero);
				$this->cancela_transaccion();
				return false;
			}
		}
		else
		{
			$model->id_envio_correo = $id;
		}
		if (!$this->save_relation($model, 'listas'))
		{
			if (isset($fichero) and file_exists($fichero))
				unlink($fichero);
			$this->cancela_transaccion();
			return false;
		}
		if (!$this->cierra_transaccion())
		{
			if (isset($fichero) and file_exists($fichero))
				unlink($fichero);
			$this->cancela_transaccion();
			return false;
		}
		return true;
	}

	public function envio_correo_prueba(EnvioCorreo $envio, $mensaje, $email)
	{
		if (!$email)
		{
			$this->error = 'Es necesario el email de prueba al que va a ser enviado';
			return false;
		}
		$correo = $envio->contenido;
		require_once APP_ROOT . 'clases/util/PHPMailer/class.phpmailer.php';
		$mail = new PHPMailer();
		$mail->AddAddress($email);
		$mail->Subject 	= stripslashes($correo->descripcion);
		$mail->Body 	= stripslashes($mensaje);
		$mail->CharSet 	= 'utf-8';
		$mail->IsHTML(true);
		$mail->Mailer 	= 'smtp';
		$mail->SetLanguage('es', APP_ROOT . 'clases/PHPMailer/language/');
		$mail->From = EMAIL_FROM;
		$mail->FromName = EMAIL_FROM_NAME;
		if (isset($_FILES['fichero_adjunto']['tmp_name']) and $_FILES['fichero_adjunto']['tmp_name'])
		{
			if (@is_uploaded_file($_FILES['fichero_adjunto']['tmp_name']))
			{
				$fichero = APP_ROOT . 'temporal/' . $_FILES['fichero_adjunto']['name'];
				if (!@move_uploaded_file($_FILES['fichero_adjunto']['tmp_name'], $fichero))
				{
					$this->error = 'No ha sido posible copiar el fichero subido al directorio temporal';
					return false;
				}
				if (!$mail->AddAttachment($fichero))
				{
					$this->error = $mail->ErrorInfo;
					@unlink($fichero);
					return false;
				}
			}
			else
			{
				$this->error = 'No ha sido posible subir el fichero adjunto al servidor';
				return false;
			}
		}
		$res = @$mail->Send();
		if (isset($fichero))
			@unlink($fichero);
		if (!$res)
			$this->error = 'No ha sido posible el envío del mensaje';
		return $res;
	}

	public function envios_cola()
	{
		$sql = 'select * from EnvioCorreo where fecha_programa_envio <= now() and fecha_fin is null';
		$sql .= ' order by fecha_programa_envio';
		$consulta = new Consulta(self::$conexion);
		if (!$consulta->ejecuta($sql))
			return false;
		$registros = array();
		while ($registro = $consulta->lee_registro())
			$registros[] = new EnvioCorreo($registro);
		$consulta->libera();
		return $registros;
	}

	public function destinatarios($email = null)
	{
		if (!$this->model or !$this->model->id_envio_correo)
		{
			$this->error = 'Debe indicar el ID del envío de correo';
			return false;
		}
		if (!$this->correoModel->get_destinatarios_envio($this->model, $email))
		{
			$this->msgError = $this->correoModel->lee_msg_error();
			$this->codError = $this->correoModel->lee_cod_error();
			return false;
		}
		$sql = 'select distinct d1.* from Correo d1';
		$sql .= ' inner join CorreoListaCorreo d2 on (d2.id_correo = d1.id_correo)';
		$sql .= ' inner join envioCorreoLista d3 on (d3.id_lista_correo = d2.id_lista_correo)';
		$sql .= ' where d3.id_envio_correo = ' . $this->model->id_envio_correo;
		if ($email)
			$sql .= ' and d1.email_correo > \'' . $email . '\'';
		$sql .= ' and d1.baja = false';
		$sql .= ' order by d1.email_correo';
		$sql .= ' order by fecha_programa_envio';
		$consulta = new Consulta(self::$conexion);
		if (!$consulta->ejecuta($sql))
			return false;
		$correos = array();
		while ($correo = $consulta->lee_registro())
			$correos[] = $correo;
		$this->model->destinatarios = $correos;
		return true;
	}

	public function envia($pathRelativo, $rootDocumentos, & $contMsj = 0, $mensaje, $max_emails = null
			, $tiempoIni = null)
	{
		if ($max_emails and $contMsj >= $max_emails)
			return true;
		if (!$this->model->fecha_inicio)
		{
			$this->model->fecha_inicio = date('Y-m-d H:i:s');
			if (!$this->save($this->model))
				return false;
		}
		if (!$this->destinatarios($this->model->resultado))
			return false;
		$errorMsg = '';
		$correo = $model->contenido;
		$asunto = stripslashes($correo->descripcion);
		$mensaje = stripslashes($mensaje);
		$config = new Configuracion($this->da);
		$config->buscador('mensajes_enviados_dia');
		if (!$config->lee_configuracion())
		return false;
		$configVO = $config->getVO();
		foreach ($this->getVO()->get_destinatarios() as $emailVO)
		{
			$mensajeAux = str_replace('[email]', $emailVO->get_email_correo(), $mensaje);
			$mensajeAux = str_replace('[key]', $emailVO->get_referencia_correo(), $mensajeAux);
			$mail = new PHPMailer;
			$mail->CharSet 	= 'utf-8';
			$mail->IsHTML(true);
			$mail->Mailer 	= 'smtp';
			$mail->SetLanguage('es', $rootDocumentos . '/clases/PHPMailer/language/');
			if ($this->model->get_fichero_adjunto())
			if (!$mail->AddAttachment($this->model->get_fichero_adjunto()))
			{
				$this->msgError = 'No se ha podido adjuntar el fichero. ' . $mail->ErrorInfo;
				return false;
			}
			$mail->AddAddress($emailVO->get_email_correo());
			$mail->Subject 	= stripslashes($correoVO->get_descripcion());
			$mail->Body 	= stripslashes($mensajeAux);
			$mail->From = EMAIL_FROM;
			$mail->FromName = EMAIL_FROM_NAME;
			$mail->AddReplyTo(EMAIL_FROM, EMAIL_FROM_NAME);
			$res = $mail->Send();
			if (!$res)
			$errorMsg .= 'No ha sido posible el envío del mensaje a '
			. $emailVO->get_email_correo() . ' (' . $mail->ErrorInfo . ')\n';
			$this->model->set_resultado($emailVO->get_email_correo());
			if (!$envio->edicionEnvioCorreo($this->model, false))
			$errorMsg .= 'No ha sido posible actualizar el estado del mensaje a '
			. $emailVO->get_email_correo() . '\n';
			//guardar el incremento
			$contMsj++;
			$configVO->set_valor($contMsj);
			if (!$config->edicion($configVO))
			{
				echo 'Error: ' . $config->lee_msg_error();
				return false;
			}
			if ($max_emails and $contMsj >= $max_emails)
			return true;
			if ($tiempoIni and $tiempoIni < (mktime() - 290))
			return true;
		}
		$this->model->set_ok(($errorMsg) ? 0 : 1);
		$this->model->set_resultado($this->model->get_resultado() . $errorMsg);
		$this->model->set_fecha_fin(date('Y-m-d H:i:s'));
		if (!$envio->edicionEnvioCorreo($this->model, false))
		return false;
		return $contMsj;
	}
}