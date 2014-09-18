<?php
	class Menu extends Model
	{
		protected $idMenu;
		protected $titulo;
		protected $padre;
		protected $contenido;
		protected $hijos;
		protected $orden;
		protected $usuario;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['idMenu'] = 'auto';
			$this->fk['padre'] = new FK('Menu', ManyToOne, 'idPadre', 'idMenu');
			$this->fk['contenido'] = new FK('Contenido', ManyToOne, 'idContenido');
			$this->fk['hijos'] = new FK('Menu', OneToMany, 'idPadre', null, 'orden');
			$this->fk['usuario'] = new FK('Usuario', ManyToOne, 'idUsuario');
		}
		
		public function enlace()
		{
			$enlace = null;
			if (!$this->contenido() and count($this->hijos()) > 0)
			{
				if ($this->padre())
				{
					if (($enlace = $this->enlace_contenido($this->hijos(0))) === false)
						return 'error';
				}
				else
					$enlace = '#';
			}
			if (!$enlace)
			{
				if (($enlace = $this->enlace_contenido($this)) === false)
					return 'error';
			}
			return $enlace;
		}
		
		public function enlace_contenido(Menu $menu)
		{
			if (!$menu->contenido())
				$enlace = '';
			else
			{
				if ($menu->contenido->permalink)
				{
					$enlace = URL_APP . $menu->contenido->permalink;
				}
				else
				{
					$enlace = URL_APP . '?referencia=' . $menu->contenido->referencia;
				}
				if ($menu->padre())
				{
					 $enlace .= '&amp;idMenu=' . $menu->padre->idMenu;
				}
			}
			if ($enlace != '')
				$enlace = trim($enlace);
			else
				$enlace = '#';
			return($enlace);
		}
	}