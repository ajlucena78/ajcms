<?php
	class EnvioCorreo extends Model
	{
		protected $id_envio_correo;
		protected $fecha_programa_envio;
		protected $fecha_inicio;
		protected $fecha_fin;
		protected $resultado;
		protected $ok;
		protected $fichero_adjunto;
		protected $contenido;
		protected $listas;
		private $destinatarios;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['id_envio_correo'] = 'auto';
			$this->fk['contenido'] = new FK('Contenido', ManyToOne, 'idContenido');
			$this->fk['listas'] = new FK('ListaCorreo', ManyToMany, 'id_lista_correo', 'id_envio_correo', null
					, 'EnvioCorreoLista');
		}
		
		public function is_lista(ListaCorreo $lista)
		{
			foreach ($this->listas() as $lst)
			{
				if ($lst->id_lista_correo == $lista->id_lista_correo)
				{
					return true;
				}
			}
			return false;
		}
		
		public function is_destinatario($email, $ref)
		{
			foreach ($this->destinatarios() as $dest)
			{
				if ($dest->email_correo == $email and $dest->referencia_correo == $ref)
				{
					return true;
				}
			}
			return false;
		}
	}