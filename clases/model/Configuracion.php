<?php
	class Configuracion extends Model
	{
		protected $nombre;
		protected $valor;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['nombre'] = 'manual';
		}
	}