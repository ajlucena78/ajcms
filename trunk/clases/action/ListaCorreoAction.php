<?php
	class ListaCorreoAction extends Action
	{
		protected $listaCorreoService;
		protected $listas;
		protected $lista;
		
		public function consulta()
		{
			$this->usuarioService->check_usuario();
			if (isset($_GET['nombre_lista_correo']))
				$_SESSION['nombre_lista_correo'] = trim($_GET['nombre_lista_correo']);
			else
				$_SESSION['nombre_lista_correo'] = null;
			$lista = new ListaCorreo();
			$lista->nombre_lista_correo = $_SESSION['nombre_lista_correo'];
			$this->listas = $this->listaCorreoService->find($lista, null, 'nombre_lista_correo');
			if ($this->listas === false)
			{
				$this->error = $this->listaCorreoService->error();
				return 'error';
			}
			foreach ($this->listas as $lista)
			{
				$correos = $this->listaCorreoService->num_correos($lista);
				if ($correos === false)
				{
					$this->error = $this->listaCorreoService->error();
					return 'error';
				}
				$lista->correos = $correos;
			}
			return 'success';
		}
		
		public function alta()
		{
			$this->usuarioService->check_usuario();
			$this->lista = new ListaCorreo($_POST);
			if (isset($_POST['guardar']))
			{
				if (!$this->lista->nombre_lista_correo)
				{
					$this->error = 'El nombre de la lista es obligatorio para crearla';
					return 'error';
				}
				$this->lista->usuario = $_SESSION['usuario'];
				if (!$this->listaCorreoService->save($this->lista))
				{
					$this->error = $this->listaCorreoService->error();
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
				$idListaCorreo = $_POST['id'];
			elseif (isset($_GET['id']) and $_GET['id'] > 0)
				$idListaCorreo = $_GET['id'];
			else
			{
				$this->error = 'Falta el dato id_lista_correo a enviar por GET o POST';
				return 'false';
			}
			if (isset($_POST['guardar']))
			{
				$this->lista = new ListaCorreo($_POST);
				$this->lista->id_lista_correo = $idListaCorreo;
				if (!$this->listaCorreoService->save($this->lista, true))
				{
					$this->error = $this->listaCorreoService->error();
					return 'error';
				}
				return 'ok';
			}
			$this->lista = $this->listaCorreoService->findById($idListaCorreo);
			if ($this->lista === false)
			{
				$this->error = $this->listaCorreoService->error();
					return 'fatal';
			}
			if (!$this->lista)
			{
				$this->error = 'No se encuentra la lista de correo indicada';
				return 'fatal';
			}
			return 'success';
		}
		
		public function baja()
		{
			$this->usuarioService->check_usuario();
			if (isset($_POST['id']) and $_POST['id'] > 0)
				$id_lista_correo = $_POST['id'];
			elseif (isset($_GET['id']) and $_GET['id'] > 0)
				$id_lista_correo = $_GET['id'];
			else
			{
				$this->error = 'Falta el dato id_lista_correo a enviar por GET o POST';
				return 'error';
			}
			$this->lista = $this->listaCorreoService->findById($id_lista_correo);
			if ($this->lista === false)
			{
				$this->error = $this->listaCorreoService->error();
				return 'error';
			}
			if (!$this->lista)
			{
				$this->error = 'No se encuentra la lista de correo indicada para dar de baja';
				return 'error';
			}
			if (isset($_POST['borrar']))
			{
				if (!$this->listaCorreoService->removeById($id_lista_correo))
				{
					$this->error = $this->listaCorreoService->error();
					return 'error';
				}
				return 'ok';
			}
			return 'success';
		}
	}