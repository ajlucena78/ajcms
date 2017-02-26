<?php
	class ContenidoImagen extends Model
	{
		protected $idImagen;
		protected $orden;
		protected $alineamiento;
		protected $tamano;
		protected $oculta;
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
			$this->fk['contenido'] = new FK('Contenido', ManyToOne, 'idContenido');
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
		
		public function url($original = false)
		{
			$directorio = floor($this->idImagen / 1000);
			$url = URL_APP . 'res/upload/' . $directorio . '/';
			if ($original)
			{
				$url .= 'original-';
			}
			$url .= $this->permalink . '.' . $this->extension;
			return $url;
		}
		
		public function ruta($original = false)
		{
			$directorio = floor($this->idImagen / 1000);
			$ruta = APP_ROOT . 'res/upload/' . $directorio . '/';
			if ($original)
			{
				$ruta .= 'original-';
			}
			$ruta .= $this->permalink . '.' . $this->extension;
			return $ruta;
		}
	}