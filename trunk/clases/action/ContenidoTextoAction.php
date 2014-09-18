<?php
	require_once 'ContenidoAction.php';
	class ContenidoTextoAction extends ContenidoAction
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
				$_SESSION['criterios']['descripcion_contenidos'] = $_GET['descripcion'];
			elseif (!isset($_SESSION['criterios']['descripcion_contenidos']))
				$_SESSION['criterios']['descripcion_contenidos'] = '';
			$contenido = new ContenidoTexto();
			if (isset($_SESSION['criterios']['descripcion_contenidos']) 
					and $_SESSION['criterios']['descripcion_contenidos'])
				$contenido->descripcion = $_SESSION['criterios']['descripcion_contenidos'];
			$this->contenidos = $this->contenidoTextoService->find($contenido, null, 'descripcion'
					, array('descripcion' => 1));
			if ($this->contenidos === false)
				return 'error';
			return 'success';
		}
		
		public function alta()
		{
			$this->usuarioService->check_usuario();
			$this->contenido = new ContenidoTexto($_POST);
			if (isset($_POST['guardar']))
			{
				$this->contenido->tipo = CONTENIDO_TEXTO;
				$this->contenido->usuario = $_SESSION['usuario'];
				if (!$this->contenidoTextoService->valida($this->contenido))
				{
					$this->error = $this->contenidoTextoService->error();
					return 'error';
				}
				if (!$this->contenidoTextoService->save($this->contenido))
					return 'error';
				else
				{
					header('Location:' . URL_APP . '?action=edicion-contenido-texto&id=' 
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
				$this->error = 'Falta el dato idContenido a enviar por GET o POST';
				return 'fatal';
			}
			$this->contenido = $this->contenidoTextoService->findById($id);
			if (!$this->contenido)
			{
				$this->error = 'El contenido indicado ya no existe';
				return 'fatal';
			}
			$this->contenidos = $this->contenidoTextoService->findAll('descripcion');
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
				else
					$this->mensaje = 'El orden de la imagen ha sido cambiado';
			}
			//cambiar el orden de un vídeo
			if (isset($_POST['cambiarOrdenVideo']) and $_POST['cambiarOrdenVideo'] == 1)
			{
				$campos = array();
				$campos['idContenido'] = $_POST['id'];
				$campos['id_video'] = $_POST['id_video'];
				$campos['orden'] = $_POST['orden'];
				$video = new ContenidoVideo($campos);
				$this->ancla = '#video_' . $video->id_video;
				if (!$this->contenidoVideoService->cambiar_orden_video($video))
				{
					$this->error = $this->contenidoVideoService->error();
					return 'error';
				}
				else
					$this->mensaje = 'El orden del video ha sido cambiado';
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
				else
					$this->mensaje = 'Imagen eliminada. \nRecuerde borrar la etiqueta [imagen] del texto';
			}
			//desvincular un vídeo
			if (isset($_POST['borrarVideo']) and $_POST['borrarVideo'] == 1)
			{
				$campos = array();
				$campos['idContenido'] = $_POST['id'];
				$campos['id_video'] = $_POST['id_video'];
				if (!$this->contenidoVideoService->removeById($campos))
				{
					$this->error = $this->contenidoVideoService->error();
					return 'error';
				}
				else
					$this->mensaje = 'Video eliminado \nRecuerde borrar la etiqueta [video] del texto';
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
			//editar un vídeo
			if (isset($_POST['guardarVideo']) and $_POST['guardarVideo'] == 1)
			{
				$campos = array();
				$campos['idContenido'] = $_POST['id'];
				$campos['id_video'] = $_POST['id_video'];
				$video = $this->contenidoVideoService->findById($campos);
				if (!$video)
				{
					$this->error = 'No se encuentra el video a editar';
					return 'error';
				}
				$video->titulo_video = $_POST['titulo_video'];
				$video->alineamiento = $_POST['alineamiento'];
				$video->alto_video = $_POST['alto_video'];
				$video->ancho_video = $_POST['ancho_video'];
				if (isset($_FILES['video']['name']) and $_FILES['video']['name'])
				{
					$datos = explode('.', $_FILES['video']['name']);
					if (count($datos) != 2)
					{
						$this->error = 'El nombre del video no es correcto';
						return 'error';
					}
					$video->extension = $datos[1];
					$video->tam = $_FILES['video']['size'];
					$video->tipo = $_FILES['video']['type'];
					$video->tmp_dir($_FILES['video']['tmp_name']);
				}
				if (!$this->contenidoVideoService->valida($video))
				{
					$this->error = $this->contenidoVideoService->error();
					return 'error';
				}
				if (!$this->contenidoVideoService->subir_video($video))
				{
					$this->error = $this->contenidoVideoService->error();
					return 'error';
				}
				$this->mensaje = 'El video ha sido editado correctamente';
			}
			//edicion del contenido
			if (isset($_POST['guardar']))
			{
				$this->contenido->descripcion = $_POST['descripcion'];
				$this->contenido->encabezado = $_POST['encabezado'];
				$this->contenido->permalink = $_POST['permalink'];
				$this->contenido->texto = $_POST['texto'];
				if (!$this->contenidoTextoService->valida($this->contenido))
				{
					$this->error = $this->contenidoTextoService->error();
					return 'error';
				}
				if (!$this->contenidoTextoService->save($this->contenido, true))
				{
					$this->error = $this->contenidoTextoService->error();
					return 'error';
				}
				$this->mensaje = 'Contenido editado';
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
						$this->mensaje = 'La imagen ha sido subida correctamente. \n';
						$this->mensaje .= 'Recuerde incluir la etiqueta [imagen] en el texto';
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
			//guardar un nuevo vídeo
			if (isset($_POST['nuevoVideo']) and $_POST['nuevoVideo'])
			{
				if (isset($_FILES['video']['name']) and $_FILES['video']['name'])
				{
					$datos = explode('.', $_FILES['video']['name']);
					if (count($datos) != 2)
					{
						$this->error = 'El nombre del vídeo no es correcto';
						return 'error';
					}
					$campos = array();
					$campos['titulo_video'] = $_POST['titulo_video'];
					$campos['extension'] = $datos[1];
					$campos['tam'] = $_FILES['video']['size'];
					$campos['tmp_dir'] = $_FILES['video']['tmp_name'];
					$campos['tipo'] = $_FILES['video']['type'];
					$campos['alineamiento'] = $_POST['alineamiento'];
					$campos['alto_video'] = $_POST['alto_video'];
					$campos['ancho_video'] = $_POST['ancho_video'];
					$this->video = new ContenidoVideo($campos);
					$this->video->idContenido = $_POST['id'];
					$this->video->tmp_dir($_FILES['video']['tmp_name']);
					if (!$orden = $this->contenidoVideoService->max_orden($this->video))
					{
						$this->error = $this->contenidoVideoService->error();
						return 'error';
					}
					$this->video->orden = $orden;
					$this->video->activo_video = true;
					if (!$this->contenidoVideoService->valida($this->video))
					{
						$this->error = $this->contenidoVideoService->error();
						$this->ancla = 'nuevo_video';
						return 'error';
					}
					if (!$this->contenidoVideoService->subir_video($this->video))
					{
						$this->error = $this->contenidoVideoService->error();
						$this->ancla = 'nuevo_video';
						return 'error';
					}
					$this->mensaje = 'El video ha sido subido correctamente. \n';
					$this->mensaje .= 'Recuerde incluir la etiqueta [video] en el texto';
					$this->video = new Video();
				}
				else
				{
					$this->error = 'No ha sido especificado el archivo de la película en formato FLV a subir';
					$this->ancla = 'nuevo_video';
					$this->video = new ContenidoVideo($_POST);
					return 'error';
				}
			}
			//cambiar una imagen de contenido
			if (isset($_POST['moverImagen']) and $_POST['moverImagen'])
			{
				if (!$_POST['id_contenido_destino'])
				{
					$this->error = 'No ha seleccionado el contenido al que quiere mover la imagen';
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
					$this->mensaje = 'La imagen se ha movido al contenido indicado';
				}
			}
			return 'success';
		}
		
		public function buscador()
		{
			$this->menus = $this->menuService->menus_index();
			if (!isset($_GET['consulta']) or !$_GET['consulta'])
			{
				$this->error = 'Error: El texto de la consulta no ha sido enviado';
				return 'error';
			}
			$_GET['consulta'] = str_replace('<space>', ' ', $_GET['consulta']);
			if (strlen(trim($_GET['consulta'])) < 3)
			{
				$this->error = 'Error: El texto de la consulta debe tener al menos 3 caracteres';
				return 'error';
			}
			$this->contenidos = $this->contenidoTextoService->buscar($_GET['consulta']);
			if ($this->contenidos === false)
			{
				$this->error = $this->contenidoTextoService->error();
				return 'error';
			}
			$this->titulo = 'Buscador';
			return 'success';
		}
	}