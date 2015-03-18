function reloadwin()
{
	var apaisado = false;
	if (getWindowWidth() > getWindowHeight())
		var apaisado = true;
	var burbujas = get('burbujas');
	if (burbujas)
		if (apaisado)
			burbujas.style.height = '15pt';
		else
			burbujas.style.height = '';
	var sellos = get('sellos');
	var logo = get('logo');
	if (sellos && logo)
		if (apaisado)
		{
			sellos.style = 'width: 42%; float: right;';
			logo.style = 'width: 50%; float: left;';
		}
		else
		{
			sellos.style = '';
			logo.style = '';
		}
	var cont = 0;
	do
	{
		var foto = get('foto_' + cont);
		if (foto)
		{
			if (apaisado)
				foto.style.width = '46%';
			else
				foto.style.width = '96%';
		}
		cont++;
	}
	while (foto);
}

function scrollwin()
{
	var top = get('top');
	var sellos = get('sellos');
	if (top && sellos)
	{
		var topY = getPageScrollY();
		var apaisado = false;
		if (getWindowWidth() > getWindowHeight())
			var apaisado = true;
		if (topY > 0)
		{
			top.style.position = 'absolute';
			set_top(top, topY);
			if (!apaisado)
				ocultar_obj('sellos');
		}
		else
		{
			top.style.position = 'relative';
			set_top(top, 0);
			mostrar_obj('sellos');
		}
	}
}