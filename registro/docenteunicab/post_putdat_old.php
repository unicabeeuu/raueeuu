<?php
session_start();
require "../adminunicab/php/conexion.php";
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
	
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Unicab Registro Académico</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

 <!-- Favicon -->
<link rel="shortcut icon" href="../images/favicon.png" />
<!-- // Favicon -->
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
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
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/modernizr.custom.js"></script>
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

<script type="text/javascript">
    $(document).ready(function(){
        $("#ImagenA").change(function () {
 			$('#texto').text('');
 			$('#img').attr('src', '');

 			if(validarExtension(this)) {
 				if(validarPeso(this)) {
 					verImagen(this);
		    	}
			}  
		});
		
		$("#selcat").change(function() {
		    var cat = $("#selcat").val();
		    
		    if(cat == 0) {
		        var texto = "Debe seleccionar una categoria";
                $("#lblmsg").html(texto).css("color","red");
                $("#ctr_categoria").val(1);
		    }
		    else {
		        $("#lblmsg").html("");
                $("#ctr_categoria").val(0);
		    }
		    
		    mostrar_submit("selcat");
    	});
    });
    
   	// Validacion de extensiones permitidas
    function validarExtension(datos) {
        var extensionesValidas = ".png, .gif, .jpeg, .jpg";
		var ruta = datos.value;
		var extension = ruta.substring(ruta.lastIndexOf('.') + 1).toLowerCase();
		var extensionValida = extensionesValidas.indexOf(extension);

		if(extensionValida < 0) {
            //$('#texto').text('La extensión no es válida Su fichero tiene de extensión: .'+ extension);
            var texto = "La extensión no es válida Su fichero tiene de extensión: ." + extension + ": ";
            $("#lblmsg").html(texto).css("color","red");
            $("#ctr_ImagenA").val(1);
            mostrar_submit("ImagenA");
            
            return false;
        }else {
            $("#lblmsg").html("");
            $("#ctr_ImagenA").val(0);
            
            return true;
        }
    }

   	// Validacion de peso del fichero en kbs
    function validarPeso(datos) {
        var pesoPermitido = 1024;
        
        if (datos.files && datos.files[0]) {

		    var pesoFichero = datos.files[0].size/1024;

		    if(pesoFichero > pesoPermitido) {
		        //$('#texto').text('El peso maximo permitido del fichero es: ' + pesoPermitido + ' KBs Su fichero tiene: ' + pesoFichero +' KBs');
		        var texto = "El peso maximo permitido del fichero es: " + pesoPermitido + " KBs Su fichero tiene: " + pesoFichero + " KBs";
                $("#lblmsg").html(texto).css("color","red");
                $("#ctr_ImagenA").val(1);
                mostrar_submit("ImagenA");
                
		        return false;
		    } else {
		        $("#lblmsg").html("");
                $("#ctr_ImagenA").val(0);
            
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
	        mostrar_submit("ImagenA");
	   	}
	}
	
	function mayus(e, id, desc) {
        //e.value = e.value.toUpperCase();
        
        if(id == "txtpreg") {
            validar_texto(id, desc);
        }
        else {
            validar_texto(id, desc);
        }
    }
    
    function validar_texto(id, desc) {
        var control = 0;
        var id_obj = "#" + id;
        var ctr_obj = "#ctr_" + id;
        var v_input = document.getElementById(id);
        var v_val = /[-_'"\<\>\~\^\*\$\#\%\&\=\+\|\{\}\[\]\\]{1,}/;
        //var v_val = /[-_'"\<\>\~\^\*\$\!\¡\#\%\&\¿\?\/\=\+\|,;:\(\)\{\}\[\]\\]{1,}/;
        var val = String($(id_obj).val()).match(v_val);
        
        if(val == null) {
            v_input.setCustomValidity("");
            $("#lblmsg").html("");
            //$("#alert").hide();
            $(ctr_obj).val(0);
        }
        else {
            v_input.setCustomValidity("Ha ingresado caracteres inválidos");
            var texto = "Ha ingresado caracteres no permitidos para " + desc + ": ";
            texto += "- _ \' \" < > ~ ^ * $ # & = + | { } [ ] \\";
            //alert(texto);
            $("#lblmsg").html(texto).css("color","red");
            //$("#alert").show();
            $(ctr_obj).val(1);
            control = 1;
        }
		
		if(control == 0) {
		    if($(id_obj).val() == "") {
		        var texto = "El campo " + desc + " se debe llenar";
				$("#lblmsg").html(texto).css("color","red");
				//$("#alert").show();
                $(ctr_obj).val(1);
		    }
		}
		
        mostrar_submit(id);
    }
    
    function mostrar_submit(id) {
        var control = 0;
        
        var id_obj = "#" + id;
        var long = $(id_obj).val().length;
        //alert(long);
        
        //Se controla la longitud máxima
        if(id == "DescripcionA") {
            $("#lbldesc").html(long);
            if(long > 1000) {
                $("#ctr_DescripcionA").val(1);
            }
        }
        
        var a = parseInt($("#ctr_DescripcionA").val());
        var b = parseInt($("#ctr_TituloA").val());
        var c = parseInt($("#ctr_ImagenA").val());
        var d = parseInt($("#ctr_categoria").val());
        //alert("a=" + a + " b=" + b + " c=" + c + " d=" + d);
        
        control = parseInt($("#ctr_DescripcionA").val()) + parseInt($("#ctr_TituloA").val()) + parseInt($("#ctr_ImagenA").val()) + parseInt($("#ctr_categoria").val());
        
        //alert(control);
        if(control > 0) {
            $("#btnguardar").hide();
        }
        else {
            $("#btnguardar").show();
        }
        
        (a == 1) ? $("#DescripcionA").addClass("error") : $("#DescripcionA").removeClass("error");
        (b == 1) ? $("#TituloA").addClass("error") : $("#TituloA").removeClass("error");
        (c == 1) ? $("#ImagenA").addClass("error") : $("#ImagenA").removeClass("error");
        (d == 1) ? $("#lblcat").addClass("error") : $("#lblcat").removeClass("error");
    }
        
</script>
   	
<style>
    #chartdiv {
      width: 100%;
      height: 295px;
    }
    .maxl {
        color: blue;
    }
    #alert {
        position: fixed;
        bottom: 0;
        left: 180px;
        z-index: 5000;
        height: 80px;
    }
    #txtvacio {
        border: 0;
    }
    .error {
        border: 3px solid red !important;
    }
        
    input[type=checkbox] {
    	visibility: hidden;
    }
    
    .checkbox-GHF {
    	display: inline-block;
    	position: relative;
        width: 70px;
    	height: 30px;
    	background: #F3F781;
    	border-radius: 15px;
    	box-shadow: inset 0px 1px 1px rgba(0,0,0,0.6), 0px 1px 0px rgba(255,255,255,0.3);   
    }
    
    .checkbox-GHF label {
    
        /* aspecto */
        display: block;
        width: 34px;
    	height: 20px;
    	border-radius: 17px;
    	box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.35);
    	background: #fcfff4;
    	background: linear-gradient(to top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
        cursor: pointer;
        
        /* Posicionamiento */
        position: absolute;
        top: 5px;
    	left: 5px;
        z-index: 1;
        
    	/* Comportamiento */
        transition: all .4s ease;
        
        /* ocultar el posible texto que tenga */
        overflow: hidden;
        text-indent: 35px;  
        transition: text-indent 0s;
    }
    
    /* estado activado */
    .checkbox-GHF input[type=checkbox]:checked + label {
    	left: auto;
        right: 5px;
    }
    
    .checkbox-GHF:after {
    	content: 'NO';
    	font: 12px/30px Arial, sans-serif;
    	color: red;
    	position: absolute;
    	right: 10px;
        z-index: 0;
    	font-weight: bold;
    	
    }
    
    .checkbox-GHF:before {
    	content: 'SI';
    	font: 12px/30px Arial, sans-serif;
    	color: green;
    	position: absolute;
    	left: 10px;
    	z-index: 0;
    	font-weight: bold;
    }
