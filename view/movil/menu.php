<h1>MEN&Uacute; PRINCIPAL</h1>
<?php $cont = 0; ?>
<?php foreach ($menus as $menu) { ?>
	<hr />
	<div class="menu">
		<a href="<?php echo $menu->enlace(); ?>" <?php if (!$cont) { ?>style="color: red;"<?php } ?>>
			<?php echo formato_html($menu->titulo); ?>
		</a>
	</div>
	<?php $cont++; ?>
<?php } ?>
<?php $menus = null; ?>