<?php
	require_once 'ContenidoAction.php';
	class ContenidoEnlaceAction extends ContenidoAction
	{
		protected $contenidoEnlaceService;
		protected $mensaje;
		protected $enlaces;
		protected $enlace;
		protected $imagen;
		protected $video;
		protected $ancla;
		
		public function consulta()
		{
			$this->usuarioService->check_usuario();
			$this->enlaces = $this->contenidoEnlaceService->findAll('descripcion');
			if ($this->enlaces === false)
			{
				$this->error = $this->contenidoEnlaceService->error();
				return 'error';
			}
			return 'success';
		}
		
		public function alta()
		{
			$this->usuarioService->check_usuario();
			$this->enlace = new ContenidoEnlace($_POST);
			if (isset($_POST['guardar']))
			{
				$this->enlace->tipo = CONTENIDO_ENLACE;
				$this->enlace->usuario = $_SESSION['usuario'];
				if (!$this->contenidoEnlaceService->valida($this->enlace))
				{
					$this->error = $this->contenidoEnlaceService->error();
					return 'error';
				}
				if (!$this->contenidoEnlaceService->save($this->enlace))
				{
					$this->error = $this->contenidoEnlaceService->error();
					return 'error';
				}
				else
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
			$this->enlace = $this->contenidoEnlaceService->findById($id);
			if (!$this->enlace)
			{
				$this->error = 'El enlace indicado ya no existe';
				return 'fatal';
			}
			if (isset($_POST['guardar']))
			{
				$this->enlace->descripcion = $_POST['descripcion'];
				$this->enlace->permalink = $_POST['permalink'];
				$this->enlace->url = $_POST['url'];
				if (!$this->contenidoEnlaceService->valida($this->enlace))
				{
					$this->error = $this->contenidoEnlaceService->error();
					return 'error';
				}
				if (!$this->contenidoEnlaceService->save($this->enlace, true))
				{
					$this->error = $this->contenidoEnlaceService->error();
					return 'error';
				}
				return 'ok';
			}
			return 'success';
		}
	}