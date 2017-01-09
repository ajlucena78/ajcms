<?php
	class Imagen extends Model
	{
		protected $idImagen;
		protected $titulo;
		protected $extension;
		protected $tam;
		protected $tipo;
		private $ampliable;
		private $tmp_dir;
		protected $permalink;
		protected $contenido;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['idImagen'] = 'auto';
			$this->fk['contenido'] = new FK('Contenido', ManyToMany, 'idContenido', 'idImagen', null
					, 'ContenidoImagen');
		}
		
		public function ampliable($val = null)
		{
			if ($val !== null)
				$this->ampliable = $val;
			else
				return $this->ampliable;
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
			if ($this->permalink)
			{
				return $this->permalink;
			}
			else
			{
				return link_action('ver_imagen', array('id' => $this->idImagen), false, false);
			}
		}
		
		public function url()
		{
			$directorio = floor($this->idImagen / 1000);
			return URL_APP . 'res/upload/' . $directorio . '/' . $this->idImagen . '.' . $this->extension;
		}
	}