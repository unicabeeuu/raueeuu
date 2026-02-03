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
			//btnprocesar();
		}
		$("#res").html("");
	});
	
	$("#selgra1").change(function() {
		var gra = $("#selgra1").val();
		if(gra == "NA") {
			$("#submit").hide("");
		}
		else {
		    var pen = $("#selpen1").val();
    		if(pen == "NA") {
    			$("#submit").hide("");
    		}
    		else {
    		    $("#submit").show("");
    		}
		}
		cargarpen_act_mood(gra);
	});
	
	$("#selpen1").change(function() {
		var pen = $("#selpen1").val();
		if(pen == "NA") {
			$("#submit").hide("");
		}
		else {
		    var gra = $("#selgra1").val();
    		if(gra == "NA") {
    			$("#submit").hide("");
    		}
    		else {
    		    $("#submit").show("");
    		}
		}
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
	
	$("#selpg").change(function() {
		var pg = $("#selpg").val();
		cargarparam();
		$("#selparam").html("");
		if(pg == 0) {
		    $("#buscar").hide();
		    $("#btnbuscar").hide();
		}
	});
	
	$("#selparam").change(function() {
		var vparam = $("#selparam").val();
		/*var texto = $("select[name='selparam'] option:selected").text();
		var op = texto.substring(9, 11); 
		alert(op);*/
		if(vparam == "NA") {
		    $("#buscar").hide();
		    $("#btnbuscar").hide();
		}
		else {
		    $("#buscar").show();
		    $("#btnbuscar").show();
		    $("#buscar").val(vparam);
		}
		var texto = $("select[name='selparam'] option:selected").text();
        var op = texto.substring(9, 11);
        $("#op").val(op);
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
function cargarparam() {
    $.ajax({
		type:"POST",
		url:"param_upddat1.php",
		data:"param=" + $("#selpg").val(),
		success:function(r) {
		    //alert(r);
			$("#selparam").html(r);
		}
	});
}
function cargarpen_act_mood(gra) {
	$.ajax({
		type:"POST",
		url:"cargarpen_act_mood.php",
		data:"idgra=" + $("#selgra1").val(),
		success:function(r) {
			$("#selpen1").html(r);
		}
	});
}