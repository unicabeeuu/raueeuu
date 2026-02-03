<?php
    session_start();
	require("1cc3s4db.php");
	require("1cc3s4db_m.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
//if (isset($_SESSION['uniprofe']) || isset($_SESSION['unisuper'])) {
	$idest = $_REQUEST["idest_ra"];
	//$idest = 500;
	//echo $idest;
	
	$desemp = array();
	
	if (isset($_SESSION['uniprofe'])) {
		$queryr0 = "Delete From tbl_desemp Where email_inst = '".$_SESSION['uniprofe']."'";
	}
	else if (isset($_SESSION['unisuper'])) {
		$queryr0 = "Delete From tbl_desemp Where email_inst = '".$_SESSION['unisuper']."'";
	}
	else if (isset($_SESSION['admin_unicab'])) {
		$queryr0 = "Delete From tbl_desemp Where email_inst = '".$_SESSION['admin_unicab']."'";
	}
	//echo $queryr0;
	$resultado_r0=$mysqli1->query($queryr0);
	
	//Se busca el id estudiante de moodle
	$queryr1 = "SELECT id_moodle FROM equivalence_idest WHERE id_registro = '$idest'";
	$resultado_r1=$mysqli1->query($queryr1);
	while($row1 = $resultado_r1->fetch_assoc()){
		$idest_m = $row1['id_moodle'];
	}
	
	//echo $idest_m;
	//AND c.shortname NOT IN ('CapDocente','Infograf赤as','Ingraf赤as','Pr芍cticaDoc','Ajedrz','Inducci車n','Inducci車n-Unicab') 
	$query1 = "SELECT UPPER(CONCAT(u.lastname, ' ', u.firstname)) nombre, u.id, c.shortname, cast(ifnull(gg.finalgrade/10, 0) as decimal(10,1)) as calificacion, 
	    gi.itemname, gi.idnumber 
		FROM mood_grade_grades gg, mood_grade_items gi, mood_course c, mood_user u, mood_role_assignments ra, mood_context ct   
		WHERE gg.itemid=gi.id AND gi.courseid=c.id 
		AND gg.userid=u.id AND u.id = ra.userid AND ra.contextid = ct.id AND ct.instanceid = c.id 
		AND gi.itemtype='mod' AND ct.contextlevel = 50 AND ra.roleid = 5 
		AND u.id = '$idest_m' 
		AND gi.grademax > 1";
	//echo $query1;
	//echo $_SESSION['uniprofe'];
	//echo $_SESSION['unisuper'];
	//echo $_SESSION['admin_unicab'];
	$resultado=$mysqli->query($query1);
	$sel = $mysqli->affected_rows;
	//echo $sel;
	
	while($row = $resultado->fetch_assoc()){
		if (isset($_SESSION['uniprofe'])) {
		    $query2="INSERT INTO tbl_desemp (nombre, id, shortname, calificacion, email_inst, itemname, idnumber) 
			VALUES ('".$row['nombre']."',".$row['id'].",'".$row['shortname']."',".$row['calificacion'].",'".$_SESSION['uniprofe']."','".$row['itemname']."','".$row['idnumber']."')";
		}
		else if (isset($_SESSION['unisuper'])) {
			$query2="INSERT INTO tbl_desemp (nombre, id, shortname, calificacion, email_inst, itemname, idnumber) 
			VALUES ('".$row['nombre']."',".$row['id'].",'".$row['shortname']."',".$row['calificacion'].",'".$_SESSION['unisuper']."','".$row['itemname']."','".$row['idnumber']."')";
		}
		else if (isset($_SESSION['admin_unicab'])) {
			$query2="INSERT INTO tbl_desemp (nombre, id, shortname, calificacion, email_inst, itemname, idnumber) 
			VALUES ('".$row['nombre']."',".$row['id'].",'".$row['shortname']."',".$row['calificacion'].",'".$_SESSION['admin_unicab']."','".$row['itemname']."','".$row['idnumber']."')";
		}
		$resultado2=$mysqli1->query($query2);
		//echo $query2;
	}
	//echo $query2;
	//echo $shortname;
	//echo $_SESSION['uniprofe'];
	
	if (isset($_SESSION['uniprofe'])) {
		/*$query3 = "SELECT a.ct ctt, a.shortname, ifnull(b.ct,0) cb, ifnull(c.ct,0) ca, a.ct-ifnull(b.ct,0)-ifnull(c.ct,0) cf 
		FROM 
		(SELECT COUNT(1) ct, shortname 
		FROM tbl_desemp WHERE id = '$idest_m' AND email_inst = '".$_SESSION['uniprofe']."' GROUP BY shortname) a 
		LEFT JOIN 
		(SELECT COUNT(1) ct, shortname 
		FROM tbl_desemp WHERE id = '$idest_m' AND email_inst = '".$_SESSION['uniprofe']."' AND calificacion BETWEEN 3 AND 4 GROUP BY shortname) b 
		ON a.shortname = b.shortname 
		LEFT JOIN 
		(SELECT COUNT(1) ct, shortname 
		FROM tbl_desemp WHERE id = '$idest_m' AND email_inst = '".$_SESSION['uniprofe']."' AND calificacion > 4 GROUP BY shortname) c 
		ON a.shortname = c.shortname";*/
		
		//ta.ct -> cantidad total de actividades por curso
		//z.cb -> cantidad de actividades con calificaci車n entre 3 y 4
		//z.ca -> cantidad de actividades con calificaci車n mayor a 4
		$query3 = "SELECT ta.ct ctt, ta.shortname, z.cb, z.ca, ta.ct-z.cb-z.ca cf 
		FROM 
		(SELECT a.ct ctt, a.shortname, ifnull(b.ct,0) cb, ifnull(c.ct,0) ca 
		FROM 
		(SELECT COUNT(1) ct, shortname 
		FROM tbl_desemp WHERE id = '$idest_m' AND email_inst = '".$_SESSION['uniprofe']."' GROUP BY shortname) a 
		LEFT JOIN 
		(SELECT COUNT(1) ct, shortname 
		FROM tbl_desemp WHERE id = '$idest_m' AND email_inst = '".$_SESSION['uniprofe']."' AND calificacion BETWEEN 3 AND 4 GROUP BY shortname) b 
		ON a.shortname = b.shortname 
		LEFT JOIN 
		(SELECT COUNT(1) ct, shortname 
		FROM tbl_desemp WHERE id = '$idest_m' AND email_inst = '".$_SESSION['uniprofe']."' AND calificacion > 4 GROUP BY shortname) c 
		ON a.shortname = c.shortname) z, 
		tbl_tot_act_curso ta WHERE z.shortname = ta.shortname";
	}
	else if (isset($_SESSION['unisuper'])) {
		$query3 = "SELECT ta.ct ctt, ta.shortname, z.cb, z.ca, ta.ct-z.cb-z.ca cf 
		FROM 
		(SELECT a.ct ctt, a.shortname, ifnull(b.ct,0) cb, ifnull(c.ct,0) ca 
		FROM 
		(SELECT COUNT(1) ct, shortname 
		FROM tbl_desemp WHERE id = '$idest_m' AND email_inst = '".$_SESSION['unisuper']."' GROUP BY shortname) a 
		LEFT JOIN 
		(SELECT COUNT(1) ct, shortname 
		FROM tbl_desemp WHERE id = '$idest_m' AND email_inst = '".$_SESSION['unisuper']."' AND calificacion BETWEEN 3 AND 4 GROUP BY shortname) b 
		ON a.shortname = b.shortname 
		LEFT JOIN 
		(SELECT COUNT(1) ct, shortname 
		FROM tbl_desemp WHERE id = '$idest_m' AND email_inst = '".$_SESSION['unisuper']."' AND calificacion > 4 GROUP BY shortname) c 
		ON a.shortname = c.shortname) z, 
		tbl_tot_act_curso ta WHERE z.shortname = ta.shortname";
	}
	else if (isset($_SESSION['admin_unicab'])) {
		$query3 = "SELECT ta.ct ctt, ta.shortname, z.cb, z.ca, ta.ct-z.cb-z.ca cf 
		FROM 
		(SELECT a.ct ctt, a.shortname, ifnull(b.ct,0) cb, ifnull(c.ct,0) ca 
		FROM 
		(SELECT COUNT(1) ct, shortname 
		FROM tbl_desemp WHERE id = '$idest_m' AND email_inst = '".$_SESSION['admin_unicab']."' GROUP BY shortname) a 
		LEFT JOIN 
		(SELECT COUNT(1) ct, shortname 
		FROM tbl_desemp WHERE id = '$idest_m' AND email_inst = '".$_SESSION['admin_unicab']."' AND calificacion BETWEEN 3 AND 4 GROUP BY shortname) b 
		ON a.shortname = b.shortname 
		LEFT JOIN 
		(SELECT COUNT(1) ct, shortname 
		FROM tbl_desemp WHERE id = '$idest_m' AND email_inst = '".$_SESSION['admin_unicab']."' AND calificacion > 4 GROUP BY shortname) c 
		ON a.shortname = c.shortname) z, 
		tbl_tot_act_curso ta WHERE z.shortname = ta.shortname";
	}
	//echo $query3;
	
	$resultado3=$mysqli1->query($query3);
	while($row3 = $resultado3->fetch_assoc()){
		$desemp[] = array('ctt' => $row3['ctt'], 'shortname' => $row3['shortname'], 'cb' => $row3['cb'], 'ca' => $row3['ca'], 'cf' => $row3['cf']);
	}
	
	echo json_encode($desemp, JSON_UNESCAPED_UNICODE);
	//https://ejemplocodigo.com/ejemplo-php-crear-y-leer-json-de-una-tabla-mysql/
	//https://unicab.org/registro/docenteunicab/updreg/buscar_notas.php
	
/*}else{
	echo "<script>alert('Debes iniciar sesi車n');</script>";
	echo "<script>location.href='../login.php'</script>";
}*/

?>