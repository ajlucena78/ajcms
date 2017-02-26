<?php echo '<?xml version="1.0" encoding="UTF-8" ?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<?php foreach ($contenidos as $contenido) { ?>
		<?php if ($contenido->permalink == 'adm') { continue; } ?>
		<url>
			<loc><?php
					echo HOST_APP . URL_APP;
					if ($contenido->permalink)
					{
						echo $contenido->permalink;
					}
					else
						echo "?referencia=" . $contenido->referencia;
			?></loc>
		</url>
	<?php } ?>
</urlset>