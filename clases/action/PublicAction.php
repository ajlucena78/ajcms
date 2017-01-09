<?php
	class PublicAction extends Action
	{
		protected $menuService;
		protected $menus;
		
		public function contacto()
		{
			$this->menus = $this->menuService->menus_index();
			$this->titulo = 'Formulario de contacto';
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
			if (!@mail(EMAIL_FROM, 'Consulta de ' . $_POST['nombre'], $mensaje
					, 'From: Formulario de contacto<' . EMAIL_FROM . '>'))
			{
				$this->error = 'El envío no se ha podido realizar en este momento, intente más tarde por favor';
				return 'fatal';
			}
			$this->titulo = 'Formulario de contacto';
			return 'success';
		}
		
		public function mapa()
		{
			$this->menus = $this->menuService->menus_index();
			$this->titulo = 'Mapa';
			return 'success';
		}
		
		public function version_movil()
		{
			$_SESSION['navegador'] = 'movil';
			$_SESSION['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
			return 'success';
		}
	}