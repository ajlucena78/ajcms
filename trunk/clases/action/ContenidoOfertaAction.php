<?php
	require_once 'ContenidoAction.php';
	class ContenidoOfertaAction extends ContenidoAction
	{
		protected $contenidoOfertaService;
		protected $mensaje;
		protected $ancla;
		protected $ofertas;
		protected $oferta;
		
		public function index()
		{
			$this->ofertas = $this->contenidoOfertaService->findAll();
			$this->menus = $this->menuService->menus_index();
			$this->titulo = 'Ofertas y promociones';
			return 'success';
		}
		
		public function show()
		{
			if (!isset($_GET['id']) or !is_numeric($_GET['id']) or $_GET['id'] < 1)
				return 'error';
			$this->oferta = $this->contenidoOfertaService->findById($_GET['id']);
			if (!$this->oferta)
				return 'error';
			$this->menus = $this->menuService->menus_index();
			$this->titulo = $this->oferta->descripcion;
			return 'success';
		}
		
		public function consulta()
		{
			$this->usuarioService->check_usuario();
			if (isset($_GET['descripcion']))
				$_SESSION['criterios']['descripcion_ofertas'] = $_GET['descripcion'];
			elseif (!isset($_SESSION['criterios']['descripcion_ofertas']))
				$_SESSION['criterios']['descripcion_ofertas'] = null;
			$oferta = new ContenidoOferta();
			if (isset($_SESSION['criterios']['descripcion_ofertas']) 
					and $_SESSION['criterios']['descripcion_ofertas'])
				$oferta->descripcion = $_SESSION['criterios']['descripcion_ofertas'];
			$this->ofertas = $this->contenidoOfertaService->find($oferta, null, 'descripcion'
					, array('descripcion' => 1));
			if ($this->ofertas === false)
			{
				$this->error = $this->contenidoOfertaService->error();
				return 'error';
			}
			return 'success';
		}
		
		public function alta()
		{
			$this->usuarioService->check_usuario();
			$this->oferta = new ContenidoOferta($_POST);
			if (isset($_POST['guardar']))
			{
				$this->oferta->tipo = CONTENIDO_OFERTA;
				$this->oferta->usuario = $_SESSION['usuario'];
				if (!$this->contenidoOfertaService->valida($this->oferta))
				{
					$this->error = $this->contenidoOfertaService->error();
					return 'error';
				}
				if (!$this->contenidoOfertaService->save($this->oferta))
					return 'error';
				else
				{
					header('Location:' . URL_APP . '?action=edicion-oferta&id=' . $this->oferta->idContenido);
					exit();
				}
			}
			return 'success';
		}
		
		public function edicion()
		{
			$this->usuarioService->check_usuario();
			ini_set('max_execution_time', '1800');
			ini_set('upload_max_filesize', '8M');
			ini_set('post_max_size', '8M');
			ini_set('max_input_time', '1800');
			if (isset($_POST['id']) and $_POST['id'] > 0)
				$id = $_POST['id'] + 0;
			elseif (isset($_GET['id']) and $_GET['id'] > 0)
				$id = $_GET['id'] + 0;
			else
			{
				$this->error = 'Falta el dato idContenido a enviar por GET o POST';
				return 'fatal';
			}
			$this->oferta = $this->contenidoOfertaService->findById($id);
			if (!$this->oferta)
			{
				$this->error = 'La oferta indicada ya no existe';
				return 'fatal';
			}
			$this->ofertas = $this->contenidoOfertaService->findAll('descripcion');
			//desvincular una imagen
			if (isset($_POST['borrarImagen']) and $_POST['borrarImagen'] == 1)
			{
				$campos = array();
				$campos['idContenido'] = $_POST['id'];
				$campos['idImagen'] = $_POST['idImagen'];
				if (!$this->contenidoImagenService->removeById($campos))
				{
					$this->error = $this->contenidoImagenService->error();
					return 'error';
				}
				else
					$this->mensaje = 'Imagen eliminada de la oferta';
			}
			//editar una imagen
			if (isset($_POST['guardarImagen']) and $_POST['guardarImagen'] == 1)
			{
				$campos = array();
				$campos['idContenido'] = $_POST['id'];
				$campos['idImagen'] = $_POST['idImagen'];
				$imagen = $this->contenidoImagenService->findById($campos);
				if (!$imagen)
				{
					$this->error = 'No se encuentra la imagen a editar';
					return 'error';
				}
				$imagen->titulo = $_POST['titulo'];
				$imagen->alineamiento = $_POST['alineamiento'];
				$imagen->tamano = $_POST['tamano'];
				$imagen->ampliable((isset($_POST['ampliable']) and $_POST['ampliable']) ? '1' : '0');
				if (isset($_FILES['imagen']['name']) and $_FILES['imagen']['name'])
				{
					$datos = explode('.', $_FILES['imagen']['name']);
					if (count($datos) != 2)
					{
						$this->error = 'El nombre de la imagen no es correcto';
						return 'error';
					}
					$imagen->extension = $datos[1];
					$imagen->tam = $_FILES['imagen']['size'];
					$imagen->tipo = $_FILES['imagen']['type'];
					$imagen->tmp_dir($_FILES['imagen']['tmp_name']);
				}
				if (!$this->contenidoImagenService->valida($imagen))
				{
					$this->error = $this->contenidoImagenService->error();
					return 'error';
				}
				if (!$this->contenidoImagenService->subir_imagen($imagen))
				{
					$this->error = $this->contenidoImagenService->error();
					return 'error';
				}
				$this->mensaje = 'La imagen ha sido editada correctamente';
			}
			//edicion de la oferta
			if (isset($_POST['guardar']))
			{
				$this->oferta->descripcion = $_POST['descripcion'];
				$this->oferta->precio = $_POST['precio'];
				$this->oferta->permalink = $_POST['permalink'];
				$this->oferta->texto = $_POST['texto'];
				if (!$this->oferta->usuario)
					$this->oferta->usuario = $_SESSION['usuario'];
				if (!$this->contenidoOfertaService->valida($this->oferta))
				{
					$this->error = $this->contenidoOfertaService->error();
					return 'error';
				}
				if (!$this->contenidoOfertaService->save($this->oferta, true))
				{
					$this->error = $this->contenidoOfertaService->error();
					return 'error';
				}
				$this->mensaje = 'Oferta editada';
			}
			//guardar una nueva imagen
			if (isset($_POST['nuevaImagen']) and $_POST['nuevaImagen'])
			{
				if (isset($_FILES['imagen']['name']) and $_FILES['imagen']['name'])
				{
					$datos = explode('.', $_FILES['imagen']['name']);
					if (count($datos) != 2)
					{
						$error = true;
						$this->error = 'El nombre de la imagen no es correcto';
					}
					else
					{
						$campos = array();
						$campos['titulo'] = $_POST['titulo'];
						$campos['extension'] = $datos[1];
						$campos['tam'] = $_FILES['imagen']['size'];
						$campos['tipo'] = $_FILES['imagen']['type'];
						$campos['alineamiento'] = $_POST['alineamiento'];
						$campos['tamano'] = $_POST['tamano'];
						$this->imagen = new ContenidoImagen($campos);
						$this->imagen->idContenido = $_POST['id'];
						$this->imagen->ampliable((isset($_POST['ampliable']) 
								and $_POST['ampliable']) ? '1' : '0');
						$this->imagen->tmp_dir($_FILES['imagen']['tmp_name']);
						if (!$orden = $this->contenidoImagenService->max_orden($this->imagen))
						{
							$this->error = $this->contenidoImagenService->error();
							return 'error';
						}
						$this->imagen->orden = $orden;
						if (!$this->contenidoImagenService->valida($this->imagen))
						{
							$this->error = $this->contenidoImagenService->error();
							$this->ancla = 'nueva_imagen';
							return 'error';
						}
						if (!$this->contenidoImagenService->subir_imagen($this->imagen))
						{
							$this->error = $this->contenidoImagenService->error();
							$this->ancla = 'nueva_imagen';
							return 'error';
						}
						$this->mensaje = 'La imagen ha sido subida correctamente';
						$this->imagen = new Imagen();
					}
				}
				else
				{
					$this->error = 'No ha sido especificado el archivo de la imagen en formato JPG a subir';
					$this->imagen = new ContenidoImagen($_POST);
					$this->ancla = 'nueva_imagen';
					return 'error';
				}
			}
			//cambiar una imagen de oferta
			if (isset($_POST['moverImagen']) and $_POST['moverImagen'])
			{
				if (!$_POST['id_contenido_destino'])
				{
					$this->error = 'No ha seleccionado la oferta a la que quiere mover la imagen';
					return 'error';
				}
				$campos = array();
				$campos['idContenido'] = $_POST['id'];
				$campos['idImagen'] = $_POST['idImagen'];
				$imagen = $this->contenidoImagenService->findById($campos);
				if ($imagen)
				{
					if (!$this->contenidoImagenService->mover($imagen, $_POST['id_contenido_destino']))
					{
						$this->error = $this->contenidoImagenService->error();
						return 'error';
					}
					$this->mensaje = 'La imagen se ha movido a la oferta indicada';
				}
			}
			return 'success';
		}
	}