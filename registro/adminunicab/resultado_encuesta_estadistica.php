<?php
    session_start();
	require("../docenteunicab/updreg/1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	//https://unicab.org/registro/adminunicab/resultado_encuesta_estadistica.php?idgra=2&idpreg=1
	
//if (isset($_SESSION['uniprofe']) || isset($_SESSION['unisuper'])) {
	$idgra = $_REQUEST["idgra"];
	$idpreg = $_REQUEST["idpreg"];
	
	//Se arman los labels
	$sql_lbls = "SELECT * FROM tbl_encuestas_preguntas WHERE id_encuesta = 1 AND id = $idpreg AND respuesta_texto = 'NO'";
	//echo $sql_lbls;
	$res_lbls = $mysqli1->query($sql_lbls);
	while($row_lbls = $res_lbls->fetch_assoc()){
		$preg_e = $row_lbls['e'];
		$pregunta = $row_lbls['pregunta'];
		if ($row_lbls['e'] != "NO") {
			$lbls = array($row_lbls['a'], $row_lbls['b'], $row_lbls['c'], $row_lbls['d'], $row_lbls['e']);
		}
		else if ($row_lbls['e'] == "NO") {
			$lbls = array($row_lbls['a'], $row_lbls['b'], $row_lbls['c'], $row_lbls['d']);
		}
	}
	
	$respuestas = new stdClass();
	
	$p1 = array();
	$p2 = array();
	$p3 = array();
	$p4 = array();
	
	$ct_5opciones = array();
	$ct_4opciones = array();
	
	$ct_5opciones[0] = 0;
	$ct_5opciones[1] = 0;
	$ct_5opciones[2] = 0;
	$ct_5opciones[3] = 0;
	$ct_5opciones[4] = 0;
	
	$ct_4opciones[0] = 0;
	$ct_4opciones[1] = 0;
	$ct_4opciones[2] = 0;
	$ct_4opciones[3] = 0;
	
	//Se consultan las cantidades
	if ($idgra == "NA") {
		$sql_ct = "SELECT COUNT(1) ct, er.resultado, 
		CASE er.resultado WHEN 'A' THEN ep.a WHEN 'B' THEN ep.b WHEN 'C' THEN ep.c WHEN 'D' THEN ep.d WHEN 'E' THEN ep.e ELSE er.resultado END resultado1 
		FROM tbl_encuestas_resultados er, tbl_encuestas_preguntas ep 
		WHERE er.id_pregunta = ep.id AND er.id_encuesta = ep.id_encuesta 
		AND er.id_encuesta = 1 AND er.id_pregunta = $idpreg 
		GROUP BY er.resultado, 2;";
	}
	else {
		$sql_ct = "SELECT COUNT(1) ct, er.resultado, 
		CASE er.resultado WHEN 'A' THEN ep.a WHEN 'B' THEN ep.b WHEN 'C' THEN ep.c WHEN 'D' THEN ep.d WHEN 'E' THEN ep.e ELSE er.resultado END resultado1 
		FROM tbl_encuestas_resultados er, tbl_encuestas_preguntas ep 
		WHERE er.id_pregunta = ep.id AND er.id_encuesta = ep.id_encuesta 
		AND er.id_encuesta = 1 AND er.id_pregunta = $idpreg AND er.id_grado = $idgra 
		GROUP BY er.resultado, 2;";
	}
	
	
	$res_ct = $mysqli1->query($sql_ct);
	while($row_ct = $res_ct->fetch_assoc()){
		if ($preg_e != 'NO') {
			if ($row_ct['resultado'] == "A") {
				$ct_5opciones[0] = $row_ct['ct'];
			}
			else if ($row_ct['resultado'] == "B") {
				$ct_5opciones[1] = $row_ct['ct'];
			}
			else if ($row_ct['resultado'] == "C") {
				$ct_5opciones[2] = $row_ct['ct'];
			}
			else if ($row_ct['resultado'] == "D") {
				$ct_5opciones[3] = $row_ct['ct'];
			}
			else if ($row_ct['resultado'] == "E") {
				$ct_5opciones[4] = $row_ct['ct'];
			}
		}
		else if ($preg_e == 'NO') {
			if ($row_ct['resultado'] == "A") {
				$ct_4opciones[0] = $row_ct['ct'];
			}
			else if ($row_ct['resultado'] == "B") {
				$ct_4opciones[1] = $row_ct['ct'];
			}
			else if ($row_ct['resultado'] == "C") {
				$ct_4opciones[2] = $row_ct['ct'];
			}
			else if ($row_ct['resultado'] == "D") {
				$ct_4opciones[3] = $row_ct['ct'];
			}
		}		
	}
	
	$c = count($lbls);
	//echo $c;
	$respuestas->lbls = $lbls;
	if ($preg_e != 'NO') {
		$respuestas->cantidades = $ct_5opciones;
	}
	else if ($preg_e == 'NO') {
		$respuestas->cantidades = $ct_4opciones;
	}
	$respuestas->pregunta = $pregunta;
	
	echo json_encode($respuestas, JSON_UNESCAPED_UNICODE);
	
/*}else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../login.php'</script>";
}*/

?>