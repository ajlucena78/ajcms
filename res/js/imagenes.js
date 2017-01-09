function Imagen(imgOriginal, titulo, imgMini, id)
{
	this.id = id;
	this.imgOriginal = imgOriginal;
	this.titulo = titulo;
	this.imgMini = imgMini;
}

var imagenes = new Array();
var imgActual = null;
var img = null;
var visor_imagenes_abierto = false;

function ver_imagen(id, precarga)
{
	visor_imagenes_abierto = true;
	for (var i = 0; i < imagenes.length; i++)
	{
		if (imagenes[i].id == id)
		{
			imgActual = i;
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
			redim_imagen();
			break;
		}
	}
	if (!precarga)
	{
		if (i > 1)
		{
			var img1 = new Image();
			img1.src = imagenes[i - 1].imgOriginal;
		}
		if (i < imagenes.length - 1)
		{
			var img2 = new Image();
			img2.src = imagenes[i + 1].imgOriginal;
		}
	}
}

function redim_imagen()
{
	if (!img.width)
		setTimeout('redim_imagen();', 500);
	else
	{
		var imagen = document.getElementById('imagen');
		imagen.style.marginTop = '5px';
		if (img.height > 550)
			imagen.height = '550';
		else
		{
			imagen.height = img.height;
			if (img.height <  430)
				imagen.style.marginTop = '60px';
		}
		if (img.width > 740)
			imagen.width = '740';
		else
			imagen.width = img.width;
		var loading_image = document.getElementById('loading_image');
		loading_image.style.display = 'none';
		var titulo_img = document.getElementById('titulo_imagen');
		titulo_img.innerHTML = '<strong>' + (imgActual + 1) + '. </strong>';
		titulo_img.innerHTML += imagenes[imgActual].titulo;
		var capa_solo_imagen = document.getElementById('capa_solo_imagen');
		capa_solo_imagen.style.display = 'block';
	}
}

function ver_anterior()
{
	var i = imgActual - 1;
	if (imagenes[i])
		ver_imagen(imagenes[i].id);
}

function ver_siguiente()
{
	var i = imgActual + 1;
	if (imagenes[i])
		ver_imagen(imagenes[i].id);
}

function quitar_imagen()
{
	var fondo_imagenes = document.getElementById('fondo_imagenes');
	var capa_imagenes = document.getElementById('imagenes');
	capa_imagenes.style.display = 'none';
	fondo_imagenes.style.display = 'none';
	imgActual = null;
}

function mover_imagen(event)
{
	if (imgActual !== null)
	{
		var tecla = uni_key_code(event);
		switch (tecla)
		{
			case 37:
				ver_anterior();
				break;
			case 39:
				ver_siguiente();
				break;
			case 27:
				quitar_imagen();
		}
	}
}