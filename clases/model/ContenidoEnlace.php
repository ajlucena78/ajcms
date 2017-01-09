<?php
	require_once APP_ROOT . 'clases/model/Contenido.php';
	class ContenidoEnlace extends Contenido
	{
		protected $url;
		protected $h1;
		protected $metadesc;
		protected $tipoEnlace;
	}