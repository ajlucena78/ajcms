<?php
	class ContenidoVideo extends Model
	{
		protected $idVideo;
		protected $tituloVideo;
		protected $activoVideo;
		protected $anchoVideo;
		protected $altoVideo;
		protected $extension;
		protected $tam;
		protected $tipo;
		protected $orden;
		protected $alineamiento;
		protected $contenido;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['idVideo'] = 'auto';
			$this->fk['contenido'] = new FK('Contenido', ManyToOne, 'idContenido');
		}
	}