<?php
	class CorreoAction extends Action
	{
		protected $correoService;
		protected $listaCorreoService;
		protected $correos;
		protected $correo;
		protected $lista;
		
		public function email()
		{
			$this->usuarioService->check_usuario();
			$_GET['email'] = trim($_GET['email']);
			$correo = new Correo();
			$correo->email_correo = $_GET['email'];
			$this->correos = $this->correoService->find($correo, null, null, array('email_correo' => 1));
			if ($this->correos === false)
			{
				$this->error = $this->correoService->error();
				return 'error';
			}
			if (!$this->correos)
			{
				echo '<script>window.alert("El email con el texto "' . formato_html($_GET['email']) 
						. '" que desea buscar no se encuentra");</script>';
				echo '<script>window.history.back();</script>';
				exit();
			}
			if (count($this->correos) == 1)
			{
				$correo = $this->correos[0];
				header('Location:?action=ver-email&id=' . $correo->id_correo);
				exit();
			}
			return 'success';
		}
		
		public function ver_email()
		{
			$this->usuarioService->check_usuario();
			if (!isset($_GET['id']) or !$_GET['id'])
			{
				$this->error = 'Debe indicar el ID del email que desea buscar';
				return 'error';
			}
			$this->correo = $this->correoService->findById($_GET['id']);
			if ($this->correo === false)
			{
				$this->error = $this->correoService->error();
				return 'error';
			}
			if (!$this->correo)
			{
				$this->error = 'El email con ID ' . formato_html($_GET['id']) 
						. ' que desea buscar no se encuentra';
				return 'error';
			}
			return 'success';
		}
		
		public function baja()
		{
			$this->usuarioService->check_usuario();
			if (isset($_POST['id']) and $_POST['id'] > 0)
				$id_correo = $_POST['id'];
			elseif (isset($_GET['id']) and $_GET['id'] > 0)
				$id_correo = $_GET['id'];
			else
			{
				$this->error = 'Falta el dato id_correo a enviar por GET o POST';
				return 'error';
			}
			$this->correo = $this->correoService->findById($id_correo);
			if ($this->correo === false)
			{
				$this->error = $this->correoService->error();
				return 'error';
			}
			if (!$this->correo)
			{
				$this->error = 'No se encuentra el correo con ID: ' . $id_correo;
				return 'error';
			}
			if (isset($_POST['id_lista_correo']))
			{
				$_GET['id_lista_correo'] = $_POST['id_lista_correo'];
			}
			if (isset($_GET['id_lista_correo']) and $_GET['id_lista_correo'])
			{
				$this->lista = $this->listaCorreoService->findById($_GET['id_lista_correo']);
				if ($this->lista === false)
				{
					$this->error = $this->listaCorreoService->error();
					return 'error';
				}
				if (!$this->lista)
				{
					$this->error = 'Lista de correo no encontrada';
					return 'error';
				}
				$this->correo->listas = array($this->lista);
			}
			if (isset($_POST['borrar']))
			{
				if (!isset($this->lista))
				{
					//se borra el email de todas las listas
					$this->correo->baja = true;
					if (!$this->correoService->guardar($this->correo, true))
					{
						$this->error = $this->correoService->error();
						return 'error';
					}
					return 'listas';
				}
				else
				{
					//se quita de una lista
					if (!$this->correoService->destroy_relation($this->correo, 'listas'))
					{
						$this->error = $this->correoService->error();
						return 'error';
					}
					header('Location:' . URL_APP . '?action=edicion-lista&id=' . $this->lista->id_lista_correo);
					exit();
				}
			}
			return 'success';
		}
		
		public function alta()
		{
			$this->usuarioService->check_usuario();
			if (isset($_POST['id']) and $_POST['id'])
			{
				$_GET['id'] = $_POST['id'];
			}
			$lista = $this->listaCorreoService->findById($_GET['id']);
			if ($lista === false)
			{
				$this->error = $this->listaCorreoService->error();
				return 'fatal';
			}
			if (!$lista)
			{
				$this->error = 'Lista de correo no encontrada';
				return 'fatal';
			}
			$this->correo = new Correo($_POST);
			$this->correo->listas = array($lista);
			if (isset($_POST['guardar']))
			{
				if (!$this->correoService->guardar($this->correo))
				{
					$this->error = $this->correoService->error();
					return 'error';
				}
				else
				{
					if (!isset($_POST['opcion']) or $_POST['opcion'] != 'Guardar')
					{
						header('Location:' . URL_APP . '?action=listas-correo&id=' . $this->correo->id_correo);
						exit();
					}
					$this->correo->email_correo = '';
				}
			}
			return 'success';
		}
		
		public function edicion()
		{
			$this->usuarioService->check_usuario();
			if (isset($_POST['id']) and $_POST['id'] > 0)
				$id_correo = $_POST['id'];
			elseif (isset($_GET['id']) and $_GET['id'] > 0)
				$id_correo = $_GET['id'];
			else
			{
				$this->error = 'Falta el dato id_correo a enviar por GET o POST';
				return 'fatal';
			}
			if (isset($_GET['id_lista_correo']) and $_GET['id_lista_correo'] > 0)
				$_POST['id_lista_correo'] = $_GET['id_lista_correo'];
			$this->lista = new ListaCorreo($_POST);
			$this->correo = $this->correoService->findById($id_correo);
			if ($this->correo === false)
			{
				$this->error = $this->correoService->error();
				return 'fatal';
			}
			if (!$this->correo)
			{
				$this->error = 'Correo no encontrado';
				return 'fatal';
			}
			if (isset($_POST['guardar']))
			{
				if (!$this->correo->id_correo)
				{
					$this->error = 'Debe indicar el ID del correo';
					return false;
				}
				$this->correo->email_correo = trim($_POST['email_correo']);
				if (!$this->correoService->valida($this->correo))
				{
					$this->error = $this->correoService->error();
					return 'error';
				}
				if (!$this->correoService->save($this->correo, true))
				{
					$this->error = $this->correoService->error();
					return 'error';
				}
				if ($this->lista->id_lista_correo)
				{
					$url = URL_APP . '?action=edicion-lista&id=' . $this->lista->id_lista_correo;
					header('Location:' . $url);
					exit();
				}
				return 'listas';
			}
			return 'success';
		}
		
		public function baja_email()
		{
			if ($_GET['email'] and $_GET['key'])
			{
				$this->correo = new Correo();
				$this->correo->email_correo = trim($_GET['email']);
				$this->correo->referencia_correo = trim($_GET['key']);
				$this->correo = $this->correoService->find($this->correo);
				if ($this->correo === false)
				{
					$this->error = $this->correoService->error();
					return 'error';
				}
				if (!$this->correo)
				{
					return 'index';
				}
				$this->correo = $this->correo[0];
				if (!$this->correoService->baja($this->correo, true))
				{
					$this->error = $this->correoService->error();
					return 'error';
				}
				$mensaje = 'La cuenta de correo ' . $this->correo->email_correo 
						. ' ha sido dada de baja por el cliente.';
				mail(EMAIL_ADMIN, 'Baja del email ' . $this->correo->email_correo, $mensaje, 'From: ' 
						. EMAIL_FROM);
				return 'success';
			}
			return 'index';
		}
	}