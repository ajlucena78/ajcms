function scrollwin()
{
	var alto = 250;
	var menu = document.getElementById('menu_izq');
	var panel = document.getElementById('sidebar-first');
	if (getPageScrollY() < (getHeight(panel) + alto) || getHeight(menu) > getWindowHeight())
	{
		var top = 0;
		ocultar_obj('logo_menu');
	}
	else
	{
		var top = getPageScrollY() - alto;
		mostrar_obj('logo_menu');
	}
	set_top(menu, top);
}