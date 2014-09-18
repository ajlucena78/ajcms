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
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['idImagen'] = 'auto';
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
	}