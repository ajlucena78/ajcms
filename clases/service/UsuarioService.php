<?php
	class UsuarioService extends Service
	{	
		public function check_redirect()
		{
			if (isset($_SERVER['PHP_AUTH_USER']))
			{
				$_POST['PHP_AUTH_USER'] = $_SERVER['PHP_AUTH_USER'];
				$_POST['PHP_AUTH_PW'] = $_SERVER['PHP_AUTH_PW'];
			}
			if (isset($_SESSION['acceso_usuario_concedido']) and $_SESSION['acceso_usuario_concedido'])
			{
				return true;
			}
			if (isset($_SERVER['REDIRECT_URL']) and $_SERVER['REDIRECT_URL'])
			{
				$_SESSION['HTTP_REFERER'] = $_SERVER['REDIRECT_URL'];
			}
			if ($_SESSION['HTTP_REFERER'] == (URL_APP . 'inicio-sesion-adm') or 
					$_SESSION['HTTP_REFERER'] == (URL_APP . 'inicio-sesion'))
			{
				if (isset($_SERVER['HTTP_REFERER']) and $_SERVER['HTTP_REFERER'] 
						and $_SERVER['HTTP_REFERER'] != (HOST_APP . URL_APP . 'inicio-sesion-adm') 
						and $_SERVER['HTTP_REFERER'] != (HOST_APP . URL_APP . 'inicio-sesion'))
				{
					$_SESSION['HTTP_REFERER'] = $_SERVER['HTTP_REFERER'];
				}
				elseif ($_SESSION['HTTP_REFERER'] == (URL_APP . 'inicio-sesion-adm'))
				{
					$_SESSION['HTTP_REFERER'] = URL_APP . 'adm';
				}
				elseif ($_SESSION['HTTP_REFERER'] == (URL_APP . 'inicio-sesion'))
				{
					$_SESSION['HTTP_REFERER'] = URL_APP;
				}
			}
		}
		
		public function check_usuario($login = false)
		{
			if (!$login)
			{
				$this->check_redirect();
			}
			if (!isset($_SESSION['PHP_AUTH_USER']) or !$_SESSION['PHP_AUTH_USER'] or !$_SESSION['PHP_AUTH_PW'])
			{
				if ($login)
					return false;
				else
				{
					header('Location:' . URL_APP . 'inicio-sesion-adm');
					exit();
				}
			}
			$usuario = new Usuario();
			$usuario->login = $_SESSION['PHP_AUTH_USER'];
			$usuario->pwd = $_SESSION['PHP_AUTH_PW'];
			$usuario = $this->find($usuario);
			if (!$usuario)
			{
				$this->error = 'Los datos de usuario aportados no son correctos';
				return false;
			}
			$usuario = $usuario[0];
			if ($usuario->permiso->idPermiso == PERMISO_SOCIO)
			{
				return false;
			}
			if (!isset($_SESSION['acceso_usuario_concedido']) or !$_SESSION['acceso_usuario_concedido'])
			{
				$usuario->fechaAcceso = date('Y-m-d H:i:s');
				$usuario->ip = $_SERVER['REMOTE_ADDR'];
				$this->save($usuario, true);
				$_SESSION['usuario'] = $usuario;
				$_SESSION['acceso_usuario_concedido'] = true;
			}
			return true;
		}
		
		public function check_socio($login = false)
		{
			if (!$login)
			{
				$this->check_redirect();
			}
			if (!isset($_SESSION['PHP_AUTH_USER']) or !$_SESSION['PHP_AUTH_USER'] or !$_SESSION['PHP_AUTH_PW'])
			{
				if ($login)
					return false;
				else
				{
					header('Location:' . URL_APP . 'inicio-sesion');
					exit();
				}
			}
			$usuario = new Usuario();
			$usuario->login = $_SESSION['PHP_AUTH_USER'];
			$usuario->pwd = $_SESSION['PHP_AUTH_PW'];
			$usuario = $this->find($usuario);
			if (!$usuario)
			{
				$this->error = 'Los datos de usuario aportados no son correctos';
				return false;
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