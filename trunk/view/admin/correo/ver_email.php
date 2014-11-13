<form name="edicion" action="<?php vlink('baja-correo'); ?>" method="post">
	<input type="hidden" name="id" value="<?php echo $correo->id_correo; ?>" />
	<input type="hidden" name="borrar" value="1" />
	<div style="float: left; width: 10%;">
		Email:
	</div>
	<div style="float: right; text-align: left; width: 90%;">
		<strong><?php echo formato_html($correo->email_correo); ?></strong>
	</div>
	<div style="height: 10px; clear: both;"></div>
	<div>
		<?php if (count($correo->listas) > 0) { ?>
			Se encuentra en las listas:
			<ul>
				<?php foreach ($correo->listas as $lista) { ?>
					<li><?php echo formato_html($lista->nombre_lista_correo); ?></li>
				<?php } ?>
			</ul>
		<?php }else{ ?>
			No se encuentra en ninguna lista
		<?php } ?>
	</div>
	<div style="height: 40px; float: right;">
		<?php if ($correo->baja) { ?>
			<span style="color: red; text-decoration: blink;">Se encuentra dado de baja</span>
		<?php }else{ ?>
			<input type="submit" value="Dar de baja de todas las listas" style="color: red;" />
		<?php } ?>
	</div>
</form>