<?php
	class Noticia extends Model
	{
		protected $idNoticia;
		protected $referencia;
		protected $descripcion;
		protected $servido;
		protected $tipo;
		protected $permalink;
		protected $texto;
		protected $fecha;
		protected $imagenes;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['idNoticia'] = 'auto';
			$this->fk['imagenes'] = new FK('Imagen', ManyToMany, 'idImagen', 'idNoticia', 'orden', 'NoticiaImagen');
		}
	}