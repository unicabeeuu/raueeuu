<?php
	session_start();
	require("1cc3s4db.php");
	include "mcript.php";
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	//https://unicab.org/registro/docenteunicab/updreg/cargarpen_act_mood.php?idgra=7
	
	$idgra = $_REQUEST["idgra"];
	//echo $idgra;
	
	$cadena = "";
	
	//$sql="SELECT * FROM profesores WHERE email_institucional='".$_SESSION['uniprofe']."'";
	//$sql="SELECT * FROM profesores WHERE email_institucional='gregory.figueredo@unicab.org'";
	$sql="SELECT * FROM tbl_empleados WHERE email='".$_SESSION['uniprofe']."'";
	$res=$mysqli1->query($sql);

	while ($fila = $res->fetch_assoc()) {
	  	$id = $fila['id'];
    }
    //echo $id;
    
    if($id == 18) {
        $query1 = "SELECT DISTINCT shortname, id_pensamiento FROM tbl_config_act WHERE id_grado = '$idgra' ORDER BY 1";
    }
    else {
		//La siguiente consulta cambia para química y física --- la primera es para química y la segunda para física
        $query1 = "SELECT a.*, eg.id_grado_ra, em.id_materia_ra 
            FROM 
            (SELECT DISTINCT shortname, id_pensamiento id_pensamiento_original, 
			case concat(id_grado,id_pensamiento) when 2273 then 73997 when 2376 then 76997 when 1647 then 47997 when 1752 then 52997 
			else id_pensamiento end id_pensamiento, id_grado FROM tbl_config_act WHERE id_grado = $idgra) a, 
            equivalence_idgra eg, 
            (SELECT DISTINCT id_grado, id_materia FROM carga_profesor WHERE id_empleado = $id) cp, 
            equivalence_idmat em 
            WHERE a.id_grado = eg.id_category AND eg.id_grado_ra = cp.id_grado AND cp.id_materia = em.id_materia_ra 
            AND em.id_course = a.id_pensamiento_original";
		/*$query1 = "SELECT a.*, eg.id_grado_ra, em.id_materia_ra 
            FROM 
            (SELECT DISTINCT shortname, id_pensamiento id_pensamiento_original, 
			case concat(id_grado,id_pensamiento) when 2273 then 73997 when 2376 then 76997 when 1647 then 47997 when 1752 then 52997 
			else id_pensamiento end id_pensamiento, id_grado FROM tbl_config_act WHERE id_grado = $idgra) a, 
            equivalence_idgra eg, 
            (SELECT DISTINCT id_grado, id_materia FROM carga_profesor WHERE id_empleado = $id) cp, 
            equivalence_idmat em 
            WHERE a.id_grado = eg.id_category AND eg.id_grado_ra = cp.id_grado AND cp.id_materia = em.id_materia_ra 
            AND em.id_course = a.id_pensamiento";*/
    }
    //echo $query1;
	
	$cadena = $cadena."<option value='NA'>Seleccione pensamiento</option>";
	$resultado=$mysqli1->query($query1);
	while($row = $resultado->fetch_assoc()) {
		$cadena = $cadena."<option value='".$row['id_pensamiento']."'>".$row['shortname']."</option>";
	}
	echo $cadena;
?>