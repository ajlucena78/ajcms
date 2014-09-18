<?php
	class MenuService extends Service
	{
		public function valida(Menu $menu)
		{
			if (!$menu->titulo)
			{
				$this->error = 'Falta el título del menú';
				return false;
			}
			if (!$menu->orden)
			{
				$this->error = 'Falta el orden del menú';
				return false;
			}
			return true;
		}
		
		public function menus_index()
		{
			$menuAux = new Menu();
			$menuAux->padre = new Menu();
			$menuAux->padre->idMenu = 'null';
			return $this->find($menuAux);
		}
		
		public function subir(Menu $menu)
		{
			if (!$menu->idMenu)
			{
				$this->error = 'Debe indicar el identificador del menú a subir';
				return false;
			}
			if (!$menu = $this->findById($menu->idMenu))
			{
				$this->error = 'No se encuentra el menú elegido';
				return false;
			}
			if ($menu->orden == 1)
			{
				return true;
			}
			$menu->orden = $menu->orden - 1;
			$menuAnterior = new Menu();
			$menuAnterior->padre = new Menu();
			if ($menu->padre)
				$menuAnterior->padre->idMenu = $menu->padre->idMenu;
			else
				$menuAnterior->padre->idMenu = 'null';
			$menuAnterior->orden = $menu->orden;
			if (!$menuAnterior = $this->find($menuAnterior))
			{
				$this->error = 'No se encuentra el menú anterior al elegido';
				return false;
			}
			$menuAnterior = $menuAnterior[0];
			if (!$this->inicia_transaccion())
				return false;
			$menuAnterior->orden = -1;
			if (!$this->save($menuAnterior, true))
			{
				$this->cancela_transaccion();
				return false;
			}
			if (!$this->save($menu, true))
			{
				$this->cancela_transaccion();
				return false;
			}
			$menuAnterior->orden = $menu->orden + 1;
			if (!$this->save($menuAnterior, true))
			{
				$this->cancela_transaccion();
				return false;
			}
			if (!$this->cierra_transaccion())
			{
				$this->cancela_transaccion();
				return false;
			}
			return true;
		}

		public function bajar(Menu $menu)
		{
			if (!$menu->idMenu)
			{
				$this->error = 'Debe indicar el identificador del menú a bajar';
				return false;
			}
			if (!$menu = $this->findById($menu->idMenu))
			{
				$this->error = 'No se encuentra el menú elegido';
				return false;
			}
			$menu->orden = $menu->orden + 1;
			$menuSiguiente = new Menu();
			$menuSiguiente->padre = new Menu();
			if ($menu->padre)
				$menuSiguiente->padre->idMenu = $menu->padre->idMenu;
			else
				$menuSiguiente->padre->idMenu = 'null';
			$menuSiguiente->orden = $menu->orden;
			if (!$menuSiguiente = $this->find($menuSiguiente))
			{
				$this->error = 'No se encuentra el menú siguiente al elegido';
				return false;
			}
			$menuSiguiente = $menuSiguiente[0];
			if (!$this->inicia_transaccion())
				return false;
			$menuSiguiente->orden = -1;
			if (!$this->save($menuSiguiente, true))
			{
				$this->cancela_transaccion();
				return false;
			}
			if (!$this->save($menu, true))
			{
				$this->cancela_transaccion();
				return false;
			}
			$menuSiguiente->orden = $menu->orden - 1;
			if (!$this->save($menuSiguiente, true))
			{
				$this->cancela_transaccion();
				return false;
			}
			if (!$this->cierra_transaccion())
			{
				$this->cancela_transaccion();
				return false;
			}
			return true;
		}
		
		public function num_hijos(Menu $menu)
		{
			$idMenu = $menu->idMenu;
			if (!$idMenu)
				$idMenu = 'null';
			$sql = 'select (count(idMenu) + 0) as total from Menu where idPadre = ' . $idMenu;
			$consulta = new Consulta(self::$conexion);
			if (!$consulta->ejecuta($sql))
			{
				$this->error = $consulta->error();
				return false;
			}
			if (!$res = $consulta->lee_registro())
			{
				$this->error = 'No se ha podido obtener el número de submenus';
				return false;
			}
			$consulta->libera();
			return $res['total'] + 0;
		}
		
		public function max_orden(Menu $menu)
		{
			if ($menu->padre and $menu->padre->idMenu)
				$idPadre = '= ' . $menu->padre->idMenu;
			else
				$idPadre = 'is null';
			$sql = 'select max(orden) as orden from Menu where idPadre ' . $idPadre;
			$consulta = new Consulta(self::$conexion);
			if (!$consulta->ejecuta($sql))
			{
				$this->error = $consulta->error();
				return false;
			}
			$reg = $consulta->lee_registro();
			if ($reg['orden'])
				$orden = $reg['orden'] + 1;
			else
				$orden = 1;
			$consulta->libera();
			return $orden;
		}
	}