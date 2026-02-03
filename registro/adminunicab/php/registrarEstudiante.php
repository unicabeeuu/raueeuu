 <html>
 <head>
 <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../registro-estudiantes.php">
 <meta http-equiv="content-type" content="text/html" />
 <meta charset="UTF-8">
 </head>

 </html>
<?php

include "conexion.php";
require("1cc3s4db.php");
	
//SOLUCIONA EL PROBLEMA DE ACENTOS Y Ñ EN LA BASE DE DATOS
//@mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO
	$apellidos=strtoupper($_POST['apellidos']);
	$nombres=strtoupper($_POST['nombres']);
	$tipo_documento=$_POST['tDocumento'];
	$n_documento=$_POST['n_documento'];
	$genero=$_POST['genero'];
	$fecha_nacimiento=$_POST['fecha_nacimiento'];

	$expedicion=strtoupper($_POST['expedicion']);
	$ciudad=strtoupper($_POST['ciudad']);
	$direccion_estudiante=$_POST['direccion_estudiante'];
	$telefono_estudiante=$_POST['telefono_estudiante'];
	$email_institucional=$_POST['email_institucional'];
	$actividad_extra=$_POST['actividad_extra'];	
	$pass=$_POST['pass'];
	$rh=$_POST['rh'];
	$id_grado=$_POST['grado'];

	$email_acudiente_1=$_POST['email_acudiente_1'];
	$acudiente_1=$_POST['acudiente_1'];
	$n_documento_acu=$_POST['documento_acu'];
	$telefono_acudiente_1=$_POST['telefono_acudiente_1'];
	$direccion=$_POST['direccion'];
	$parentesco_acudiente_1=strtoupper($_POST['parentesco_acudiente_1']);
	
	$email_acudiente_2=$_POST['email_acudiente_2'];
	$acudiente_2=$_POST['acudiente_2'];
	$telefono_acudiente_2=$_POST['telefono_acudiente_2'];
	$parentesco_acudiente_2=strtoupper($_POST['parentesco_acudiente_2']);
	
	date_default_timezone_set('America/Bogota');
    $dia=date("d");
    $mes=date("m");
    $mesLetra=date("M");
    $fanio=date("Y");
    //$faniop=date("Y");
    $espaniol="";
    //echo $fanio;
    if($mes == 12) {
	    $fanio++;
	}
    
    $fecha2 = $fanio."/".$mes."/". $dia;
    $fecha3 = $fanio."-".$mes."-". $dia;
	
    //echo $n_documento;
    
	$buscar="SELECT * FROM estudiantes where n_documento='".$n_documento."'";
	$petecion=mysqli_query($conexion,$buscar);

	$buscar_correo="SELECT * FROM estudiantes where email_institucional='".$email_institucional."'";
	$petecion1=mysqli_query($conexion,$buscar_correo);
	
	if (mysqli_num_rows($petecion)>1) {
		echo"<script>alert('El estudiante ya esta registrado')</script>";
	}else if (mysqli_num_rows($petecion1)>1) {
		echo"<script>alert('El correo ya esta asignado a otro estudiante')</script>";
	}else{
	    //**************************************************************************************************************
        //Se actualizan las tablas de estudiantes con los pagos y matrículas
        //echo "control";
        
        //Se valida la fecha actual con respecto a los cierres de periodo para el periodo de ingreso
        $per = "1";
    	if(date($fecha2) >= date('2021/02/03') && date($fecha2) < date('2021/04/11')) {
    	    $per = "1";
    	}
    	else if(date($fecha2) >= date('2021/04/11') && date($fecha2) < date('2021/06/28')) {
    	    $per = "2";
    	}
    	else if(date($fecha2) >= date('2021/06/28') && date($fecha2) < date('2021/09/12')) {
    	    $per = "3";
    	}
    	else if(date($fecha2) >= date('2021/09/12')) {
    	    $per = "4";
    	}
    	//echo $per;
    	//beca = 0 -> sin beca; = 1 media beca; = 2 beca completa
    	//pension_a -> es la nueva pensión de promoción anticipada
    	$beca = 0;
        $descuento = 0;
        $ct_pagos = 0;
            
    	$sql_beca = "SELECT * FROM tbl_becas WHERE identificacion = $n_documento AND periodo_lectivo = $fanio";
    	//echo $sql_beca;
    	$res_beca=$mysqli1->query($sql_beca);
        while($row_beca = $res_beca->fetch_assoc()){
            $beca = $row_beca['beca'];
            $descuento = $row_beca['descuento'];
            $ct_pagos = $row_beca['ct_pagos'];
        }
        
        $sql_costos = "SELECT * FROM tbl_costos_unicab WHERE a = $fanio AND id_grado = $id_grado";
        //echo $sql_costos;
    	$res_costos=$mysqli1->query($sql_costos);
        while($row_costos = $res_costos->fetch_assoc()){
            $matricula = $row_costos['matricula'];
            $pension = $row_costos['pension'];
            $ocp = $row_costos['ocp'];
            $poliza = $row_costos['poliza'];
            $dg = $row_costos['dg'];
            $pp = $row_costos['pp'];
        }
        
        if($id_grado > 16) {
            if($per == 2) {
                $pagos_anuales_de = 2.5;
            }
            else {
                $pagos_anuales_de = 5;
            }
        }
        else {
            if($per == 2) {
                $pagos_anuales_de = 7.5;
            }
            else if($per == 3) {
                $pagos_anuales_de = 5;
            }
            else {
                $pagos_anuales_de = 10;
            }
        }
        $total_anual_de = $pension * $pagos_anuales_de;
        $descuento1 = $descuento/100 * $pension;
        $total_anual_sd = ($pension - $descuento1) * $pagos_anuales_de;
        if($beca == 1) {
            $beca1 = $pension/2;
        }
        else if($beca == 2) {
            $beca1 = $pension;
        }
        else {
            $beca1 = 0;
        }
        $total_anual_sb = ($pension - $beca1) * $pagos_anuales_de;
        $pension_final = $total_anual_sb / $pagos_anuales_de;
        
        $estnuevo = "SI";
        if($estnuevo == "NO") {
            $sql_updins_est = "UPDATE estudiantes SET periodo_ing = $per, descuento = $descuento, beca = $beca, acuerdo_ct_pagos = $ct_pagos, pension_de = $pension, 
            pension_a = 0, pagos_anuales_de = $pagos_anuales_de, pagos_anuales_a = 0, pagos_anuales_f = $pagos_anuales_de, tot_anual_de = $total_anual_de, 
            descuento1 = $descuento1, tot_anual_sd = $total_anual_sd, beca1 = $beca1, tot_anual_sb = $total_anual_sb, pension_final = $pension_final, 
            telefono_estudiante = $cel, tipo_documento = $tdoc, 
            email_acudiente_1 = '$emailA', acudiente_1 = '$nombre_completoA', telefono_acudiente_1 = '$celA', documento_responsable = '$documentoA', 
			parentesco_acudiente_1 = '".$parentesco_acudiente_1."', parentesco_acudiente_2 = '".$parentesco_acudiente_2."' 
            WHERE n_documento = '$documento'";
        }
        else if($estnuevo == "SI") {
            $sql_updins_est = "INSERT INTO estudiantes 
            (apellidos, nombres, genero, tipo_documento, n_documento, fecha_nacimiento, expedicion, ciudad, direccion, direccion_estudiante, telefono_estudiante, email_institucional, 
            actividad_extra, email_acudiente_1, email_acudiente_2, acudiente_1, acudiente_2, telefono_acudiente_1, telefono_acudiente_2, estado, password, mensaje, fecha_datos, 
            documento_responsable, periodo_ing, descuento, beca, acuerdo_ct_pagos, pension_de, pension_a, pagos_anuales_de, pagos_anuales_a, pagos_anuales_f, tot_anual_de, 
            descuento1, tot_anual_sd, beca1, tot_anual_sb, pension_final, parentesco_acudiente_1, parentesco_acudiente_2) 
            VALUES 
            ('$apellidos', '$nombres', '$genero', '$tipo_documento', '$n_documento', '$fecha_nacimiento', '$expedicion', '$ciudad', '$direccion', '$direccion_estudiante', '$telefono_estudiante', '$email_institucional', 
            '$actividad_extra', '$email_acudiente_1', '$email_acudiente_2', '$acudiente_1', '$acudiente_2', '$telefono_acudiente_1', '$telefono_acudiente_2', '$rh', '$pass', 'NA', '$fecha2', 
            '$documento_acu', $per, $descuento, $beca, $ct_pagos, $pension, 0, $pagos_anuales_de, 0, $pagos_anuales_de, $total_anual_de, 
            $descuento1, $total_anual_sd, $beca1, $total_anual_sb, $pension_final, '$parentesco_acudiente_1', '$parentesco_acudiente_2')";
        }
        //echo "<br>".$sql_updins_est;
        $res_updinst_est = $mysqli1->query($sql_updins_est);
        
        //se arma el n_matricula
        $sql_maxa = "SELECT MAX(DATE_FORMAT(fecha_ingreso, '%Y')) a FROM matricula";
        $exe_maxa = mysqli_query($conexion,$sql_maxa);
        while ($rowa = mysqli_fetch_array($exe_maxa)) {
            $maxa = $rowa['a'];
        }
        //echo "<br/>".$a;
        //echo "<br/>".$maxa;
        if($fanio == $maxa) {
            $sql_mat = "SELECT MAX(idMatricula) maxid FROM matricula WHERE date_format(fecha_ingreso, '%Y') = $fanio";
            //echo "<br/>".$sql_mat;
            $exe_mat = mysqli_query($conexion,$sql_mat);
            while ($rowm = mysqli_fetch_array($exe_mat)) {
                $consecutivo = $rowm['maxid'];
                $consecutivo1 = $consecutivo + 1;
            }
        }
        else {
            $consecutivo = 1;
            $consecutivo1 = 1;
        }
        //echo "<br/>".$consecutivo;
        
        //Se captura el n_matricula del maxid
        //$sql_n_matric = "SELECT n_matricula FROM matricula WHERE idMatricula = $consecutivo";
        $sql_n_matric = "SELECT n_matricula FROM matricula WHERE idMatricula = (SELECT MAX(idMatricula) maxid FROM matricula WHERE date_format(fecha_ingreso, '%Y') = $fanio)";
        $exe_n_matric = $mysqli1->query($sql_n_matric);
        while($row_n_matric = $exe_n_matric->fetch_assoc()) {
            $n_matric = $row_n_matric['n_matricula'];
        }
        $consec_n_matric = explode("-", $n_matric);
        $consec_n_matric0 = $consec_n_matric[0];
        $consec_n_matric1 = $consec_n_matric0 + 1;
        
        //$n_matricula = $consecutivo."-".$fanio."-".$idgra."G";
        //$n_matricula1 = $consecutivo1."-".$fanio."-".$idgra."G";
        $n_matricula = $consec_n_matric1."-".$fanio."-".$id_grado."G";
        //echo "<br>".$n_matricula;
        //echo "<br>".$n_matricula1;
        
        //Se captura el id del estudiante
    	$sqlid = "SELECT id FROM estudiantes WHERE n_documento = '$n_documento'";
    	$exe_id = mysqli_query($conexion,$sqlid);
        while ($rowid = mysqli_fetch_array($exe_id)) {
            $idest = $rowid['id'];
        }
    	//echo $idest;
    	
    	//Se hace el insert en la tabla de matrículas
    	if($idest > 0) {
    	    //Se valida si ya existe un registro en estado pre_solicitud
    	    $ct_matric = 0;
    	    $sql_valm = "SELECT COUNT(1) ct FROM matricula WHERE n_matricula = '$n_matricula' AND id_estudiante = $idest AND estado = 'pre_solicitud'";
    	    $msg_estudiante = "EstudianteOK";
    	    $exe_valm = mysqli_query($conexion,$sql_valm);
            while ($row_valm = mysqli_fetch_array($exe_valm)) {
                $ct_matric = $row_valm['ct'];
            }
            //echo $ct_matric;
            if($ct_matric == 0) {
                $sql_insert1 = "INSERT INTO matricula (n_matricula, fecha_ingreso, estado, id_estudiante, id_grado, EstadoGrado) 
                VALUES ('$n_matricula', '$fecha2', 'solicitud', $idest, $id_grado, 'NA')";
                //echo "<br/>".$sql_insert1;
                $exe_insert1=mysqli_query($conexion,$sql_insert1);
            }
    	}
    	
        //************FIN ACTUALIZACION TABLAS ESTUDIANTES Y MATRICULA **************************************************************
	    
		/*$sql_insert="INSERT INTO `estudiantes`(`id`, `apellidos`, `nombres`, `genero`, `tipo_documento`, `n_documento`, `fecha_nacimiento`, `expedicion`, `ciudad`, `direccion`, `direccion_estudiante`, `telefono_estudiante`, `email_institucional`, `actividad_extra`, `email_acudiente_1`, `email_acudiente_2`, `acudiente_1`, `acudiente_2`, `telefono_acudiente_1`, `telefono_acudiente_2`, `estado`, `password`, `mensaje`) 
	    VALUES (NULL,'".$apellidos."','".$nombres."','".$genero."','".$tipo_documento."','".$n_documento."','".$fecha_nacimiento."','".$expedicion."','".$ciudad."','".$direccion."','".$direccion_estudiante."','".$telefono_estudiante."','".$email_institucional."','".$actividad_extra."','".$email_acudiente_1."','".$email_acudiente_2."','".$acudiente_1."','".$acudiente_2."','".$telefono_acudiente_1."','".$telefono_acudiente_2."','inactivo','unicabnuevo2020','')";

	    $exe_insert=mysqli_query($conexion,$sql_insert);*/
	    
	    echo"<script>alert('El estudiante se ha almacenado')</script>";
	}
?>