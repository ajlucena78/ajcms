<?php
	require_once APP_ROOT . 'clases/model/Video.php';
	class ContenidoVideo extends Video
	{
		protected $idContenido;
		protected $orden;
		protected $alineamiento;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['idContenido'] = 'manual';
		}
	}