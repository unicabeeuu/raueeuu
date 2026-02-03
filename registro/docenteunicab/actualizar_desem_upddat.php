<?php

	session_start();
	require "../adminunicab/php/conexion.php";
	//https://unicab.org/registro/docenteunicab/actualizar_desem_upddat.php
	
	//if (isset($_SESSION['unisuper']) || isset($_SESSION['uniprofe'])) {
		
		date_default_timezone_set('America/Bogota');
		$dia = date("d");
		$mes = date("m");
		$mesLetra = date("M");
		$fanio = date("Y");
		if ($mes > 10) {
			$fanio++;
		}
	
		//Se borra la talba de desemp pres
		$sql_delete = "DELETE FROM tbl_desemp_pres";
		$res_delete = mysqli_query($conexion, $sql_delete);
		
		//Se arma el desempeño para bio
		$sql_desemp_bio = "SELECT a.a, a.identificacion, a.id_materia, a.id_grado, a.ok, b.tot, 
		CASE WHEN a.ok/b.tot > .75 THEN 'BIO,' ELSE '' END DSA, 
		CASE WHEN a.ok/b.tot > .5 AND a.ok/b.tot <= .75 THEN 'BIO,' ELSE '' END DA, 
		CASE WHEN a.ok/b.tot > .25 AND a.ok/b.tot <= .5 THEN 'BIO,' ELSE '' END DM, 
		CASE WHEN a.ok/b.tot <= .25 THEN 'BIO,' ELSE '' END DB 
		FROM 
		(SELECT a, identificacion, id_materia, id_grado, COUNT(1) ok 
		FROM tbl_respuestas 
		WHERE estado = 'FINALIZADA' AND resultado = 'OK' AND id_materia in (1, 10) AND a in ($fanio, $fanio-1) 
		GROUP BY identificacion, id_materia, id_grado) a, 
		(SELECT a, identificacion, id_materia, id_grado, COUNT(1) tot 
		FROM tbl_respuestas 
		WHERE estado = 'FINALIZADA' AND id_materia in (1, 10) AND a in ($fanio, $fanio-1) 
		GROUP BY identificacion, id_materia, id_grado) b
		WHERE a.identificacion = b.identificacion AND a.id_materia = b.id_materia AND a.id_grado = b.id_grado AND a.a = b.a AND a.identificacion = '1049630479'";
		//echo $sql_desemp_bio;
		$res_desemp_bio = mysqli_query($conexion, $sql_desemp_bio);
		while ($fila_desemp_bio = mysqli_fetch_array($res_desemp_bio)){
			//Se consulta si la identificación ya existe
			$sql_identif_bio = "SELECT COUNT(1) ct_bio FROM tbl_desemp_pres WHERE identificacion = '".$fila_desemp_bio['identificacion']."'";
			$res_sql_identif_bio = mysqli_query($conexion, $sql_identif_bio);
			while ($fila_identif_bio = mysqli_fetch_array($res_sql_identif_bio)){
				$ct_bio = $fila_identif_bio['ct_bio'];
			}
			if ($ct_bio > 0) {
				$sql_insupd = "UPDATE tbl_desemp_pres SET DSA = CONCAT(DSA, REPLACE('".$fila_desemp_bio['DSA']."', '-', '')), 
				DA = CONCAT(DA, REPLACE('".$fila_desemp_bio['DA']."', '-', '')), DM = CONCAT(DM, REPLACE('".$fila_desemp_bio['DM']."', '-', '')), 
				DB = CONCAT(DB, REPLACE('".$fila_desemp_bio['DB']."', '-', '')) 
				WHERE identificacion = '".$fila_desemp_bio['identificacion']."' AND año = ".$fila_desemp_bio['a'];
			}
			else {
				$sql_insupd = "INSERT INTO tbl_desemp_pres (identificacion, DSA, DA, DM, DB, año, id_grado) VALUES 
				('".$fila_desemp_bio['identificacion']."', '".$fila_desemp_bio['DSA']."', '".$fila_desemp_bio['DA']."', 
				'".$fila_desemp_bio['DM']."', '".$fila_desemp_bio['DB']."', ".$fila_desemp_bio['a'].", ".$fila_desemp_bio['id_grado'].")";
			}
			//echo $sql_insupd;
			$res_insupd = mysqli_query($conexion, $sql_insupd);
		}
		echo "desempeño bio ok<br>";
		
		//Se arma el desempeño para esp
		$sql_desemp_esp = "SELECT a.a, a.identificacion, a.id_materia, a.id_grado, a.ok, b.tot, 
		CASE WHEN a.ok/b.tot > .75 THEN 'ESP,' ELSE '-' END DSA, 
		CASE WHEN a.ok/b.tot > .5 AND a.ok/b.tot <= .75 THEN 'ESP,' ELSE '-' END DA, 
		CASE WHEN a.ok/b.tot > .25 AND a.ok/b.tot <= .5 THEN 'ESP,' ELSE '-' END DM, 
		CASE WHEN a.ok/b.tot <= .25 THEN 'ESP,' ELSE '-' END DB 
		FROM 
		(SELECT a, identificacion, id_materia, id_grado, COUNT(1) ok 
		FROM tbl_respuestas 
		WHERE estado = 'FINALIZADA' AND resultado = 'OK' AND id_materia in (6, 15) AND a in ($fanio, $fanio-1) 
		GROUP BY identificacion, id_materia, id_grado) a, 
		(SELECT a, identificacion, id_materia, id_grado, COUNT(1) tot 
		FROM tbl_respuestas 
		WHERE estado = 'FINALIZADA' AND id_materia in (6, 15) AND a in ($fanio, $fanio-1) 
		GROUP BY identificacion, id_materia, id_grado) b
		WHERE a.identificacion = b.identificacion AND a.id_materia = b.id_materia AND a.id_grado = b.id_grado AND a.a = b.a";
		//echo $sql_desemp_esp."<br>";
		$res_desemp_esp = mysqli_query($conexion, $sql_desemp_esp);
		while ($fila_desemp_esp = mysqli_fetch_array($res_desemp_esp)){
			//Se consulta si la identificación ya existe
			$sql_identif_esp = "SELECT COUNT(1) ct_esp FROM tbl_desemp_pres WHERE identificacion = '".$fila_desemp_esp['identificacion']."'";
			//echo $sql_identif_esp."<br>";
			$res_sql_identif_esp = mysqli_query($conexion, $sql_identif_esp);
			while ($fila_identif_esp = mysqli_fetch_array($res_sql_identif_esp)){
				$ct_esp = $fila_identif_esp['ct_esp'];
			}
			$dsa = $fila_desemp_esp['DSA'];
			//echo "dsa: ".$dsa." <br>";
			//echo $ct_esp."<br>";
			if ($ct_esp > 0) {
				$sql_insupd = "UPDATE tbl_desemp_pres SET DSA = CONCAT(DSA, REPLACE('".$fila_desemp_esp['DSA']."', '-', '')), 
				DA = CONCAT(DA, REPLACE('".$fila_desemp_esp['DA']."', '-', '')), DM = CONCAT(DM, REPLACE('".$fila_desemp_esp['DM']."', '-', '')), 
				DB = CONCAT(DB, REPLACE('".$fila_desemp_esp['DB']."', '-', '')) 
				WHERE identificacion = '".$fila_desemp_esp['identificacion']."' AND año = ".$fila_desemp_esp['a'];
			}
			else {
				$sql_insupd = "INSERT INTO tbl_desemp_pres (identificacion, DSA, DA, DM, DB, año, id_grado) VALUES 
				('".$fila_desemp_esp['identificacion']."', REPLACE('".$fila_desemp_esp['DSA']."', '-', ''), REPLACE('".$fila_desemp_esp['DA']."', '-', ''), 
				REPLACE('".$fila_desemp_esp['DM']."', '-', ''), REPLACE('".$fila_desemp_esp['DB']."', '-', ''), ".$fila_desemp_esp['a'].", ".$fila_desemp_esp['id_grado'].")";
			}
			//echo $sql_insupd."<br>";
			$res_insupd = mysqli_query($conexion, $sql_insupd);
		}
		echo "desempeño esp ok<br>";
		
		//Se arma el desempeño para ing
		$sql_desemp_ing = "SELECT a.a, a.identificacion, a.id_materia, a.id_grado, a.ok, b.tot, 
		CASE WHEN a.ok/b.tot > .75 THEN 'ING,' ELSE '-' END DSA, 
		CASE WHEN a.ok/b.tot > .5 AND a.ok/b.tot <= .75 THEN 'ING,' ELSE '-' END DA, 
		CASE WHEN a.ok/b.tot > .25 AND a.ok/b.tot <= .5 THEN 'ING,' ELSE '-' END DM, 
		CASE WHEN a.ok/b.tot <= .25 THEN 'ING,' ELSE '-' END DB 
		FROM 
		(SELECT a, identificacion, id_materia, id_grado, COUNT(1) ok 
		FROM tbl_respuestas 
		WHERE estado = 'FINALIZADA' AND resultado = 'OK' AND id_materia in (7) AND a in ($fanio, $fanio-1) 
		GROUP BY a, identificacion, id_materia, id_grado) a, 
		(SELECT a, identificacion, id_materia, id_grado, COUNT(1) tot 
		FROM tbl_respuestas 
		WHERE estado = 'FINALIZADA' AND id_materia in (7) AND a in ($fanio, $fanio-1) 
		GROUP BY identificacion, id_materia, id_grado) b
		WHERE a.identificacion = b.identificacion AND a.id_materia = b.id_materia AND a.id_grado = b.id_grado AND a.a = b.a";
		//echo $sql_desemp_esp."<br>";
		$res_desemp_ing = mysqli_query($conexion, $sql_desemp_ing);
		while ($fila_desemp_ing = mysqli_fetch_array($res_desemp_ing)){
			//Se consulta si la identificación ya existe
			$sql_identif_ing = "SELECT COUNT(1) ct_ing FROM tbl_desemp_pres WHERE identificacion = '".$fila_desemp_ing['identificacion']."'";
			//echo $sql_identif."<br>";
			$res_sql_identif_ing = mysqli_query($conexion, $sql_identif_ing);
			while ($fila_identif_ing = mysqli_fetch_array($res_sql_identif_ing)){
				$ct_ing = $fila_identif_ing['ct_ing'];
			}
			if ($ct_ing > 0) {
				$sql_insupd = "UPDATE tbl_desemp_pres SET DSA = CONCAT(DSA, REPLACE('".$fila_desemp_ing['DSA']."', '-', '')), 
				DA = CONCAT(DA, REPLACE('".$fila_desemp_ing['DA']."', '-', '')), DM = CONCAT(DM, REPLACE('".$fila_desemp_ing['DM']."', '-', '')), 
				DB = CONCAT(DB, REPLACE('".$fila_desemp_ing['DB']."', '-', '')) 
				WHERE identificacion = '".$fila_desemp_ing['identificacion']."' AND año = ".$fila_desemp_ing['a'];
			}
			else {
				$sql_insupd = "INSERT INTO tbl_desemp_pres (identificacion, DSA, DA, DM, DB, año, id_grado) VALUES 
				('".$fila_desemp_ing['identificacion']."', REPLACE('".$fila_desemp_ing['DSA']."', '-', ''), REPLACE('".$fila_desemp_ing['DA']."', '-', ''), 
				REPLACE('".$fila_desemp_ing['DM']."', '-', ''), REPLACE('".$fila_desemp_ing['DB']."', '-', ''), ".$fila_desemp_ing['a'].", ".$fila_desemp_ing['id_grado'].")";
			}
			//echo $sql_insupd."<br>";
			$res_insupd = mysqli_query($conexion, $sql_insupd);
		}
		echo "desempeño ing ok<br>";
		
		//Se arma el desempeño para fis
		$sql_desemp_fis = "SELECT a.a, a.identificacion, a.id_materia, a.id_grado, a.ok, b.tot, 
		CASE WHEN a.ok/b.tot > .75 THEN 'FIS,' ELSE '-' END DSA, 
		CASE WHEN a.ok/b.tot > .5 AND a.ok/b.tot <= .75 THEN 'FIS,' ELSE '-' END DA, 
		CASE WHEN a.ok/b.tot > .25 AND a.ok/b.tot <= .5 THEN 'FIS,' ELSE '-' END DM, 
		CASE WHEN a.ok/b.tot <= .25 THEN 'FIS,' ELSE '-' END DB 
		FROM 
		(SELECT a, identificacion, id_materia, id_grado, COUNT(1) ok 
		FROM tbl_respuestas 
		WHERE estado = 'FINALIZADA' AND resultado = 'OK' AND id_materia in (11) AND a in ($fanio, $fanio-1) 
		GROUP BY identificacion, id_materia, id_grado) a, 
		(SELECT a, identificacion, id_materia, id_grado, COUNT(1) tot 
		FROM tbl_respuestas 
		WHERE estado = 'FINALIZADA' AND id_materia in (11) AND in ($fanio, $fanio-1) 
		GROUP BY identificacion, id_materia, id_grado) b
		WHERE a.identificacion = b.identificacion AND a.id_materia = b.id_materia AND a.id_grado = b.id_grado AND a.a = b.a";
		//echo $sql_desemp_esp."<br>";
		$res_desemp_fis = mysqli_query($conexion, $sql_desemp_fis);
		while ($fila_desemp_fis = mysqli_fetch_array($res_desemp_fis)){
			//Se consulta si la identificación ya existe
			$sql_identif_fis = "SELECT COUNT(1) ct_fis FROM tbl_desemp_pres WHERE identificacion = '".$fila_desemp_fis['identificacion']."'";
			//echo $sql_identif."<br>";
			$res_sql_identif_fis = mysqli_query($conexion, $sql_identif_fis);
			while ($fila_identif_fis = mysqli_fetch_array($res_sql_identif_fis)){
				$ct_fis = $fila_identif_fis['ct_fis'];
			}
			if ($ct_fis > 0) {
				$sql_insupd = "UPDATE tbl_desemp_pres SET DSA = CONCAT(DSA, REPLACE('".$fila_desemp_fis['DSA']."', '-', '')), 
				DA = CONCAT(DA, REPLACE('".$fila_desemp_fis['DA']."', '-', '')), DM = CONCAT(DM, REPLACE('".$fila_desemp_fis['DM']."', '-', '')), 
				DB = CONCAT(DB, REPLACE('".$fila_desemp_fis['DB']."', '-', '')) 
				WHERE identificacion = '".$fila_desemp_fis['identificacion']."' AND año = ".$fila_desemp_fis['a'];
			}
			else {
				$sql_insupd = "INSERT INTO tbl_desemp_pres (identificacion, DSA, DA, DM, DB, año, id_grado) VALUES 
				('".$fila_desemp_fis['identificacion']."', REPLACE('".$fila_desemp_fis['DSA']."', '-', ''), REPLACE('".$fila_desemp_fis['DA']."', '-', ''), 
				REPLACE('".$fila_desemp_fis['DM']."', '-', ''), REPLACE('".$fila_desemp_fis['DB']."', '-', ''), ".$fila_desemp_fis['a'].", ".$fila_desemp_fis['id_grado'].")";
			}
			//echo $sql_insupd."<br>";
			$res_insupd = mysqli_query($conexion, $sql_insupd);
		}
		echo "desempeño fis ok<br>";
		
		//Se arma el desempeño para mat
		$sql_desemp_mat = "SELECT a.a, a.identificacion, a.id_materia, a.id_grado, a.ok, b.tot, 
		CASE WHEN a.ok/b.tot > .75 THEN 'MAT,' ELSE '-' END DSA, 
		CASE WHEN a.ok/b.tot > .5 AND a.ok/b.tot <= .75 THEN 'MAT,' ELSE '-' END DA, 
		CASE WHEN a.ok/b.tot > .25 AND a.ok/b.tot <= .5 THEN 'MAT,' ELSE '-' END DM, 
		CASE WHEN a.ok/b.tot <= .25 THEN 'MAT,' ELSE '-' END DB 
		FROM 
		(SELECT a, identificacion, id_materia, id_grado, COUNT(1) ok 
		FROM tbl_respuestas 
		WHERE estado = 'FINALIZADA' AND resultado = 'OK' AND id_materia in (5) AND a in ($fanio, $fanio-1) 
		GROUP BY identificacion, id_materia, id_grado) a, 
		(SELECT a, identificacion, id_materia, id_grado, COUNT(1) tot 
		FROM tbl_respuestas 
		WHERE estado = 'FINALIZADA' AND id_materia in (5) AND a in ($fanio, $fanio-1) 
		GROUP BY identificacion, id_materia, id_grado) b
		WHERE a.identificacion = b.identificacion AND a.id_materia = b.id_materia AND a.id_grado = b.id_grado AND a.a = b.a";
		//echo $sql_desemp_mat."<br>";
		$res_desemp_mat = mysqli_query($conexion, $sql_desemp_mat);
		while ($fila_desemp_mat = mysqli_fetch_array($res_desemp_mat)){
			//Se consulta si la identificación ya existe
			$sql_identif_mat = "SELECT COUNT(1) ct_mat FROM tbl_desemp_pres WHERE identificacion = '".$fila_desemp_mat['identificacion']."'";
			//echo $sql_identif_mat."<br>";
			$res_sql_identif_mat = mysqli_query($conexion, $sql_identif_mat);
			while ($fila_identif_mat = mysqli_fetch_array($res_sql_identif_mat)){
				$ct_mat = $fila_identif_mat['ct_mat'];
			}
			//echo $ct_mat."<br>";
			if ($ct_mat > 0) {
				$sql_insupd = "UPDATE tbl_desemp_pres SET DSA = CONCAT(DSA, REPLACE('".$fila_desemp_mat['DSA']."', '-', '')), 
				DA = CONCAT(DA, REPLACE('".$fila_desemp_mat['DA']."', '-', '')), DM = CONCAT(DM, REPLACE('".$fila_desemp_mat['DM']."', '-', '')), 
				DB = CONCAT(DB, REPLACE('".$fila_desemp_mat['DB']."', '-', '')) 
				WHERE identificacion = '".$fila_desemp_mat['identificacion']."' AND año = ".$fila_desemp_mat['a'];
			}
			else {
				$sql_insupd = "INSERT INTO tbl_desemp_pres (identificacion, DSA, DA, DM, DB, año, id_grado) VALUES 
				('".$fila_desemp_mat['identificacion']."', REPLACE('".$fila_desemp_mat['DSA']."', '-', ''), REPLACE('".$fila_desemp_mat['DA']."', '-', ''), 
				REPLACE('".$fila_desemp_mat['DM']."', '-', ''), REPLACE('".$fila_desemp_mat['DB']."', '-', ''), ".$fila_desemp_mat['a'].", ".$fila_desemp_mat['id_grado'].")";
			}
			//echo $sql_insupd."<br>";
			$res_insupd = mysqli_query($conexion, $sql_insupd);
		}
		echo "desempeño mat ok<br>";
		
		//Se arma el desempeño para soc
		$sql_desemp_soc = "SELECT a.a, a.identificacion, a.id_materia, a.id_grado, a.ok, b.tot, 
		CASE WHEN a.ok/b.tot > .75 THEN 'SOC,' ELSE '-' END DSA, 
		CASE WHEN a.ok/b.tot > .5 AND a.ok/b.tot <= .75 THEN 'SOC,' ELSE '-' END DA, 
		CASE WHEN a.ok/b.tot > .25 AND a.ok/b.tot <= .5 THEN 'SOC,' ELSE '-' END DM, 
		CASE WHEN a.ok/b.tot <= .25 THEN 'SOC,' ELSE '-' END DB 
		FROM 
		(SELECT a, identificacion, id_materia, id_grado, COUNT(1) ok 
		FROM tbl_respuestas 
		WHERE estado = 'FINALIZADA' AND resultado = 'OK' AND id_materia in (4,12) AND a in ($fanio, $fanio-1) 
		GROUP BY identificacion, id_materia, id_grado) a, 
		(SELECT a, identificacion, id_materia, id_grado, COUNT(1) tot 
		FROM tbl_respuestas 
		WHERE estado = 'FINALIZADA' AND id_materia in (4,12) AND a in ($fanio, $fanio-1) 
		GROUP BY identificacion, id_materia, id_grado) b
		WHERE a.identificacion = b.identificacion AND a.id_materia = b.id_materia AND a.id_grado = b.id_grado AND a.a = b.a";
		//echo $sql_desemp_esp."<br>";
		$res_desemp_soc = mysqli_query($conexion, $sql_desemp_soc);
		while ($fila_desemp_soc = mysqli_fetch_array($res_desemp_soc)){
			//Se consulta si la identificación ya existe
			$sql_identif_soc = "SELECT COUNT(1) ct_soc FROM tbl_desemp_pres WHERE identificacion = '".$fila_desemp_soc['identificacion']."'";
			//echo $sql_identif."<br>";
			$res_sql_identif_soc = mysqli_query($conexion, $sql_identif_soc);
			while ($fila_identif_soc = mysqli_fetch_array($res_sql_identif_soc)){
				$ct_soc = $fila_identif_soc['ct_soc'];
			}
			if ($ct_soc > 0) {
				$sql_insupd = "UPDATE tbl_desemp_pres SET DSA = CONCAT(DSA, REPLACE('".$fila_desemp_soc['DSA']."', '-', '')), 
				DA = CONCAT(DA, REPLACE('".$fila_desemp_soc['DA']."', '-', '')), DM = CONCAT(DM, REPLACE('".$fila_desemp_soc['DM']."', '-', '')), 
				DB = CONCAT(DB, REPLACE('".$fila_desemp_soc['DB']."', '-', '')) 
				WHERE identificacion = '".$fila_desemp_soc['identificacion']."' AND año = ".$fila_desemp_soc['a'];
			}
			else {
				$sql_insupd = "INSERT INTO tbl_desemp_pres (identificacion, DSA, DA, DM, DB, año, id_grado) VALUES 
				('".$fila_desemp_soc['identificacion']."', REPLACE('".$fila_desemp_soc['DSA']."', '-', ''), REPLACE('".$fila_desemp_soc['DA']."', '-', ''), 
				REPLACE('".$fila_desemp_soc['DM']."', '-', ''), REPLACE('".$fila_desemp_soc['DB']."', '-', ''), ".$fila_desemp_soc['a'].", ".$fila_desemp_soc['id_grado'].")";
			}
			//echo $sql_insupd."<br>";
			$res_insupd = mysqli_query($conexion, $sql_insupd);
		}
		echo "desempeño soc ok<br>";
		
		//Se arma el desempeño para tec
		$sql_desemp_tec = "SELECT a.a, a.identificacion, a.id_materia, a.id_grado, a.ok, b.tot, 
		CASE WHEN a.ok/b.tot > .75 THEN 'TEC,' ELSE '-' END DSA, 
		CASE WHEN a.ok/b.tot > .5 AND a.ok/b.tot <= .75 THEN 'TEC,' ELSE '-' END DA, 
		CASE WHEN a.ok/b.tot > .25 AND a.ok/b.tot <= .5 THEN 'TEC,' ELSE '-' END DM, 
		CASE WHEN a.ok/b.tot <= .25 THEN 'TEC,' ELSE '-' END DB 
		FROM 
		(SELECT a, identificacion, id_materia, id_grado, COUNT(1) ok 
		FROM tbl_respuestas 
		WHERE estado = 'FINALIZADA' AND resultado = 'OK' AND id_materia in (9) AND a in ($fanio, $fanio-1) 
		GROUP BY identificacion, id_materia, id_grado) a, 
		(SELECT a, identificacion, id_materia, id_grado, COUNT(1) tot 
		FROM tbl_respuestas 
		WHERE estado = 'FINALIZADA' AND id_materia in (9) AND a in ($fanio, $fanio-1) 
		GROUP BY identificacion, id_materia, id_grado) b
		WHERE a.identificacion = b.identificacion AND a.id_materia = b.id_materia AND a.id_grado = b.id_grado AND a.a = b.a";
		//echo $sql_desemp_esp."<br>";
		$res_desemp_tec = mysqli_query($conexion, $sql_desemp_tec);
		while ($fila_desemp_tec = mysqli_fetch_array($res_desemp_tec)){
			//Se consulta si la identificación ya existe
			$sql_identif_tec = "SELECT COUNT(1) ct_tec FROM tbl_desemp_pres WHERE identificacion = '".$fila_desemp_tec['identificacion']."'";
			//echo $sql_identif."<br>";
			$res_sql_identif_tec = mysqli_query($conexion, $sql_identif_tec);
			while ($fila_identif_tec = mysqli_fetch_array($res_sql_identif_tec)){
				$ct_tec = $fila_identif_tec['ct_tec'];
			}
			if ($ct_tec > 0) {
				$sql_insupd = "UPDATE tbl_desemp_pres SET DSA = CONCAT(DSA, REPLACE('".$fila_desemp_tec['DSA']."', '-', '')), 
				DA = CONCAT(DA, REPLACE('".$fila_desemp_tec['DA']."', '-', '')), DM = CONCAT(DM, REPLACE('".$fila_desemp_tec['DM']."', '-', '')), 
				DB = CONCAT(DB, REPLACE('".$fila_desemp_tec['DB']."', '-', '')) 
				WHERE identificacion = '".$fila_desemp_tec['identificacion']."' AND año = ".$fila_desemp_tec['a'];
			}
			else {
				$sql_insupd = "INSERT INTO tbl_desemp_pres (identificacion, DSA, DA, DM, DB, año, id_grado) VALUES 
				('".$fila_desemp_tec['identificacion']."', REPLACE('".$fila_desemp_tec['DSA']."', '-', ''), REPLACE('".$fila_desemp_tec['DA']."', '-', ''), 
				REPLACE('".$fila_desemp_tec['DM']."', '-', ''), REPLACE('".$fila_desemp_tec['DB']."', '-', ''), ".$fila_desemp_tec['a'].", ".$fila_desemp_tec['id_grado'].")";
			}
			//echo $sql_insupd."<br>";
			$res_insupd = mysqli_query($conexion, $sql_insupd);
		}
		echo "desempeño tec ok<br>";
		
		require("updreg/1cc3s4db.php");
	
		date_default_timezone_set('America/Bogota');
		$dia = date("d");
		$mes = date("m");
		$mesLetra = date("M");
		$fanio = date("Y");
		$hora = date("G");
		$minutos = date("i");
		$fecha2 = $fanio."/".$mes."/".$dia." ".$hora.":".$minutos;
		$control = "Actualización de evaluciones de admisión ".$fecha2;
		
		$sql = "INSERT INTO tbl_temp1 (t1) VALUES ('$control')";
		$res = $mysqli1->query($sql);
		
	//}

?>