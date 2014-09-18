<?php
	class UsuarioService extends Service
	{
		public function check_usuario()
		{
			if (!isset($_SERVER['PHP_AUTH_USER']) or !isset($_SERVER['PHP_AUTH_PW']))
			{
				$this->datosInvalidos();
			}
			if (!$_SERVER['PHP_AUTH_USER'] or !$_SERVER['PHP_AUTH_PW'])
			{
				$this->datosInvalidos();
			}
			if (isset($_SESSION['desconectado']) and $_SESSION['desconectado'])
			{
				$_SESSION['desconectado'] = null;
				$this->datosInvalidos();
			}
			$usuario = new Usuario();
			$usuario->login = $_SERVER['PHP_AUTH_USER'];
			$usuario->pwd = md5($_SERVER['PHP_AUTH_PW']);
			$usuario = $this->find($usuario);
			if (!$usuario)
			{
				$this->datosInvalidos();
			}
			if (!isset($_SESSION['acceso_usuario_concedido']) or !$_SESSION['acceso_usuario_concedido'])
			{
				$usuario = $usuario[0];
				$usuario->fechaAcceso = date('Y-m-d H:i:s');
				$usuario->ip = $_SERVER['REMOTE_ADDR'];
				$this->save($usuario, true);
				$_SESSION['usuario'] = $usuario;
				$_SESSION['acceso_usuario_concedido'] = true;
			}
			return true;
		}
		
		private function datosInvalidos()
		{
			header('WWW-Authenticate: Basic realm="Panel de administración"');
			header('HTTP /1.1 401 Unauthorized');
			echo '<h1>Acceso Denegado</h1>IP ' . $_SERVER['REMOTE_ADDR'] . ' registrada.';
			exit();
		}
		
		function valida(Usuario $usuario)
		{
			if (!$usuario->permiso or !$usuario->permiso->idPermiso)
			{
				$this->error = 'Debe indicar el permiso del usuario';
				return false;
			}
			if (!$usuario->login)
			{
				$this->error = 'Debe indicar el nombre de usuario';
				return false;
			}
			if (strpos($usuario->login, ' ') !== false or strpos($usuario->login, '\'') !== false)
			{
				$this->error = 'El nombre de usuario no puede contener espacios ni comillas';
				return false;
			}
			if (strlen($usuario->login) < 4)
			{
				$this->error = 'El nombre de usuario debe tener como mínimo 4 caracteres';
				return false;
			}
			if (!$usuario->pwd)
			{
				$this->error = 'Debe indicar la clave del usuario';
				return false;
			}
			if (strpos($usuario->pwd, ' ') !== false or strpos($usuario->pwd, '\'') !== false)
			{
				$this->error = 'La clave no puede contener espacios ni comillas';
				return false;
			}
			if (strlen($usuario->pwd) < 6)
			{
				$this->error = 'La clave debe tener como mínimo 6 caracteres';
				return false;
			}
			return true;
		}
	}