<?php
	require_once APP_ROOT . 'clases/model/Imagen.php';
	class ContenidoImagen extends Imagen
	{
		protected $idContenido;
		protected $orden;
		protected $alineamiento;
		protected $tamano;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['idContenido'] = 'manual';
		}
	}