<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n"; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<?php foreach ($contenidos as $contenido) { ?>
		<url>
			<loc><?php
					echo HOST_APP . URL_APP;
					if ($contenido->permalink)
						echo utf8_encode($contenido->permalink);
					else
						echo "?referencia=" . $contenido->referencia;
			?></loc>
		</url>
	<?php } ?>
</urlset>