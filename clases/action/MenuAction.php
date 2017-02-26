<?php
	class MenuAction extends Action
	{
		protected $menuService;
		protected $contenidoService;
		protected $contenidoTextoService;
		protected $menu;
		protected $contenidos;
		protected $menus;
		protected $numHijosMenu;
		protected $idPadre;
		protected $menuPadre;
		
		public function consulta()
		{
			if (!$this->usuarioService->check_usuario())
			{
				return 'inicio-sesion-adm';
			}
			if (!isset($_GET['idPadre']) and !isset($_POST['idPadre']))
			{
				$this->idPadre = 0;
			}
			else
			{
				if (isset($_POST['idPadre']))
				{
					$this->idPadre = $_POST['idPadre'];
				}
				else
				{
					$this->idPadre = $_GET['idPadre'];
				}
			}
			if ($this->idPadre)
			{
				$this->menuPadre = $this->menuService->findById($this->idPadre);
				if ($this->menuPadre === false)
				{
					$this->error = $this->menuService->error();
					return 'fatal';
				}
				if (!$this->menuPadre)
				{
					$this->error = 'No se encuentra el menú superior para el ID: ' . $this->idPadre;
					return 'fatal';
				}
			}
			else
			{
				$this->menuPadre = new Menu();
			}
			$this->menu = new Menu();
			//alta
			if (isset($_POST['alta']))
			{
				$this->menu = new Menu($_POST);
				if (isset($_POST['idPadre']) and $_POST['idPadre'])
				{
					$this->menu->padre = new Menu();
					$this->menu->padre->idMenu = $_POST['idPadre'];
				}
				$this->menu->usuario = $_SESSION['usuario'];
				$this->menu->orden = $this->menuService->max_orden($this->menu);
				if ($this->idPadre)
				{
					$this->menu->padre = new Menu();
					$this->menu->padre->idMenu = $this->idPadre;
				}
				if ($_POST['idContenido'])
				{
					$this->menu->contenido = new Contenido();
					$this->menu->contenido->idContenido = $_POST['idContenido'];
				}
				if (!$this->menuService->valida($this->menu))
				{
					$this->error = $this->menuService->error();
					return 'error';
				}
				$id = $this->menuService->save($this->menu);
				if (!$id)
				{
					$this->error = $this->menuService->error();
					return 'fatal';
				}
				$this->menu = new Menu();
			}
			//edición
			if (isset($_POST['guardar']) and $_POST['guardar'])
			{
				$this->menu = $this->menuService->findById($_POST['idMenu']);
				if (!$this->menu)
				{
					$this->error = 'El menú a editar no se encuentra';
					return 'error';
				}
				$this->menu->titulo = trim($_POST['titulo']);
				$this->menu->contenido = new Contenido();
				if ($_POST['idContenido'])
				{
					$this->menu->contenido->idContenido = $_POST['idContenido'];
				}
				if (!$this->menuService->valida($this->menu))
				{
					$this->error = $this->menuService->error();
					return 'error';
				}
				if (!$this->menuService->save($this->menu, true))
				{
					$this->error = $this->menuService->error();
					return 'error';
				}
				$this->menu = new Menu();
			}
			//borrar
			if (isset($_POST['borrar']) and $_POST['borrar'] == 1)
			{
				if (!isset($_POST['idMenu']) or !($_POST['idMenu'] += 0))
				{
					$this->error = 'No se ha reportado el ID del menú a borrar';
					return 'error';
				}
				$this->menu = $this->menuService->findById($_POST['idMenu']);
				if (!$this->menu)
				{
					$this->error = 'El menú a editar no se encuentra';
					return 'error';
				}
				if (!$this->menuService->remove($this->menu))
				{
					$this->error = $this->menuService->error();
					return 'fatal';
				}
				$this->menu = new Menu();
			}
			//subir
			if (isset($_POST['subir']) and $_POST['subir'] == 1)
			{
				$this->menu = new Menu($_POST);
				if (!$this->menuService->subir($this->menu))
				{
					$this->error = $this->menuService->error();
				}
				$this->menu = new Menu();
			}
			//bajar
			if (isset($_POST['bajar']) and $_POST['bajar'] == 1)
			{
				$this->menu = new Menu($_POST);
				if (!$this->menuService->bajar($this->menu))
				{
					$this->error = $this->menuService->error();
				}
				$this->menu = new Menu();
			}
			$this->contenidos = $this->contenidoService->findAll('descripcion');
			if ($this->contenidos === false)
			{
				$visor->error = $this->contenidoService->error();
				return 'fatal';
			}
			$this->numHijosMenu = array();
			if (!$this->idPadre)
			{
				$menuAux = new Menu();
				$menuAux->padre = new Menu();
				$menuAux->padre->idMenu = 'null';
				$this->menus = $this->menuService->find($menuAux, null, 'orden');
			}
			else
			{
				$this->menus = $this->menuPadre->hijos();
			}
			foreach ($this->menus as $menu)
			{
				if (isset($_POST['idMenu']) and $menu->idMenu == $_POST['idMenu'])
					$menu = new Menu($_POST);
				$this->numHijosMenu[] = $this->menuService->num_hijos($menu);
			}
			return 'success';
		}
		
		public function index()
		{
			$this->menus = $this->menuService->menus_index();
			return 'success';
		}
	}