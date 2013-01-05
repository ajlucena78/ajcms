<?php
	class ContenidoTextoAction extends Action
	{
		protected $contenidoTextoService;
		protected $contenidos;
		
		public function index()
		{
			if (isset($_POST['descripcion']))
				$_SESSION['criterios']['descripcion_contenidos'] = $_POST['descripcion'];
			else
				$_SESSION['criterios']['descripcion_contenidos'] = null;
			$contenido = new ContenidoTexto();
			$contenido->texto = $_SESSION['criterios']['descripcion_contenidos'];
			$contenidos = $this->contenidoTextoService->find($contenido);
			if ($contenidos === false)
				return 'error';
			return 'success';
		}
	}