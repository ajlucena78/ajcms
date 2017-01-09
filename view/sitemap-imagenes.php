<?php 
	header('Content-Type:text/xml');
	echo '<?xml version="1.0" encoding="UTF-8" ?>';
?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<?php foreach ($imagenes as $imagen) { ?>
		<?php if (!$imagen->permalink or $imagen->oculta) continue; ?>
		<url>
			<loc><?php echo HOST_APP . URL_APP . $imagen->permalink; ?></loc>
		</url>
	<?php } ?>
</urlset>