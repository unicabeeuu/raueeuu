<?php
session_start();
include "php/conexion.php";

    $tabla = $_REQUEST['tabla'];
    $estado = $_REQUEST['estado'];
    
if (isset($_SESSION['unisuper']) || isset($_SESSION['uniprofe'])) {
    $sql="SELECT * FROM tbl_empleados WHERE email='".$_SESSION['uniprofe']."' OR email='".$_SESSION['unisuper']."'";
	$res=mysqli_query($conexion,$sql);

	while ($fila = mysqli_fetch_array($res)){
                      
	  	$id = $fila['id'];
		$apellidos  = $fila['apellidos'];
		$nombres = $fila['nombres'];
		$email_institucional = $fila['email'];
		$director=$fila['d_pensamiento'];
		$n_documento = $fila['n_documento'];
		$password = $fila['pc'];
		$perfil = $fila['perfil'];
	}
	
	//Se cargan las tablas de cargos, dependencias, profesiones y tipos de documento
	$sql_c = "SELECT * FROM tbl_cargos";
	$sel_c = mysqli_query($conexion,$sql_c);
	$sel_c1 = mysqli_query($conexion,$sql_c);
	
	$sql_d = "SELECT * FROM tbl_dependencias";
	$sel_d = mysqli_query($conexion,$sql_d);
	$sel_d1 = mysqli_query($conexion,$sql_d);
	
	$sql_p = "SELECT * FROM tbl_profesiones";
	$sel_p = mysqli_query($conexion,$sql_p);
	$sel_p1 = mysqli_query($conexion,$sql_p);
	
	$sql_td = "SELECT * FROM tbl_tipos_documento";
	$sel_td = mysqli_query($conexion,$sql_td);
	$sel_td1 = mysqli_query($conexion,$sql_td);
    
?>
<!DOCTYPE HTML>
<html lang="es">
<head><meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>Unicab Registro Académico</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

 <!-- Favicon -->
<link rel="shortcut icon" href="../images/favicon.png" />
<!-- // Favicon -->
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<link rel="stylesheet" href="../docenteunicab/updreg/sogap/chosen/chosen.css">
<link rel="stylesheet" href="../docenteunicab/updreg/sogap/chosen/ImageSelect.css">
<!--<link rel="stylesheet" href="../docenteunicab/updreg/sogap/chosen/bootstrap.min.css" >-->

<!-- Bootstrap Core CSS  -->
<link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />

<!-- Custom CSS -->
<link href="../css/style.css" rel='stylesheet' type='text/css' />

<!-- font-awesome icons CSS -->
<link href="../css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons CSS-->

<!-- side nav css file -->
<link href='../css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
<!-- //side nav css file -->
 <!-- js-->
<!--<script src="../js/jquery-1.11.1.min.js"></script>-->
<script type="text/javascript" src="../docenteunicab/updreg/sogap/js/jquery.min.js"></script>
<script src="../js/modernizr.custom.js"></script>

<script type="text/javascript" src="../docenteunicab/updreg/sogap/js/chosen.jquery.js"></script>
<script type="text/javascript" src="../docenteunicab/updreg/sogap/js/ImageSelect.jquery.js"></script>
<!--<script type="text/javascript" src="../docenteunicab/updreg/sogap/js/bootstrap.js"></script>-->
<script src="../js/bootstrap.js"> </script>

<!--webfonts-->
<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<!--//webfonts--> 

<!--css tabla -->
<link href="../css/jquery.dataTables.min.css" rel="stylesheet"> 
<!-- // css tabla -->

<!-- Metis Menu -->
<script src="../js/metisMenu.min.js"></script>
<script src="../js/custom.js"></script>
<link href="../css/custom.css" rel="stylesheet">
<!--//Metis Menu -->
<style>
    #chartdiv {
      width: 100%;
      height: 295px;
    }
    
    #divtabla {
        overflow:scroll;
        height:200px;
        width:800px;
    }
    
    #divtabla table {
        width:800px
    }
    .form-controlxx {
        background-color: lightgray;
        width: 50px;
    }
