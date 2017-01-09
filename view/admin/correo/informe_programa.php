<div>
	<?php echo str_replace("\n", "\n<br />\n", formato_html($envio->resultado)); ?>
</div>
<div style="height: 40px; float: right">
	<br />
	<input type="button" value="Volver" onclick="window.location.href = '<?php vlink('envios') ?>';" />
</div>
<br />
&nbsp;
<br />