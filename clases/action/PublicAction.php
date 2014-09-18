<?php
	class PublicAction extends Action
	{
		protected $noticiaService;
		protected $contenidoService;
		protected $menuService;
		protected $contenidos;
		protected $noticias;
		protected $menus;
		
		public function sitemap()
		{
			$contenidos = $this->contenidoService->findAll();
			$this->contenidos = array();
			foreach ($contenidos as $contenido)
			{
				if ($contenido->tipo != 3)
					$this->contenidos[] = $contenido;
			}
			header('Content-Type:text/xml');
			return 'success';
		}
		
		public function contacto()
		{
			$this->menus = $this->menuService->menus_index();
			return 'success';
		}
		
		public function envio_contacto()
		{
			$this->menus = $this->menuService->menus_index();
			if (!trim($_POST['nombre']) or !trim($_POST['telefono']) or !trim($_POST['comentario']))
			{
				$this->error = 'El nombre, el teléfono y el mensaje son obligatorios';
				return 'error';
			}
			$mensaje = 'Nombre: ' . $_POST['nombre'] . "\n";
			$mensaje .= 'Teléfono: ' . $_POST['telefono'] . "\n";
			$mensaje .= 'Email: ' . $_POST['email'] . "\n";
			$mensaje .= "\n" . $_POST['comentario'] . "\n";
			if (!@mail('publicar@publicar.es', 'Consulta de ' . $_POST['nombre'], $mensaje
					, 'From: Formulario de contacto UBIPOL<info@publicar.es>'))
			{
				$this->error = 'El envío no se ha podido realizar en este momento, intente más tarde por favor';
				return 'fatal';
			}
			return 'success';
		}
	}