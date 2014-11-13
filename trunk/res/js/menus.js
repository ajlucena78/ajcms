var id_menu_activo = null;

function activa_form_menu(id)
{
	var cont = 0;
	while (true)
	{
		cont++;
		var titulo = document.getElementById('titulo' + cont);
		if (!titulo)
			break;
		document.getElementById('submenus' + cont).disabled = true;
		if (cont == id)
		{
			document.getElementById('editar' + cont).disabled = false;
			document.getElementById('cancelar' + cont).disabled = false;
			document.getElementById('editar_menu_' + id).style.display = 'block';
			continue;
		}
		titulo.disabled = true;
		document.getElementById('idContenido' + cont).disabled = true;
		document.getElementById('editar' + cont).disabled = true;
		document.getElementById('borrar' + cont).disabled = true;
	}
	id_menu_activo = id;
}

function borrar_menu(id)
{
	if (window.confirm('¿Borrar esta opción de menú?\nImportante: Todos los submenús que '
			+ 'dependan de la misma también serán borrados.'))
	{
		var form = document.getElementById('formMenu' + id);
		form.guardar.value = 0;
		form.borrar.value = 1;
		form.submit();
	}
}

function cancelar_form_menu(idPadre)
{
	window.location.href = '?action=menus&idPadre=' + idPadre;
}

function subir_menu(id)
{
	var form = document.getElementById('formMenu' + id);
	form.guardar.value = 0;
	form.subir.value = 1;
	form.submit();
}

function bajar_menu(id)
{
	var form = document.getElementById('formMenu' + id);
	form.guardar.value = 0;
	form.bajar.value = 1;
	form.submit();
}

function ver_opciones_menu(id)
{
	var cont = 0;
	while (true)
	{
		cont++;
		var opciones = document.getElementById('editar_menu_' + cont);
		if (!opciones)
			break;
		opciones.style.display = 'none';
	}
	document.getElementById('editar_menu_' + id).style.display = 'block';
}