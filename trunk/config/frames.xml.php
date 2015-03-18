<?php
	if (!isset($XML_KEY) or $XML_KEY != date('Ymdh'))
		exit();
	echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<frames>
	<frame id="index">index.php</frame>
	<frame id="admin">admin.php</frame>
	<frame id="movil">movil/index.php</frame>
</frames>