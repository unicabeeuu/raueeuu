function tomarImagenPorSeccion(div,nombre) {

	html2canvas(document.querySelector("#" + div)).then(canvas => {
		var img = canvas.toDataURL('image/png', 1.0);
		console.log(img);
		base = "img=" + img + "&nombre=" + nombre;

		$.ajax({
			type:"POST",
			url:"../../servicios/crear_imagenes1.php",
			data:base,
			success:function(respuesta) {	
				respuesta = parseInt(respuesta);
				if (respuesta > 0) {
					alert("Imagen creada con exito!");
				} else {
					alert("No se pudo crear la imagen :(");
				}
			}
		});
	});	
}