</style>
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		<?php 
		    if($id == 18) {
	        require 'menu_adm.php';
		    }
		    else {
		        //require 'menu.php';
		        require 'menu_tutores.php';
		    }  
		?>
	
		<?php require 'header.php';  ?>
		
		<!-- modal -->
		<section>
			<?php require 'modal.php';  ?>
		</section>
		<!-- modal -->
		
		<section>
           	<div id="page-wrapper">
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
							<h4>Crear nuevo blog:</h4>
						</div>
						<div class="form-body">
							<form action="crearBlog.php" method="POST" id="form" name="form" enctype="multipart/form-data">

								<div class="form-group"> 
									<label for="TituloA">Título</label> 
									<input type="text" class="form-control" id="TituloA" name="TituloA" placeholder="Ingrese nombre del evento" autofocus onkeyup="mayus(this, 'TituloA', 'Título');">
									<input type="hidden" style="width: 20px" id="ctr_TituloA" value="1"/>
								</div>
								
								<div class="form-group"> 
									<label for="Categoria" id="lblcat">Categoría</label> 
									<select id="selcat" name="selcat" class="form-control">
									    <option value="0">Seleccione categoría</option>
									    <?php  
									        $sqlcat = "SELECT * FROM tbl_categorias_blog";
									        $rescat = mysqli_query($conexion,$sqlcat);

	                                        while ($fila = mysqli_fetch_array($rescat)){
	                                            echo '<option value="'.$fila['id'].'">'.$fila['categoria'].'</option>';
	                                        }
									    ?>
									</select>
									<input type="hidden" style="width: 20px" id="ctr_categoria" value="1"/>
								</div>

								<div class="form-group"> 
									<label for="DescripcionA">Descripción (1000 | <label class="maxl" id="lbldesc">0</label>)</label> 
									<textarea id="DescripcionA" name="DescripcionA" rows="8" class="form-control" placeholder="Descripción o información del evento" onkeyup="mayus(this, 'DescripcionA', 'Descripción');"></textarea>
									<input type="hidden" style="width: 20px" id="ctr_DescripcionA" value="1"/>
								</div>
								
								<div class="form-group"> 
								    <hr style="border-color: red;">
								    <ul style="margin-left: 50px;">
									    <li>
									        <div>
									            <p>Nota: Si desea agregar más texto, imágenes, vídeos o vínculos externos (como por ejemplo formularios), envíe toda la información por 
									            correo a <a href="mailto:webmasterunicab@unicab.org">webmasterunicab@unicab.org</a>, indicando el <mark style="background:yellow;">título</mark> del blog y el <mark style="background:yellow;">id</mark> que aparecerá al guardar la información ... y active la siguiente opción.</p><br>
									            <table>
									                <tbody>
									                    <tr>
									                        <td><label>Texto complementario, imágenes, vídeos o vínculos</label></td>
									                        <td width="10"></td>
									                        <td>
									                            <div class="checkbox-GHF">
                									                <input type="checkbox" id="checkAvanzado" name="checkAvanzado" value="0"/>
                                                                    <label for="checkAvanzado">...</label>
                                                                </div>
									                        </td>
									                    </tr>
									                </tbody>
									            </table>
									            
									            <!--<p>&lt;iframe width="560" height="315" src="<mark style="background: yellow;">https://www.youtube.com/embed/Rq9vLVmB9BU</mark>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen&gt;&lt;/iframe&gt;</p><br>
									            <p>Lo único que se debe cambiar es lo que está resaltado.</p>-->
									        </div>
									    </li>
									</ul>
									<hr style="border-color: red;">
								</div>

								<div class="form-group"> 
									<label for="ImagenA">Imagen (Peso máximo 1024 Kb)</label> 
									<input type="file" class="form-control" id="ImagenA" name="ImagenA" required>
									<input type="hidden" style="width: 20px" id="ctr_ImagenA" value="1"/>
									<p id="texto"> </p><br/>   	
									<img id="img" src=""  class="img-fluid" width="50%" />
								</div>

								<div class="form-group"> 
									<label for="Autor">Públicado por</label> 
									<input type="text" class="form-control" id="Autor"  readonly="" value="<?php echo $apellidos.' '.$nombres; ?>">
								</div>

								<input type="hidden" class="form-control" name="IdEmp" value="<?php echo $id;?>" readonly>

								<button type="submit" id="btnguardar" class="btn btn-primary" style="display: none;">Guardar</button> 
							</form>
						</div>
						
						<div class="alert alert-danger" role="alert" id="alert">
                            <p><i class="fa fa-warning"></i><span>: </span><label id="lblmsg"></label>
                            <input type="text" class="alert alert-danger" style="width: 10px" id="txtvacio" value="0"></p>
                        </div>
                        
					</div>
           		</div>
      		</div>
		</section>        	
		<!--footer-->
		<?php require 'footer.php'; ?>
	    <!--//footer-->
	</div>
</body>
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
    
    <!-- js tabla -->
	<script src="../js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
    	$('#listEstudiantes').DataTable();	
		} );
	</script>
	<!-- //js tabla -->

	<!-- Bootstrap Core JavaScript -->
   	<script src="../js/bootstrap.js"> </script>
	<!-- //Bootstrap Core JavaScript -->
    
	<!--  <script>-->
<?php 
}else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>