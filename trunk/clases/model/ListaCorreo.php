<?php
	class ListaCorreo extends Model
	{
		protected $idListaCorreo;
		protected $nombreListaCorreo;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['idListaCorreo'] = 'auto';
		}
	}