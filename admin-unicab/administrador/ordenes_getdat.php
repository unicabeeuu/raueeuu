<?php 
	session_start();
	require "../php/conexion.php";
	require("1cc3s4db.php");
	header("Cache-Control: no-store");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	
if (isset($_SESSION['admin_unicab'])) {

	$sql="SELECT * FROM tbl_empleados WHERE email='".$_SESSION['admin_unicab']."'";
	$res=mysqli_query($conexion,$sql);

	while ($fila = mysqli_fetch_array($res)){
                      
	  	$id = $fila['id'];
		$apellidos  = $fila['apellidos'];
		$nombres = $fila['nombres'];
		$email_institucional = $fila['email'];
		$director=$fila['d_pensamiento'];
		$n_documento = $fila['n_documento'];
		$password = $fila['pc'];
		
    }
	
	$query = "SELECT * FROM equivalence_idgra";
    $resultado=$mysqli1->query($query);
    $resultado1=$mysqli1->query($query);
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Administrador - Web Unicab</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<link rel="shortcut icon" type="image/x-icon" href="../../images/fave-icon.png"/>
<!-- Bootstrap Core CSS -->
<link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />

<!-- Custom CSS -->
<link href="../css/style.css" rel='stylesheet' type='text/css' />

<!-- font-awesome icons CSS -->
<link href="../css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons CSS -->

 <!-- side nav css file -->
 <link href='../css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
 <!-- side nav css file -->
 
 <!-- js-->
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/modernizr.custom.js"></script>

<!--webfonts-->
<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<!--//webfonts--> 

    <!--css tabla -->
    <link href="../../registro/css/jquery.dataTables.min.css" rel="stylesheet"> 
    <!-- // css tabla -->
    
	<link rel="stylesheet" href="../../registro/docenteunicab/updreg/css/reg.css" />

<!-- Metis Menu -->
<script src="../js/metisMenu.min.js"></script>
<script src="../js/custom.js"></script>
<link href="../css/custom.css" rel="stylesheet">
<!--//Metis Menu -->

    <style>
        input[type=search] {
			border: none;
			border-bottom: 2px solid green;
			background-color: #A9F5BC;
		}
		thead {
		    background-color: lightgray;
		    font-weight: bold;
		    text-align: center;
		}
		tbody tr {
		    text-align: center;
		}
		
        #cont {
        	display: flex;
        	justify-content: space-around;
        }
        fieldset {
        	border: 2px double green;
        	-moz-border-radius: 8px;
        	-webkit-border-radius: 8px;	
        	border-radius: 8px;
        }
        legend {
        	 text-align: center;
        	 font-weight: bold;
        	 font-size: 18pt;
        	 color: #B4045F;
        	 text-shadow: 0px 0px 10px #BA55D3;
        }
        .mprincipal {
        	list-style-image: url("../images/m26.png");
        	font-weight: bold !important;
            font-size: 20px !important;
        }
        .msecund {
        	list-style-image: url(../images/bd30.png); 
        	background: lightgreen;
        	padding: 20px;
        	font-weight: bold;
        	font-size: 18px;
        }
        .msecund li {
        	background: #cce5ff;
        	margin-left: 20px;
        	margin-top: 5px;
        }
    </style>
    
    <script>
        $(function() {
            //alert("hola");
            $("#selgra1").change(function() {
                //alert("hola");
                $("#divtabla").empty();
                $("#search").hide();
                $("#idest").val("0");
                $("#submit1").hide("");
                
                var gra = $("#selgra1").val();
        		$("#lblgra").html("Grado = " + gra);
                
        		if(gra == "NA") {
        			$("#submit").hide("");
        			$("#idest").hide("");
        			$("#periodo").hide("");
        		}
        		else {
        		    //alert("mostrar");
        		    $("#submit").show("");
        		    $("#idest").show("");
        		    $("#periodo").show("");
        		}
        		//var selna = "NA";
        		//$("#selgra2 option[value='" + selna + "']").attr("selected",true);
        	});
        	
        	$("#selgra2").change(function() {
                $("#divtabla").empty();
                $("#search").hide();
                $("#idest").val("0");
                $("#submit").hide("");
                $("#idest").hide("");
                $("#periodo").hide("");
                
                var gra = $("#selgra2").val();
                $("#lblgra1").html("Grado = " + gra);
                
        		if(gra == "NA") {
        			$("#submit1").hide("");
        		}
        		else {
        		    $("#submit1").show("");
        		}
        	});
        	
        	$("#search").keyup(function(){
                _this = this;
                // Show only matching TR, hide rest of them
                $.each($("#tblcert tbody tr"), function() {
                    //alert ($(this).text());
                    if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                        $(this).hide();
                    else
                        $(this).show();
                });
            });
        	
        });
        
        function consultar_op() {
            var idgra = $("#selgra2").val();
            //alert (idgra);
            $.ajax({
        		type:"POST",
        		url:"../../registro/financieraunicab/ordenes_getdat1.php",
        		data:"idgra=" + $("#selgra2").val(),
        		success:function(r) {
        		    $("#search").show();
        		    $("#divtabla").html(r);
        			//$("#tbodyact").html(r);
        		}
        	});
        }
        
        function validar_per() {
            var per = $("#peridodo").val();
            alert(per);
            if(per > 1 && per < 5) {
                $("#submit").show("");
            }
            else {
                $("#submit").hide("");
            }
        }
    </script>
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		<!-- menu -->
		<?php 
			require "include/header.php";
		?>
		<!-- menu -->
		
		<!-- header -->
		<?php 
			require "include/menu.php";
		?>
		<!-- header -->
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
				<div class="forms">
					<!---------------------------------------------->
                    <div id="cont">
            			<!--***********************************************************************************************-->
            			<div id="div1">
            				<fieldset>
            				<legend><h3>GENERAR RECIBOS DE PAGO</h3></legend>
            				    <form class="form-horizontal" action="../../registro/financieraunicab/orden_pago.php"  method="POST" target="_blank" onsubmit="return validacion()">
            					<ul class="mprincipal">
            						<li><h3>GENRAR RECIBOS POR<span style="color: white;">.....</span>
            						</h3></li>
            							<ul class="msecund">
            								<li>
												<select id="selgra1" name="selgra1" required>
												    <option value="NA" selected>Seleccione grado</option>
												    <?php 
												        while($row = $resultado->fetch_assoc()){
												            echo "<option value='".$row['id_grado_ra']."'>".$row['name']."</option>";
												        }
												    ?>
												</select><br>
												<label>Documento estudiante</label>
												<input type="text" id="idest" name="idest" placeholder="documento estudiante" style="width: 150px; display: none;" value="0"/>
												<label style="color: white;">...</label>
												<!--<input type="text" id="periodo" name="periodo" placeholder="per" style="width: 50px; display: none;" required/>
												<label style="color: white;">...</label>-->
												<button id="submit" class="btn btn-primary" style="display: none;" >Generar</button>
											</li>
            							</ul>
            					</ul>
            					</form>
            				</fieldset>
            
            			</div>
            			<div id="div2">
            				<fieldset>
            				<legend><h3>CONSULTAR RECIBOS DE PAGO</h3></legend>
            				    <!--<form class="form-horizontal" action="act_moodle_getdat1.php"  method="POST" target="_blank" onsubmit="return validacion()">-->
            					<ul class="mprincipal">
            						<li><h3>LISTADO DE RECIBOS POR<span style="color: white;">.....</span>
            						</h3></li>
            							<ul class="msecund">
            								<li>
												<select id="selgra2" name="selgra2" required>
												    <option value="NA" selected>Seleccione grado</option>
												    <?php 
												        while($row = $resultado1->fetch_assoc()){
												            echo "<option value='".$row['id_grado_ra']."'>".$row['name']."</option>";
												        }
												    ?>
												</select>
												<label style="color: white;">...</label>
												<button id="submit1" class="btn btn-primary" style="display: none;" onclick="consultar_op()">Buscar</button>
											</li>
            							</ul>
            					</ul>
            					<!--</form>-->
            				</fieldset>
            
            			</div>
            		</div></br>
					<div id="resul_bus">
					    
					</div>
					<?php
        				$mysqli1->close();
        			?>
					<!---------------------------------------------->
					<input type='search' placeholder='Ingrese texto a buscar' id='search' name='search' style="display: none;"><br/><br/>
					<div id="divtabla">
					    
					</div>
					<div id="divcontrol" style="display: none;">
					    <label id="lblgra"></label><label id="lblgra1"></label>
					    <input type="hidden" id="idemp" name="idemp" value="<?php echo $id; ?>"/>
					</div>
					<!---------------------------------------------->
                    
				</div>
			</div>
		</div>
		<!--footer-->
		<?php 
			require "include/footer.php";
		?>
        <!--//footer-->
	</div>
	
	<!-- side nav js -->
	<script src='../js/SidebarNav.min.js' type='text/javascript'></script>
	<script>
      $('.sidebar-menu').SidebarNav()
    </script>
	<!-- //side nav js -->
	
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

	<!-- Bootstrap Core JavaScript -->
   <script src="../js/bootstrap.js"> </script>
   <script type="text/javascript" src="../js/MaxLength.min.js"></script>

   <script type="text/javascript">
   		function Validar(){
			var nombre=document.getElementById('TituloB').value;
			var descripcion=document.getElementById('DescripcionB').value;
			var categoria=document.getElementById('CategoriaB').value;
			
			if (nombre=="") {
 				$('#alert').html('<center><strong>Advertencia</strong> El título del Blog es Obligatorio</center>').slideDown(500);
 				return false;
			}else{
		   		$('#alert').html('').slideUp(300);			
			}

			if (descripcion=="") {
				$('#alert').html('<center><strong>Advertencia</strong> La descripción o información del Blog es Obligatorio</center>').slideDown(500);
				return false;
			}else{
		   		$('#alert').html('').slideUp(300);			
			}

			if (categoria==0) {
				$('#alert').html('<center><strong>Advertencia</strong> Debe seleccionar una categoria valida</center>').slideDown(500);
				return false;
			}else{
		   		$('#alert').html('').slideUp(300);			
			}
		}
   	</script>

   	<!-- validar tipo de documento -->
   	<script type="text/javascript">

   		$(document).ready(function(){
   			var extensionesValidas = ".png, .gif, .jpeg, .jpg";
     		var pesoPermitido = 1024;

     		$("#ImagenB").change(function () {
     			$('#texto').text('');
     			$('#img').attr('src', '');

     			if(validarExtension(this)) {
     				if(validarPeso(this)) {
     					verImagen(this);
			    	}
				}  
    		});

		    // Validacion de extensiones permitidas
		    function validarExtension(datos) {

				var ruta = datos.value;
				var extension = ruta.substring(ruta.lastIndexOf('.') + 1).toLowerCase();
				var extensionValida = extensionesValidas.indexOf(extension);

				if(extensionValida < 0) {
		            $('#texto').text('La extensión no es válida Su fichero tiene de extensión: .'+ extension);
		            return false;
		        }else {
		            return true;
		        }
		    }

		   	// Validacion de peso del fichero en kbs
		    function validarPeso(datos) {

		        if (datos.files && datos.files[0]) {

				    var pesoFichero = datos.files[0].size/1024;

				    if(pesoFichero > pesoPermitido) {
				        $('#texto').text('El peso maximo permitido del fichero es: ' + pesoPermitido + ' KBs Su fichero tiene: '+ pesoFichero +' KBs');
				        return false;
				    } else {
				        return true;
				    }
				}
		    }

		  	// Vista preliminar de la imagen.
		  	function verImagen(datos) {
			    if (datos.files && datos.files[0]) {
			        var reader = new FileReader();
		         	reader.onload = function (e) {
		         		$('#img').attr('src', e.target.result);
		          	};

			        reader.readAsDataURL(datos.files[0]);

			   	}
			}
		});
   	</script>
   	<!-- validar tipo de documento -->
	
	<script type="text/javascript">
    $(function () {
        $("#TituloB").MaxLength(
        {
            MaxLength: 400,
            DisplayCharacterCount: false	
        });

        $("#DescripcionB").MaxLength(
        {
            MaxLength: 10000,
            DisplayCharacterCount: false	
        });
    });
</script>
</body>
</html>
<?php 
}else{
	echo "<script>alert('Debe iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>