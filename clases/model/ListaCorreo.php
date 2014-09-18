<?php
	class ListaCorreo extends Model
	{
		protected $id_lista_correo;
		protected $nombre_lista_correo;
		protected $correos;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['id_lista_correo'] = 'auto';
			$this->fk['correos'] = new FK('Correo', ManyToMany, 'id_correo', 'id_lista_correo', 'email_correo'
					, 'CorreoListaCorreo');
		}
	}