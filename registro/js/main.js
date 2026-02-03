function Validar(){
	var contrasena, cadena;
	cadena="/[az]/";
	contrasena=document.getElementById("pass").value;

	if (contrasena==="") {
		alert("campo ");
		return false;
	}else if (cadena.test(contrasena)) {
		alert("incorrecto");
		return false;
	}

}
