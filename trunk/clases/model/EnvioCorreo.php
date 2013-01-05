<?php
	class EnvioCorreo extends Model
	{
		protected $idEnvioCorreo;
		protected $fechaProgramaEnvio;
		protected $contenido;
		protected $fechaInicio;
		protected $fechaFin;
		protected $resultado;
		protected $ok;
		protected $ficheroAdjunto;
		protected $enviados;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['idEnvioCorreo'] = 'auto';
			$this->fk['contenido'] = new FK('Contenido', ManyToOne, 'idContenido');
		}
	}