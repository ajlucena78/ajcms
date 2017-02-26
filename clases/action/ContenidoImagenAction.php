<?php
	class ContenidoImagenAction extends Action
	{
		protected $menuService;
		protected $contenidoImagenService;
		protected $imagen;
		protected $menus;
		protected $titulo;
		protected $imagenes;
		
		public function show()
		{
			if (!isset($_GET['id']))
				return 'error';
			$this->imagen = $this->contenidoImagenService->findById($_GET['id']);
			if (!$this->imagen)
				return 'error';
			$this->menus = $this->menuService->menus_index();
			$this->titulo = $this->imagen->titulo;
			return 'success';
		}
		
		public function sitemap()
		{
			$this->imagenes = $this->contenidoImagenService->findAll();
			header('Content-Type:text/xml');
			return 'success';
		}
	}