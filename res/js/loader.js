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
	document.getElementById('alert_loader').style.display = 'none';
	document.getElementById('loader').style.display = 'none';
}