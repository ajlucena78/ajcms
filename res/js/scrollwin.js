function scrollwin()
{
	var alto = 230;
	var menu = document.getElementById('menu_izq');
	var panel = document.getElementById('sidebar-first');
	mostrar_obj('panel_menu_izq');
	if (getPageScrollY() < (getHeight(panel) + alto))
	{
		var top = 0;
		ocultar_obj('logo_menu');
	}
	else
	{
		if (getHeight(menu) > getWindowHeight())
		{
			ocultar_obj('panel_menu_izq');
		}
		var top = getPageScrollY() - alto + 35;
		mostrar_obj('logo_menu');
	}
	set_top(menu, top);
}