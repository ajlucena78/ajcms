<?php
	require_once 'ContenidoAction.php';
	class ContenidoTextoAction extends ContenidoAction
	{
		protected $mensaje;
		protected $contenidos;
		protected $contenido;
		protected $imagen;
		protected $archivo;
		protected $video;
		protected $ancla;
		
		public function consulta()
		{
			if (!$this->usuarioService->check_usuario())
			{
				return 'inicio-sesion-adm';
			}
			if (isset($_POST['id']) and (0 + $_POST['id']))
			{
				//privar o hacer público un contenido
				$contenido = $this->contenidoService->findById($_POST['id']);
				if (!$contenido)
				{
					$this->error = 'No se localiza el contenido con ID: ' . $_POST['id'];
					return 'error';
				}
				if (isset($_POST['privada']) and $_POST['privada'])
				{
					$contenido->privado = true;
				}
				else
				{
					$contenido->privado = false;
				}
				if ($this->contenidoService->save($contenido, true) === false)
				{
					$this->error = $this->contenidoService->error();
					return 'error';
				}
			}
			if (isset($_GET['descripcion']))
			{
				$_SESSION['criterios']['descripcion_contenidos'] = $_GET['descripcion'];
			}
			elseif (!isset($_SESSION['criterios']['descripcion_contenidos']))
			{
				$_SESSION['criterios']['descripcion_contenidos'] = '';
			}
			$contenido = new ContenidoTexto();
			if (isset($_SESSION['criterios']['descripcion_contenidos']) 
					and $_SESSION['criterios']['descripcion_contenidos'])
			{
				$contenido->descripcion = $_SESSION['criterios']['descripcion_contenidos'];
			}
			$contenidos = $this->contenidoTextoService->find($contenido, null, 'descripcion'
					, array('descripcion' => 1));
			if ($contenidos === false)
			{
				return 'error';
			}
			$this->contenidos = array();
			foreach ($contenidos as $contenido)
			{
				if ($contenido->tipo == CONTENIDO_TEXTO)
				{
					$this->contenidos[] = $contenido;
				}
			}
			return 'success';
		}
		
		public function alta()
		{
			if (!$this->usuarioService->check_usuario())
			{
				return 'inicio-sesion-adm';
			}
			$this->contenido = new ContenidoTexto($_POST);
			if (!isset($_POST['guardar']))
			{
				return 'error';
			}
			$this->contenido->tipo = CONTENIDO_TEXTO;
			$this->contenido->usuario = $_SESSION['usuario'];
			$this->contenido->textoMovil = (isset($_POST['textoMovil']) and $_POST['textoMovil']) ? true : false;
			$this->contenido->pieMovil = (isset($_POST['pieMovil']) and $_POST['pieMovil']) ? true : false;
			$this->contenido->privado = (isset($_POST['privado']) and $_POST['privado']) ? true : false;
			if (!$this->contenidoTextoService->valida($this->contenido))
			{
				$this->error = $this->contenidoTextoService->error();
				return 'error';
			}
			if (!$this->contenidoTextoService->save($this->contenido))
			{
				$this->error = $this->contenidoVideoService->error();
				return 'fatal';
			}
			$_SESSION['id'] = $this->contenido->idContenido;
			return 'success';
		}
		
		public function edicion()
		{
			if (!$this->usuarioService->check_usuario())
			{
				return 'inicio-sesion-adm';
			}
			ini_set('max_execution_time', '1800');
			ini_set('upload_max_filesize', '20M');
			ini_set('post_max_size', '20M');
			ini_set('max_input_time', '1800');
			if (isset($_POST['id']) and $_POST['id'] > 0)
				$id = $_POST['id'] + 0;
			elseif (isset($_GET['id']) and $_GET['id'] > 0)
				$id = $_GET['id'] + 0;
			elseif (isset($_SESSION['id']) and $_SESSION['id'] > 0)
			{
				$id = $_SESSION['id'] + 0;
				unset($_SESSION['id']);
			}
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
			//desvincular un archivo
			if (isset($_POST['borrarArchivo']) and $_POST['borrarArchivo'] == 1)
			{
				$campos = array();
				$campos['idContenido'] = $_POST['id'];
				$campos['idArchivo'] = $_POST['idArchivo'];
				if (!$this->contenidoArchivoService->removeById($campos))
				{
					$this->error = $this->contenidoArchivoService->error();
					return 'error';
				}
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
				if ($_POST['titulo'])
				{
					$imagen->titulo = $_POST['titulo'];
				}
				else
				{
					$imagen->titulo = $this->contenido->descripcion;
				}
				$imagen->alineamiento = $_POST['alineamiento'];
				$imagen->tamano = $_POST['tamano'];
				$imagen->ampliable((isset($_POST['ampliable']) and $_POST['ampliable']) ? '1' : '0');	
				$imagen->oculta = (isset($_POST['oculta']) and $_POST['oculta']) ? '1' : '0';
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
				$imagen->idUsuario = $_SESSION['usuario']->idUsuario;
				if (!$this->contenidoImagenService->subir_imagen($imagen))
				{
					$this->error = $this->contenidoImagenService->error();
					return 'error';
				}
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
				if ($_POST['titulo_video'])
				{
					$video->titulo_video = $_POST['titulo_video'];
				}
				else
				{
					$video->titulo_video = $this->contenido->descripcion;
				}
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
				$video->idUsuario = $_SESSION['usuario']->idUsuario;
				if (!$this->contenidoVideoService->subir_video($video))
				{
					$this->error = $this->contenidoVideoService->error();
					return 'error';
				}
			}
			//editar un archivo
			if (isset($_POST['guardarArchivo']) and $_POST['guardarArchivo'] == 1)
			{
				$campos = array();
				$campos['idContenido'] = $_POST['id'];
				$campos['idArchivo'] = $_POST['idArchivo'];
				$archivo = $this->contenidoArchivoService->findById($campos);
				if (!$archivo)
				{
					$this->error = 'No se encuentra el archivo a editar';
					return 'error';
				}
				if (isset($_FILES['archivo']['name']) and $_FILES['archivo']['name'])
				{
					$datos = explode('.', $_FILES['archivo']['name']);
					if (count($datos) != 2)
					{
						$this->error = 'El nombre del archivo no es correcto';
						return 'error';
					}
					$archivo->nombre = $datos[0];
					$archivo->extension = $datos[1];
					$archivo->tam = $_FILES['archivo']['size'];
					$archivo->tipo = $_FILES['archivo']['type'];
					$archivo->tmp_dir($_FILES['archivo']['tmp_name']);
				}
				$archivo->titulo = $_POST['titulo'];
				if (!$this->contenidoArchivoService->valida($archivo))
				{
					$this->error = $this->contenidoArchivoService->error();
					return 'error';
				}
				$archivo->idUsuario = $_SESSION['usuario']->idUsuario;
				if (!$this->contenidoArchivoService->subir_archivo($archivo))
				{
					$this->error = $this->contenidoArchivoService->error();
					return 'error';
				}
			}
			//edición del contenido
			if (isset($_POST['guardar']))
			{
				$this->contenido->descripcion = $_POST['descripcion'];
				$this->contenido->encabezado = $_POST['encabezado'];
				$this->contenido->permalink = $_POST['permalink'];
				$this->contenido->texto = $_POST['texto'];
				$this->contenido->texto2 = $_POST['texto2'];
				$this->contenido->metadesc = $_POST['metadesc'];
				$this->contenido->pie = $_POST['pie'];
				$this->contenido->textoMovil = (isset($_POST['textoMovil']) 
						and $_POST['textoMovil']) ? true : false;
				$this->contenido->pieMovil = (isset($_POST['pieMovil']) and $_POST['pieMovil']) ? true : false;
				$this->contenido->idUsuario = $_SESSION['usuario']->idUsuario;
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
						if ($_POST['titulo'])
						{
							$campos['titulo'] = $_POST['titulo'];
						}
						else
						{
							$campos['titulo'] = $this->contenido->descripcion;
						}
						$campos['extension'] = $datos[1];
						$campos['tam'] = $_FILES['imagen']['size'];
						$campos['tipo'] = $_FILES['imagen']['type'];
						$campos['alineamiento'] = $_POST['alineamiento'];
						$campos['tamano'] = $_POST['tamano'];
						$this->imagen = new ContenidoImagen($campos);
						$this->imagen->contenido = new Contenido();
						$this->imagen->contenido->idContenido = $_POST['id'];
						$this->imagen->ampliable((isset($_POST['ampliable']) 
								and $_POST['ampliable']) ? '1' : '0');
						$this->imagen->oculta = (isset($_POST['oculta']) and $_POST['oculta']) ? '1' : '0';
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
						$this->imagen->idUsuario = $_SESSION['usuario']->idUsuario;
						if (!$this->contenidoImagenService->subir_imagen($this->imagen))
						{
							$this->error = $this->contenidoImagenService->error();
							$this->ancla = 'nueva_imagen';
							return 'error';
						}
						$this->imagen = new ContenidoImagen();
					}
				}
				else
				{
					$this->error = 'No ha sido especificado el archivo de la imagen en formato JPG a subir';
					$this->imagen = new ContenidoImagen($_POST);
					$this->ancla = 'nueva_imagen';
					return 'error';
				}
				$this->ancla = 'nueva_imagen';
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
					if ($_POST['titulo_video'])
					{
						$campos['titulo_video'] = $_POST['titulo_video'];
					}
					else
					{
						$campos['titulo_video'] = $this->contenido->descripcion;
					}
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
					$this->video->idUsuario = $_SESSION['usuario']->idUsuario;
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
					$this->video = new ContenidoVideo();
				}
				else
				{
					$this->error = 'No ha sido especificado el archivo de la película en formato FLV a subir';
					$this->ancla = 'nuevo_video';
					$this->video = new ContenidoVideo($_POST);
					return 'error';
				}
			}
			//guardar un nuevo archivo
			if (isset($_POST['nuevoArchivo']) and $_POST['nuevoArchivo'])
			{
				if (isset($_FILES['archivo']['name']) and $_FILES['archivo']['name'])
				{
					$datos = explode('.', $_FILES['archivo']['name']);
					if (count($datos) != 2)
					{
						$error = true;
						$this->error = 'El nombre del archivo no es correcto';
					}
					else
					{
						$campos = array();
						$campos['titulo'] = $_POST['titulo'];
						$campos['nombre'] = $datos[0];
						$campos['extension'] = $datos[1];
						$campos['tam'] = $_FILES['archivo']['size'];
						$campos['tipo'] = $_FILES['archivo']['type'];
						$this->archivo = new ContenidoArchivo($campos);
						$this->archivo->contenido = new Contenido();
						$this->archivo->contenido->idContenido = $_POST['id'];
						$this->archivo->tmp_dir($_FILES['archivo']['tmp_name']);
						if (!$this->contenidoArchivoService->valida($this->archivo))
						{
							$this->error = $this->contenidoArchivoService->error();
							$this->ancla = 'nuevo_archivo';
							return 'error';
						}
						$this->archivo->idUsuario = $_SESSION['usuario']->idUsuario;
						if (!$this->contenidoArchivoService->subir_archivo($this->archivo))
						{
							$this->error = $this->contenidoArchivoService->error();
							$this->ancla = 'nuevo_archivo';
							return 'error';
						}
						$this->archivo = new ContenidoArchivo();
					}
				}
				else
				{
					$this->error = 'No ha sido especificado el archivo a subir';
					$this->archivo = new ContenidoArchivo($_POST);
					$this->ancla = 'nuevo_archivo';
					return 'error';
				}
				$this->ancla = 'nueva_imagen';
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
			$_GET['consulta'] = str_replace('[space]', ' ', $_GET['consulta']);
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