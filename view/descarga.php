<?php
	header('Content-type: ' . $archivo->tipo);
	header('Content-Disposition: attachment; filename="' . $archivo->nombre . '.' . $archivo->extension . '"');
	readfile($archivo->ruta());