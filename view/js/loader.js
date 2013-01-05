function redim_loader()
{
	var loader = document.getElementById('loader');
	if (!loader.style.display || loader.style.display == "block")
	{
		var w = getPageWidth();
		if (w < getWindowWidth())
			w = getWindowWidth();
		var h = getPageHeight();
		if (h < getWindowHeight())
			h = getWindowHeight();
		resize_layer(loader, w, h);
		var alertLoader = document.getElementById('alert_loader');
		var y = getPageScrollY() + (getWindowHeight() - getHeight(alertLoader)) / 2;
		var x = getPageScrollX() + (getWindowWidth() - getWidth(alertLoader)) / 2;
		moveLayerTo(alertLoader, x + "px", y + "px");
		setTimeout("redim_loader();", 500);
	}
}

function close_loader()
{
	/*
	var fondo = document.getElementById("fondo");
	var alto = getWindowHeight();
	if  (getPageHeight() > alto)
		alto = getPageHeight();
	resize_layer (fondo, "100%", alto + "px");
	var contenido = document.getElementById("contenido");
	resize_layer (contenido, (getWindowWidth() - 220) + "px", (getWindowHeight() - 100) + "px");
	*/
	document.getElementById('alert_loader').style.display = 'none';
	document.getElementById('loader').style.display = 'none';
}