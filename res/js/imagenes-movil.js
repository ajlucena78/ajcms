function ver_imagen(url)
{
	var fondo_imagenes = document.getElementById('fondo_imagenes');
	fondo_imagenes.style.display = 'block';
	var titulo_img = document.getElementById('titulo_imagen');
	titulo_img.innerHTML = "";
	var capa_imagenes = document.getElementById('imagenes');
	capa_imagenes.style.display = 'table';
	var capa_solo_imagen = document.getElementById('capa_solo_imagen');
	capa_solo_imagen.style.display = 'none';
	var loading_image = document.getElementById('loading_image');
	loading_image.style.display = 'block';
	img = new Image();
	img.src = imagenes[i].imgOriginal;
	var imagen = document.getElementById('imagen');
	imagen.src = img.src;
}

function ver_anterior()
{
	var i = imgActual - 1;
	if (imagenes[i])
		ver_imagen(imagenes[i].id);
	else
		window.alert('No hay más imágenes previas');
}

function ver_siguiente()
{
	var i = imgActual + 1;
	if (imagenes[i])
		ver_imagen(imagenes[i].id);
	else
		window.alert('No hay más imágenes');
}

function quitar_imagen()
{
	var fondo_imagenes = document.getElementById('fondo_imagenes');
	var capa_imagenes = document.getElementById('imagenes');
	capa_imagenes.style.display = 'none';
	fondo_imagenes.style.display = 'none';
	imgActual = null;
}