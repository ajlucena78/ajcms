<form name="baja" action="<?php vlink('baja-contenido'); ?>" method="post">
	<input type="hidden" name="id" value="<?php echo $contenido->idContenido; ?>" />
	<input type="hidden" name="borrar" value="1" />
	<div style="float: left; width: 20%;">
		<strong>Tipo:</strong>
	</div>
	<div style="float: right; text-align: left; width: 80%;">
		<?php if ($contenido->tipo == CONTENIDO_ENLACE){ ?>
			Enlace
		<?php }elseif ($contenido->tipo == CONTENIDO_MENSAJE){ ?>
			Mensaje
		<?php }elseif ($contenido->tipo == CONTENIDO_OFERTA){ ?>
			Oferta
		<?php }else{ ?>
			Contenido de texto
		<?php } ?>
	</div>
	<div style="height: 10px; clear: both;">
	</div>
	<div style="float: left; width: 20%;">
		<strong>Nombre:</strong>
	</div>
	<div style="float: right; text-align: left; width: 80%;">
		<?php echo formato_html($contenido->descripcion); ?>
	</div>
	<div style="height: 10px; clear: both;">
	</div>
	<div style="height: 40px; float: right">
		<input type="submit" value="Borrar el contenido" style="color: red;" />
		<input type="button" value="Cancelar" onclick="window.history.back();" />
	</div>
</form>