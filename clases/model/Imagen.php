<?php
	class Imagen extends Model
	{
		protected $idImagen;
		protected $titulo;
		protected $extension;
		protected $tam;
		protected $tipo;
		protected $orden;
		protected $alineamiento;
		protected $contenido;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['idImagen'] = 'auto';
			$this->fk['contenido'] = new FK('Contenido', ManyToOne, 'idContenido');
		}
	}