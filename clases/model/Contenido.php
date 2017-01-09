<?php
	class Contenido extends Model
	{
		protected $idContenido;
		protected $referencia;
		protected $descripcion;
		protected $tipo;
		protected $permalink;
		protected $imagenes;
		protected $videos;
		protected $menus;
		protected $usuario;
		protected $privado;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['idContenido'] = 'auto';
			$this->fk['imagenes'] = new FK('ContenidoImagen', OneToMany, 'idContenido', null, 'orden');
			$this->fk['videos'] = new FK('ContenidoVideo', OneToMany, 'idContenido', null, 'orden');
			$this->fk['menus'] = new FK('Menu', OneToMany, 'idContenido');
			$this->fk['usuario'] = new FK('Usuario', ManyToOne, 'idUsuario');
		}
		
		public function enlace()
		{
			if ($this->permalink)
				$url = $this->permalink;
			else
				$url = '?referencia=' . $this->referencia;
			return $url;
		}
		
		public function ruta($menu = null)
		{
			if (!$this->idContenido)
				return false;
			$ruta = $this->descripcion;
			//localizamos el menú al que pertenece el contenido
			if ($menu)
			{
				if (!$menu->idMenu)
					return false;
			}
			elseif ($this->menus())
			{
				$menu = $this->menus();
				$menu = $menu[0];
			}
			if ($menu)
			{
				//se cargan todos los menús superiores hasta el raíz
				while (true)
				{
					if (!$menu or !$menu->padre)
						break;
					$enlace = $menu->enlace();
					$rutaAux = '';
					if ($enlace)
						$rutaAux .= '<a href="' . $enlace . '">';
					$rutaAux .= $menu->titulo;
					if ($enlace)
						$rutaAux .= '</a>';
					$ruta = $rutaAux . ' &gt; ' . $ruta;
					$menu = $menu->padre;
				}
			}
			return $ruta;
		}
	}