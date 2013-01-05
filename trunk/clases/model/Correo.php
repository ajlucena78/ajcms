<?php
	class Correo extends Model
	{
		protected $idCorreo;
		protected $emailCorreo;
		protected $referenciaCorreo;
		protected $baja;
		protected $listasCorreos;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['idCorreo'] = 'auto';
			$this->fk['listasCorreos'] = new FK('ListaCorreo', ManyToMany, 'idCorreo', null, 'nombreListaCorreo'
					, 'CorreoListaCorreo');
		}
	}