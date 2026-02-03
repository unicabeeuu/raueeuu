<?php
    session_start();
	require("1cc3s4db.php");
	include "mcript.php";
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
//if (isset($_SESSION['uniprofe']) || isset($_SESSION['unisuper']) || isset($_SESSION['admin_unicab'])) {
	$fila = 0;
	
	$gra = strtoupper($_REQUEST['selgra1']);
	$perdiendo = $_REQUEST['chkper'];
	$per1 = $_REQUEST['selper'];
	$grupo = $_REQUEST['selgrupo'];
	//echo $gra;
	//echo "perdiendo".$perdiendo;
	//echo "per1".$per1;
	//echo "grupo".$grupo;
	$estado = $_REQUEST['estadog'];
	echo "Estado: ".$estado;
	
	date_default_timezone_set('America/Bogota');
	$fecha = time();
	$dia = date("d",$fecha);
	$mes = date("m",$fecha);
	$a = date("Y",$fecha);
	$hora = date("H",$fecha);
	$minutos = date("i",$fecha);
	if($dia < 10) {
		//$dia = "0".$dia;
	}
	if($mes < 10) {
		//$mes = "0".$mes;
	}
	$fecha2 =$a."/".$mes."/". $dia;
	//echo $fecha2;
	
	//Se valida la fecha actual con respecto a los cierres de periodo
	if(date($fecha2) >= date('2021/02/01') && date($fecha2) < date('2021/04/11')) {
	    $per = "P1";
	}
	else if(date($fecha2) >= date('2021/04/11') && date($fecha2) < date('2021/06/25')) {
	    $per = "P2";
	}
	else if(date($fecha2) >= date('2021/06/25') && date($fecha2) < date('2021/09/10')) {
	    $per = "P3";
	}
	else if(date($fecha2) >= date('2021/09/10')) {
	    $per = "P4";
	}
	else {
	    $per = "P1";
	}
	//echo $per;
	
	$id_est_per = "(";
	
	$query0 = "SELECT * FROM equivalence_idgra WHERE id_category = ".$gra;
	$resultado0=$mysqli1->query($query0);
	while($row0 = $resultado0->fetch_assoc()){
	    $gra1 = $row0['name'];
	    $idgra = $row0['id_grado_ra'];
	    $grado = $row0['grado_ra'];
	}
	//echo $idgra;
	
	//Se buscan los estudiantes que están perdiendo
	if($perdiendo == true) {
	    if($per1 == 1) {
	        $query_est_per = "SELECT DISTINCT a.id_estudiante 
                FROM 
                (SELECT SUM(nota), id_estudiante, id_materia 
                FROM `notas` 
                WHERE id_grado = ".$idgra." AND id_periodo = 1 
                GROUP BY id_estudiante, id_materia
                HAVING SUM(nota) <= 2.9) a";
	    }
	    else if($per1 == 2) {
	        $query_est_per = "SELECT DISTINCT a.id_estudiante 
                FROM 
                (SELECT SUM(nota)/2, id_estudiante, id_materia 
                FROM `notas` 
                WHERE id_grado = ".$idgra." AND id_periodo IN (1,2) 
                GROUP BY id_estudiante, id_materia
                HAVING SUM(nota)/2 <= 2.9) a";
	    }
	    else if($per1 == 3) {
	        $query_est_per = "SELECT DISTINCT a.id_estudiante 
                FROM 
                (SELECT SUM(nota)/3, id_estudiante, id_materia 
                FROM `notas` 
                WHERE id_grado = ".$idgra." AND id_periodo IN (1,2,3) 
                GROUP BY id_estudiante, id_materia
                HAVING SUM(nota)/3 <= 2.9) a";
	    }
	    else if($per1 == 4 || $per1 == 0) {
	        $query_est_per = "SELECT DISTINCT a.id_estudiante 
                FROM 
                (SELECT SUM(nota)/4, id_estudiante, id_materia 
                FROM `notas` 
                WHERE id_grado = ".$idgra."
                GROUP BY id_estudiante, id_materia
                HAVING SUM(nota)/4 <= 2.9) a";
	    }
	    //echo $query_est_per;
	    
	    $res_qep=$mysqli1->query($query_est_per);
    	while($row_ep = $res_qep->fetch_assoc()){
    	    $id_est_per = $id_est_per.$row_ep['id_estudiante'].",";
    	}
    	$id_est_per = substr($id_est_per,0,strlen($id_est_per)-1);
    	$id_est_per = $id_est_per.")";
    	//echo $id_est_per;
	}
	
	
	//Se hace la consulta para generar el listado
	//Se valida el estado
	if($estado == 'activo') {
	    if($grupo == "NA") {
	        //$query1 = "SELECT DISTINCT e.id, eg.id_grado_ra, a.grado, m.n_matricula, m.idMatricula, a.usuario, CONCAT(e.nombres,' ',e.apellidos) nombre, e.n_documento, 
    	    $query1 = "SELECT DISTINCT e.id, eg.id_grado_ra, a.grado, m.n_matricula, m.idMatricula, a.usuario, CONCAT(e.apellidos,' ',e.nombres) nombre, e.n_documento, 
    	    e.expedicion, e.fecha_nacimiento, e.email_institucional, 
    		e.acudiente_1, e.email_acudiente_1, e.telefono_acudiente_1, e.acudiente_2, e.email_acudiente_2, e.telefono_acudiente_2, e.direccion, e.ciudad, 
    		e.actividad_extra, m.grupo 
    		FROM estudiantes e, matricula m, equivalence_idgra eg, 
    		(SELECT em.*, ee.id_registro 
    		FROM tbl_estudiantes_mood em LEFT JOIN equivalence_idest ee
    		ON em.id = ee.id_moodle ) a 
    		WHERE e.id = m.id_estudiante AND e.id = a.id_registro AND a.grado = eg.name AND m.estado = '$estado'  AND e.estado != 'Retirado'";
	    }
	    else {
	        //$query1 = "SELECT DISTINCT e.id, eg.id_grado_ra, a.grado, m.n_matricula, m.idMatricula, a.usuario, CONCAT(e.nombres,' ',e.apellidos) nombre, e.n_documento, 
    	    $query1 = "SELECT DISTINCT e.id, eg.id_grado_ra, a.grado, m.n_matricula, m.idMatricula, a.usuario, CONCAT(e.apellidos,' ',e.nombres) nombre, e.n_documento, 
    	    e.expedicion, e.fecha_nacimiento, e.email_institucional, 
    		e.acudiente_1, e.email_acudiente_1, e.telefono_acudiente_1, e.acudiente_2, e.email_acudiente_2, e.telefono_acudiente_2, e.direccion, e.ciudad, 
    		e.actividad_extra, m.grupo 
    		FROM estudiantes e, matricula m, equivalence_idgra eg, 
    		(SELECT em.*, ee.id_registro 
    		FROM tbl_estudiantes_mood em LEFT JOIN equivalence_idest ee
    		ON em.id = ee.id_moodle ) a 
    		WHERE e.id = m.id_estudiante AND e.id = a.id_registro AND a.grado = eg.name AND m.estado = '$estado'  AND e.estado != 'Retirado' 
    		AND m.grupo = '$grupo'";
	    }
	    
	}
	else if($estado == 'inactivo') {
	    if($grupo == "NA") {
	        //$query1 = "SELECT DISTINCT e.id, eg.id_grado_ra, eg.name grado, m.n_matricula, m.idMatricula, a.usuario, CONCAT(e.nombres,' ',e.apellidos) nombre, e.n_documento, 
    	    $query1 = "SELECT DISTINCT e.id, eg.id_grado_ra, eg.name grado, m.n_matricula, m.idMatricula, a.usuario, CONCAT(e.apellidos,' ',e.nombres) nombre, e.n_documento, 
    	    e.expedicion, e.fecha_nacimiento, e.email_institucional, 
    		e.acudiente_1, e.email_acudiente_1, e.telefono_acudiente_1, e.acudiente_2, e.email_acudiente_2, e.telefono_acudiente_2, e.direccion, e.ciudad, 
    		e.actividad_extra, m.grupo 
    		FROM estudiantes e, matricula m, equivalence_idgra eg, 
    		(SELECT em.*, ee.id_registro 
    		FROM tbl_estudiantes_mood em LEFT JOIN equivalence_idest ee
    		ON em.id = ee.id_moodle ) a 
    		WHERE e.id = m.id_estudiante AND e.id = a.id_registro AND m.id_grado = eg.id_grado_ra AND m.estado = '$estado'";
	    }
	    else {
	        //$query1 = "SELECT DISTINCT e.id, eg.id_grado_ra, eg.name grado, m.n_matricula, m.idMatricula, a.usuario, CONCAT(e.nombres,' ',e.apellidos) nombre, e.n_documento, 
    	    $query1 = "SELECT DISTINCT e.id, eg.id_grado_ra, eg.name grado, m.n_matricula, m.idMatricula, a.usuario, CONCAT(e.apellidos,' ',e.nombres) nombre, e.n_documento, 
    	    e.expedicion, e.fecha_nacimiento, e.email_institucional, 
    		e.acudiente_1, e.email_acudiente_1, e.telefono_acudiente_1, e.acudiente_2, e.email_acudiente_2, e.telefono_acudiente_2, e.direccion, e.ciudad, 
    		e.actividad_extra, m.grupo 
    		FROM estudiantes e, matricula m, equivalence_idgra eg, 
    		(SELECT em.*, ee.id_registro 
    		FROM tbl_estudiantes_mood em LEFT JOIN equivalence_idest ee
    		ON em.id = ee.id_moodle ) a 
    		WHERE e.id = m.id_estudiante AND e.id = a.id_registro AND m.id_grado = eg.id_grado_ra AND m.estado = '$estado' 
    		AND m.grupo = '$grupo'";
	    }
	    
	}
	if($gra == "NA") {
	    if($perdiendo == true) {
	        $query1 = $query1." AND e.id IN ".$id_est_per." ORDER BY a.grado, nombre";
	    }
	    else {
	        $query1 = $query1." ORDER BY a.grado, nombre";
	    }
	    /*$query1 = "SELECT DISTINCT e.id, eg.id_grado_ra, a.grado, m.n_matricula, a.usuario, CONCAT(e.nombres,' ',e.apellidos) nombre, e.n_documento, e.fecha_nacimiento, e.email_institucional, 
		e.acudiente_1, e.email_acudiente_1, e.telefono_acudiente_1, e.acudiente_2, e.email_acudiente_2, e.telefono_acudiente_2, e.direccion, e.ciudad, 
		e.actividad_extra 
		FROM estudiantes e, matricula m, equivalence_idgra eg, 
		(SELECT em.*, ee.id_registro 
		FROM tbl_estudiantes_mood em LEFT JOIN equivalence_idest ee
		ON em.id = ee.id_moodle ) a 
		WHERE e.id = m.id_estudiante AND e.id = a.id_registro AND a.grado = eg.name 
		ORDER BY a.grado, nombre";*/
	}
	else {
	    if($perdiendo == true) {
	        $query1 = $query1." AND e.id IN ".$id_est_per." AND a.grado = '".$gra1."' ORDER BY a.grado, nombre";
	    }
	    else {
	        $query1 = $query1." AND a.grado = '".$gra1."' ORDER BY a.grado, nombre";
	    }
	    /*$query1 = "SELECT DISTINCT e.id, eg.id_grado_ra, a.grado, m.n_matricula, a.usuario, CONCAT(e.nombres,' ',e.apellidos) nombre, e.n_documento, e.fecha_nacimiento, e.email_institucional, 
		e.acudiente_1, e.email_acudiente_1, e.telefono_acudiente_1, e.acudiente_2, e.email_acudiente_2, e.telefono_acudiente_2, e.direccion, e.ciudad, 
		e.actividad_extra 
		FROM estudiantes e, matricula m, equivalence_idgra eg, 
		(SELECT em.*, ee.id_registro 
		FROM tbl_estudiantes_mood em LEFT JOIN equivalence_idest ee
		ON em.id = ee.id_moodle ) a 
		WHERE e.id = m.id_estudiante AND e.id = a.id_registro AND a.grado = eg.name 
		AND a.grado = '".$gra1."'  
		ORDER BY a.grado, nombre";*/
	}
	//echo $query1;
	$resultado=$mysqli1->query($query1);
	$sel = $mysqli1->affected_rows;
	
