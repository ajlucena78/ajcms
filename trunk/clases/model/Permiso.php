<?php
	class Permiso extends Model
	{
		protected $idPermiso;
		protected $permiso;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['idPermiso'] = 'auto';
		}
	}