<?php
	require_once 'ContenidoAction.php';
	class ContenidoCorreoAction extends ContenidoAction
	{
		protected $mensaje;
		protected $contenidos;
		protected $contenido;
		protected $imagen;
		protected $video;
		protected $ancla;
		
		public function consulta()
		{
			$this->usuarioService->check_usuario();
			if (isset($_GET['descripcion']))
				$_SESSION['criterios']['descripcion_correos'] = $_GET['descripcion'];
			elseif (!isset($_SESSION['criterios']['descripcion_correos']))
				$_SESSION['criterios']['descripcion_correos'] = '';
			$contenido = new ContenidoCorreo();
			if (isset($_SESSION['criterios']['descripcion_correos']) 
					and $_SESSION['criterios']['descripcion_correos'])
				$contenido->descripcion = $_SESSION['criterios']['descripcion_correos'];
			$this->contenidos = $this->contenidoCorreoService->find($contenido, null, 'descripcion'
					, array('descripcion' => 1));
			if ($this->contenidos === false)
				return 'error';
			return 'success';
		}
		
		public function alta()
		{
			$this->usuarioService->check_usuario();
			$this->contenido = new ContenidoCorreo($_POST);
			if (isset($_POST['guardar']))
			{
				$this->contenido->tipo = CONTENIDO_MENSAJE;
				$this->contenido->usuario = $_SESSION['usuario'];
				$this->contenido->referencia = uniqid();
				if (!$this->contenidoCorreoService->valida($this->contenido))
				{
					$this->error = $this->contenidoCorreoService->error();
					return 'error';
				}
				if (!$this->contenidoCorreoService->save($this->contenido))
				{
					$this->error = $this->contenidoCorreoService->error();
					return 'error';
				}
				else
				{
					header('Location:' . URL_APP . '?action=edicion-mensaje&id=' 
							. $this->contenido->idContenido);
					exit();
				}
			}
			return 'success';
		}
		
		public function edicion()
		{
			$this->usuarioService->check_usuario();
			ini_set('max_execution_time', '1800');
			ini_set('upload_max_filesize', '20M');
			ini_set('post_max_size', '20M');
			ini_set('max_input_time', '1800');
			if (isset($_POST['id']) and $_POST['id'] > 0)
				$id = $_POST['id'] + 0;
			elseif (isset($_GET['id']) and $_GET['id'] > 0)
				$id = $_GET['id'] + 0;
			else
			{
				$this->error = 'Falta el dato id a enviar por GET o POST';
				return 'fatal';
			}
			$this->contenido = $this->contenidoCorreoService->findById($id);
			if (!$this->contenido)
			{
				$this->error = 'El contenido indicado ya no existe';
				return 'fatal';
			}
			$this->contenidos = $this->contenidoCorreoService->findAll();
			//cambiar el orden de una imagen
			if (isset($_POST['cambiarOrdenImagen']) and $_POST['cambiarOrdenImagen'] == 1)
			{
				$campos = array();
				$campos['idContenido'] = $_POST['id'];
				$campos['idImagen'] = $_POST['idImagen'];
				$campos['orden'] = $_POST['orden'];
				$imagen = new ContenidoImagen($campos);
				$this->ancla = '#imagen_' . $imagen->idImagen;
				if (!$this->contenidoImagenService->cambiar_orden_imagen($imagen))
				{
					$this->error = $this->contenidoImagenService->error();
					return 'error';
				}
				$this->mensaje = 'El orden de la imagen ha sido cambiado';
				return 'success';
			}
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
				$this->mensaje = 'Imagen eliminada. \nRecuerde borrar la etiqueta [imagen] del texto';
				return 'success';
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
				return 'success';
			}
			//edicion del mensaje
			if (isset($_POST['guardar']))
			{
				$this->contenido->descripcion = $_POST['descripcion'];
				$this->contenido->permalink = ($_POST['permalink']) ? $_POST['permalink'] : null;
				$this->contenido->texto = $_POST['texto'];
				$this->contenido->usuario = $_SESSION['usuario'];
				if (!$this->contenidoCorreoService->valida($this->contenido))
				{
					$this->error = $this->contenidoCorreoService->error();
					return 'error';
				}
				if (!$this->contenidoCorreoService->save($this->contenido, true))
				{
					$this->error = $this->contenidoCorreoService->error();
					return 'error';
				}
				$this->mensaje = 'Mensaje editado';
				return 'success';
			}
			//guardar una nueva imagen
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
					$this->imagen = new ContenidoImagen($campos);
					$this->imagen->idContenido = $_POST['id'];
					$this->imagen->tmp_dir($_FILES['imagen']['tmp_name']);
					$this->imagen->tamano = 100;
					if (!$orden = $this->contenidoImagenService->max_orden($this->imagen))
					{
						$this->error = $this->contenidoImagenService->error();
						return 'error';
					}
					$this->imagen->orden = $orden;
					if (!$this->contenidoImagenService->valida($this->imagen))
					{
						$this->error = $this->contenidoImagenService->error();
						return 'error';
					}
					if (!$this->contenidoImagenService->subir_imagen($this->imagen))
					{
						$this->error = $this->contenidoImagenService->error();
						return 'error';
					}
					$this->mensaje = 'La imagen ha sido subida correctamente. \n';
					$this->mensaje .= 'Recuerde incluir la etiqueta [imagen] en el texto';
					$this->imagen = new Imagen();
				}
			}
			return 'success';
		}
		
		public function buscador()
		{
			if (!isset($_GET['consulta']) or !$_GET['consulta'])
			{
				$this->error = 'Error: El texto de la consulta no ha sido enviado';
				return 'error';
			}
			if (strlen($_GET['consulta']) < 3)
			{
				$this->error = 'Error: El texto de la consulta debe tener al menos 3 caracteres';
				return 'error';
			}
			$contenido = new ContenidoTexto();
			$contenido->texto = $_GET['consulta'];
			$this->contenidos = $this->contenidoCorreoService->find($contenido, null, null, array('texto' => 1));
			$this->menus = $this->menuService->menus_index();
			$this->titulo = 'Buscador';
			return 'success';
		}
	}