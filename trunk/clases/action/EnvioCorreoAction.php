<?php
	require_once APP_ROOT . 'clases/util/Fecha.php';
	class EnvioCorreoAction extends Action
	{
		protected $envioCorreoService;
		protected $contenidoCorreoService;
		protected $listaCorreoService;
		protected $envios;
		protected $envio;
		protected $correos;
		protected $listas;
		protected $email_test;
		protected $mensaje;
		
		public function index()
		{
			$this->usuarioService->check_usuario();
			if (isset($_GET['descripcion']))
				$_SESSION['criterios']['descripcion_envios'] = $_GET['descripcion'];
			elseif (!isset($_SESSION['criterios']['descripcion_envios']))
				$_SESSION['criterios']['descripcion_envios'] = null;
			$envio = new EnvioCorreo();
			require_once APP_ROOT . 'clases/model/Contenido.php';
			$envio->contenido = new Contenido();
			$envio->contenido->descripcion = '%' . $_SESSION['criterios']['descripcion_envios'] . '%';
			$this->envios = $this->envioCorreoService->find($envio, null, 'id_envio_correo desc', 'descripcion');
			if ($this->envios === false)
			{
				$this->error = $this->envioCorreoService->error();
				return 'error';
			}
			return 'success';
		}
		
		public function programa()
		{
			$this->usuarioService->check_usuario();
			if (isset($_POST['id']) and $_POST['id'] > 0)
				$id = $_POST['id'] + 0;
			elseif (isset($_GET['id']) and $_GET['id'] > 0)
				$id = $_GET['id'] + 0;
			if (isset($id) and $id)
			{
				$update = true;
			}
			else
			{
				$update = false;
			}
			if (isset($_POST['guardar']))
			{
				$this->envio = new EnvioCorreo($_POST);
				if (isset($id))
					$this->envio->id_envio_correo = $id;
				if (isset($_POST['listas']))
				{
					$listas = array();
					foreach ($_POST['listas'] as $idLista)
					{
						$lista = new ListaCorreo();
						$lista->id_lista_correo = $idLista;
						$listas[] = $lista;
					}
					$this->envio->listas = $listas;
				}
			}
			else
			{
				if (isset($id))
				{
					$this->envio = $this->envioCorreoService->findById($id);
					if ($this->envio === false)
					{
						$this->error = $this->contenidoCorreoService;
						return 'fatal';
					}
					if (!$this->envio)
					{
						$this->error = 'El envío a editar no existe';
						return 'fatal';
					}
					$this->envio->fecha_programa_envio = Fecha::convierte_BBDD_a_spa($this->envio->fecha_programa_envio, true);
				}
				else
				{
					$this->envio = new EnvioCorreo();
				}
			}
			$this->listas = $this->listaCorreoService->findAll('nombre_lista_correo');
			$correos = $this->contenidoCorreoService->findAll('descripcion');
			$this->correos = array();
			foreach ($correos as $correo)
			{
				if ($correo->referencia != 'emacab' and $correo->referencia != 'emapie')
					$this->correos[] = $correo;
			}
			if (isset($_POST['guardar']))
			{
				if ($_POST['id_contenido'])
				{
					$this->envio->contenido = $this->contenidoCorreoService->findById($_POST['id_contenido']);
					if ($this->envio->contenido === false)
					{
						$this->error = $this->contenidoCorreoService;
						return 'fatal';
					}
					if (!$this->envio->contenido)
					{
						$this->error = 'No se encuntra el mensaje seleccionado';
						return 'error';
					}
				}
				else
				{
					$this->error = 'Es necesario el mensaje que va a ser enviado';
					return 'error';
				}
				if ($_POST['test'])
				{
					$this->email_test = $_POST['email_test'];
					$mensaje = $this->contenidoCorreoService->carga_mensaje($this->envio->contenido);
					if (!$this->envioCorreoService->envio_correo_prueba($this->envio, $mensaje
							, $this->email_test))
					{
						$this->error = $this->envioCorreoService->error();
						return 'error';
					}
					$this->mensaje = 'Mensaje de prueba a la cuenta ' . $this->email_test . ' enviado';
				}
				else
				{
					if ($this->envio->fecha_programa_envio)
						$this->envio->fecha_programa_envio = Fecha::convierte_SQL($this->envio->fecha_programa_envio);
					$this->envio->usuario = $_SESSION['usuario'];
					if (!$this->envioCorreoService->guarda($this->envio, $update))
					{
						$this->error = $this->envioCorreoService->error();
						return 'error';
					}
					return 'envios';
				}
			}
			return 'success';
		}
		
		public function baja()
		{
			$this->usuarioService->check_usuario();
			if (isset($_POST['id']))
				$_GET['id'] = $_POST['id'];
			if (!isset($_GET['id']) or !$_GET['id'])
			{
				$this->error = 'No se ha indicado el ID para borrar el envío';
				return 'error';
			}
			$this->envio = $this->envioCorreoService->findById($_GET['id']);
			if ($this->envio === false)
			{
				$this->error = $this->envioCorreoService->error();
				return 'error';
			}
			if (!$this->envio)
			{
				$this->error = 'El envío ha eliminar no existe';
				return 'error';
			}
			if (isset($_POST['borrar']))
			{
				if (!$this->envioCorreoService->removeById($this->envio->id_envio_correo))
				{
					$this->error = $this->envioCorreoService->error();
					return 'error';
				}
				return 'ok';
			}
			return 'success';
		}
	}