<?php
	ini_set("max_execution_time", "0");
	ini_set("memory_limit", "256M");
	
	require_once("../config.php");
	require_once($rootDocumentos . "/clases/dao/Conexion.php");
	require_once($rootDocumentos . "/clases/model/EnvioCorreoModel.php");
	require_once($rootDocumentos . "/clases/model/ConfiguracionModel.php");
	
	$conexion = new Conexion();
	while(true)
	{
		while (true)
		{
			if ($conexion->conecta($hostBD, $nombreBD, $usuarioBD, $claveBD))
				break;
			sleep(60);
		}
		$envio = new EnvioCorreoModel($conexion);
		if (!$envio->get_envios_cola())
		{
			echo "Se ha producido una incidencia en la carga de los programas (" . $envio->lee_msg_error() . ")";
		}
		while ($envio->lee_envioCorreo())
		{
			if ($envio->envia($dominio . $pathRelativo, $rootDocumentos, $mensajes) === false)
			{
				echo "Se ha producido una incidencia en el envío: " . $envio->getVO()->get_fecha_programa_envio() 
					. " (" . $envio->lee_msg_error() . ")\n";
			}
		}
		$envio->libera();
		$conexion->desconecta();
		sleep(60);
	}