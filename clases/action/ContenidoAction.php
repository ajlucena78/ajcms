<?php
	class ContenidoAction extends Action
	{
		protected $menuService;
		protected $contenidoService;
		protected $contenidoTextoService;
		
		public function index()
		{
			//carga del módulo adecuado
			if (isset($_GET['permalink']) and $_GET['permalink'] and !isset($_GET['referencia']))
			{
				$_GET['permalink'] = utf8_decode($_GET['permalink']);
				//permalink
				if (substr($_GET['permalink'], strlen($_GET['permalink']) - 1, 1) == "/")
					$_GET['permalink'] = substr($_GET['permalink'], 0, strlen($_GET['permalink']) - 1);
				$contenido = new Contenido();
				$contenido->permalink = $_GET['permalink'];
				$contenido = $this->contenidoService->find($contenido);
				if (!$contenido)
				{
					$this->error = 'No se encuentra el contenido ' . $_GET['permalink'];
					return 'error';
				}
			}
			else
			{
				//referencia
				$contenido = new Contenido();
				if (!isset($_GET['referencia']) or !$_GET['referencia'])
					$contenido->referencia = "index_";
				else
					$contenido->referencia = $_GET['referencia'];
				$contenido = $this->contenidoService->find($contenido);
				if (!$contenido)
				{
					$this->error = 'No se encuentra el contenido de referencia ' . $_GET['referencia'];
					return 'error';
				}
				$contenido = $contenido[0];
			}
			
			//tipo enlace
			if ($contenido->tipo == 2)
			{
				//TODO
				$contenidoEnlace = new ContenidoEnlaceModel($conexion);
				if (!$contenidoEnlace->buscador($contenidoVO->get_idContenido()))
				{
					$visor->verError($contenidoEnlace->lee_msg_error());
					exit();
				}
				if (!$contenidoEnlace->lee_contenidoEnlace())
				{
					$visor->verError($contenidoEnlace->lee_msg_error());
					exit();
				}
				$contenidoEnlace->libera();
				$contenidoEnlaceVO = $contenidoEnlace->getVO();
				header("Location:" . $contenidoEnlaceVO->get_url());
				$conexion->desconecta();
				exit();
			}
			
			//carga del menú al que pertenece el contenido
			$menu = new Menu();
			$menu->contenido = $contenido;
			$menu = $this->menuService->find($menu);
			if ($menu === false)
				return 'error';
			if ($menu)
			{
				$menu = $menu[0];
				if (isset($_GET['idMenu']) and ($_GET['idMenu'] += 0) > 0)
				{
					$idPadre = $_GET['idMenu'];
					$idMenuContenido = $menu->padre->idPadre;
					$menu->idPadre = $idPadre;
				}
				elseif ($menu->padre)
					$idPadre = $menu->padre->idPadre;
				if (count($menu->hijos) == 0 and $menu->padre)	//and $menu->padre->idPadre > 0)
				{
					//carga del menú del padre
					/*
					if (!$menu->buscador($menuVO->get_idPadre()))
					{
						$visor->verError($menu->lee_msg_error());
						exit();
					}
					*/
					if (!$menu->padre)
					{
						$menu = $this->menuService->findById($idMenuContenido);
						if (!$menu)
							return 'error';
					}
					else
						$menu = $menu->padre;
					/*
					if (!$menu->lee_menu())
					{
						$menu->buscador($idMenuContenido);
						$menu->lee_menu();
					}
					$menuVO = $menu->getVO();
					*/
					//$menuPadreVO_view = $menu;
					if (!$menu->padre)
						$MENU_01 = $menu->idMenu;
					else
					{
						//carga de los submenús del abuelo
						$menuAbuelo = $menu->padre;
						/*
						if (!$menu->buscador($menuVO->get_idPadre()))
						{
							$visor->verError($menu->lee_msg_error());
							exit();
						}
						if (!$menu->lee_menu())
						{
							$visor->verError($menu->lee_msg_error());
							exit();
						}
						$menuAbueloVO = $menu->getVO();
						$menuAux->carga_submenus($menuAbueloVO);
						*/
						if (!$menuAbuelo->idPadre)
							$MENU_01 = $menuAbuelo->idMenu;
						$menuContenidoPadre_view = $menuAbuelo;
					}
				}
				else
					$MENU_01 = $menu->idMenu;
				$menuContenido_view = $menu;
			}
			else
				$idPadre = 0;
			
			//carga de todas las opciones de menú del primer nivel (raíz)
			$menuAux = new Menu();
			$menuAux->padre = new Menu();
			$menuAux->padre->idMenu = 'null';
			$menus_view = $this->menuService->find($menuAux);
			
			//carga del contenido
			$verMenu = true;
			if ($contenido->tipo == 1)
			{
				//TODO inclusión del archivo
				$contenidoFichero = new ContenidoFicheroModel($conexion);
				if (!$contenidoFichero->buscador($contenidoVO->get_idContenido()))
				{
					$visor->verError($contenidoFichero->lee_msg_error());
					exit();
				}
				if (!$contenidoFichero->lee_contenidoFichero())
				{
					$visor->verError($contenidoFichero->lee_msg_error());
					exit();
				}
				$contenidoFichero->libera();
				$contenidoFicheroVO = $contenidoFichero->getVO();
				if (!$contenidoFicheroVO->get_menu())
					$verMenu = false;
			}
			else
			{
				//texto
				$contenido = $this->contenidoTextoService->findById($contenido->idContenido);
				if (!$contenido)
					return 'error';
				/*
				$html = $this->contenidoTextoService->get_texto_procesado($pathRelativo, $rootDocumentos);
				if ($html === false)
					return 'error';
				*/
			}
			
			//ruta al contenido
			if (isset($idPadre) and $idPadre)
			{
				$menu = new Menu();
				$menu->idMenu = $idPadre;
			}
			else
				$menu = null;
			$ruta_view = $contenido->get_ruta($menu);
			if ($ruta_view === false)
				return 'error';
			
			//TODO cambiar
			$titulo = $contenido->descripcion 
					. ' (PUBLICAR - Publicidad Est&aacute;tica &amp; Din&aacute;mica. Dos Hermanas, Sevilla)';
			
			return 'success';
		}
	}