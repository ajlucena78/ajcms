<?php
	class Menu extends Model
	{
		protected $idMenu;
		protected $titulo;
		protected $padre;
		protected $contenido;
		protected $hijos;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['idMenu'] = 'auto';
			$this->fk['padre'] = new FK('Menu', ManyToOne, 'idPadre', 'idMenu');
			$this->fk['contenido'] = new FK('Contenido', ManyToOne, 'idContenido');
			$this->fk['hijos'] = new FK('Menu', OneToMany, 'idPadre', null, 'titulo');
		}
		
		public function get_enlace()
		{
			$enlace = null;
			if (!$menu->contenido and count($menu->hijos) > 0)
			{
				if ($menu->padre)
				{
					if (($enlace = $this->menuService->getEnlaceContenido($menu->padre)) === false)
						return 'error';
					if ($enlace != '')
						$enlace = trim($enlace);
					else
						$enlace = '#';
				}
			}
			if (!$enlace)
			{
				if (($enlace = $this->menuService->getEnlaceContenido($menu)) === false)
					return 'error';
				if ($enlace != '')
					$enlace = trim($enlace);
				else
					$enlace = '#';
			}
			$menu->enlace = $enlace;
		}
		
		private function getEnlaceContenido(Menu $menu)
		{	
			if (!$menu->contenido)
				$enlace = '';
			else
			{
				if ($menu->contenido->permalink)
					$enlace = $_SESSION['config']->getPathApp() . '/' . $menu->contenido->permalink;
				else
					$enlace = $_SESSION['config']->getPathApp() . '/?referencia=' . $menu->contenido->referencia;
				if ($menu->padre)
					 $enlace .= '&amp;idMenu=' . $menu->padre->idMenu;
			}
			return($enlace);
		}
	}