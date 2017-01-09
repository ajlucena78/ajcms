function reloadwin()
{
	var apaisado = false;
	if (getWindowWidth() > getWindowHeight())
		var apaisado = true;
	var sellos = get('sellos');
	var logo = get('logo');
	if (sellos && logo)
		if (apaisado)
		{
			logo.style = 'width: 50%; float: left;';
			sellos.style = 'width: 42%; float: right;';
			mostrar_obj('sellos');
		}
		else
		{
			sellos.style = '';
			ocultar_obj('sellos');
			logo.style = '';
		}
	var cont = 0;
	do
	{
		var foto = get('foto_' + cont);
		if (foto)
		{
			if (apaisado)
				foto.style.width = '31%';
			else
				foto.style.width = '48%';
		}
		cont++;
	}
	while (foto);
}

function leer_mas_movil()
{
	mostrar_obj('mas_info_movil');
	ocultar_obj('leer_mas_boton');
}

function scrollwin()
{}

function leer_pie_movil()
{
	mostrar_obj('mas_info_movil2');
	ocultar_obj('leer_mas_boton2');
}