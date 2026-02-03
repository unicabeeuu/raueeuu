<?php
	//Genera el select de los grados
	require("../docenteunicab/updreg/1cc3s4db.php");
	require("../docenteunicab/updreg/mcript.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	$tabla = $_REQUEST['tabla'];
	$estado = $_REQUEST['estado'];
	//echo $tabla;
	
	$cadena = "";
	
	if($tabla == "tbl_empleados") {
	    $query1 = "SELECT e.*, d.id id_depen, p.id id_prof, c.id id_cargo 
	    FROM ".$tabla." e, tbl_dependencias d, tbl_profesiones p, tbl_cargos c 
	    WHERE e.dependencia = d.dependencia AND e.profesion = p.profesion AND e.cargo = c.cargo";
	}
	else if($tabla == "estudiantes") {
	    $query1 = "SELECT * FROM ".$tabla." WHERE estado = '$estado'";
	}
	else {
	    $query1 = "SELECT * FROM ".$tabla;
	}
	//echo $query1;
	
	if($tabla == "tbl_cargos") {
	    $cadena = $cadena."<table id='tbldatos' class='table table-fixed' border='1px'>
	                        <thead>
	                        <tr style='background-color: gray; color: white; text-weight: bold;'>
	                            <td>ID</td>
	                            <td>CARGO</td>
	                            <td>...</td>
	                        </tr></thead><tbody>";
	}
	else if($tabla == "tbl_dependencias") {
	    $cadena = $cadena."<table id='tbldatos' class='table table-fixed' border='1px'>
	                        <thead>
	                        <tr style='background-color: gray; color: white; text-weight: bold;'>
	                            <td>ID</td>
	                            <td>DEPENDENCIA</td>
	                            <td>...</td>
	                        </tr></thead><tbody>";
	}
	else if($tabla == "tbl_tipos_documento") {
	    $cadena = $cadena."<table id='tbldatos' class='table table-fixed' border='1px'>
	                        <thead>
	                        <tr style='background-color: gray; color: white; text-weight: bold;'>
	                            <td>ID</td>
	                            <td>TIPO DOCUMENTO</td>
	                            <td>...</td>
	                        </tr></thead><tbody>";
	}
	else if($tabla == "tbl_profesiones") {
	    $cadena = $cadena."<table id='tbldatos' class='table table-fixed' border='1px'>
	                        <thead>
	                        <tr style='background-color: gray; color: white; text-weight: bold;'>
	                            <td>ID</td>
	                            <td>PROFESION</td>
	                            <td>...</td>
	                        </tr></thead><tbody>";
	}
	else if($tabla == "tbl_empleados") {
	    $cadena = $cadena."<table id='tbldatos' class='table table-fixed' border='1px'>
	                        <thead>
	                        <tr style='background-color: gray; color: white; text-weight: bold;'>
	                            <td>ID</td>
	                            <td>NOMBRES</td>
	                            <td>APELLIDOS</td>
	                            <td>EMAIL</td>
	                            <td>N_DOCUMENTO</td>
	                            <td>CARGO</td>
	                            <td>CELULAR</td>
	                            <td>...</td>
	                        </tr></thead><tbody>";
	}
	else if($tabla == "estudiantes") {
	    $cadena = $cadena."<table id='tbldatos' class='table table-fixed' border='1px'>
	                        <thead>
	                        <tr style='background-color: gray; color: white; text-weight: bold;'>
	                            <td>ID</td>
	                            <td>NOMBRES</td>
	                            <td>APELLIDOS</td>
	                            <td>EMAIL</td>
	                            <td>N_DOCUMENTO</td>
	                            <td>ESTADO</td>
	                            <td>...</td>
	                        </tr></thead><tbody>";
	}
	//echo $cadena;                      
	
	$resultado=$mysqli1->query($query1);
	while($row = $resultado->fetch_assoc()) {
	    if($tabla == "tbl_cargos") {
	        $cadena = $cadena."<tr>
                <td>".$row['id']."</td>
                <td>".$row['cargo']."</td>
                <td><button class='btn btn-warning glyphicon glyphicon-edit' data-toggle='modal' data-target='#modal_cargos' title='Modificar'
                onclick='enviardat_c(".$row['id'].",\"".str_replace("'","_",$row['cargo'])."\")'> Modificar</button></td></tr>";
	    }
	    else if($tabla == "tbl_dependencias") {
	        $cadena = $cadena."<tr>
                <td>".$row['id']."</td>
                <td>".$row['dependencia']."</td>
                <td><button class='btn btn-warning glyphicon glyphicon-edit' data-toggle='modal' data-target='#modal_depen' title='Modificar'
                onclick='enviardat_d(".$row['id'].",\"".str_replace("'","_",$row['dependencia'])."\")'> Modificar</button></td></tr>";
	    }
	    else if($tabla == "tbl_tipos_documento") {
	        $cadena = $cadena."<tr>
                <td>".$row['id']."</td>
                <td>".$row['tipo_documento']."</td>
                <td><button class='btn btn-warning glyphicon glyphicon-edit' data-toggle='modal' data-target='#modal_td' title='Modificar'
                onclick='enviardat_td(".$row['id'].",\"".str_replace("'","_",$row['tipo_documento'])."\")'> Modificar</button></td></tr>";
	    }
	    else if($tabla == "tbl_profesiones") {
	        $cadena = $cadena."<tr>
                <td>".$row['id']."</td>
                <td>".$row['profesion']."</td>
                <td><button class='btn btn-warning glyphicon glyphicon-edit' data-toggle='modal' data-target='#modal_prof' title='Modificar'
                onclick='enviardat_p(".$row['id'].",\"".str_replace("'","_",$row['profesion'])."\")'> Modificar</button></td></tr>";
	    }
	    else if($tabla == "tbl_empleados") {
	        $pc = $dev_enc($row['pc']);
	        $cadena = $cadena."<tr>
                <td>".$row['id']."</td>
                <td>".$row['nombres']."</td>
                <td>".$row['apellidos']."</td>
                <td>".$row['email']."</td>
                <td>".$row['n_documento']."</td>
                <td>".$row['cargo']."</td>
                <td>".$row['celular']."</td>
                <td><button class='btn btn-warning glyphicon glyphicon-edit' data-toggle='modal' data-target='#modal_emp' title='Modificar'
                onclick='enviardat_emp(".$row['id'].",\"".str_replace("'","_",$row['nombres'])."\",\"".str_replace("'","_",$row['apellidos']).
                "\",\"".$row['email']."\",\"".$row['pc']."\",".$row['n_documento'].",\"".str_replace("'","_",$row['dependencia'])."\",\"".$row['skype'].
                "\",\"".$row['celular']."\",\"".str_replace("'","_",$row['cargo'])."\",\"".str_replace("'","_",$row['profesion']).
                "\",\"".str_replace("'","_",$row['nombre_corto'])."\",\"".str_replace("'","_",$row['rh'])."\")'> Modificar</button></td></tr>";
	    }
	    else if($tabla == "estudiantes") {
	        $cadena = $cadena."<tr>
                <td>".$row['id']."</td>
                <td>".$row['nombres']."</td>
                <td>".$row['apellidos']."</td>
                <td>".$row['email_institucional']."</td>
                <td>".$row['n_documento']."</td>
                <td>".$row['estado']."</td>
                <td><button class='btn btn-warning glyphicon glyphicon-edit' data-toggle='modal' data-target='#modal_est' title='Modificar'
                onclick='enviardat_est(".$row['id'].",\"".str_replace("'","_",$row['nombres'])."\",\"".str_replace("'","_",$row['apellidos']).
                "\",\"".$row['genero']."\",\"".$row['tipo_documento']."\",".$row['n_documento'].",\"".str_replace("'","_",$row['fecha_nacimiento']).
                "\",\"".$row['expedicion']."\",\"".$row['ciudad']."\",\"".$row['direccion']."\",\"".$row['direccion_estudiante']."\",\"".str_replace("'","_",$row['telefono_estudiante']).
                "\",\"".$row['email_institucional']."\",\"".$row['actividad_extra']."\",\"".$row['email_acudiente1']."\",\"".str_replace("'","_",$row['email_acudiente2']).
                "\",\"".$row['acudiente_1']."\",\"".str_replace("'","_",$row['acudiente_2'])."\",\"".str_replace("'","_",$row['telefono_acudiente1']).
                "\",\"".str_replace("'","_",$row['telefono_acudiente_2'])."\",\"".$row['estado']."\",\"".$row['password']."\",\"".$row['fecha_datos']."\")'> Modificar</button></td></tr>";
	    }
	    
	}
	$cadena = $cadena."</tbody></table>";
	echo $cadena;
?>