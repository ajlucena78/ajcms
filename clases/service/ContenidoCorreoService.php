<?php
	require_once APP_ROOT . 'clases/service/ContenidoService.php';
	class ContenidoCorreoService extends ContenidoService
	{
		public function valida(ContenidoCorreo $model)
		{
			if (!$model->texto)
			{
				$this->error = 'Es necesario el texto del mensaje';
				return false;
			}
			return true;
		}
		
		public function carga_mensaje(ContenidoCorreo $correo, $pathRelativo = null, $rootDocumentos = null)
		{
			if (!$pathRelativo)
				$pathRelativo = HOST_APP . URL_APP;
			if (!$rootDocumentos)
				$rootDocumentos = APP_ROOT;
			$contenido = new ContenidoCorreo();
			$contenido->referencia = 'emacab';
			if (!$contenido = $this->find($contenido))
				return false;
			$contenido = $contenido[0];
			$mensaje = $contenido->texto_procesado($pathRelativo, $rootDocumentos);
			$mensaje .= $correo->texto_procesado($pathRelativo, $rootDocumentos);
			$contenido = new ContenidoCorreo();
			$contenido->referencia = 'emapie';
			if (!$contenido = $this->find($contenido))
				return false;
			$contenido = $contenido[0];
			$mensaje .= $contenido->texto_procesado($pathRelativo, $rootDocumentos);
			$cabMensaje = '<!DOCTYPE html PUBLIC \'-//W3C//DTD XHTML 1.0 Transitional//EN\' ';
			$cabMensaje .= '\'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\'>';
			$cabMensaje .= '<html xmlns=\'http://www.w3.org/1999/xhtml\' lang=\'es\' xml:lang=\'es\'>';
			$cabMensaje .= '	<head>';
			$cabMensaje .= '		<meta http-equiv=\'Content-Type\'';
			$cabMensaje .= 'content=\'text/html; charset=utf-8\' />';
			$cabMensaje .= '		<title>' . formato_html($correo->descripcion) . '</title>';
			$cabMensaje .= '	</head>';
			$cabMensaje .= '	<body>';
			$cabMensaje .= '	<p style=\'text-align: center;\'>';
			$cabMensaje .= '		Si desea <strong>darse de baja</strong> de estos mensajes, haga clic';
			$cabMensaje .= ' <a href=\'' . $pathRelativo . '?action=baja-email&amp;referencia=' 
					. $correo->referencia . '&amp;email=[email]&amp;key=[key]\'' 
					. ' target=\'_blank\'>en este enlace</a>.';
			$cabMensaje .= '	</p>';
			$cabMensaje .= '	<p style=\'text-align: center;\'>';
			$cabMensaje .= '		Si no ve el mensaje correctamente, por favor haga clic';
			$cabMensaje .= ' <a href=\'' . $pathRelativo . '?action=index&amp;referencia=' . $correo->referencia 
					. '&amp;email=[email]&amp;key=[key]\'' . ' target=\'_blank\'>aqu&iacute;</a>.';
			$cabMensaje .= '	</p>';
			$pieMensaje = '	</body>';
			$pieMensaje .= '</html>';
			$mensaje = $cabMensaje . $mensaje . $pieMensaje;
			return $mensaje;
		}
	}