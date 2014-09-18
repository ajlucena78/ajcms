<?php
	class Usuario extends Model
	{
		protected $idUsuario;
		protected $login;
		protected $pwd;
		protected $fechaAcceso;
		protected $ip;
		protected $permiso;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['idUsuario'] = 'auto';
			$this->fk['permiso'] = new FK('Permiso', ManyToOne, 'idPermiso');
		}
	}