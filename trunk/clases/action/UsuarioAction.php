<?php
	class UsuarioAction extends Action
	{
		protected $usuarioService;
		protected $permisoService;
		protected $usuario;
		protected $usuarios;
		protected $permisos;
		
		public function logout()
		{
			$_SESSION['desconectado'] = true;
			$_SESSION['usuario'] = null;
			$_SESSION['acceso_usuario_concedido'] = false;
			return 'success';
		}
		
		public function consulta()
		{
			$this->usuarioService->check_usuario();
			if (isset($_GET['login']))
				$_SESSION['criterios']['login_usuarios'] = $_GET['login'];
			elseif (!isset($_SESSION['login_usuarios']))
				$_SESSION['criterios']['login_usuarios'] = null;
			$usuario = new Usuario();
			if (isset($_SESSION['criterios']['login_usuarios']) and $_SESSION['criterios']['login_usuarios'])
				$usuario->login = $_SESSION['criterios']['login_usuarios'];
			$this->usuarios = $this->usuarioService->find($usuario, null, 'login', array('login' => 1));
			if ($this->usuarios === false)
			{
				$this->error = $this->usuarioService->error();
				return 'error';
			}
			return 'success';
		}
		
		public function alta()
		{
			$this->usuarioService->check_usuario();
			$this->usuario = new Usuario($_POST);
			$this->permisos = $this->permisoService->findAll('permiso');
			if ($this->permisos === false)
			{
				$this->error = $this->permisoService->error();;
				return 'fatal';
			}
			if (isset($_POST['guardar']))
			{
				if ($this->usuario->pwd != $_POST['pwd2'])
				{
					$this->error = 'Las claves no son iguales';
					return 'error';
				}
				if (isset($_POST['idPermiso']) and $_POST['idPermiso'])
				{
					$this->usuario->permiso = new Permiso();
					$this->usuario->permiso->idPermiso = $_POST['idPermiso'];
				}
				if (!$this->usuarioService->valida($this->usuario))
				{
					$this->error = $this->usuarioService->error();
					return 'error';
				}
				$this->usuario->pwd = md5($this->usuario->pwd);
				if (!$this->usuarioService->save($this->usuario))
				{
					$this->error = $this->usuarioService->error();
					return 'fatal';
				}
				return 'ok';
			}
			return 'success';
		}
		
		public function edicion()
		{
			$this->usuarioService->check_usuario();
			if (isset($_POST['id']) and $_POST['id'] > 0)
				$id = $_POST['id'] + 0;
			elseif (isset($_GET['id']) and $_GET['id'] > 0)
				$id = $_GET['id'] + 0;
			else
			{
				$this->error = 'Falta el dato id de enlace a enviar por GET o POST';
				return 'fatal';
			}
			$this->usuario = $this->usuarioService->findById($id);
			if ($this->usuario === false)
			{
				$this->error = $this->usuarioService->error();
				return 'fatal';
			}
			if (!$this->usuario)
			{
				$this->error = 'El usuario indicado ya no existe';
				return 'fatal';
			}
			$this->permisos = $this->permisoService->findAll('permiso');
			if ($this->permisos === false)
			{
				$this->error = $this->permisoService->error();;
				return 'fatal';
			}
			if (isset($_POST['guardar']))
			{
				if (isset($_POST['guardarClave']))
				{
					$this->usuario->pwd = $_POST['pwd'];
					if ($this->usuario->pwd != $_POST['pwd2'])
					{
						$this->error = 'Las claves no son iguales';
						return 'error';
					}
					$this->usuario->pwd = $_POST['pwd'];
				}
				else
				{
					$this->usuario->login = trim($_POST['login']);
					$this->usuario->permiso = new Permiso();
					if (isset($_POST['idPermiso']) and $_POST['idPermiso'])
					{
						$this->usuario->permiso->idPermiso = $_POST['idPermiso'];
					}
				}
				if (!$this->usuarioService->valida($this->usuario))
				{
					$this->error = $this->usuarioService->error();
					return 'error';
				}
				if (isset($_POST['guardarClave']))
				{
					$this->usuario->pwd = md5($this->usuario->pwd);
				}
				if (!$this->usuarioService->save($this->usuario, true))
				{
					$this->error = $this->usuarioService->error();
					return 'error';
				}
				return 'ok';
			}
			return 'success';
		}
		
		public function baja()
		{
			$this->usuarioService->check_usuario();
			if (isset($_POST['id']) and $_POST['id'] > 0)
				$id = $_POST['id'];
			elseif (isset($_GET['id']) and $_GET['id'] > 0)
				$id = $_GET['id'];
			else
			{
				$this->error = 'Falta el dato idUsuario a enviar por GET o POST';
				return 'error';
			}
			$this->usuario = $this->usuarioService->findById($id);
			if ($this->usuario === false)
			{
				$this->error = $this->usuarioService->error();
				return 'error';
			}
			if (!$this->usuario)
			{
				$this->error = 'El usuario indicado para dar de baja ya no existe';
				return 'fatal';
			}
			if (isset($_POST['borrar']))
			{
				if (!$this->usuarioService->removeById($id))
				{
					$this->error = $this->usuarioService->error();
					return 'error';
				}
				return 'ok';
			}
			return 'success';
		}
	}