</style>
    <script>
        $(function() {
            cargar_datos();
            var tabla = $("#txttabla").val();
            
            $("#seloper").change(function() {
                //$("#search").val("");
                
                if(tabla == "tbl_empleados") {
                    $("td:nth-child(8)").hide();
                }
                else if(tabla == "estudiantes") {
                    $("td:nth-child(7)").hide();
                }
                else {
                    $("td:nth-child(3)").hide();
                }
                
                $("#btnadd").hide();
                
                var oper = $("#seloper").val();
                
        		if(oper == "NA") {
        			if(tabla == "tbl_empleados") {
                        $("td:nth-child(8)").hide();
                    }
                    else if(tabla == "estudiantes") {
                        $("td:nth-child(7)").hide();
                    }
                    else {
                        $("td:nth-child(3)").hide();
                    }
        		}
        		else if(oper == "MODIFICAR") {
        			if(tabla == "tbl_empleados") {
                        $("td:nth-child(8)").show();
                    }
                    else if(tabla == "estudiantes") {
                        $("td:nth-child(7)").show();
                    }
                    else {
                        $("td:nth-child(3)").show();
                    }
        		}
        		else {
        		    if(tabla == "tbl_empleados") {
                        $("td:nth-child(8)").hide();
                    }
                    else if(tabla == "estudiantes") {
                        $("td:nth-child(7)").hide();
                    }
                    else {
                        $("td:nth-child(3)").hide();
                    }
        		    //$("#btnadd").show();
        		    
        		    if(tabla == "tbl_cargos") {
        		        $("#modal_cargos_add").modal("show");
        		    }
        		    else if(tabla == "tbl_dependencias") {
        		        $("#modal_depen_add").modal("show");
        		    }
        		    else if(tabla == "tbl_profesiones") {
        		        $("#modal_prof_add").modal("show");
        		    }
        		    else if(tabla == "tbl_tipos_documento") {
        		        $("#modal_td_add").modal("show");
        		    }
        		    else if(tabla == "tbl_empleados") {
        		        $("#modal_emp_add").modal("show");
        		    }
        		}
        		
        	});
        	
        	$("#seldepenupd").change(function() {
        	    if($("#seldepenupd").val() == "NA") {
        	        $("#seldepenupdv").val("1");
        	    }
        	    else {
        	        $("#seldepenupdv").val("0");
        	    }
        	    validar_campos_upd(tabla);
        	});
        	
        	$("#selcargoupd").change(function() {
        	    if($("#selcargoupd").val() == "NA") {
        	        $("#selcargoupdv").val("1");
        	    }
        	    else {
        	        $("#selcargoupdv").val("0");
        	    }
        	    validar_campos_upd(tabla);
        	});
        	
        	$("#selprofupd").change(function() {
        	    if($("#selprofupd").val() == "NA") {
        	        $("#selprofupdv").val("1");
        	    }
        	    else {
        	        $("#selprofupdv").val("0");
        	    }
        	    validar_campos_upd(tabla);
        	});
        	
        	$("#seltdupd").change(function() {
        	    if($("#seltdupd").val() == "NA") {
        	        $("#seltdupdv").val("1");
        	    }
        	    else {
        	        $("#seltdupdv").val("0");
        	    }
        	    validar_campos_upd(tabla);
        	});
        	
        	$("#seldepenput").change(function() {
        	    if($("#seldepenput").val() == "NA") {
        	        $("#seldepenputv").val("1");
        	    }
        	    else {
        	        $("#seldepenputv").val("0");
        	    }
        	    validar_campos_put(tabla);
        	});
        	
        	$("#selcargoput").change(function() {
        	    if($("#selcargoput").val() == "NA") {
        	        $("#selcargoputv").val("1");
        	    }
        	    else {
        	        $("#selcargoputv").val("0");
        	    }
        	    validar_campos_put(tabla);
        	});
        	
        	$("#selprofput").change(function() {
        	    if($("#selprofput").val() == "NA") {
        	        $("#selprofputv").val("1");
        	    }
        	    else {
        	        $("#selprofputv").val("0");
        	    }
        	    validar_campos_put(tabla);
        	});
        	
        	$("#seltdput").change(function() {
        	    if($("#seltdput").val() == "NA") {
        	        $("#seltdputv").val("1");
        	    }
        	    else {
        	        $("#seltdputv").val("0");
        	    }
        	    validar_campos_put(tabla);
        	});
            
            $("#search").keyup(function(){
                _this = this;
                // Show only matching TR, hide rest of them
                $.each($("#tbldatos tbody tr"), function() {
                    //alert ($(this).text());
                    if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                        $(this).hide();
                    else
                        $(this).show();
                });
            });
        });
        
        function cargar_datos() {
            //alert ("hola");
            var tabla = $("#txttabla").val();
            var estado = $("#txtestado").val();
            $("#search").val("");
            
            $.ajax({
        		type:"POST",
        		url:"cargar_tbl_param_getdat.php",
        		data:"tabla=" + $("#txttabla").val() + "&estado=" + $("#txtestado").val(),
        		success:function(r) {
        		    //alert (r);
        		    $("#search").show();
        		    $("#divtabla").html(r);
        			//$("#tbodyact").html(r);
        			var oper = $("#seloper").val();
        			if(oper == "MODIFICAR") {
        			    //$("td:nth-child(3)").show();
        			    if(tabla == "tbl_empleados") {
                            $("td:nth-child(8)").show();
                        }
                        else if(tabla == "estudiantes") {
                            $("td:nth-child(7)").show();
                        }
                        else {
                            $("td:nth-child(3)").show();
                        }
        			}
        			else {
        			    //$("td:nth-child(3)").hide();
        			    if(tabla == "tbl_empleados") {
                            $("td:nth-child(8)").hide();
                        }
                        else if(tabla == "estudiantes") {
                            $("td:nth-child(7)").hide();
                        }
                        else {
                            $("td:nth-child(3)").hide();
                        }
        			}

        		}
        	});
        }
        
        function enviardat_c(id, cargo) {
            //alert (idact);
            $("#txtidupd").val(id);
            $("#txtcargoupd").val(cargo);
        }
        
        function enviardat_d(id, depen) {
            //alert (idact);
            $("#txtid_d_upd").val(id);
            $("#txtdepenupd").val(depen);
        }
        
        function enviardat_p(id, prof) {
            //alert (idact);
            $("#txtid_p_upd").val(id);
            $("#txtprofupd").val(prof);
        }
        
        function enviardat_td(id, td) {
            //alert (idact);
            $("#txtid_td_upd").val(id);
            $("#txttdupd").val(td);
        }
        
        function enviardat_emp(id, nombres, apellidos, email, pc, n_d, depen, skype, cel, cargo, prof, n_c, rh) {
            //alert (idact);
            $("#txtid_emp_upd").val(id);
            $("#txtnomupd").val(nombres);
            $("#txtapeupd").val(apellidos);
            $("#txtemailupd").val(email);
            $("#txtpassupd").val(pc);
            $("#txtpcupd").val(pc);
            $("#txtndocupd").val(n_d);
            //$("#seldepenupd").val(depen);
            $("#txtskypeupd").val(skype);
            $("#txtcelupd").val(cel);
            //$("#selcargoupd").val(cargo);
            //$("#selprofupd").val(prof);
            $("#txtnomcupd").val(n_c);
            $("#txtrhupd").val(rh);
            
            $("#seldepenupd").val(depen);
            $("#selcargoupd").val(cargo);
            $("#selprofupd").val(prof);
            
            $("#txtnomupdv").val("0");
            $("#txtapeupdv").val("0");
            $("#txtemailupdv").val("0");
            $("#seldepenupdv").val("0");
            $("#txtskypeupdv").val("0");
            $("#txtcelupdv").val("0");
            $("#selcargoupdv").val("0");
            $("#selprofupdv").val("0");
            $("#txtnomcupdv").val("0");
            $("#txtrhupdv").val("0");
            
            $(".alert-danger").hide();
            validar_campos_upd("tbl_empleados");
        }
        
        function updcargo() {
            var datos = "id=" + $("#txtidupd").val() + "&cargo=" + $("#txtcargoupd").val();
            var cargo = $("#txtcargoupd").val();
            cargo = cargo.replace(" ","_");
        	//alert(datos);
        	
            $.ajax({
        		type:"POST",
        		url:"cargo_upddat.php",
        		data:"id=" + $("#txtidupd").val() + "&cargo=" + cargo,
        		success:function(r) {
        		    if(r > 0) {
            		    $("#divtabla").empty();
            		    cargar_datos();
        		    }
        		}
        	});
        	
        	//$("#seloper option[value='NA']").attr("selected",true);
        	//$("#seloper").val("NA");
        	//$("td:nth-child(3)").hide();
        	//location.reload();
        }
        
        function putcargo() {
            var datos = "id=" + $("#txtidput").val() + "&cargo=" + $("#txtcargoput").val();
            var cargo = $("#txtcargoput").val();
            cargo = cargo.replace(" ","_");
        	//alert(datos);
        	
            $.ajax({
        		type:"POST",
        		url:"cargo_putdat.php",
        		data:"cargo=" + cargo,
        		success:function(r) {
        		    if(r > 0) {
            		    //$("#divtabla").empty();
            		    //cargar_datos();
            		    tabla = $("#txttabla").val();
        	            validar_put(cargo,'cargo',tabla);
        		    }
        		}
        	});
        	//location.reload();
        	//tabla = $("#txttabla").val();
        	//validar_put(cargo,'cargo',tabla);
        }
        
        function upddepen() {
            var datos = "id=" + $("#txtid_d_upd").val() + "&depen=" + $("#txtdepenupd").val();
            var depen = $("#txtdepenupd").val();
            depen = depen.replace(" ","_");
        	//alert(datos);
        	
            $.ajax({
        		type:"POST",
        		url:"depen_upddat.php",
        		data:"id=" + $("#txtid_d_upd").val() + "&depen=" + depen,
        		success:function(r) {
        		    if(r > 0) {
            		    $("#divtabla").empty();
            		    cargar_datos();
        		    }
        		}
        	});
        }
        
        function putdepen() {
            var datos = "id=" + $("#txtid_d_put").val() + "&cargo=" + $("#txtdepenput").val();
            var depen = $("#txtdepenput").val();
            depen = depen.replace(" ","_");
        	//alert(datos);
        	
            $.ajax({
        		type:"POST",
        		url:"depen_putdat.php",
        		data:"depen=" + depen,
        		success:function(r) {
        		    if(r > 0) {
            		    //$("#divtabla").empty();
            		    //cargar_datos();
            		    tabla = $("#txttabla").val();
        	            validar_put(depen,'dependencia',tabla);
        		    }
        		}
        	});
        }
        
        function updprof() {
            var datos = "id=" + $("#txtid_p_upd").val() + "&prof=" + $("#txtprofupd").val();
            var prof = $("#txtprofupd").val();
            prof = prof.replace(" ","_");
        	//alert(datos);
        	
            $.ajax({
        		type:"POST",
        		url:"prof_upddat.php",
        		data:"id=" + $("#txtid_p_upd").val() + "&prof=" + prof,
        		success:function(r) {
        		    if(r > 0) {
            		    $("#divtabla").empty();
            		    cargar_datos();
        		    }
        		}
        	});
        }
        
        function putprof() {
            var datos = "id=" + $("#txtid_p_put").val() + "&prof=" + $("#txtprofput").val();
            var prof = $("#txtprofput").val();
            prof = prof.replace(" ","_");
        	//alert(datos);
        	
            $.ajax({
        		type:"POST",
        		url:"prof_putdat.php",
        		data:"prof=" + prof,
        		success:function(r) {
        		    if(r > 0) {
            		    //$("#divtabla").empty();
            		    //cargar_datos();
            		    tabla = $("#txttabla").val();
        	            validar_put(prof,'profesion',tabla);
        		    }
        		}
        	});
        }
        
        function updtd() {
            //alert ("TD");
            var datos = "id=" + $("#txtid_td_upd").val() + "&td=" + $("#txttdupd").val();
            var td = $("#txttdupd").val();
            td = td.replace(" ","_");
        	//alert(datos);
        	
            $.ajax({
        		type:"POST",
        		url:"td_upddat.php",
        		data:"id=" + $("#txtid_td_upd").val() + "&td=" + td,
        		success:function(r) {
        		    if(r > 0) {
            		    $("#divtabla").empty();
            		    cargar_datos();
        		    }
        		}
        	});
        }
        
        function puttd() {
            var datos = "id=" + $("#txtid_td_put").val() + "&td=" + $("#txttdput").val();
            var td = $("#txttdput").val();
            td = td.replace(" ","_");
        	//alert(datos);
        	
            $.ajax({
        		type:"POST",
        		url:"td_putdat.php",
        		data:"td=" + td,
        		success:function(r) {
        		    if(r > 0) {
            		    //$("#divtabla").empty();
            		    //cargar_datos();
            		    tabla = $("#txttabla").val();
        	            validar_put(td,'tipo_documento',tabla);
        		    }
        		}
        	});
        }
        
        function updemp() {
            var datos = "id=" + $("#txtid_p_upd").val() + "&prof=" + $("#txtprofupd").val();
            var nom = $("#txtnomupd").val();
            nom = nom.replace(" ","_");
            var ape = $("#txtapeupd").val();
            ape = ape.replace(" ","_");
            var depen = $("#seldepenupd").val();
            depen = depen.replace(" ","_");
            var cargo = $("#selcargoupd").val();
            cargo = cargo.replace(" ","_");
            var prof = $("#selprofupd").val();
            prof = prof.replace(" ","_");
            var nomc = $("#txtnomcupd").val();
            nomc = nomc.replace(" ","_");
            var rh = $("#txtrhupd").val();
            rh = rh.replace(" ","_");
            rh = rh.replace("+","zzz");
        	//alert(rh);
        	
        	var dataf = "id=" + $("#txtid_emp_upd").val() + "&nom=" + nom + "&ape=" + ape + "&email=" + $("#txtemailupd").val() + "&pc=" + $("#txtpassupd").val() 
        		+ "&pc1=" + $("#txtpcupd").val() + "&depen=" + $("#seldepenupd").val() + "&skype=" + $("#txtskypeupd").val() + "&cel=" + $("#txtcelupd").val() 
        		+ "&cargo=" + $("#selcargoupd").val() + "&prof=" + $("#selprofupd").val() + "&nomc=" + nomc + "&rh=" + rh;
        	//alert(dataf);
        	
            $.ajax({
        		type:"POST",
        		url:"emp_upddat.php",
        		data:"id=" + $("#txtid_emp_upd").val() + "&nom=" + nom + "&ape=" + ape + "&email=" + $("#txtemailupd").val() + "&pc=" + $("#txtpassupd").val() 
        		+ "&pc1=" + $("#txtpcupd").val() + "&depen=" + $("#seldepenupd").val() + "&skype=" + $("#txtskypeupd").val() + "&cel=" + $("#txtcelupd").val() 
        		+ "&cargo=" + $("#selcargoupd").val() + "&prof=" + $("#selprofupd").val() + "&nomc=" + nomc + "&rh=" + rh,
        		success:function(r) {
        		    if(r > 0) {
            		    $("#divtabla").empty();
            		    cargar_datos();
        		    }
        		    //alert(r);
        		}
        	});
        }
        
        function putemp() {
            var datos = "id=" + $("#txtid_emp_put").val();
            var nom = $("#txtnomput").val();
            nom = nom.replace(" ","_");
            var ape = $("#txtapeput").val();
            ape = ape.replace(" ","_");
            var depen = $("#seldepenput").val();
            depen = depen.replace(" ","_");
            var cargo = $("#selcargoput").val();
            cargo = cargo.replace(" ","_");
            var prof = $("#selprofput").val();
            prof = prof.replace(" ","_");
            var nomc = $("#txtnomcput").val();
            nomc = nomc.replace(" ","_");
            ndoc = $("#txtndocput").val();
            var rh = $("#txtrhput").val();
            rh = rh.replace(" ","_");
            rh = rh.replace("+","zzz");
        	//alert(rh);
        	
            $.ajax({
        		type:"POST",
        		url:"emp_putdat.php",
        		data:"id=" + $("#txtid_emp_put").val() + "&nom=" + nom + "&ape=" + ape + "&email=" + $("#txtemailput").val() + "&pc=" + $("#txtpassput").val() 
        		+ "&ndoc=" + $("#txtndocput").val() + "&depen=" + $("#seldepenput").val() + "&skype=" + $("#txtskypeput").val() + "&cel=" + $("#txtcelput").val() 
        		+ "&cargo=" + $("#selcargoput").val() + "&prof=" + $("#selprofput").val() + "&nomc=" + nomc + "&rh=" + rh,
        		success:function(r) {
        		    if(r > 0) {
            		    //$("#divtabla").empty();
            		    //cargar_datos();
            		    tabla = $("#txttabla").val();
        	            validar_put(ndoc,'n_documento',tabla);
        		    }
        		}
        	});
        }
        
        function validar_put(valor, campo, tabla) {
            //alert("hola");
            $.ajax({
        		type:"POST",
        		url:"validar_putdat.php",
        		data:"valor=" + valor + "&campo=" + campo + "&tabla=" + tabla,
        		success:function(r) {
        		    //alert(r);
        		    if(r > 0) {
        		        location.reload();
        		    }
        		}
        	});
        }
        
        function validar_email(input) {
            var input_email = document.getElementById(input);
            var input_email_val = document.getElementById(input).value;
            var control = input + "v";
            //alert (input_email_val);
            var patron = /^[_-\w.]+@[a-z]+\.[a-z]{2,5}$/;
            //var esCoincidente = patron.test(document.getElementById("email2").value);
            //var esCoincidente = patron.test($("#email").val());
            var esCoincidente = patron.test(input_email_val);
            if(esCoincidente) {
                input_email.setCustomValidity("");
                $(".alert-danger").html("");
                $(".alert-danger").hide();
                document.getElementById(control).value = 0;
            }
            else {
                input_email.setCustomValidity("El email no tiene el formato correcto");
                $(".alert-danger").html("El email no tiene el formato correcto").css("color","red");
                $(".alert-danger").show();
                document.getElementById(control).value = 1;
            }
            var tabla = $("#txttabla").val();
            validar_campos_upd(tabla);
            validar_campos_put(tabla);
        }
        
        function validar_texto(input, campo) {
            var input_texto = document.getElementById(input);
            var input_texto_val = document.getElementById(input).value;
            var control = input + "v";
            var patron = /^[\w]{1,100}$/;
            var esCoincidente = patron.test(input_texto_val);
            
            if(esCoincidente) {
                input_texto.setCustomValidity("");
                $(".alert-danger").html("");
                $(".alert-danger").hide();
                document.getElementById(control).value = 0;
            }
            else {
                input_texto.setCustomValidity("El campo no tiene el formato correcto");
                $(".alert-danger").html("El campo " + campo + " no tiene el formato correcto").css("color","red");
                $(".alert-danger").show();
                document.getElementById(control).value = 1;
            }
            var tabla = $("#txttabla").val();
            validar_campos_upd(tabla);
            validar_campos_put(tabla);
        }
        
        function validar_numero(input, campo) {
            var input_numero = document.getElementById(input);
            var input_numero_val = document.getElementById(input).value;
            var control = input + "v";
            var patron = /^[0-9]{1,15}$/;
            var esCoincidente = patron.test(input_numero_val);
            
            if(esCoincidente) {
                input_numero.setCustomValidity("");
                $(".alert-danger").html("");
                $(".alert-danger").hide();
                document.getElementById(control).value = 0;
            }
            else {
                input_numero.setCustomValidity("El campo no tiene el formato correcto");
                $(".alert-danger").html("El campo " + campo + " no tiene el formato correcto").css("color","red");
                $(".alert-danger").show();
                document.getElementById(control).value = 1;
            }
            var tabla = $("#txttabla").val();
            validar_campos_upd(tabla);
            validar_campos_put(tabla);
        }
        
        function validar_texto1(input, campo) {
            var input_texto = document.getElementById(input);
            var input_texto_val = document.getElementById(input).value;
            var control = input + "v";
            var patron = /^[_-\w. +]{1,100}$/;
            var esCoincidente = patron.test(input_texto_val);
            
            if(esCoincidente) {
                input_texto.setCustomValidity("");
                $(".alert-danger").html("");
                $(".alert-danger").hide();
                document.getElementById(control).value = 0;
            }
            else {
                input_texto.setCustomValidity("El campo no tiene el formato correcto");
                $(".alert-danger").html("El campo " + campo + " no tiene el formato correcto").css("color","red");
                $(".alert-danger").show();
                document.getElementById(control).value = 1;
            }
            var tabla = $("#txttabla").val();
            validar_campos_upd(tabla);
            validar_campos_put(tabla);
        }
        
        function validar_celular(input, campo) {
            var input_texto = document.getElementById(input);
            var input_texto_val = document.getElementById(input).value;
            var control = input + "v";
            var patron = /^[0-9]{3}\s[0-9]{3}\s[0-9]{4}$/;
            var esCoincidente = patron.test(input_texto_val);
            
            if(esCoincidente) {
                input_texto.setCustomValidity("");
                $(".alert-danger").html("");
                $(".alert-danger").hide();
                document.getElementById(control).value = 0;
            }
            else {
                input_texto.setCustomValidity("El campo no tiene el formato correcto");
                $(".alert-danger").html("El campo " + campo + " no tiene el formato correcto").css("color","red");
                $(".alert-danger").show();
                document.getElementById(control).value = 1;
            }
            var tabla = $("#txttabla").val();
            validar_campos_upd(tabla);
            validar_campos_put(tabla);
        }
        
        function validar_campos_upd(tabla) {
            if(tabla == "tbl_empleados") {
                var suma = parseInt($("#txtnomupdv").val()) + parseInt($("#txtapeupdv").val()) + parseInt($("#txtemailupdv").val()) + parseInt($("#seldepenupdv").val()) +
                    parseInt($("#txtskypeupdv").val()) + parseInt($("#txtcelupdv").val()) + parseInt($("#selcargoupdv").val()) +
                    parseInt($("#selprofupdv").val()) + parseInt($("#txtnomcupdv").val());
                //alert (suma);
                if(suma > 0) {
                    $("#btnupdemp").hide();
                }
                else {
                    $("#btnupdemp").show();
                }
            }
        }
        
        function validar_campos_put(tabla) {
            if(tabla == "tbl_empleados") {
                var suma = parseInt($("#txtnomputv").val()) + parseInt($("#txtapeputv").val()) + parseInt($("#txtemailputv").val()) + parseInt($("#seldepenputv").val()) +
                    parseInt($("#txtskypeputv").val()) + parseInt($("#txtcelputv").val()) + parseInt($("#selcargoputv").val()) +
                    parseInt($("#selprofputv").val()) + parseInt($("#txtnomcputv").val()) + parseInt($("#txtndocputv").val());
                if(suma > 0) {
                    $("#btnputemp").hide();
                }
                else {
                    $("#btnputemp").show();
                }
            }
        }
    </script>
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		
		<?php 
		    if($perfil == "SU" || $perfil == "AR" || $perfil == "AR_AW") {
		    //if($id == 18 ) {
		        require 'menu_registro.php';
		    }
		    else {
		        require 'menu.php';
		    }
		?>
		<!--left-fixed -navigation-->
		
		<!-- header-starts -->
		<?php require 'header.php';  ?>
		<!-- //header-ends -->
		
		<!-- modal -->
		<section>
			<?php require 'modal.php';  ?>
		</section>
		<!-- modal -->
		
		<!-- main content start-->
        <section>
           	<div id="page-wrapper">
           		<div class="charts">		
           		 	<div class="mid-content-top charts-grids">	
                    	<div class="middle-content">
                    		<div class="form-group"> 
                    			<div class="form-body">
                    			    <fieldset>
                    				<legend class="alert alert-info" role="alert"><h3>ADMINISTRACION DE <?php echo strtoupper($tabla); ?></h3></legend>
                    				    <!--<form class="form-horizontal" action="act_moodle_getdat1.php"  method="POST" target="_blank" onsubmit="return validacion()">-->
                    					<select id="seloper" name="seloper" class="my-select" style="color: white;">
                    					    <option selected="selected" data-img-src="../docenteunicab/updreg/img/sel.png" value="NA">SO</option>
                                			<option data-img-src="../docenteunicab/updreg/img/add.png" value="AGREGAR">ADD</option>
                                			<option data-img-src="../docenteunicab/updreg/img/upd1.png" value="MODIFICAR">UPD</option>
                                		</select>
                                		<!--<img src="../docenteunicab/updreg/img/agregar0.png"></img>-->
                    					<!--</form>-->
                    				</fieldset><br/>
                    				<input type='search' placeholder='Ingrese texto a buscar' id='search' name='search' style="display: none;"><br/><br/>
                    			    <div id="divtabla">
        							</div>
        							<!--<button class="btn btn-primary" id="btnadd" style="display: none;">Agregar</button>
                        			<button class="btn btn-warning" >Modificar</button>-->
								</div>
								<input type="hidden" id="txttabla" name="txttabla" value="<?php echo $tabla; ?>"/>
								<input type="hidden" id="txtestado" name="txtestado" value="<?php echo $estado; ?>"/>
              		 		</div>
            			</div>
           			</div>
       			</div>	
       		</div>
		</section>
	<!--footer-->
	<?php require 'footer.php'; ?>
    <!--//footer-->
	</div>
	
	<!-- ******************************************************************************************************************************** -->
	<!-- Modal de edición tbl_cargos  -->
    <div class="modal fade" id="modal_cargos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">MODIFICAR REGISTRO <?php echo strtoupper($tabla); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label>ID</label>
            <input type="text" id="txtidupd" class="form-control" readonly/>
            <label>CARGO</label>
            <input type="text" id="txtcargoupd" class="form-control" />
            <!--<input type="text" id="txtcomputar" class="form-control" oninput="validacomputar()"/>
            <label id="lblval"></label>-->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-warning" id="btnupdcargo" data-dismiss="modal" onclick="updcargo()">Guardar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal de insertar tbl_cargos  -->
    <div class="modal fade" id="modal_cargos_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">NUEVO REGISTRO <?php echo strtoupper($tabla); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label>ID</label>
            <input type="text" id="txtidput" class="form-control" readonly/>
            <label>CARGO</label>
            <input type="text" id="txtcargoput" class="form-control" />
            <!--<input type="text" id="txtcomputar" class="form-control" oninput="validacomputar()"/>
            <label id="lblval"></label>-->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-warning" id="btncartoput" data-dismiss="modal" onclick="putcargo()">Guardar</button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- ******************************************************************************************************************************** -->
	<!-- Modal de edición tbl_dependencias  -->
    <div class="modal fade" id="modal_depen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">MODIFICAR REGISTRO <?php echo strtoupper($tabla); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label>ID</label>
            <input type="text" id="txtid_d_upd" class="form-control" readonly/>
            <label>DEPENDENCIA</label>
            <input type="text" id="txtdepenupd" class="form-control" />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-warning" id="btnupddepen" data-dismiss="modal" onclick="upddepen()">Guardar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal de insertar tbl_dependencias  -->
    <div class="modal fade" id="modal_depen_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">NUEVO REGISTRO <?php echo strtoupper($tabla); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label>ID</label>
            <input type="text" id="txtid_d_put" class="form-control" readonly/>
            <label>DEPENDENCIA</label>
            <input type="text" id="txtdepenput" class="form-control" />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-warning" id="btnputdepen" data-dismiss="modal" onclick="putdepen()">Guardar</button>
          </div>
        </div>
      </div>
    </div>
	
	<!-- ******************************************************************************************************************************** -->
	<!-- Modal de edición tbl_profesiones  -->
    <div class="modal fade" id="modal_prof" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">MODIFICAR REGISTRO <?php echo strtoupper($tabla); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label>ID</label>
            <input type="text" id="txtid_p_upd" class="form-control" readonly/>
            <label>PROFESION</label>
            <input type="text" id="txtprofupd" class="form-control"/>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-warning" id="btnupdprof" data-dismiss="modal" onclick="updprof()">Guardar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal de insertar tbl_profesiones  -->
    <div class="modal fade" id="modal_prof_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">NUEVO REGISTRO <?php echo strtoupper($tabla); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label>ID</label>
            <input type="text" id="txtid_p_put" class="form-control" readonly/>
            <label>PROFESION</label>
            <input type="text" id="txtprofput" class="form-control" />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-warning" id="btnputprof" data-dismiss="modal" onclick="putprof()">Guardar</button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- ******************************************************************************************************************************** -->
	<!-- Modal de edición tbl_tipos_documento  -->
    <div class="modal fade" id="modal_td" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">MODIFICAR REGISTRO <?php echo strtoupper($tabla); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label>ID</label>
            <input type="text" id="txtid_td_upd" class="form-control" readonly/>
            <label>TIPO DOCUMENTO</label>
            <input type="text" id="txttdupd" class="form-control"/>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-warning" id="btnupdtd" data-dismiss="modal" onclick="updtd()">Guardar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal de insertar tbl_tipos_documento  -->
    <div class="modal fade" id="modal_td_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">NUEVO REGISTRO <?php echo strtoupper($tabla); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label>ID</label>
            <input type="text" id="txtid_td_put" class="form-control" readonly/>
            <label>TIPO DOCUMENTO</label>
            <input type="text" id="txttdput" class="form-control" />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-warning" id="btnputtd" data-dismiss="modal" onclick="puttd()">Guardar</button>
          </div>
        </div>
      </div>
    </div>
	
	<!-- ******************************************************************************************************************************** -->
	<!-- Modal de edición tbl_empleados  -->
    <div class="modal fade bs-example-modal-lg" id="modal_emp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">MODIFICAR REGISTRO <?php echo strtoupper($tabla); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <label>ID</label>
              <input type="text" id="txtid_emp_upd" class="form-control" readonly/>
              <label>NOMBRES</label><input type="hidden" id="txtnomupdv" value="1"/>
              <input type="text" id="txtnomupd" class="form-control" oninput="validar_texto('txtnomupd','nombres')"/>
              <label>APELLIDOS</label><input type="hidden" id="txtapeupdv" value="1"/>
              <input type="text" id="txtapeupd" class="form-control" oninput="validar_texto('txtapeupd','apellidos')"/>
              <label>EMAIL</label><input type="hidden" id="txtemailupdv" value="1"/>
              <input type="text" id="txtemailupd" class="form-control" oninput="validar_email('txtemailupd')"/>
              <label>PASSWORD</label>
              <input type="text" id="txtpassupd" class="form-control" />
              <label>N_DOCUMENTO</label>
              <input type="text" id="txtndocupd" class="form-control" readonly/>
              <label>DEPENDENCIA</label><input type="hidden" id="seldepenupdv" value="1"/>
              <select id="seldepenupd" class="form-control">
                <option value="NA">Seleccione dependencia</option>
                <?php  
                    while ($filad = mysqli_fetch_array($sel_d)){
                ?>
                        <option value="<?php echo $filad['dependencia']; ?>"><?php echo $filad['dependencia']; ?></option>
                <?php  
                    }
                ?>
              </select>
              <label>SKYPE</label><input type="hidden" id="txtskypeupdv" value="1"/>
              <input type="text" id="txtskypeupd" class="form-control" oninput="validar_texto1('txtskypeupd','skype')"/>
              <label>CELULAR</label><input type="hidden" id="txtcelupdv" value="1"/>
              <input type="text" id="txtcelupd" class="form-control" oninput="validar_celular('txtcelupd','celular')" placeholder="### ### ####"/>
              <label>CARGO</label><input type="hidden" id="selcargoupdv" value="1"/>
              <select id="selcargoupd" class="form-control">
                <option value="NA">Seleccione cargo</option>
                <?php  
                    while ($filac = mysqli_fetch_array($sel_c)){
                ?>
                        <option value="<?php echo $filac['cargo']; ?>"><?php echo $filac['cargo']; ?></option>
                <?php  
                    }
                ?>
              </select>
              <label>PROFESION</label><input type="hidden" id="selprofupdv" value="1"/>
              <select id="selprofupd" class="form-control">
                <option value="NA">Seleccione profesion</option>
                <?php  
                    while ($filap = mysqli_fetch_array($sel_p)){
                ?>
                        <option value="<?php echo $filap['profesion']; ?>"><?php echo $filap['profesion']; ?></option>
                <?php  
                    }
                ?>
              </select>
              <label>NOMBRE CORTO</label><input type="hidden" id="txtnomcupdv" value="1"/>
              <input type="text" id="txtnomcupd" class="form-control" oninput="validar_texto('txtnomcupd','nombre corto')"/>
              <label>RH</label><input type="hidden" id="txtrhupdv" value="1"/>
              <input type="text" id="txtrhupd" class="form-control" oninput="validar_texto1('txtrhupd','RH')"/>
          </div>
          <input type="hidden" id="txtpcupd"/>
          <label id="alertempupd" class="alert alert-danger"></label>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-warning" id="btnupdemp" data-dismiss="modal" onclick="updemp()" style="display: none;">Guardar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal de insertar tbl_empleados  -->
    <div class="modal fade bs-example-modal-lg" id="modal_emp_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">NUEVO REGISTRO <?php echo strtoupper($tabla); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label>ID</label>
            <input type="text" id="txtid_emp_put" class="form-control" readonly/>
            <label>NOMBRES</label><input type="hidden" id="txtnomputv" value="1"/>
            <input type="text" id="txtnomput" class="form-control" oninput="validar_texto('txtnomput','nombres')"/>
            <label>APELLIDOS</label><input type="hidden" id="txtapeputv" value="1"/>
            <input type="text" id="txtapeput" class="form-control" oninput="validar_texto('txtapeput','apellidos')"/>
            <label>EMAIL</label><input type="hidden" id="txtemailputv" value="0"/>
            <input type="text" id="txtemailput" class="form-control" oninput="validar_email('txtemailput')"/>
            <label>PASSWORD</label>
            <input type="text" id="txtpassput" class="form-control" />
            <label>N_DOCUMENTO</label><input type="hidden" id="txtndocputv" value="1"/>
            <input type="text" id="txtndocput" class="form-control" oninput="validar_numero('txtndocput','n_documento')"/>
            <label>DEPENDENCIA</label><input type="hidden" id="seldepenputv" value="1"/>
            <select id="seldepenput" class="form-control">
                <option value="NA">Seleccione dependencia</option>
                <?php  
                    while ($filad1 = mysqli_fetch_array($sel_d1)){
                ?>
                        <option value="<?php echo $filad1['dependencia']; ?>"><?php echo $filad1['dependencia']; ?></option>
                <?php  
                    }
                ?>
            </select>
            <label>SKYPE</label><input type="hidden" id="txtskypeputv" value="1"/>
            <input type="text" id="txtskypeput" class="form-control" oninput="validar_texto1('txtskypeput','skype')"/>
            <label>CELULAR</label><input type="hidden" id="txtcelputv" value="1"/>
            <input type="text" id="txtcelput" class="form-control" oninput="validar_celular('txtcelput','celular')"/>
            <label>CARGO</label><input type="hidden" id="selcargoputv" value="1"/>
            <select id="selcargoput" class="form-control">
                <option value="NA">Seleccione cargo</option>
                <?php  
                    while ($filac1 = mysqli_fetch_array($sel_c1)){
                ?>
                        <option value="<?php echo $filac1['cargo']; ?>"><?php echo $filac1['cargo']; ?></option>
                <?php  
                    }
                ?>
            </select>
            <label>PROFESION</label><input type="hidden" id="selprofputv" value="1"/>
            <select id="selprofput" class="form-control">
                <option value="NA">Seleccione profesion</option>
                <?php  
                    while ($filap1 = mysqli_fetch_array($sel_p1)){
                ?>
                        <option value="<?php echo $filap1['profesion']; ?>"><?php echo $filap1['profesion']; ?></option>
                <?php  
                    }
                ?>
            </select>
            <label>NOMBRE CORTO</label><input type="hidden" id="txtnomcputv" value="1"/>
            <input type="text" id="txtnomcput" class="form-control" oninput="validar_texto('txtnomcput','nombre corto')"/>
            <label>RH</label><input type="hidden" id="txtrhputv" value="1"/>
            <input type="text" id="txtrhput" class="form-control" oninput="validar_texto1('txtrhput','RH')"/>
          </div>
          <label id="alertempput" class="alert alert-danger"></label>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-warning" id="btnputemp" data-dismiss="modal" onclick="putemp()" style="display: none;">Guardar</button>
          </div>
        </div>
      </div>
    </div>
	
	<!-- Classie --><!-- for toggle left push menu script -->
		<script src="../js/classie.js"></script>
		<script>
			var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
				showLeftPush = document.getElementById( 'showLeftPush' ),
				body = document.body;
				
			showLeftPush.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( body, 'cbp-spmenu-push-toright' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				disableOther( 'showLeftPush' );
			};
			
			function disableOther( button ) {
				if( button !== 'showLeftPush' ) {
					classie.toggle( showLeftPush, 'disabled' );
				}
			}
		</script>
	<!-- //Classie --><!-- //for toggle left push menu script -->
		
	<!--scrolling js-->
	<script src="../js/jquery.nicescroll.js"></script>
	<script src="../js/scripts.js"></script>
	<!--//scrolling js-->
	
	<!-- side nav js -->
	<script src='../js/SidebarNav.min.js' type='text/javascript'></script>
	<script>
      $('.sidebar-menu').SidebarNav()
    </script>
	<!-- //side nav js -->

	<!-- Bootstrap Core JavaScript 
   <script src="../js/bootstrap.js"> </script>-->
	<!-- //Bootstrap Core JavaScript -->

	<!-- js tabla -->
	<script src="../js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
    	$('#listEstudiantes').DataTable();	
		} );
	</script>
	<!-- //js tabla -->
	
	<!-- Este c車digo es para el select con im芍genes -->
   	<script>
	    $(".my-select").chosen({width:"180px"});
	</script>
</body>
<?php 
}else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>