?>

<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title></title>
		<link rel="stylesheet" href="css/bootstrap.min.css" >
		<link href="../../css/font-awesome.css" rel="stylesheet">
		<link rel="stylesheet" href="css/reg.css" >
		
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/reg.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script type="text/javascript" src="js/gridviewscroll.js"></script>
		<script type="text/javascript" src="js/Chart.bundle.min.js"></script>
		<style>
		    #tblest {
                table-layout: fixed;
            }
		    #tblest .tdlargo {
                width: 350px;
            }
            #tblest .tdcorto {
                width: 50px;
            }
            #tblest .tdnormal {
                width: 130px;
            }
            #tblest .tdmedia {
                width: 100px;
            }
            #tblest .tdmediol {
                width: 200px;
            }
            #tblest .tdmediol1 {
                width: 250px;
            }
            #tblest .tdelargo {
                width: 400px;
            }
            
            .GridViewScrollHeader TH, .GridViewScrollHeader TD {
                padding: 5px;
                font-weight: normal;
                background-color: #CCCCCC;
                color: #000000;
            }
            
            .GridViewScrollItem TD {
                padding: 5px;
                color: #444444;
            }
            
            .GridViewScrollItemFreeze TD {
                padding: 5px;
                background-color: #CCCCCC;
                color: #444444;
            }
            
            .GridViewScrollFooterFreeze TD {
                padding: 5px;
                color: #444444;
            }
            
            .GridviewScrollItemHover TD
            {
                background-color: #CCCCCC;
                color: blue;
                cursor: pointer;
            }
            .GridviewScrollItemSelected TD
            {
                background: #A9F5BC;
                color: blue;
            }
		</style>
		<script>
		    var gridViewScroll = null;
        
            $(function() {
                var options = new GridViewScrollOptions();
                options.elementID = "tblest";
                options.width = 1000;
                options.height = 300;
                options.freezeColumn = true;
                options.freezeFooter = false;
                options.freezeColumnCssClass = "GridViewScrollItemFreeze";
                options.freezeFooterCssClass = "GridViewScrollFooterFreeze";
                options.freezeColumnCount = 1;
    
                gridViewScroll = new GridViewScroll(options);
                gridViewScroll.enhance();
                
                $("#tblest tbody tr").click(function(){ 
                    $(this).addClass('GridviewScrollItemSelected').siblings().removeClass('GridviewScrollItemSelected');  
                    var value=$(this).find('td:nth-child(2)').text();
                    var value1=$(this).find('td:nth-child(3)').text();
                    $("#txtidest").val(value);
                    $("#txtidgra").val(value1);
                    
                    //ver_cal(value,value1);
                    ver_observaciones(value);
                    ver_cal_mood(value,value1);
                });
                
                $("#tblest tbody tr").hover(function(){ 
                    $(this).addClass('GridviewScrollItemHover').siblings().removeClass('GridviewScrollItemHover');  
                    var value=$(this).find('td:first').html();
                });
            });
            
            function ver_observaciones(idest) {
                //alert(idest);
                
                $.ajax({
            		type:"POST",
            		url:"observaciones_getdat.php",
            		data:"idest=" + idest,
            		success:function(r) {
            		    var obs = r.replace("_"," ");
            		    //alert(obs);
            		    //$("#txtobs").val(r.replace("_"," "));
            		    $("#txtobs").val(r);
            		}
            	});
            }
            
            function isnanc(valor) {
                return isNaN(valor) ? 0 : valor;
            }
            
            //*******************************************************************************
            function mostrar_notas(data) {
                var vper = $("#selperiodo").val();
                
                var res = JSON.parse(data);
                if(res.lbls.length == 1) {
    			    if(vper == "1") {
    			        var cf0 = ((isnanc(parseFloat(res.p1[0])))/1).toFixed(1);
    			    }
    			    else if(vper == "2") {
    			        var cf0 = ((isnanc(parseFloat(res.p1[0])) + isnanc(parseFloat(res.p2[0])))/2).toFixed(1);
            	    }
            	    else if(vper == "3") {
    			        var cf0 = ((isnanc(parseFloat(res.p1[0])) + isnanc(parseFloat(res.p2[0])) + isnanc(parseFloat(res.p3[0])))/3).toFixed(1);
            	    }
            	    else {
            	        var cf0 = ((isnanc(parseFloat(res.p1[0])) + isnanc(parseFloat(res.p2[0])) + isnanc(parseFloat(res.p3[0])) + isnanc(parseFloat(res.p4[0])))/4).toFixed(1);
            	    }
            	    var datos = {
                        labels : [res.lbls[0] + " (CF="+cf0+")","."],
                        datasets : [
                            {label : "P1", backgroundColor : "rgba(249,255,51,0.9)", data : [res.p1[0],0], order: 1},
                            {label : "P2", backgroundColor : "rgba(151,187,205,0.9)", data : [res.p2[0],0], order: 1},
                            {label : "P3", backgroundColor : "rgba(239,152,60,0.9)", data : [res.p3[0],0], order: 1},
                            {label : "P4", backgroundColor : "rgba(150,85,244,0.9)", data : [res.p4[0],0], order: 1},
                            {label : "Cal. Final", backgroundColor : "#000000", data : [cf0], type: 'line', fill : false, pointRadius: 5, showLine: false, borderColor : "#000000", order: 0},
                            {label : "Cal. Min.", backgroundColor : "rgba(255,0,0,0.9)", data : [3,3], type: 'line', fill : false, borderColor : "#FF0000", order: 3}
                        ]
                    };
            	}
    			else if(res.lbls.length == 2) {
    			    if(vper == "1") {
    			        var cf0 = ((isnanc(parseFloat(res.p1[0])))/1).toFixed(1);
                	    var cf1 = ((isnanc(parseFloat(res.p1[1])))/1).toFixed(1);
    			    }
    			    else if(vper == "2") {
    			        var cf0 = ((isnanc(parseFloat(res.p1[0])) + isnanc(parseFloat(res.p2[0])))/2).toFixed(1);
                	    var cf1 = ((isnanc(parseFloat(res.p1[1])) + isnanc(parseFloat(res.p2[1])))/2).toFixed(1);
            	    }
            	    else if(vper == "3") {
    			        var cf0 = ((isnanc(parseFloat(res.p1[0])) + isnanc(parseFloat(res.p2[0])) + isnanc(parseFloat(res.p3[0])))/3).toFixed(1);
                	    var cf1 = ((isnanc(parseFloat(res.p1[1])) + isnanc(parseFloat(res.p2[1])) + isnanc(parseFloat(res.p3[1])))/3).toFixed(1);
            	    }
            	    else {
            	        var cf0 = ((isnanc(parseFloat(res.p1[0])) + isnanc(parseFloat(res.p2[0])) + isnanc(parseFloat(res.p3[0])) + isnanc(parseFloat(res.p4[0])))/4).toFixed(1);
                	    var cf1 = ((isnanc(parseFloat(res.p1[1])) + isnanc(parseFloat(res.p2[1])) + isnanc(parseFloat(res.p3[1])) + isnanc(parseFloat(res.p4[1])))/4).toFixed(1);
            	    }
            	    var datos = {
                        labels : [res.lbls[0] + " (CF="+cf0+")",res.lbls[1] + " (CF="+cf1+")","."],
                        datasets : [
                            {label : "P1", backgroundColor : "rgba(249,255,51,0.9)", data : [res.p1[0],res.p1[1],0], order: 1},
                            {label : "P2", backgroundColor : "rgba(151,187,205,0.9)", data : [res.p2[0],res.p2[1],0], order: 1},
                            {label : "P3", backgroundColor : "rgba(239,152,60,0.9)", data : [res.p3[0],res.p3[1],0], order: 1},
                            {label : "P4", backgroundColor : "rgba(150,85,244,0.9)", data : [res.p4[0],res.p4[1],0], order: 1},
                            {label : "Cal. Final", backgroundColor : "#000000", data : [cf0,cf1], type: 'line', fill : false, pointRadius: 5, showLine: false, borderColor : "#000000", order: 0},
                            {label : "Cal. Min.", backgroundColor : "rgba(255,0,0,0.9)", data : [3,3,3], type: 'line', fill : false, borderColor : "#FF0000", order: 3}
                        ]
                    };
            	}
    			else if(res.lbls.length == 3) {
    			    if(vper == "1") {
    			        var cf0 = ((isnanc(parseFloat(res.p1[0])))/1).toFixed(1);
                	    var cf1 = ((isnanc(parseFloat(res.p1[1])))/1).toFixed(1);
                	    var cf2 = ((isnanc(parseFloat(res.p1[2])))/1).toFixed(1);
    			    }
    			    else if(vper == "2") {
    			        var cf0 = ((isnanc(parseFloat(res.p1[0])) + isnanc(parseFloat(res.p2[0])))/2).toFixed(1);
                	    var cf1 = ((isnanc(parseFloat(res.p1[1])) + isnanc(parseFloat(res.p2[1])))/2).toFixed(1);
                	    var cf2 = ((isnanc(parseFloat(res.p1[2])) + isnanc(parseFloat(res.p2[2])))/2).toFixed(1);
            	    }
            	    else if(vper == "3") {
    			        var cf0 = ((isnanc(parseFloat(res.p1[0])) + isnanc(parseFloat(res.p2[0])) + isnanc(parseFloat(res.p3[0])))/3).toFixed(1);
                	    var cf1 = ((isnanc(parseFloat(res.p1[1])) + isnanc(parseFloat(res.p2[1])) + isnanc(parseFloat(res.p3[1])))/3).toFixed(1);
                	    var cf2 = ((isnanc(parseFloat(res.p1[2])) + isnanc(parseFloat(res.p2[2])) + isnanc(parseFloat(res.p3[2])))/3).toFixed(1);
            	    }
            	    else {
            	        var cf0 = ((isnanc(parseFloat(res.p1[0])) + isnanc(parseFloat(res.p2[0])) + isnanc(parseFloat(res.p3[0])) + isnanc(parseFloat(res.p4[0])))/4).toFixed(1);
                	    var cf1 = ((isnanc(parseFloat(res.p1[1])) + isnanc(parseFloat(res.p2[1])) + isnanc(parseFloat(res.p3[1])) + isnanc(parseFloat(res.p4[1])))/4).toFixed(1);
                	    var cf2 = ((isnanc(parseFloat(res.p1[2])) + isnanc(parseFloat(res.p2[2])) + isnanc(parseFloat(res.p3[2])) + isnanc(parseFloat(res.p4[2])))/4).toFixed(1);
            	    }
            	    var datos = {
                        labels : [res.lbls[0] + " (CF="+cf0+")",res.lbls[1] + " (CF="+cf1+")",res.lbls[2] + " (CF="+cf2+")","."],
                        datasets : [
                            {label : "P1", backgroundColor : "rgba(249,255,51,0.9)", data : [res.p1[0],res.p1[1],res.p1[2],0], order: 1},
                            {label : "P2", backgroundColor : "rgba(151,187,205,0.9)", data : [res.p2[0],res.p2[1],res.p2[2],0], order: 1},
                            {label : "P3", backgroundColor : "rgba(239,152,60,0.9)", data : [res.p3[0],res.p3[1],res.p3[2],0], order: 1},
                            {label : "P4", backgroundColor : "rgba(150,85,244,0.9)", data : [res.p4[0],res.p4[1],res.p4[2],0], order: 1},
                            {label : "Cal. Final", backgroundColor : "#000000", data : [cf0,cf1,cf2], type: 'line', fill : false, pointRadius: 5, showLine: false, borderColor : "#000000", order: 0},
                            {label : "Cal. Min.", backgroundColor : "rgba(255,0,0,0.9)", data : [3,3,3,3], type: 'line', fill : false, borderColor : "#FF0000", order: 3}
                        ]
                    };
            	}
    			else if(res.lbls.length == 4) {
    			    if(vper == "1") {
    			        var cf0 = ((isnanc(parseFloat(res.p1[0])))/1).toFixed(1);
                	    var cf1 = ((isnanc(parseFloat(res.p1[1])))/1).toFixed(1);
                	    var cf2 = ((isnanc(parseFloat(res.p1[2])))/1).toFixed(1);
                	    var cf3 = ((isnanc(parseFloat(res.p1[3])))/1).toFixed(1);
    			    }
    			    else if(vper == "2") {
    			        var cf0 = ((isnanc(parseFloat(res.p1[0])) + isnanc(parseFloat(res.p2[0])))/2).toFixed(1);
                	    var cf1 = ((isnanc(parseFloat(res.p1[1])) + isnanc(parseFloat(res.p2[1])))/2).toFixed(1);
                	    var cf2 = ((isnanc(parseFloat(res.p1[2])) + isnanc(parseFloat(res.p2[2])))/2).toFixed(1);
                	    var cf3 = ((isnanc(parseFloat(res.p1[3])) + isnanc(parseFloat(res.p2[3])))/2).toFixed(1);
            	    }
            	    else if(vper == "3") {
    			        var cf0 = ((isnanc(parseFloat(res.p1[0])) + isnanc(parseFloat(res.p2[0])) + isnanc(parseFloat(res.p3[0])))/3).toFixed(1);
                	    var cf1 = ((isnanc(parseFloat(res.p1[1])) + isnanc(parseFloat(res.p2[1])) + isnanc(parseFloat(res.p3[1])))/3).toFixed(1);
                	    var cf2 = ((isnanc(parseFloat(res.p1[2])) + isnanc(parseFloat(res.p2[2])) + isnanc(parseFloat(res.p3[2])))/3).toFixed(1);
                	    var cf3 = ((isnanc(parseFloat(res.p1[3])) + isnanc(parseFloat(res.p2[3])) + isnanc(parseFloat(res.p3[3])))/3).toFixed(1);
            	    }
            	    else {
            	        var cf0 = ((isnanc(parseFloat(res.p1[0])) + isnanc(parseFloat(res.p2[0])) + isnanc(parseFloat(res.p3[0])) + isnanc(parseFloat(res.p4[0])))/4).toFixed(1);
                	    var cf1 = ((isnanc(parseFloat(res.p1[1])) + isnanc(parseFloat(res.p2[1])) + isnanc(parseFloat(res.p3[1])) + isnanc(parseFloat(res.p4[1])))/4).toFixed(1);
                	    var cf2 = ((isnanc(parseFloat(res.p1[2])) + isnanc(parseFloat(res.p2[2])) + isnanc(parseFloat(res.p3[2])) + isnanc(parseFloat(res.p4[2])))/4).toFixed(1);
                	    var cf3 = ((isnanc(parseFloat(res.p1[3])) + isnanc(parseFloat(res.p2[3])) + isnanc(parseFloat(res.p3[3])) + isnanc(parseFloat(res.p4[3])))/4).toFixed(1);
            	    }
            	    var datos = {
                        labels : [res.lbls[0] + " (CF="+cf0+")",res.lbls[1] + " (CF="+cf1+")",res.lbls[2] + " (CF="+cf2+")",res.lbls[3] + " (CF="+cf3+")","."],
                        datasets : [
                            {label : "P1", backgroundColor : "rgba(249,255,51,0.9)", data : [res.p1[0],res.p1[1],res.p1[2],res.p1[3],0], order: 1},
                            {label : "P2", backgroundColor : "rgba(151,187,205,0.9)", data : [res.p2[0],res.p2[1],res.p2[2],res.p2[3],0], order: 1},
                            {label : "P3", backgroundColor : "rgba(239,152,60,0.9)", data : [res.p3[0],res.p3[1],res.p3[2],res.p3[3],0], order: 1},
                            {label : "P4", backgroundColor : "rgba(150,85,244,0.9)", data : [res.p4[0],res.p4[1],res.p4[2],res.p4[3],0], order: 1},
                            {label : "Cal. Final", backgroundColor : "#000000", data : [cf0,cf1,cf2,cf3], type: 'line', fill : false, pointRadius: 5, showLine: false, borderColor : "#000000", order: 0},
                            {label : "Cal. Min.", backgroundColor : "rgba(255,0,0,0.9)", data : [3,3,3,3,3], type: 'line', fill : false, borderColor : "#FF0000", order: 3}
                        ]
                    };
            	}
    			else if(res.lbls.length == 5) {
    			    if(vper == "1") {
    			        var cf0 = ((isnanc(parseFloat(res.p1[0])))/1).toFixed(1);
                	    var cf1 = ((isnanc(parseFloat(res.p1[1])))/1).toFixed(1);
                	    var cf2 = ((isnanc(parseFloat(res.p1[2])))/1).toFixed(1);
                	    var cf3 = ((isnanc(parseFloat(res.p1[3])))/1).toFixed(1);
                	    var cf4 = ((isnanc(parseFloat(res.p1[4])))/1).toFixed(1);
    			    }
    			    else if(vper == "2") {
    			        var cf0 = ((isnanc(parseFloat(res.p1[0])) + isnanc(parseFloat(res.p2[0])))/2).toFixed(1);
                	    var cf1 = ((isnanc(parseFloat(res.p1[1])) + isnanc(parseFloat(res.p2[1])))/2).toFixed(1);
                	    var cf2 = ((isnanc(parseFloat(res.p1[2])) + isnanc(parseFloat(res.p2[2])))/2).toFixed(1);
                	    var cf3 = ((isnanc(parseFloat(res.p1[3])) + isnanc(parseFloat(res.p2[3])))/2).toFixed(1);
                	    var cf4 = ((isnanc(parseFloat(res.p1[4])) + isnanc(parseFloat(res.p2[4])))/2).toFixed(1);
            	    }
            	    else if(vper == "3") {
    			        var cf0 = ((isnanc(parseFloat(res.p1[0])) + isnanc(parseFloat(res.p2[0])) + isnanc(parseFloat(res.p3[0])))/3).toFixed(1);
                	    var cf1 = ((isnanc(parseFloat(res.p1[1])) + isnanc(parseFloat(res.p2[1])) + isnanc(parseFloat(res.p3[1])))/3).toFixed(1);
                	    var cf2 = ((isnanc(parseFloat(res.p1[2])) + isnanc(parseFloat(res.p2[2])) + isnanc(parseFloat(res.p3[2])))/3).toFixed(1);
                	    var cf3 = ((isnanc(parseFloat(res.p1[3])) + isnanc(parseFloat(res.p2[3])) + isnanc(parseFloat(res.p3[3])))/3).toFixed(1);
                	    var cf4 = ((isnanc(parseFloat(res.p1[4])) + isnanc(parseFloat(res.p2[4])) + isnanc(parseFloat(res.p3[4])))/3).toFixed(1);
            	    }
            	    else {
            	        var cf0 = ((isnanc(parseFloat(res.p1[0])) + isnanc(parseFloat(res.p2[0])) + isnanc(parseFloat(res.p3[0])) + isnanc(parseFloat(res.p4[0])))/4).toFixed(1);
                	    var cf1 = ((isnanc(parseFloat(res.p1[1])) + isnanc(parseFloat(res.p2[1])) + isnanc(parseFloat(res.p3[1])) + isnanc(parseFloat(res.p4[1])))/4).toFixed(1);
                	    var cf2 = ((isnanc(parseFloat(res.p1[2])) + isnanc(parseFloat(res.p2[2])) + isnanc(parseFloat(res.p3[2])) + isnanc(parseFloat(res.p4[2])))/4).toFixed(1);
                	    var cf3 = ((isnanc(parseFloat(res.p1[3])) + isnanc(parseFloat(res.p2[3])) + isnanc(parseFloat(res.p3[3])) + isnanc(parseFloat(res.p4[3])))/4).toFixed(1);
                	    var cf4 = ((isnanc(parseFloat(res.p1[4])) + isnanc(parseFloat(res.p2[4])) + isnanc(parseFloat(res.p3[4])) + isnanc(parseFloat(res.p4[4])))/4).toFixed(1);
            	    }
            	    var datos = {
                        labels : [res.lbls[0] + " (CF="+cf0+")",res.lbls[1] + " (CF="+cf1+")",res.lbls[2] + " (CF="+cf2+")",res.lbls[3] + " (CF="+cf3+")",res.lbls[4] + " (CF="+cf4+")","."],
                        datasets : [
                            {label : "P1", backgroundColor : "rgba(249,255,51,0.9)", data : [res.p1[0],res.p1[1],res.p1[2],res.p1[3],res.p1[4],0], order: 1},
                            {label : "P2", backgroundColor : "rgba(151,187,205,0.9)", data : [res.p2[0],res.p2[1],res.p2[2],res.p2[3],res.p2[4],0], order: 1},
                            {label : "P3", backgroundColor : "rgba(239,152,60,0.9)", data : [res.p3[0],res.p3[1],res.p3[2],res.p3[3],res.p3[4],0], order: 1},
                            {label : "P4", backgroundColor : "rgba(150,85,244,0.9)", data : [res.p4[0],res.p4[1],res.p4[2],res.p4[3],res.p4[4],0], order: 1},
                            {label : "Cal. Final", backgroundColor : "#000000", data : [cf0,cf1,cf2,cf3,cf4], type: 'line', fill : false, pointRadius: 5, showLine: false, borderColor : "#000000", order: 0},
                            {label : "Cal. Min.", backgroundColor : "rgba(255,0,0,0.9)", data : [3,3,3,3,3,3], type: 'line', fill : false, borderColor : "#FF0000", order: 3}
                        ]
                    };
            	}
            	else if(res.lbls.length == 6) {
            	    if(vper == "1") {
    			        var cf0 = ((isnanc(parseFloat(res.p1[0])))/1).toFixed(1);
                	    var cf1 = ((isnanc(parseFloat(res.p1[1])))/1).toFixed(1);
                	    var cf2 = ((isnanc(parseFloat(res.p1[2])))/1).toFixed(1);
                	    var cf3 = ((isnanc(parseFloat(res.p1[3])))/1).toFixed(1);
                	    var cf4 = ((isnanc(parseFloat(res.p1[4])))/1).toFixed(1);
                	    var cf5 = ((isnanc(parseFloat(res.p1[5])))/1).toFixed(1);
    			    }
    			    else if(vper == "2") {
    			        var cf0 = ((isnanc(parseFloat(res.p1[0])) + isnanc(parseFloat(res.p2[0])))/2).toFixed(1);
                	    var cf1 = ((isnanc(parseFloat(res.p1[1])) + isnanc(parseFloat(res.p2[1])))/2).toFixed(1);
                	    var cf2 = ((isnanc(parseFloat(res.p1[2])) + isnanc(parseFloat(res.p2[2])))/2).toFixed(1);
                	    var cf3 = ((isnanc(parseFloat(res.p1[3])) + isnanc(parseFloat(res.p2[3])))/2).toFixed(1);
                	    var cf4 = ((isnanc(parseFloat(res.p1[4])) + isnanc(parseFloat(res.p2[4])))/2).toFixed(1);
                	    var cf5 = ((isnanc(parseFloat(res.p1[5])) + isnanc(parseFloat(res.p2[5])))/2).toFixed(1);
            	    }
            	    else if(vper == "3") {
    			        var cf0 = ((isnanc(parseFloat(res.p1[0])) + isnanc(parseFloat(res.p2[0])) + isnanc(parseFloat(res.p3[0])))/3).toFixed(1);
                	    var cf1 = ((isnanc(parseFloat(res.p1[1])) + isnanc(parseFloat(res.p2[1])) + isnanc(parseFloat(res.p3[1])))/3).toFixed(1);
                	    var cf2 = ((isnanc(parseFloat(res.p1[2])) + isnanc(parseFloat(res.p2[2])) + isnanc(parseFloat(res.p3[2])))/3).toFixed(1);
                	    var cf3 = ((isnanc(parseFloat(res.p1[3])) + isnanc(parseFloat(res.p2[3])) + isnanc(parseFloat(res.p3[3])))/3).toFixed(1);
                	    var cf4 = ((isnanc(parseFloat(res.p1[4])) + isnanc(parseFloat(res.p2[4])) + isnanc(parseFloat(res.p3[4])))/3).toFixed(1);
                	    var cf5 = ((isnanc(parseFloat(res.p1[5])) + isnanc(parseFloat(res.p2[5])) + isnanc(parseFloat(res.p3[5])))/3).toFixed(1);
            	    }
            	    else {
            	        var cf0 = ((isnanc(parseFloat(res.p1[0])) + isnanc(parseFloat(res.p2[0])) + isnanc(parseFloat(res.p3[0])) + isnanc(parseFloat(res.p4[0])))/4).toFixed(1);
                	    var cf1 = ((isnanc(parseFloat(res.p1[1])) + isnanc(parseFloat(res.p2[1])) + isnanc(parseFloat(res.p3[1])) + isnanc(parseFloat(res.p4[1])))/4).toFixed(1);
                	    var cf2 = ((isnanc(parseFloat(res.p1[2])) + isnanc(parseFloat(res.p2[2])) + isnanc(parseFloat(res.p3[2])) + isnanc(parseFloat(res.p4[2])))/4).toFixed(1);
                	    var cf3 = ((isnanc(parseFloat(res.p1[3])) + isnanc(parseFloat(res.p2[3])) + isnanc(parseFloat(res.p3[3])) + isnanc(parseFloat(res.p4[3])))/4).toFixed(1);
                	    var cf4 = ((isnanc(parseFloat(res.p1[4])) + isnanc(parseFloat(res.p2[4])) + isnanc(parseFloat(res.p3[4])) + isnanc(parseFloat(res.p4[4])))/4).toFixed(1);
                	    var cf5 = ((isnanc(parseFloat(res.p1[5])) + isnanc(parseFloat(res.p2[5])) + isnanc(parseFloat(res.p3[5])) + isnanc(parseFloat(res.p4[5])))/4).toFixed(1);
            	    }
            	    var datos = {
                        labels : [res.lbls[0] + " (CF="+cf0+")",res.lbls[1] + " (CF="+cf1+")",res.lbls[2] + " (CF="+cf2+")",res.lbls[3] + " (CF="+cf3+")",res.lbls[4] + " (CF="+cf4+")",res.lbls[5] + " (CF="+cf5+")","."],
                        datasets : [
                            {label : "P1", backgroundColor : "rgba(249,255,51,0.9)", data : [res.p1[0],res.p1[1],res.p1[2],res.p1[3],res.p1[4],res.p1[5],0], order: 1},
                            {label : "P2", backgroundColor : "rgba(151,187,205,0.9)", data : [res.p2[0],res.p2[1],res.p2[2],res.p2[3],res.p2[4],res.p2[5],0], order: 1},
                            {label : "P3", backgroundColor : "rgba(239,152,60,0.9)", data : [res.p3[0],res.p3[1],res.p3[2],res.p3[3],res.p3[4],res.p3[5],0], order: 1},
                            {label : "P4", backgroundColor : "rgba(150,85,244,0.9)", data : [res.p4[0],res.p4[1],res.p4[2],res.p4[3],res.p4[4],res.p4[5],0], order: 1},
                            {label : "Cal. Final", backgroundColor : "#000000", data : [cf0,cf1,cf2,cf3,cf4,cf5], type: 'line', fill : false, pointRadius: 5, showLine: false, borderColor : "#000000", order: 0},
                            {label : "Cal. Min.", backgroundColor : "rgba(255,0,0,0.9)", data : [3,3,3,3,3,3,3], type: 'line', fill : false, borderColor : "#FF0000", order: 3}
                        ]
                    };
            	}
            	else if(res.lbls.length == 7) {
            	    if(vper == "1") {
            	        var cf0 = ((isnanc(parseFloat(res.p1[0])))/1).toFixed(1);
                	    var cf1 = ((isnanc(parseFloat(res.p1[1])))/1).toFixed(1);
                	    var cf2 = ((isnanc(parseFloat(res.p1[2])))/1).toFixed(1);
                	    var cf3 = ((isnanc(parseFloat(res.p1[3])))/1).toFixed(1);
                	    var cf4 = ((isnanc(parseFloat(res.p1[4])))/1).toFixed(1);
                	    var cf5 = ((isnanc(parseFloat(res.p1[5])))/1).toFixed(1);
                	    var cf6 = ((isnanc(parseFloat(res.p1[6])))/1).toFixed(1);
            	    }
            	    else if(vper == "2") {
            	        var cf0 = ((isnanc(parseFloat(res.p1[0])) + isnanc(parseFloat(res.p2[0])))/2).toFixed(1);
                	    var cf1 = ((isnanc(parseFloat(res.p1[1])) + isnanc(parseFloat(res.p2[1])))/2).toFixed(1);
                	    var cf2 = ((isnanc(parseFloat(res.p1[2])) + isnanc(parseFloat(res.p2[2])))/2).toFixed(1);
                	    var cf3 = ((isnanc(parseFloat(res.p1[3])) + isnanc(parseFloat(res.p2[3])))/2).toFixed(1);
                	    var cf4 = ((isnanc(parseFloat(res.p1[4])) + isnanc(parseFloat(res.p2[4])))/2).toFixed(1);
                	    var cf5 = ((isnanc(parseFloat(res.p1[5])) + isnanc(parseFloat(res.p2[5])))/2).toFixed(1);
                	    var cf6 = ((isnanc(parseFloat(res.p1[6])) + isnanc(parseFloat(res.p2[6])))/2).toFixed(1);
            	    }
            	    else if(vper == "3") {
            	        var cf0 = ((isnanc(parseFloat(res.p1[0])) + isnanc(parseFloat(res.p2[0])) + isnanc(parseFloat(res.p3[0])))/3).toFixed(1);
                	    var cf1 = ((isnanc(parseFloat(res.p1[1])) + isnanc(parseFloat(res.p2[1])) + isnanc(parseFloat(res.p3[1])))/3).toFixed(1);
                	    var cf2 = ((isnanc(parseFloat(res.p1[2])) + isnanc(parseFloat(res.p2[2])) + isnanc(parseFloat(res.p3[2])))/3).toFixed(1);
                	    var cf3 = ((isnanc(parseFloat(res.p1[3])) + isnanc(parseFloat(res.p2[3])) + isnanc(parseFloat(res.p3[3])))/3).toFixed(1);
                	    var cf4 = ((isnanc(parseFloat(res.p1[4])) + isnanc(parseFloat(res.p2[4])) + isnanc(parseFloat(res.p3[4])))/3).toFixed(1);
                	    var cf5 = ((isnanc(parseFloat(res.p1[5])) + isnanc(parseFloat(res.p2[5])) + isnanc(parseFloat(res.p3[5])))/3).toFixed(1);
                	    var cf6 = ((isnanc(parseFloat(res.p1[6])) + isnanc(parseFloat(res.p2[6])) + isnanc(parseFloat(res.p3[6])))/3).toFixed(1);
            	    }
            	    else {
            	        var cf0 = ((isnanc(parseFloat(res.p1[0])) + isnanc(parseFloat(res.p2[0])) + isnanc(parseFloat(res.p3[0])) + isnanc(parseFloat(res.p4[0])))/4).toFixed(1);
                	    var cf1 = ((isnanc(parseFloat(res.p1[1])) + isnanc(parseFloat(res.p2[1])) + isnanc(parseFloat(res.p3[1])) + isnanc(parseFloat(res.p4[1])))/4).toFixed(1);
                	    var cf2 = ((isnanc(parseFloat(res.p1[2])) + isnanc(parseFloat(res.p2[2])) + isnanc(parseFloat(res.p3[2])) + isnanc(parseFloat(res.p4[2])))/4).toFixed(1);
                	    var cf3 = ((isnanc(parseFloat(res.p1[3])) + isnanc(parseFloat(res.p2[3])) + isnanc(parseFloat(res.p3[3])) + isnanc(parseFloat(res.p4[3])))/4).toFixed(1);
                	    var cf4 = ((isnanc(parseFloat(res.p1[4])) + isnanc(parseFloat(res.p2[4])) + isnanc(parseFloat(res.p3[4])) + isnanc(parseFloat(res.p4[4])))/4).toFixed(1);
                	    var cf5 = ((isnanc(parseFloat(res.p1[5])) + isnanc(parseFloat(res.p2[5])) + isnanc(parseFloat(res.p3[5])) + isnanc(parseFloat(res.p4[5])))/4).toFixed(1);
                	    var cf6 = ((isnanc(parseFloat(res.p1[6])) + isnanc(parseFloat(res.p2[6])) + isnanc(parseFloat(res.p3[6])) + isnanc(parseFloat(res.p4[6])))/4).toFixed(1);
            	    }
            	    //labels : [res.lbls[0],res.lbls[1],res.lbls[2],res.lbls[3],res.lbls[4],res.lbls[5],res.lbls[6],"."],
            	    //labels : [res.lbls[0] + " (CF="+cf0+")",res.lbls[1] + " (CF="+cf1+")",res.lbls[2] + " (CF="+cf2+")",res.lbls[3] + " (CF="+cf3+")",res.lbls[4] + " (CF="+cf4+")",res.lbls[5] + " (CF="+cf5+")",res.lbls[6] + " (CF="+cf6+")","."],
            	    var datos = {
                        labels : [res.lbls[0] + " (CF="+cf0+")",res.lbls[1] + " (CF="+cf1+")",res.lbls[2] + " (CF="+cf2+")",res.lbls[3] + " (CF="+cf3+")",res.lbls[4] + " (CF="+cf4+")",res.lbls[5] + " (CF="+cf5+")",res.lbls[6] + " (CF="+cf6+")","."],
                        datasets : [
                            {label : "P1", backgroundColor : "rgba(249,255,51,0.9)", data : [res.p1[0],res.p1[1],res.p1[2],res.p1[3],res.p1[4],res.p1[5],res.p1[6],0], order: 1},
                            {label : "P2", backgroundColor : "rgba(151,187,205,0.9)", data : [res.p2[0],res.p2[1],res.p2[2],res.p2[3],res.p2[4],res.p2[5],res.p2[6],0], order: 1},
                            {label : "P3", backgroundColor : "rgba(239,152,60,0.9)", data : [res.p3[0],res.p3[1],res.p3[2],res.p3[3],res.p3[4],res.p3[5],res.p3[6],0], order: 1},
                            {label : "P4", backgroundColor : "rgba(150,85,244,0.9)", data : [res.p4[0],res.p4[1],res.p4[2],res.p4[3],res.p4[4],res.p4[5],res.p4[6],0], order: 1},
                            {label : "Cal. Final", backgroundColor : "#000000", data : [cf0,cf1,cf2,cf3,cf4,cf5,cf6], type: 'line', fill : false, pointRadius: 5, showLine: false, borderColor : "#000000", order: 0},
                            {label : "Cal. Min.", backgroundColor : "rgba(255,0,0,0.9)", data : [3,3,3,3,3,3,3,3], type: 'line', fill : false, borderColor : "#FF0000", order: 3}
                        ]
                    };
            	}
    			
    			//Se borra la etiqueta canvas
    			$("#grafico").remove();
    			//Se genera un nuevo canvas
    			$("#divcanvas").append('<canvas id="grafico" width="800" height="200"></canvas>');
                
                var canvas = document.getElementById("grafico").getContext("2d");
                window.bar = new Chart(canvas, {
                    type : "bar",
                    data : datos,
                    options : {
                        elements : {
                            rectangle : {
                                borderWidth : 1, 
                                borderColor : "gray", 
                                borderSkipped : "bottom",
                                width : 5
                            }
                        },
                        responsive : true,
                        showTooltips: false,
                        title : {
                            display : true,
                            text : "CALIFICACIONES EN REGISTRO",
                            fontSize : 14
                        }
                    }
                });
                //window.bar.update();
                
                var value=$("#txtidest").val();
                ver_desemp(value);
                $("#divdesemp").show();
            }
            //*******************************************************************************
            
            function ver_cal(id_est, id_gra) {
                //alert(id_est + id_gra);
            	$.ajax({
            		type:"POST",
            		url:"buscar_notas.php",
            		data:"idest=" + id_est + "&idgra=" + id_gra,
            		success:function(r) {
            			mostrar_notas(r);
            		}
            	});
            }
            
            function ver_desemp(id_est) {
                //alert(id_est + id_gra);
            	$.ajax({
            		type:"POST",
            		url:"desemp_getdat.php",
            		data:"idest_ra=" + id_est,
            		success:function(r) {
            			mostrar_desemp(r);
            		}
            	});
            }
            
            //*******************************************************************************
            function mostrar_desemp(data) {
                var res = JSON.parse(data);
    			
    			// *** PRIMER PEN ***
            	//Se borra la etiqueta canvas
    			$("#grafico1").remove();
    			if(res.length >= 1) {
    			    var datos = {
                        labels : ["DB","DA","AF"],
                        datasets : [
                            {data : [res[0].cb, res[0].ca, res[0].cf],
                            backgroundColor: ["#FDB45C", "rgba(129,218,122,0.9)", "#F7464A"]
                            }
                        ]
                    };
        			//$("#divresul").html(data);
        			//console.log(datos);
        			
        			//Se genera un nuevo canvas
        			$("#divcanvas1").append('<canvas id="grafico1" width="200" height="200"></canvas>');
                    
                    var canvas = document.getElementById("grafico1").getContext("2d");
                    window.pie = new Chart(canvas, {
                        type : "pie",
                        data : datos,
                        options : {
                            responsive : false,
                            title : {
                                display : true,
                                text : res[0].shortname,
                                fontSize : 14
                            },
                            legend : {display : false}
                        }
                    });
    			}
                
                // *** SEGUNDO PEN ***
            	//Se borra la etiqueta canvas
    			$("#grafico2").remove();
    			if(res.length >= 2) {
    			    var datos = {
                        labels : ["DB","DA","AF"],
                        datasets : [
                            {data : [res[1].cb, res[1].ca, res[1].cf],
                            backgroundColor: ["#FDB45C", "rgba(129,218,122,0.9)", "#F7464A"]
                            }
                        ]
                    };
        			//$("#divresul").html(data);
        			//console.log(datos);
        			
        			//Se genera un nuevo canvas
        			$("#divcanvas2").append('<canvas id="grafico2" width="200" height="200"></canvas>');
                    
                    var canvas = document.getElementById("grafico2").getContext("2d");
                    window.pie = new Chart(canvas, {
                        type : "pie",
                        data : datos,
                        options : {
                            responsive : false,
                            title : {
                                display : true,
                                text : res[1].shortname,
                                fontSize : 14
                            },
                            legend : {display : false}
                        }
                    });
    			}
                
                // *** TERCER PEN ***
            	//Se borra la etiqueta canvas
    			$("#grafico3").remove();
    			if(res.length >= 3) {
    			    var datos = {
                        labels : ["DB","DA","AF"],
                        datasets : [
                            {data : [res[2].cb, res[2].ca, res[2].cf],
                            backgroundColor: ["#FDB45C", "rgba(129,218,122,0.9)", "#F7464A"]
                            }
                        ]
                    };
        			//$("#divresul").html(data);
        			//console.log(datos);
        			
        			//Se genera un nuevo canvas
        			$("#divcanvas3").append('<canvas id="grafico3" width="200" height="200"></canvas>');
                    
                    var canvas = document.getElementById("grafico3").getContext("2d");
                    window.pie = new Chart(canvas, {
                        type : "pie",
                        data : datos,
                        options : {
                            responsive : false,
                            title : {
                                display : true,
                                text : res[2].shortname,
                                fontSize : 14
                            },
                            legend : {display : false}
                        }
                    });
    			}
                
                // *** CUARTO PEN ***
            	//Se borra la etiqueta canvas
    			$("#grafico4").remove();
    			if(res.length >= 4) {
    			    var datos = {
                        labels : ["DB","DA","AF"],
                        datasets : [
                            {data : [res[3].cb, res[3].ca, res[3].cf],
                            backgroundColor: ["#FDB45C", "rgba(129,218,122,0.9)", "#F7464A"]
                            }
                        ]
                    };
        			//$("#divresul").html(data);
        			//console.log(datos);
        			
        			//Se genera un nuevo canvas
        			$("#divcanvas4").append('<canvas id="grafico4" width="200" height="200"></canvas>');
                    
                    var canvas = document.getElementById("grafico4").getContext("2d");
                    window.pie = new Chart(canvas, {
                        type : "pie",
                        data : datos,
                        options : {
                            responsive : false,
                            title : {
                                display : true,
                                text : res[3].shortname,
                                fontSize : 14
                            },
                            legend : {display : false}
                        }
                    });
    			}
                
                // *** QUINTO PEN ***
            	//Se borra la etiqueta canvas
    			$("#grafico5").remove();
    			if(res.length >= 5) {
    			    var datos = {
                        labels : ["DB","DA","AF"],
                        datasets : [
                            {data : [res[4].cb, res[4].ca, res[4].cf],
                            backgroundColor: ["#FDB45C", "rgba(129,218,122,0.9)", "#F7464A"]
                            }
                        ]
                    };
        			//$("#divresul").html(data);
        			//console.log(datos);
        			
        			//Se genera un nuevo canvas
        			$("#divcanvas5").append('<canvas id="grafico5" width="200" height="200"></canvas>');
                    
                    var canvas = document.getElementById("grafico5").getContext("2d");
                    window.pie = new Chart(canvas, {
                        type : "pie",
                        data : datos,
                        options : {
                            responsive : false,
                            title : {
                                display : true,
                                text : res[4].shortname,
                                fontSize : 14
                            },
                            legend : {display : false}
                        }
                    });
    			}
                
                // *** SEXTO PEN ***
            	//Se borra la etiqueta canvas
    			$("#grafico6").remove();
    			if(res.length >= 6) {
    			    var datos = {
                        labels : ["DB","DA","AF"],
                        datasets : [
                            {data : [res[5].cb, res[5].ca, res[5].cf],
                            backgroundColor: ["#FDB45C", "rgba(129,218,122,0.9)", "#F7464A"]
                            }
                        ]
                    };
        			//$("#divresul").html(data);
        			//console.log(datos);
        			
        			//Se genera un nuevo canvas
        			$("#divcanvas6").append('<canvas id="grafico6" width="200" height="200"></canvas>');
                    
                    var canvas = document.getElementById("grafico6").getContext("2d");
                    window.pie = new Chart(canvas, {
                        type : "pie",
                        data : datos,
                        options : {
                            responsive : false,
                            title : {
                                display : true,
                                text : res[5].shortname,
                                fontSize : 14
                            },
                            legend : {display : false}
                        }
                    });
    			}
                
                //var value=$("#txtidest").val();
                //ver_cal_mood(value);
            }
            //*******************************************************************************
            
            function ver_cal_mood(id_est,id_gra) {
                //alert(id_est + id_gra);
                var cadena = "";
                cadena = cadena + "<fieldset id='ftm'><legend>NOTAS EN MOODLE</legend><table border='2' bordercolor='#e0e0e0' class='tr'><thead>" +
                                    "<tr border='2'>" +
                                    "<td><b>ID ESTUDIANTE</b></td>" +
                                    "<td><b>APELLIDOS</b></td>" +
                                    "<td><b>NOMBRES</b></td>" +
                                    "<td><b>PENSAMIENTO</b></td>" +
                                    "<td><b>PENSAMIENTO RA</b></td>" +
                                    "<td><b>ID PERIODO MOODLE</b></td>" +
                                    "<td><b>PERIODO RA</b></td>" +
                                    "<td><b>CALIFICACION</b></td></tr></thead><tbody>";
    			//alert(cadena);
    			
            	$.ajax({
            		type:"POST",
            		url:"buscar_notas_mood.php",
            		data:"idest_ra1=" + id_est + "&idgra_ra1=" + id_gra,
            		success:function(r) {
            			//mostrar_notas_mood(r);
            			
            			//Esto es para mostrar la tabla con las notas moodle
            			var res = JSON.parse(r);
            			console.log(res);
            			var lineas = res.tabla.lineas;
            			//console.log(lineas);
            			//$("#tablam").html(lineas.length);
            			for(var i = 0; i < lineas.length; i++) {
            			    var idestm = lineas[i].id_est;
            			    var lastn = lineas[i].lastname;
            			    var firstn = lineas[i].firstname;
            			    var shortn = lineas[i].shortname;
            			    var pen = lineas[i].pensamiento;
            			    var idnumber = lineas[i].idnumber;
            			    var per = lineas[i].periodo;
            			    var cal = lineas[i].calificacion;
            			    cadena = cadena + "<tr>" +
                        						"<td>" + idestm + "</td>" +
                        						"<td>" + lastn + "</td>" +
                        						"<td>" + firstn + "</td>" +
                        						"<td>" + shortn + "</td>" +
                        						"<td>" + pen + "</td>" +
                        						"<td>" + idnumber + "</td>" +
                        						"<td>" + per + "</td>" +
                        						"<td>" + cal + "</td>"
                        					"</tr>";
            			}
            			cadena = cadena + "</tbody></table></fieldset>";
            			$("#ftm").remove();
    			        $("#tablam").append(cadena);
            			$("#tablam").show();
            		}
            	});
            	
            	var value=$("#txtidest").val();
            	var value1=$("#txtidgra").val();
            	ver_cal(value,value1);
            }
            
        </script>
	</head>
	<body>
		<center>
			<div id="enc" style="display: none;">
				<img src="img/enc2.png" alt="enc2" />
			</div>
			<label>Calcular promedio para periodo</label>
			<?php  
			    //echo $per;
			    if($per == "P1") {
			        echo '<select id="selperiodo">
        			    <option value="1" selected>1</option>
        			    <option value="2">2</option>
        			    <option value="3">3</option>
        			    <option value="4">4</option>
        			</select>';
        		}
        		else if($per == "P2") {
			        echo '<select id="selperiodo">
        			    <option value="1">1</option>
        			    <option value="2" selected>2</option>
        			    <option value="3">3</option>
        			    <option value="4">4</option>
        			</select>';
        		}
        		else if($per == "P3") {
			        echo '<select id="selperiodo">
        			    <option value="1">1</option>
        			    <option value="2">2</option>
        			    <option value="3" selected>3</option>
        			    <option value="4">4</option>
        			</select>';
        		}
        		else if($per == "P4") {
			        echo '<select id="selperiodo">
        			    <option value="1">1</option>
        			    <option value="2">2</option>
        			    <option value="3">3</option>
        			    <option value="4" selected>4</option>
        			</select>';
        		}
        	?>
			<div id="divres">
				<table>
					<tbody>
						<tr>
							<td height="30">
							</td>
							<td></td>
						</tr>
						<tr>
							<td>
								<fieldset>
									<legend>Base de Datos de Estudiantes
									</legend>
									<?php
									    if($perdiendo == true) {
									        echo '<label>Total Registros &#9658; '.$sel.'<span style="color: red"> (perdiendo)</span></label>';
									    }
									    else {
									        echo '<label>Total Registros &#9658; '.$sel.'</label>';
									    }
									    
									?>
									<div>
									    <table border="1px" class="table" id="tblest">
											<thead>
											<tr class="GridViewScrollHeader">
												<td class="tdlargo"><b>NOMBRE</b></td>
												<td class="tdcorto"><b>ID</b></td>
												<td class="tdmedia"><b>ID GRADO</b></td>
												<td class="tdmedia"><b>GRUPO</b></td>
												<td class="tdnormal"><b>GRADO</b></td>
												<td class="tdmediol"><b>MATRICULA</b></td>
												<td class="tdnormal"><b>ID MAT.</b></td>
												<td class="tdlargo"><b>USUARIO</b></td>
												<td class="tdmediol"><b>DOCUMENTO No.</b></td>
												<td class="tdmediol1"><b>EXPEDICION</b></td>
												<td class="tdmediol"><b>FECHA NACIMIENTO</b></td>
												<td class="tdlargo"><b>EMAIL INST</b></td>
												<td class="tdlargo"><b>ACUDIENTE 1</b></td>
												<td class="tdlargo"><b>EMAIL ACUDIENTE 1</b></td>
												<td class="tdmediol1"><b>TELEFONO ACUDIENTE 1</b></td>
												<td class="tdlargo"><b>ACUDIENTE 2</b></td>
												<td class="tdlargo"><b>EMAIL ACUDIENTE 2</b></td>
												<td class="tdmediol1"><b>TELEFONO ACUDIENTE 2</b></td>
												<td class="tdelargo"><b>DIRECCION</b></td>
												<td class="tdmediol1"><b>CIUDAD</b></td>
												<td class="tdmediol"><b>ACTIVIDAD EXTRA</b></td>
											</tr>
											</thead>
											<tbody>
											<?php
											    while($row = $resultado->fetch_assoc()){
											?>
											<tr class="GridviewScrollItem">
												<td class="tdlargo"><?php echo $row['nombre'];?></td>
												<td class="tdcorto"><?php echo $row['id'];?></td>
												<td class="tdmedia"><?php echo $row['id_grado_ra'];?></td>
												<td class="tdmedia"><?php echo $row['grupo'];?></td>
												<td class="tdnormal"><?php echo $row['grado'];?></td>
												<td class="tdmediol"><?php echo $row['n_matricula'];?></td>
												<td class="tdnormal"><?php echo $row['idMatricula'];?></td>
												<td class="tdlargo"><?php echo $row['usuario'];?></td>
												<td class="tdmediol"><?php echo $row['n_documento'];?></td>
												<td class="tdmediol1"><?php echo $row['expedicion'];?></td>
												<td class="tdmediol"><?php echo $row['fecha_nacimiento'];?></td>
												<td class="tdlargo"><?php echo $row['email_institucional'];?></td>
												<td class="tdlargo"><?php echo $row['acudiente_1'];?></td>
												<td class="tdlargo"><?php echo $row['email_acudiente_1'];?></td>
												<td class="tdmediol1"><?php echo $row['telefono_acudiente_1'];?></td>
												<td class="tdlargo"><?php echo $row['acudiente_2'];?></td>
												<td class="tdlargo"><?php echo $row['email_acudiente_2'];?></td>
												<td class="tdmediol1"><?php echo $row['telefono_acudiente_2'];?></td>
												<td class="tdelargo"><?php echo $row['direccion'];?></td>
												<td class="tdmediol1"><?php echo $row['ciudad'];?></td>
												<td class="tdmediol"><?php echo $row['actividad_extra'];?></td>
											</tr>
											<?php 
											        $fila++;
											    }
												$resultado->close();
												$mysqli1->close();
											?>
											</tbody>
										</table>
									</div>
								</fieldset>
							</td>
							<td>
							    <label class="fa fa-pencil-square"> Observaciones estudiante</label>
                                <textarea id="txtobs" class="form-control" cols='21' rows='5' placeholder="..." readonly></textarea>
                                <!--<br><button id="btnres_evalpres" class='btn btn-info glyphicon glyphicon-pencil'>Ver Evaluación Presaberes</button>-->
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<br/>
			<input type="hidden" id="txtidest"/><input type="hidden" id="txtidgra"/>
			<div id="divcanvas" style="display: block;">
			    <canvas id="grafico" width="800" height="200"></canvas>
			</div>
			<div id="divresul"></div><br />
			<div id="divdesemp" style="display: none;">
			    <fieldset>
			        <legend>DESEMPEÑO ACUMULADO</legend>
			        <table width="100%">
    			        <tbody>
    			            <tr>
    			                <td colspan="6" style="text-align: center;">
    			                    <label style="color: #FDB45C; background: #FDB45C;">-----</label><span> DB -> DESEMP. BASICO (Act. entre 3.0 y 4.0) </span>
                			        <label style="color: rgba(129,218,122,0.9); background: rgba(129,218,122,0.9);">-----</label><span> DA -> DESEMP. ALTO (Act. > 4.0) </span>
                			        <label style="color: #F7464A; background: #F7464A;">-----</label><span> AF -> ACTIVIDADES FALTANTES </span>
                			    </td>
    			            </tr>
    			            <tr>
    			                <td><div id="divcanvas1"><canvas id="grafico1" width="200" height="200"></canvas></div></td>
    			                <td><div id="divcanvas2"><canvas id="grafico2" width="200" height="200"></canvas></div></td>
    			                <td><div id="divcanvas3"><canvas id="grafico3" width="200" height="200"></canvas></div></td>
    			                <td><div id="divcanvas4"><canvas id="grafico4" width="200" height="200"></canvas></div></td>
    			                <td><div id="divcanvas5"><canvas id="grafico5" width="200" height="200"></canvas></div></td>
    			                <td><div id="divcanvas6"><canvas id="grafico6" width="200" height="200"></canvas></div></td>
    			            </tr>
    			        </tbody>
    			    </table>
			    </fieldset>
			</div>
			<div id="tablam" style="display: none;">
			    
			</div>
		</center>
	</body>
	
</html>
<?php
    /*}else{
    	echo "<script>alert('Debes iniciar sesiﾃｳn');</script>";
    	echo "<script>location.href='../login.php'</script>";
    }*/
?>