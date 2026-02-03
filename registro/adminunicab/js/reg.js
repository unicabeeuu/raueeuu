$(document).ready(function() {
	//alert("Bienvenido");
	//cargargrados();
	
	$("#selpen").change(function() {
		cargargrados();
		var pen = $("#selpen").val();
		if(pen == "NA") {
			$("#divmostrar").html("");
			$("#divupd").html("");
		}
		$("#res").html("");
	});
	
	$("#selgra").change(function() {
		var gra = $("#selgra").val();
		if(gra == "NA") {
			$("#divmostrar").html("");
			$("#divupd").html("");
		}
		else {
			$("#divmostrar").html("");
			$("#divupd").html("");
			btnmostrardatos();
			btnprocesar();
		}
		$("#res").html("");
	});
	
	//Mostrar modal
	$("#mostrarmod").click(function(e) {
            e.preventDefault();
            var contenido=$(this).next("#modal");
            if(contenido.css("display")=="none"){
                contenido.slideDown(250);
                $(".temp").hide();
            }
            else {
                contenido.slideUp(250);
            }
	});

	//Cerrar modal
	$("#cerrarmod").click(function(e) {
            e.preventDefault();
            //var contenido=$(this).prev("#modal");
            var contenido=$("#modal");
            if(contenido.css("display")=="none"){
                contenido.slideDown(250);
            }
            else {
                contenido.slideUp(250);
                $(".temp").show();
            }
	});
});

function mr() {
	setTimeout("mostrar_resumen()",3000);
}
function mostrar_resumen() {
	document.getElementById("divgif").style.display = "none";
	document.getElementById("divres").style.display = "block";
	document.getElementById("btncargue").style.display = "block";
	//alert("listo");
}
function add_resumen(elemento) {
	 var u1 = document.getElementsByTagName("ul")[0];
	 var li1 = document.createElement("li");
	 li1.textContent = elemento;
	 u1.appendChild(li1);
}
function mr_putdat() {
	setTimeout("mostrar_resumen()",6000);
}
function cargargrados() {
	$.ajax({
		type:"POST",
		url:"pen_gra_upddat_s1.php",
		data:"pen=" + $("#selpen").val(),
		success:function(r) {
			$("#selgra").html(r);
		}
	});
}
function btnmostrardatos() {
	$.ajax({
		type:"POST",
		url:"pen_gra_upddat_s2.php",
		data:"pen=" + $("#selpen").val() + "&gra=" + $("#selgra").val(),
		success:function(r) {
			$("#divmostrar").html(r);
		}
	});
}
function btnprocesar() {
	$.ajax({
		type:"POST",
		url:"pen_gra_upddat_s3.php",
		data:"pen=" + $("#selpen").val() + "&gra=" + $("#selgra").val(),
		success:function(r) {
			$("#divupd").html(r);
		}
	});
}
function buscar_codigo() {
	$.ajax({
		type:"POST",
		url:"buscar_codigo.php",
		data:"identif=" + $("#buscar").val(),
		success:function(r) {
			$("#divresul").html(r);
		}
	});
}