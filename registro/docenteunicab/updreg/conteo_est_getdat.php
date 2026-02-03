<?php 
    //session_start();
    include "../../adminunicab/php/conexion.php";
	//https://unicab.org/registro/docenteunicab/updreg/conteo_est_getdat.php
    
    date_default_timezone_set('America/Bogota');
	$fecha = time();
	$dia = date("d",$fecha);
	$mes = date("m",$fecha);
	$a = date("Y",$fecha);
	$fecha2 =$a."/".$mes."/". $dia;
	$a1 = $a;
	if(date($fecha2) >= date('2025/11/01') && date($fecha2) <= date('2025/12/31')) {
	    $a1 = $a + 1;
	}
	//echo $a1;
    
    // número estudiantes moodle
    $sql_est_m="SELECT COUNT(*) as 'total_usuarios' FROM `tbl_estudiantes_mood` WHERE id NOT IN (1211, 1275, 1289, 1341) AND grado != 'Diplomados'";
    $exe_est_m=mysqli_query($conexion,$sql_est_m);
    while ($rowEM = mysqli_fetch_array($exe_est_m)) {
        $total_usuarios_m=$rowEM['total_usuarios'];
    }
	//echo "<br>".$sql_est_m;
    //echo "<br>total_usuarios_m".$total_usuarios_m;
	
    // número estudiantes activos en registro
    /*$sql_est_r="SELECT COUNT(*) as total_usuarios 
    FROM equivalence_idest ee, estudiantes e 
    WHERE ee.id_registro = e.id AND e.estado != 'Retirado'";*/
    
    /*$sql_est_r="SELECT COUNT(*) as total_usuarios 
    FROM equivalence_idest ee, estudiantes e, matricula m 
    WHERE ee.id_registro = e.id AND e.id = m.id_estudiante AND m.estado IN ('activo') 
    AND substring(m.fecha_ingreso,1,4) = '$a' AND e.n_documento != '999999'";*/
    
    /*$sql_est_r="SELECT COUNT(*) as total_usuarios 
    FROM equivalence_idest ee, estudiantes e, matricula m 
    WHERE ee.id_registro = e.id AND e.id = m.id_estudiante AND m.estado IN ('activo') 
    AND m.fecha_ingreso >= '2021/12/01' AND e.n_documento != '999999'";*/
    
    $sql_est_r = "SELECT COUNT(*) as total_usuarios 
    FROM estudiantes e, matricula m 
    WHERE e.id = m.id_estudiante AND m.estado IN ('activo') 
    AND m.n_matricula like '%$a1%' AND e.n_documento NOT IN ('999999', '9397454', '46376709')";
    
    $exe_est_r=mysqli_query($conexion,$sql_est_r);
    while ($rowER = mysqli_fetch_array($exe_est_r)) {
        $total_usuarios_r=$rowER['total_usuarios'];
    }
	//echo $sql_est_r;
	//echo "<br>total_usuarios_r".$total_usuarios_r;
    
    // número de estudiantes en pre_solicitud antiguos -- WHERE id < 1155 2713
    /*$sql_solicitud = "SELECT COUNT(*) as total_usuarios 
    FROM matricula  
    WHERE substring(fecha_ingreso,1,4) = '$a' AND estado IN ('pre_solicitud', 'solicitud') 
    AND id_estudiante IN (SELECT id FROM estudiantes WHERE id <= 1885 AND id != 1040)";*/
    $sql_solicitud = "SELECT COUNT(*) as total_usuarios 
    FROM matricula  
    WHERE n_matricula like '%$a1%' AND estado IN ('pre_solicitud', 'antiguo_pre_solicitud') 
    AND id_estudiante IN (SELECT id FROM estudiantes WHERE id <= 3148 AND id NOT IN (1040, 1155))";
    $exe_solicitud=mysqli_query($conexion,$sql_solicitud);
    while ($rowES = mysqli_fetch_array($exe_solicitud)) {
        $total_usuarios_s=$rowES['total_usuarios'];
    }
	//echo $sql_solicitud;
	//echo "<br>total_usuarios_s".$total_usuarios_s;
    
    // número de estudiantes en pre_solicitud nuevos
    $sql_solicitud1 = "SELECT COUNT(*) as total_usuarios 
    FROM matricula  
    WHERE n_matricula like '%$a1%' AND estado IN ('pre_solicitud', 'nuevo_pre_solicitud') 
    AND id_estudiante IN (SELECT id FROM estudiantes WHERE id > 3148)";
    $exe_solicitud1=mysqli_query($conexion,$sql_solicitud1);
    while ($rowES1 = mysqli_fetch_array($exe_solicitud1)) {
        $total_usuarios_s1=$rowES1['total_usuarios'];
    }
	//echo "<br>total_usuarios_s1".$total_usuarios_s1;
    
    // número de estudiantes en solicitud antiguos
    /*$sql_solicitud = "SELECT COUNT(*) as total_usuarios 
    FROM matricula  
    WHERE substring(fecha_ingreso,1,4) = '$a' AND estado IN ('pre_solicitud', 'solicitud') 
    AND id_estudiante IN (SELECT id FROM estudiantes WHERE id > 1885)";*/
    $sql_solicitud = "SELECT COUNT(*) as total_usuarios 
    FROM matricula  
    WHERE n_matricula like '%$a1%' AND estado IN ('solicitud', 'antiguo_solicitud') 
    AND id_estudiante IN (SELECT id FROM estudiantes WHERE id <= 3148 AND id NOT IN (1040, 1155, 2191))";
    $exe_solicitud=mysqli_query($conexion,$sql_solicitud);
    while ($rowES = mysqli_fetch_array($exe_solicitud)) {
        $total_usuarios_sn=$rowES['total_usuarios'];
    }
	//echo "<br>total_usuarios_sn".$total_usuarios_sn;
    
    // número de estudiantes en solicitud nuevos
    $sql_solicitud1 = "SELECT COUNT(*) as total_usuarios 
    FROM matricula  
    WHERE n_matricula like '%$a1%' AND estado IN ('solicitud', 'nuevo_solicitud') 
    AND id_estudiante IN (SELECT id FROM estudiantes WHERE id > 3148)";
    $exe_solicitud1=mysqli_query($conexion,$sql_solicitud1);
    while ($rowES1 = mysqli_fetch_array($exe_solicitud1)) {
        $total_usuarios_sn1=$rowES1['total_usuarios'];
    }
	//echo "<br>total_usuarios_sn1".$total_usuarios_sn1;
    
    $mat_efec = $total_usuarios_r + $total_usuarios_sn + $total_usuarios_sn1;
	
	// número de estudiantes con proceso abierto en el asistente
	$sql_solicitud2 = "SELECT COUNT(*) as total_usuarios 
    FROM tbl_asistente_virtual 
    WHERE paso IN ('5.2', '5.3')";
    $exe_solicitud2=mysqli_query($conexion,$sql_solicitud2);
    while ($rowES2 = mysqli_fetch_array($exe_solicitud2)) {
        $total_usuarios_proceso_abierto=$rowES2['total_usuarios'];
    }
	//echo "<br>total_estudiantes_proceso_abierto ".$total_usuarios_proceso_abierto;
    
?>