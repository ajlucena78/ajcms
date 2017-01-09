<?php
	class Video extends Model
	{
		protected $id_video;
		protected $titulo_video;
		protected $activo_video;
		protected $ancho_video;
		protected $alto_video;
		protected $extension;
		protected $tam;
		protected $tipo;
		private $tmp_dir;
		protected $contenido;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['id_video'] = 'auto';
			$this->fk['contenido'] = new FK('Contenido', ManyToMany, 'idContenido', 'idVideo', null
					, 'ContenidoVideo');
		}
		
		public function tmp_dir($val = null)
		{
			if ($val !== null)
				$this->tmp_dir = $val;
			else
				return $this->tmp_dir;
		}
	}