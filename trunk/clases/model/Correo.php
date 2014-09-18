<?php
	class Correo extends Model
	{
		protected $id_correo;
		protected $email_correo;
		protected $referencia_correo;
		protected $baja;
		protected $listas;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['id_correo'] = 'auto';
			$this->fk['listas'] = new FK('ListaCorreo', ManyToMany, 'id_lista_correo', 'id_correo'
					, 'nombre_lista_correo', 'CorreoListaCorreo');
		}
	}