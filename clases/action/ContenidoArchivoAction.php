<?php
	class ContenidoArchivoAction extends Action
	{
		protected $contenidoImagenService;
		protected $archivo;
		
		public function descarga()
		{
			if (!isset($_GET['id']))
			{
				$this->error = 'Identificador del documento a descargar no aportado';
				return 'error';
			}
			$this->archivo = new ContenidoArchivo();
			$this->archivo->codigo = $_GET['id'];
			$this->archivo = $this->contenidoArchivoService->find($this->archivo);
			if (!$this->archivo)
			{
				$this->error = 'Documento no encontrado';
				return 'error';
			}
			$this->archivo = $this->archivo[0];
			return 'success';
		}
	}