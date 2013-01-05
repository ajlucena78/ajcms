<?php
	class Menu extends Model
	{
		protected $idUsuario;
		protected $login;
		protected $pwd;
		protected $fechaAcceso;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['idUsuario'] = 'auto';
		}
	}