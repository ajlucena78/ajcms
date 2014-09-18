<?php
	class ImagenAction extends Action
	{
		protected $imagenService;
		protected $menuService;
		protected $imagen;
		protected $menus;
		protected $titulo;
		
		public function show()
		{
			if (!isset($_GET['id']))
				return 'error';
			$this->imagen = $this->imagenService->findById($_GET['id']);
			if (!$this->imagen)
				return 'error';
			$this->menus = $this->menuService->menus_index();
			$this->titulo = $this->imagen->titulo;
			return 'success';
		}
	}