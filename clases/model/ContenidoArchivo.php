<?php
	class ContenidoArchivo extends Model
	{
		protected $idArchivo;
		protected $titulo;
		protected $codigo;
		protected $nombre;
		protected $extension;
		protected $tam;
		protected $tipo;
		private $tmp_dir;
		protected $contenido;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['idArchivo'] = 'auto';
			$this->fk['contenido'] = new FK('Contenido', ManyToOne, 'idContenido');
		}
		
		public function tmp_dir($val = null)
		{
			if ($val !== null)
				$this->tmp_dir = $val;
			else
				return $this->tmp_dir;
		}
		
		public function enlace()
		{
			return link_action('descarga-archivo', array('id' => $this->codigo));
		}
		
		public function url()
		{
			$directorio = floor($this->idArchivo / 1000);
			$url = URL_APP . 'res/upload/' . $directorio . '/' . $this->nombre . '.' . $this->extension;
			return $url;
		}
		
		public function ruta()
		{
			$directorio = floor($this->idArchivo / 1000);
			$ruta = APP_ROOT . 'res/upload/' . $directorio . '/' . $this->codigo . '.' . $this->extension;
			return $ruta;
		}
	}