<?php 
    include 'conexion.php';
    require("1cc3s4db.php");
    header("Cache-Control: no-store");
    
    require_once '../../docenteunicab/updreg/dompdf/dompdf/autoload.inc.php';
    use Dompdf\Dompdf;
    
    class PDF {
        public static function stream($nom_pdf, $html) {
            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait'); // (Opcional) Configurar papel y orientación landscape | portrait
            $dompdf->render(); // Generar el PDF desde contenido HTML
            $pdf = $dompdf->output(); // Obtener el PDF generado
            $dompdf->stream($nom_pdf); // Enviar el PDF generado al navegador
        }
        
        public static function saveDisk($nom_pdf, $html, $folder) {
            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait'); // (Opcional) Configurar papel y orientación landscape | portrait
            $dompdf->render(); // Generar el PDF desde contenido HTML
            $pdf = $dompdf->output(); // Obtener el PDF generado
            
            $pdf_guardar = $folder.$nom_pdf;
            //echo $pdf_guardar;
            
            if(!file_exists($folder)) {
                if(mkdir($folder, 0755, true)) {
                    file_put_contents($pdf_guardar, $pdf);
                }
            }
            else {
                file_put_contents($pdf_guardar, $pdf);
            }
        }
    }
    
    date_default_timezone_set('America/Bogota');
    $dia=date("d");
    $mes=date("m");
    $mesLetra=date("M");
    $fanio=date("Y");
    $espaniol="";
	if ($mes >= 1 && $mes <=3) {
		$fanio--;
	}
    
    $fecha2 =$fanio."/".$mes."/". $dia;
    
    $codigo = "";
	$sa1 = ["q","a","1","z","x","2","s","w","3","p","l","4","m","k","5","o","e","6",
            "d","c","7","i","j","8","n","r","9","f","v","0","u","h","b","t","g"];
	
	for($i = 1; $i <=10; $i++) {
		$ale=mt_rand(1,sizeof($sa1));
		$codigo = $codigo.$sa1[$ale-1];
	}
    
    /*$sql="SELECT * FROM `certificado`";
    $exe_sql=mysqli_query($conexion,$sql);
    $variable=mysqli_num_rows($exe_sql);*/
    
    switch ($mes) {
    	case '1':
    		$espaniol="Enero";
    		$mesi="January";
    		break;
    	case '2':
    		$espaniol="Febrero";
    		$mesi="February";
    		break;
    	case '3':
    		$espaniol="Marzo";
    		$mesi="March";
    		break;
    	case '4':
    		$espaniol="Abril";
    		$mesi="April";
    		break;
    	case '5':
    		$espaniol="Mayo";
    		$mesi="May";
    		break;
    	case '6':
    		$espaniol="Junio";
    		$mesi="June";
    		break;
    	case '7':
    		$espaniol="Julio";
    		$mesi="July";
    		break;
    	case '8':
    		$espaniol="Agosto";
    		$mesi="August";
    		break;
    	case '9':
    		$espaniol="Septiembre";
    		$mesi="September";
    		break;
    	case '10':
    		$espaniol="Octubre";
    		$mesi="October";
    		break;
    	case '11':
    		$espaniol="Noviembre";
    		$mesi="November";
    		break;
    	case '12':
    		$espaniol="Diciembre";
    		$mesi="December";
    		break;
    }
    //echo $espaniol;
    
    $fecha_expedicion=$_REQUEST['fecha_expedicion'];
    $tipo_certificado=$_REQUEST['tipoc'];
    //$numeroc="CS".$variable;
    $numeroc = $_REQUEST['n_certif'];
    $id_estudiante=$_REQUEST['id_estudiante'];
    $id_grado=$_REQUEST['id_grado'];
    $idioma=$_REQUEST['idioma'];
    $firmas=$_REQUEST['firmas'];
    //echo $numeroc;
    $matricula_actual=$_REQUEST['matricula_actual'];
    //echo "matrícula actual: ".$matricula_actual;
    
    //echo "idioma: ".$idioma;
    
    $peticion= "SELECT e.nombres, e.apellidos, e.genero, td.tipo_documento, e.n_documento, e.expedicion, e.ciudad, g.grado, g.id, 
        m.estado, m.idMatricula, m.fecha_ingreso, m.n_matricula 
        FROM estudiantes e INNER JOIN 
        (SELECT * FROM matricula WHERE idMatricula = 
        (SELECT MAX(idMatricula) maxid FROM matricula WHERE id_estudiante = ".$id_estudiante." AND estado IN ('aprobado', 'reprobado', 'activo') 
        AND n_matricula like '%".$fanio."%')) m ON e.id = m.id_estudiante 
        INNER JOIN grados g ON m.id_grado=g.id INNER JOIN tbl_tipos_documento td ON e.tipo_documento = td.id 
        WHERE m.id_estudiante=".$id_estudiante." and m.n_matricula = '".$matricula_actual."'";
    //echo $peticion;
    
    $resultado = mysqli_query($conexion, $peticion);
    
    while ($fila1 = mysqli_fetch_array($resultado)){
        //echo "Entra al ciclo";
    	$nombreCompleto=$fila1['nombres']." ".$fila1['apellidos'];
    	$genero=$fila1['genero'];
    	$tipo_documento=$fila1['tipo_documento'];
    	$n_documento=$fila1['n_documento'];
    	$expedicion=$fila1['expedicion'];
    	$ciudad=$fila1['ciudad'];
    	$grado=$fila1['grado'];
    	$grado0=$fila1['grado'];
    	$estado=$fila1['estado'];
    	$id_grado=$fila1['id'];
    	$id_matricula=$fila1['idMatricula'];
    	$n_matricula=$fila1['n_matricula'];
    	$anio=substr($fila1['fecha_ingreso'],  0,4);
    }
    //echo $grado;
    
    if ($genero=="Masculino" || $genero == "MASCULINO") {
    	$variable="el";
    	$variableDos="identificado";
    	$variableTres="matriculado";
    	$variableCuatro="activo";
    }else{
    	$variable="la";
    	$variableDos="identificada";
    	$variableTres="matriculada";
    	$variableCuatro="activa";
    }
    
    if ($estado == "reprobado") {
		$mensaje_promovido="Reprobó grado ".$grado;
		$mensaje_promovidoIngles="Failes grade ".$grado;
	}
	else{
	    if($id_grado == 2) {
	        $mensaje_promovido="Promovido(a) a grado 2°";
    		$mensaje_promovidoIngles="Promoted to grade 2°";
	    }
	    else if($id_grado == 3) {
	        $mensaje_promovido="Promovido(a) a grado 3°";
    		$mensaje_promovidoIngles="Promoted to grade 3°";
	    }
	    else if($id_grado == 4) {
	        $mensaje_promovido="Promovido(a) a grado 4°";
    		$mensaje_promovidoIngles="Promoted to grade 4°";
	    }
	    else if($id_grado == 5) {
	        $mensaje_promovido="Promovido(a) a grado 5°";
    		$mensaje_promovidoIngles="Promoted to grade 5°";
	    }
	    else if($id_grado == 6) {
	        $mensaje_promovido="Promovido(a) a grado 6°";
    		$mensaje_promovidoIngles="Promoted to grade 6°";
	    }
	    else if($id_grado == 7) {
	        $mensaje_promovido="Promovido(a) a grado 7°";
    		$mensaje_promovidoIngles="Promoted to grade 7°";
	    }
	    else if($id_grado == 8) {
	        $mensaje_promovido="Promovido(a) a grado 8°";
    		$mensaje_promovidoIngles="Promoted to grade 8°";
	    }
	    else if($id_grado == 9) {
	        $mensaje_promovido="Promovido(a) a grado 9°";
    		$mensaje_promovidoIngles="Promoted to grade 9°";
	    }
	    else if($id_grado == 10) {
	        $mensaje_promovido="Promovido(a) a grado 10°";
    		$mensaje_promovidoIngles="Promoted to grade 10°";
	    }
	    else if($id_grado == 11) {
	        $mensaje_promovido="Promovido(a) a grado 11°";
    		$mensaje_promovidoIngles="Promoted to grade 11°";
	    }
	    else if($id_grado == 12) {
	        $mensaje_promovido="Estudiante finalizó académicamente";
			$mensaje_promovidoIngles="Student finished academically";
	    }
	    else if($id_grado == 13) {
	        $mensaje_promovido="Promovido(a) a Ciclo II";
			$mensaje_promovidoIngles="Promoted to Cycle II";
	    }
	    else if($id_grado == 14) {
	        $mensaje_promovido="Promovido(a) a Ciclo III";
			$mensaje_promovidoIngles="Promoted to Cycle III";
	    }
	    else if($id_grado == 15) {
	        $mensaje_promovido="Promovido(a) a Ciclo IV";
			$mensaje_promovidoIngles="Promoted to Cycle IV";
	    }
	    else if($id_grado == 16) {
	        $mensaje_promovido="Promovido(a) a Ciclo V";
			$mensaje_promovidoIngles="Promoted to Cycle V";
	    }
	    else if($id_grado == 17) {
	        $mensaje_promovido="Promovido(a) a Ciclo VI";
			$mensaje_promovidoIngles="Promoted to Cycle VI";
	    }
	    else if($id_grado == 18) {
	        $mensaje_promovido="Estudiante Finalizo académicamente por Ciclos";
			$mensaje_promovidoIngles="Student I finish academically by Cycles";
	    }
	}
	//echo $mensaje_promovido;
	
	$tabla = "notas";
	
	//Se valida si hay notas en la tabla de notas
	$sql_ct_notas = "SELECT COUNT(1) ct FROM notas WHERE id_estudiante = $id_estudiante AND id_grado = ".$id_grado;
	//echo $sql_ct_notas;
	$res_ct_notas = mysqli_query($conexion, $sql_ct_notas);
    while ($ct_notas = mysqli_fetch_array($res_ct_notas)){
        $ct_tabla_notas = $ct_notas['ct'];
    }
    //echo $ct_tabla_notas;
    
    if($ct_tabla_notas > 0) {
	    if($id_grado == 17 || $id_grado == 18) {
        	$sql_nota="SELECT DISTINCT p1.id_estudiante, p1.materia, p1.materiaingles, p1.pensamiento, p1.pensamientoingles, p1.id id_materia, p1.id_grado, p1.grado, 
                p1.nota P1, p2.nota P2, cast((p1.nota + p2.nota)/2 as decimal(10,1)) as promedio 
                FROM 
                (SELECT DISTINCT e.id id_estudiante, m.materia, m.materiaingles, m.pensamiento, m.pensamientoingles, m.id, g.id id_grado, g.grado, n.nota 
                FROM $tabla n, estudiantes e, materias m, grados g, periodos p 
                WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
                AND e.id = $id_estudiante AND g.id = $id_grado AND p.id = 1) p1, 
                (SELECT DISTINCT e.id id_estudiante, m.materia, m.materiaingles, m.pensamiento, m.pensamientoingles, m.id, g.id id_grado, g.grado, n.nota 
                FROM $tabla n, estudiantes e, materias m, grados g, periodos p 
                WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
                AND e.id = $id_estudiante AND g.id = $id_grado AND p.id = 2) p2 
                WHERE p1.id_estudiante = p2.id_estudiante  
                AND p1.id = p2.id  
                AND p1.id_grado = p2.id_grado  
                ORDER BY 2";
    	}
    	else {
    	    $sql_nota="SELECT DISTINCT p1.id_estudiante, p1.materia, p1.materiaingles, p1.pensamiento, p1.pensamientoingles, p1.id id_materia, p1.id_grado, p1.grado, 
                p1.nota P1, p2.nota P2, p3.nota P3, p4.nota P4, cast((p1.nota + p2.nota + p3.nota + p4.nota)/4 as decimal(10,1)) as promedio 
                FROM 
                (SELECT DISTINCT e.id id_estudiante, m.materia, m.materiaingles, m.pensamiento, m.pensamientoingles, m.id, g.id id_grado, g.grado, n.nota 
                FROM $tabla n, estudiantes e, materias m, grados g, periodos p 
                WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
                AND e.id = $id_estudiante AND g.id = $id_grado AND p.id = 1) p1, 
                (SELECT DISTINCT e.id id_estudiante, m.materia, m.materiaingles, m.pensamiento, m.pensamientoingles, m.id, g.id id_grado, g.grado, n.nota 
                FROM $tabla n, estudiantes e, materias m, grados g, periodos p 
                WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
                AND e.id = $id_estudiante AND g.id = $id_grado AND p.id = 2) p2,
                (SELECT DISTINCT e.id id_estudiante, m.materia, m.materiaingles, m.pensamiento, m.pensamientoingles, m.id, g.id id_grado, g.grado, n.nota 
                FROM $tabla n, estudiantes e, materias m, grados g, periodos p 
                WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
                AND e.id = $id_estudiante AND g.id = $id_grado AND p.id = 3) p3,
                (SELECT DISTINCT e.id id_estudiante, m.materia, m.materiaingles, m.pensamiento, m.pensamientoingles, m.id, g.id id_grado, g.grado, n.nota 
                FROM $tabla n, estudiantes e, materias m, grados g, periodos p 
                WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
                AND e.id = $id_estudiante AND g.id = $id_grado AND p.id = 4) p4 
                WHERE p1.id_estudiante = p2.id_estudiante AND p1.id_estudiante = p3.id_estudiante AND p1.id_estudiante = p4.id_estudiante 
                AND p1.id = p2.id  AND p1.id = p3.id  AND p1.id = p4.id 
                AND p1.id_grado = p2.id_grado AND p1.id_grado = p3.id_grado AND p1.id_grado = p4.id_grado 
                ORDER BY 2";
    	}
    	//echo $sql_nota;
	
    	$exe_notas1=mysqli_query($conexion,$sql_nota);
    	$exe_notas2=mysqli_query($conexion,$sql_nota);
    
    	$total_materias=mysqli_num_rows($exe_notas1);
    	$pasada=0;
    	$perdida=0;
        //echo $total_materias;
    
    	while ($fila_promedio=mysqli_fetch_array($exe_notas1)) {
    		$promedio=$fila_promedio['promedio'];
    		$grado_encurso=$fila_promedio['grado'];
    		$genero=$fila_promedio['genero'];
    		if ($promedio>=3.0) {
    			$pasada++;
    		}
    		else{
    			$perdida++;
    		}
    	}
    	//echo $perdida;
	}
	else {
	    //Se capturan las notas en la tabla tbl_notas_historia
	    $sql_nota = "SELECT * FROM tbl_notas_historia WHERE id_est = ".$id_estudiante." AND n_matricula = '$matricula_actual'";
	    //echo $sql_nota;
	    $exe_notas1=mysqli_query($conexion,$sql_nota);
    	
    	//$total_materias=mysqli_num_rows($exe_notas1);
    	$pasada=0;
    	$perdida=0;
        //echo $total_materias;
    
    	while ($fila_promedio=mysqli_fetch_array($exe_notas1)) {
    	    $json = $fila_promedio['json'];
    	}
    	//echo $json;
    	$obj = json_decode($json);
    	//echo $obj;
        $perdida = $obj->{'perdidas'};
        $calif = $obj->{'calificaciones'};
        $json_id_grado = $obj->{'id_grado'};
	}
	//$tabla = "historial_notas";
	
	if ($perdida>=1) {
		$mensaje="cursó y reprobó";
		$mensajeIngles="studied and failed";
		$mensaje_promovido="Reprobó grado ".$grado;
    	$mensaje_promovidoIngles="Failes grade ".$grado;
	}else{
		$mensaje="cursó y aprobó";
		$mensajeIngles="studied and approved";
	}
	
	if ($genero=="Femenino") {
		$genero_estudiante="la";
		$promovio="Promovida";
	}else{
		$genero_estudiante="el";
		$promovio="Promovido";
	}
	//echo $mensaje;
	//echo $genero_estudiante;
	//echo $promovio;
	
	//echo $idioma;
	//certificado español
	if ($idioma=="espanol") {
		
    	$content = '<html>';
        $content .= '<head>';
        $content .= '<style>';
        //$content .= '#divmarca {background-image: url("../../docenteunicab/updreg/img/marcaagua28_1.jpg"); background-repeat: no-repeat; background-size: cover;}';
		$content .= '#divmarca {background-image: url("../../docenteunicab/updreg/img/marcaagua28_2025.jpg"); background-repeat: no-repeat; background-size: cover;}';
        $content .= 'table {border-collapse: collapse;}';
        $content .= 'thead, tr, td {border: 1px solid gray; text-align: center;}';
        $content .= 'thead {font-weight: bold;}';
        $content .= 'span {background: #CEF6CE;}';
        $content .= '</style>';
        $content .= '</head><body>';
        
        $content .= '<center><div>';
        //$content .= '<img src="../../images/logo3.jpg" width="120px" height="108px"/>';
		$content .= '<img src="../../images/logo3_2025.jpg" width="120px" height="108px"/>';
        $content .= '</div>';
        $content .= '<p style="font-size: 12px;">';
        $content .= '<strong>UNICAB VIRTUAL</strong>, CODIGO DANE 315759002653, CODIGO ICFES 154567, Licencia de funcionamiento de la Secretaría de Educación y Cultura de Sogamoso 
                    según resolución 061 del 15 de diciembre de 2007, y Resolución Nº 0155 21 de Julio de 2010 y Resolución No. 326 del 22 de septiembre de 2015, para todos los niveles 
                    de Educación Básica Primaria, Básica Secundaria y Media Académica,';
        $content .= '</p>';
        $content .= '<p>';
        $content .= '<strong>LA RECTORA Y SECRETARIA ACADÉMICA DEL COLEGIO UNICAB VIRTUAL</strong>';
        $content .= '</p>';
        $content .= '<p>';
        $content .= '<strong>CERTIFICAN:</strong>';
        $content .= '</p>';
        $content1 = "";
        $content2 = "";
        
        if($id_grado <= 6 || $id_grado == 13 || $id_grado == 14) {
    	    $educacion = "EDUCACION BASICA PRIMARIA";
    	}
    	else if($id_grado <= 10 || $id_grado == 15 || $id_grado == 16) {
    	    $educacion = "EDUCACION BASICA SECUNDARIA";
    	}
    	else if($id_grado <= 12 || $id_grado == 17 || $id_grado == 18) {
    	    $educacion = "EDUCACION MEDIA ACADEMICA";
    	}
    	//echo $id_grado;
    	//echo $educacion;
    	
    	$content1 .= '<div id="divmarca">';
    	$content1 .= '<p style="font-size: 1rem;">Que '.$variable.' estudiante, <strong>'.$nombreCompleto.'</strong>, '.$variableDos.' con '.$tipo_documento.' No. '.$n_documento.' expedida en '.$expedicion.', '.$mensaje.' el grado <strong>'.$grado.'</strong> de <strong>'.$educacion.'</strong>, durante el año lectivo '.$aant.' cumpliendo con los siguientes logros establecidos y valoraciones que a continuación se especifican en el boletín de calificaciones:</p><br>';
        $content1 .= '<table border="1" bordercolor="#000000" style="border-collapse:separate; border-spacing:2px; font-family: sans-serif; font-size: 0.8rem; width:100%">';
        $content1 .= '<thead style="background: gray; color: white;"><tr>';
        $content1 .= '<th style="text-align: center;">Pensamiento</th>';
        $content1 .= '<th style="text-align: center;">AREA-Asignatura</th>';
        $content1 .= '<th style="text-align: center;">VALORACIÓN</th>';
        $content1 .= '<th style="text-align: center;">NIVEL DE DESEMPEÑO</th>';
		$content1 .= '</tr></thead><tbody style="font-weight: bold;">';
		
		if($ct_tabla_notas > 0) {
	 		while ($row=mysqli_fetch_array($exe_notas2)) {
	 		    $content1 .= '<tr>';
	 		    $content1 .= '<td style="text-align:center;">'.$row['pensamiento'].'</td>';
	 		    $content1 .= '<td style="text-align:center;">'.$row['materia'].'</td>';
	 		    $content1 .= '<td style="text-align:center;">'.$row['promedio'].'</td>';
	 		    
	 		    if ($row['promedio']<3.0) {
  				    $nivel = "BAJO";
  				}
  				else if ($row['promedio']>=3.0 && $row['promedio']<=3.9) {
  				    $nivel = "BASICO";
  				}
  				else if ($row['promedio']>=4.0 && $row['promedio']<=4.5) {
  				    $nivel = "ALTO";
  				}
  				else if ($row['promedio']>4.5) {
  				    $nivel = "SUPERIOR";
  				}
		      	
		      	$content1 .= '<td style="text-align:center;">'.$nivel.'</td></tr>';
		      	
		      	if ($row['id_grado']>=17) {
  				    //esta validación es para las asignaturas de bioético y humanístico
  				    if($row['id_materia'] == 10) {
  				        $content1 .= '<tr><td style="text-align:center;">'.$row['pensamiento'].'</td><td style="text-align:center;">EDUCACIÓN ÉTICA Y EN VALORES</td><td style="text-align:center;">'.$row['promedio'].'</td><td style="text-align:center;">'.$nivel.'</td></tr>';
  				        $content1 .= '<tr><td style="text-align:center;">'.$row['pensamiento'].'</td><td style="text-align:center;">EDUCACIÓN FÍSICA</td><td style="text-align:center;">'.$row['promedio'].'</td><td style="text-align:center;">'.$nivel.'</td></tr>';
					}
					else if($row['id_materia'] == 15) {
					    $content1 .= '<tr><td style="text-align:center;">'.$row['pensamiento'].'</td><td style="text-align:center;">ARTISTICA</td><td style="text-align:center;">'.$row['promedio'].'</td><td style="text-align:center;">'.$nivel.'</td></tr>';
  				        $content1 .= '<tr><td style="text-align:center;">'.$row['pensamiento'].'</td><td style="text-align:center;">FILOSOFÍA</td><td style="text-align:center;">'.$row['promedio'].'</td><td style="text-align:center;">'.$nivel.'</td></tr>';
					}
  				}
  				else {
  				    //esta validación es para las asignaturas de bioético y humanístico
					if($row['id_materia'] == 10 || $row['id_materia'] == 1) {
						$content1 .= '<tr><td style="text-align:center;">'.$row['pensamiento'].'</td><td style="text-align:center;">EDUCACIÓN ÉTICA Y EN VALORES</td><td style="text-align:center;">'.$row['promedio'].'</td><td style="text-align:center;">'.$nivel.'</td></tr>';
  				        $content1 .= '<tr><td style="text-align:center;">'.$row['pensamiento'].'</td><td style="text-align:center;">EDUCACIÓN FÍSICA</td><td style="text-align:center;">'.$row['promedio'].'</td><td style="text-align:center;">'.$nivel.'</td></tr>';
					}
					else if($row['id_materia'] == 15) {
						$content1 .= '<tr><td style="text-align:center;">'.$row['pensamiento'].'</td><td style="text-align:center;">ARTISTICA</td><td style="text-align:center;">'.$row['promedio'].'</td><td style="text-align:center;">'.$nivel.'</td></tr>';
  				        $content1 .= '<tr><td style="text-align:center;">'.$row['pensamiento'].'</td><td style="text-align:center;">FILOSOFÍA</td><td style="text-align:center;">'.$row['promedio'].'</td><td style="text-align:center;">'.$nivel.'</td></tr>';
					}
					else if($row['id_materia'] == 6) {
					    $content1 .= '<tr><td style="text-align:center;">'.$row['pensamiento'].'</td><td style="text-align:center;">ARTISTICA</td><td style="text-align:center;">'.$row['promedio'].'</td><td style="text-align:center;">'.$nivel.'</td></tr>';
					}
  				}
			}
 	    }
 	    else {
 	        foreach($calif as $promedios) {
                $json_id_mat = $promedios->{'id_mat'};
                $json_nfinal = $promedios->{'nfinal'};
                //Se busca el pensamiento y la materia
                $sql_materia = "SELECT * FROM materias WHERE id = ".$json_id_mat;
                $exe_materia=mysqli_query($conexion,$sql_materia);
            	while ($fila_materia = mysqli_fetch_array($exe_materia)) {
            	    $pensamiento = $fila_materia['pensamiento'];
            	    $materia = $fila_materia['materia'];
            	}
                
                $content1 .= '<tr>';
                $content1 .= '<td style="text-align:center;">'.$pensamiento.'</td>';
	 		    $content1 .= '<td style="text-align:center;">'.$materia.'</td>';
	 		    $content1 .= '<td style="text-align:center;">'.$json_nfinal.'</td>';
	 		    
 				if ($json_nfinal < 3.0) {
  				    $nivel = "BAJO";
  				}
  				else if ($json_nfinal >= 3.0 && $json_nfinal <= 3.9) {
  				    $nivel = "BASICO";
  				}
  				else if ($json_nfinal >= 4.0 && $json_nfinal <= 4.5) {
  				    $nivel = "ALTO";
  				}
  				else if ($json_nfinal > 4.5) {
  				    $nivel = "SUPERIOR";
  				}
  				$content1 .= '<td style="text-align:center;">'.$nivel.'</td></tr>';
		      	
  				
  				if ($json_id_grado >= 17) {
  				    //esta validación es para las asignaturas de bioético y humanístico
  				    if($json_id_mat == 10) {
						//echo "<tr><td style='text-align:center;'>".$pensamiento."</td><td style='text-align:center;'>EDUCACIÓN ÉTICA Y EN VALORES</td><td style='text-align:center;'>".$json_nfinal."</td><td style='text-align:center;'>".$nivel."</td></tr>";
						//echo "<tr><td style='text-align:center;'>".$pensamiento."</td><td style='text-align:center;'>EDUCACIÓN FÍSICA</td><td style='text-align:center;'>".$json_nfinal."</td><td style='text-align:center;'>".$nivel."</td></tr>";
						$content1 .= '<tr><td style="text-align:center;">'.$pensamiento.'</td><td style="text-align:center;">EDUCACIÓN ÉTICA Y EN VALORES</td><td style="text-align:center;">'.$json_nfinal.'</td><td style="text-align:center;">'.$nivel.'</td></tr>';
  				        $content1 .= '<tr><td style="text-align:center;">'.$pensamiento.'</td><td style="text-align:center;">EDUCACIÓN FÍSICA</td><td style="text-align:center;">'.$json_nfinal.'</td><td style="text-align:center;">'.$nivel.'</td></tr>';
					}
					else if($json_id_mat == 15) {
						//echo "<tr><td style='text-align:center;'>".$pensamiento."</td><td style='text-align:center;'>ARTISTICA</td><td style='text-align:center;'>".$json_nfinal."</td><td style='text-align:center;'>".$nivel."</td></tr>";
						//echo "<tr><td style='text-align:center;'>".$pensamiento."</td><td style='text-align:center;'>FILOSOFÍA</td><td style='text-align:center;'>".$json_nfinal."</td><td style='text-align:center;'>".$nivel."</td></tr>";
						$content1 .= '<tr><td style="text-align:center;">'.$pensamiento.'</td><td style="text-align:center;">ARTISTICA</td><td style="text-align:center;">'.$json_nfinal.'</td><td style="text-align:center;">'.$nivel.'</td></tr>';
  				        $content1 .= '<tr><td style="text-align:center;">'.$pensamiento.'</td><td style="text-align:center;">FILOSOFÍA</td><td style="text-align:center;">'.$json_nfinal.'</td><td style="text-align:center;">'.$nivel.'</td></tr>';
					}
  				}
  				else {
  				    //esta validación es para las asignaturas de bioético y humanístico
					if($json_id_mat == 10 || $json_id_mat == 1) {
						//echo "<tr><td style='text-align:center;'>".$pensamiento."</td><td style='text-align:center;'>EDUCACIÓN ÉTICA Y EN VALORES</td><td style='text-align:center;'>".$json_nfinal."</td><td style='text-align:center;'>".$nivel."</td></tr>";
						//echo "<tr><td style='text-align:center;'>".$pensamiento."</td><td style='text-align:center;'>EDUCACIÓN FÍSICA</td><td style='text-align:center;'>".$json_nfinal."</td><td style='text-align:center;'>".$nivel."</td></tr>";
						$content1 .= '<tr><td style="text-align:center;">'.$pensamiento.'</td><td style="text-align:center;">EDUCACIÓN ÉTICA Y EN VALORES</td><td style="text-align:center;">'.$json_nfinal.'</td><td style="text-align:center;">'.$nivel.'</td></tr>';
  				        $content1 .= '<tr><td style="text-align:center;">'.$pensamiento.'</td><td style="text-align:center;">EDUCACIÓN FÍSICA</td><td style="text-align:center;">'.$json_nfinal.'</td><td style="text-align:center;">'.$nivel.'</td></tr>';
					}
					else if($json_id_mat == 15) {
						//echo "<tr><td style='text-align:center;'>".$pensamiento."</td><td style='text-align:center;'>ARTISTICA</td><td>".$json_nfinal."</td><td>".$nivel."</td></tr>";
						//echo "<tr><td style='text-align:center;'>".$pensamiento."</td><td style='text-align:center;'>FILOSOFÍA</td><td>".$json_nfinal."</td><td>".$nivel."</td></tr>";
						$content1 .= '<tr><td style="text-align:center;">'.$pensamiento.'</td><td style="text-align:center;">ARTISTICA</td><td style="text-align:center;">'.$json_nfinal.'</td><td style="text-align:center;">'.$nivel.'</td></tr>';
  				        $content1 .= '<tr><td style="text-align:center;">'.$pensamiento.'</td><td style="text-align:center;">FILOSOFÍA</td><td style="text-align:center;">'.$json_nfinal.'</td><td style="text-align:center;">'.$nivel.'</td></tr>';
					}
					else if($json_id_mat == 6) {
						//echo "<tr><td style='text-align:center;'>".$pensamiento."</td><td style='text-align:center;'>ARTISTICA</td><td style='text-align:center;'>".$json_nfinal."</td><td style='text-align:center;'>".$nivel."</td></tr>";
						$content1 .= '<tr><td style="text-align:center;">'.$pensamiento.'</td><td style="text-align:center;">ARTISTICA</td><td style="text-align:center;">'.$json_nfinal.'</td><td style="text-align:center;">'.$nivel.'</td></tr>';
					}
  				}
            }
            //echo $calif[0]->{'nfinal'};
 	    }
		
		$content1 .= '</tbody></table><br>';
		$content1 .= '<div style="text-align: left;">';
		$content1 .= '<p style="border: black 2px solid; text-align: left;  border-width: thin; width:60%; font-family: sans-serif; font-size: 1rem;"><strong>'.$mensaje_promovido.'</strong></p>';
		$content1 .= '</div></div></center>';
		
		$content1 .= '<p>';
        $content1 .= 'Se expide a los '.$dia.' días del mes de '.$espaniol.' de '.$fanio.'.';
        $content1 .= '</p>';
        
        $content1 .= '<center><div>';
        
        $content2 = $content1;
        //$content1 .= '<img src="../../images/firma_certficados.JPG" width="400" height="135"/>';
        //$content1 .= '<img src="../../images/firmas1.jpg" width="700" height="166"/>';
		$content1 .= '<img class="img-responsive" width="70%" src="../../images/firma_certificados.JPG">';
        //$content2 .= '<br><br><br><img src="../../images/sin_firmas2.jpg" width="700px" height="63px"/>';
		$content2 .= '<br><br><br><img class="img-responsive" width="70%" src="../../images/firma_certificados_liliana_sf.jpg">';
        
        $content1 .= '</div>';
        $content1 .= '<p>';
        $content1 .= 'Calle 13ª N° 16-60 Sogamoso – Boyacá Tel. 0987 701685 Cel. 315 696 5291 - 315 889 5275';
        $content1 .= '</p>';
        $content1 .= '<p>';
        $content1 .= 'www.unicab.org';
        $content1 .= '</p>';
        $content1 .= '<p>';
        $content1 .= '<span>Certificado No. CFF'.$numeroc.'</span>';
        $content1 .= '</p>';
        $content1 .= '</center>';
        $content1 .= '</body></html>';  
        
        $content2 .= '</div>';
        $content2 .= '<p>';
        $content2 .= 'Calle 13ª N° 16-60 Sogamoso – Boyacá Tel. 0987 701685 Cel. 315 696 5291 - 315 889 5275';
        $content2 .= '</p>';
        $content2 .= '<p>';
        $content2 .= 'www.unicab.org';
        $content2 .= '</p>';
        $content2 .= '<p>';
        $content2 .= '<span>Certificado No. CFSF'.$numeroc.'</span>';
        $content2 .= '</p>';
        $content2 .= '</center>';
        $content2 .= '</body></html>';
        
        //echo $content;
        //echo $content1;
    	
    	$nom_pdf = "cff_".str_replace(" ","_",$grado)."_".str_replace(" ","_",$nombreCompleto)."_".$fanio.".pdf";
    	$nom_pdf1 = "cfsf_".str_replace(" ","_",$grado)."_".str_replace(" ","_",$nombreCompleto)."_".$fanio.".pdf";
    	//$nom_pdf = "cff_".str_replace(" ","_",$grado)."_".str_replace(" ","_",$nombreCompleto)."_".$aant.".pdf";
    	//$nom_pdf1 = "cfsf_".str_replace(" ","_",$grado)."_".str_replace(" ","_",$nombreCompleto)."_".$aant.".pdf";
    	//echo $nom_pdf;
    	
    	//PDF::stream($nom_pdf,$content);
    
        $folder0 = '/certificados_finales/'.$fanio.'/'.str_replace(" ","_",$grado).'/';
        //$folder0 = '/certificados_finales/'.$aant.'/'.str_replace(" ","_",$grado).'/';
        $folder = __DIR__.$folder0;
        //echo "<br>".$folder;
        //la siguiene ruta es para mostrar por pantalla
        $folder1 = '/adminunicab/php/certificados_finales/'.$fanio.'/'.str_replace(" ","_",$grado).'/';
        //$folder1 = '/adminunicab/php/certificados_finales/'.$aant.'/'.str_replace(" ","_",$grado).'/';
        PDF::saveDisk($nom_pdf,$content.$content1,$folder);
        PDF::saveDisk($nom_pdf1,$content.$content2,$folder);
        $content1 = "";
        $content2 = "";
        $nivel = "";
        $variable = "";
		$variableDos = "";
		$variableTres = "";
		$variableCuatro = "";
		$educacion = "";
        
        $ruta = "https://unicab.org/registro".$folder1.$nom_pdf;
        $ruta1 = "https://unicab.org/registro".$folder1.$nom_pdf1;
        
        echo "<br><table><tbody><tr><td>".$ruta."</td><td><div class='divdescarga'><a href='".$ruta."?c=".$codigo."' target='_blank'>DESCARGAR</a></div></td></tr>";
        echo "<tr><td>".$ruta1."</td><td><div class='divdescarga'><a href='".$ruta1."?c=".$codigo."' target='_blank'>DESCARGAR</a></div></td></tr></tbody></table>";
        
        //echo "<br>".$ruta;
        //echo "<br><br><div class='divdescarga'><a href='".$ruta."' target='_blank'>DESCARGAR</a></div>";
        
        //Se valida si el archivo pdf ya existe
        $sql_validacion = "SELECT * FROM certificado WHERE ruta = '$ruta'";
        $exe_sql_val=$mysqli1->query($sql_validacion);
    	$ct_pdf = $mysqli1->affected_rows;
        
        if($ct_pdf > 0) {
            $sql_upd="UPDATE certificado SET ruta1 = '".$ruta1."' 
            WHERE ruta = '".$ruta."'";
            //echo $sql_upd;
            $exe_upd=mysqli_query($conexion,$sql_upd);
        }
        else {
            $sql_insert='INSERT INTO certificado (fecha_expedicion, numero, tipo_certificado, id_estudiante, id_grado, ruta, numero1, identificacion, ruta1, a) 
            VALUES ("'.$fecha2.'","CFF'.$aant.$numeroc.'","Certificado final","'.$id_estudiante.'","'.$id_grado.'","'.$ruta.'",'.$aant.$numeroc.',"'.$n_documento.'","'.$ruta1.'",'.$fanio.')';
            //echo $sql_insert;
            $exe_insert=mysqli_query($conexion,$sql_insert);
        }
        
        $certicado_total++;
    	$cert_num = $fanio.$certicado_total;
	}
 	// fin certificado español
 	
 	//certificado inglés
	if ($idioma=="ingles") {
		
    	$content = '<html>';
        $content .= '<head>';
        $content .= '<style>';
        //$content .= '#divmarca {background-image: url("../../docenteunicab/updreg/img/marcaagua28_1.jpg"); background-repeat: no-repeat; background-size: cover;}';
		$content .= '#divmarca {background-image: url("../../docenteunicab/updreg/img/marcaagua28_2025.jpg"); background-repeat: no-repeat; background-size: cover;}';
        $content .= 'table {border-collapse: collapse;}';
        $content .= 'thead, tr, td {border: 1px solid gray; text-align: center;}';
        $content .= 'thead {font-weight: bold;}';
        $content .= 'span {background: #CEF6CE;}';
        $content .= '</style>';
        $content .= '</head><body>';
        
        $content .= '<center><div>';
        //$content .= '<img src="../../images/logo3.jpg" width="120px" height="108px"/>';
		$content .= '<img src="../../images/logo3_2025.jpg" width="120px" height="108px"/>';
        $content .= '</div>';
        $content .= '<p style="font-size: 12px;">';
        $content .= '<strong>UNICAB VIRTUAL</strong>, DANE CODE 315759002653, ICFES CODE 154567, operating license from education and culture secretary of Sogamoso according to administrative resolution N° 061 on December 15<sup>th</sup> in 2007, and  administrative resolution N° 0155 on July 21<sup>nd</sup> in 2010 and  administrative resolution N° 326 on September 22<sup>nd</sup> in 2015, for all education levels 
                    of preschool, elementary, secondary and high school,';
        $content .= '</p>';
        $content .= '<p>';
        $content .= '<strong>THE RECTOR  AND ACADEMIC SECRETARY OF THE UNICAB VIRTUAL SCHOOL</strong>';
        $content .= '</p>';
        $content .= '<p>';
        $content .= '<strong>CERTIFY:</strong>';
        $content .= '</p>';
        $content1 = "";
        $content2 = "";
        
        if($id_grado <= 6 || $id_grado == 13 || $id_grado == 14) {
    	    $educacion = "ELEMENTARY EDUCATION";
    	}
    	else if($id_grado <= 10 || $id_grado == 15 || $id_grado == 16) {
    	    $educacion = "SECONDARY EDUCATION";
    	}
    	else if($id_grado <= 12 || $id_grado == 17 || $id_grado == 18) {
    	    $educacion = "HIGH SCHOOL";
    	}
    	//echo $id_grado;
    	//echo $educacion;
    	
    	//echo $grado;
    	switch ($grado) {
		    case "Transición":
		        $grado="Transition";
				$nivelEducativo="Preschool Education";
		        break;
		    case "Primero":
		         $grado="1<sup>st</sup> grade";
				 $nivelEducativo="Elementary Education";
		        break;
		    case "Segundo":
		       $grado="2<sup>nd</sup> grade";
				$nivelEducativo="Elementary Education";
		        break;
			case "Tercero":
		        $grado="3<sup>rd</sup> grade";
				$nivelEducativo="Elementary Education";
		        break;
			case "Cuarto":
		        $grado="4<sup>th</sup> grade";
				$nivelEducativo="Elementary Education";
		        break;
			case "Quinto":
		        $grado="5<sup>th</sup> grade";
				$nivelEducativo="Elementary Education";
		        break;
			case "Sexto":
		        $grado="6<sup>th</sup> grade";
				$nivelEducativo="Secondary Education";
		        break;
			case "Séptimo":
		        $grado="7<sup>th</sup> grade";
				$nivelEducativo="Secondary Education";
		        break;
			case "Octavo":
		        $grado="8<sup>th</sup> grade";
				$nivelEducativo="Secondary Education";
		        break;
			case "Noveno":
		        $grado="9<sup>th</sup> grade";
				$nivelEducativo="Secondary Education";
		        break;
			case "Décimo":
		        $grado="10<sup>th</sup> grade";
				$nivelEducativo="high School";
		        break;
			case "UnDécimo":
		        $grado="11<sup>th</sup> grade";
				$nivelEducativo="high School";
		        break;
			case "Ciclo I":
		        $grado="Cycle I";
				$nivelEducativo="Elementary Education";
		        break;
			case "Ciclo II":
		        $grado="Cycle II";
				$nivelEducativo="Elementary Education";
		        break;
			case "Ciclo III":
		        $grado="Cycle III";
				$nivelEducativo="Secondary Education";
		        break;
			case "Ciclo IV":
		        $grado="Cycle IV";
				$nivelEducativo="Secondary Education";
		        break;
			case "Ciclo V":
		        $grado="Cycle V";
				$nivelEducativo="high School";
		        break;
			case "Ciclo VI":
		        $grado="Cycle VI";
				$nivelEducativo="high School";
		        break;
			default:
			 	$grado="Undefined";
				$nivelEducativo="Undefined";
		}
    	
    	$content1 .= '<div id="divmarca">';
    	$content1 .= '<p style="font-size: 1rem;">That the student, <strong>'.$nombreCompleto.'</strong>, with I.D. N° '.$n_documento.' from '.$expedicion.', '.$mensajeIngles.' the <strong>'.$grado.'</strong> of <strong>'.$educacion.'</strong>, during the  school year '.$aant.' fulfilling the following established achievements and evaluations that the partial report card is specified below:</p><br>';
        $content1 .= '<table border="1" bordercolor="#000000" style="border-collapse:separate; border-spacing:2px; font-family: sans-serif; font-size: 0.8rem; width:100%">';
        $content1 .= '<thead style="background: gray; color: white;"><tr>';
        $content1 .= '<th style="text-align: center;">THOUGHT</th>';
        $content1 .= '<th style="text-align: center;">SUBJECT</th>';
        $content1 .= '<th style="text-align: center;">ASSESSMENT</th>';
        $content1 .= '<th style="text-align: center;">PERFORMANCE LEVEL</th>';
		$content1 .= '</tr></thead><tbody style="font-weight: bold;">';
		
		if($ct_tabla_notas > 0) {
	 		while ($row=mysqli_fetch_array($exe_notas2)) {
	 		    $content1 .= '<tr>';
	 		    $content1 .= '<td style="text-align:center;">'.$row['pensamientoingles'].'</td>';
	 		    $content1 .= '<td style="text-align:center;">'.$row['materiaingles'].'</td>';
	 		    $content1 .= '<td style="text-align:center;">'.$row['promedio'].'</td>';
	 		    
	 		    if ($row['promedio']<=3.0) {
  				    $nivel = "LOW";
  				}
  				else if ($row['promedio']>=3.1 && $row['promedio']<=4.4) {
  				    $nivel = "HIGH";
  				}
  				else if ($row['promedio']>=4.5) {
  				    $nivel = "SUPERIOR";
  				}
		      	
		      	$content1 .= '<td style="text-align:center;">'.$nivel.'</td></tr>';
		      	
		      	if ($row['id_grado']>=17) {
  				    //esta validación es para las asignaturas de bioético y humanístico
  				    if($row['id_materia'] == 10) {
  				        $content1 .= '<tr><td style="text-align:center;">'.$row['pensamientoingles'].'</td><td style="text-align:center;">ETHICS AND VALUES EDUCATION</td><td style="text-align:center;">'.$row['promedio'].'</td><td style="text-align:center;">'.$nivel.'</td></tr>';
  				        $content1 .= '<tr><td style="text-align:center;">'.$row['pensamientoingles'].'</td><td style="text-align:center;">PHYSICAL EDUCATION</td><td style="text-align:center;">'.$row['promedio'].'</td><td style="text-align:center;">'.$nivel.'</td></tr>';
					}
					else if($row['id_materia'] == 15) {
					    $content1 .= '<tr><td style="text-align:center;">'.$row['pensamientoingles'].'</td><td style="text-align:center;">ARTISTIC</td><td style="text-align:center;">'.$row['promedio'].'</td><td style="text-align:center;">'.$nivel.'</td></tr>';
  				        $content1 .= '<tr><td style="text-align:center;">'.$row['pensamientoingles'].'</td><td style="text-align:center;">PHILOSOPHY</td><td style="text-align:center;">'.$row['promedio'].'</td><td style="text-align:center;">'.$nivel.'</td></tr>';
					}
  				}
  				else {
  				    //esta validación es para las asignaturas de bioético y humanístico
					if($row['id_materia'] == 10 || $row['id_materia'] == 1) {
						$content1 .= '<tr><td style="text-align:center;">'.$row['pensamientoingles'].'</td><td style="text-align:center;">ETHICS AND VALUES EDUCATION</td><td style="text-align:center;">'.$row['promedio'].'</td><td style="text-align:center;">'.$nivel.'</td></tr>';
  				        $content1 .= '<tr><td style="text-align:center;">'.$row['pensamientoingles'].'</td><td style="text-align:center;">PHYSICAL EDUCATION</td><td style="text-align:center;">'.$row['promedio'].'</td><td style="text-align:center;">'.$nivel.'</td></tr>';
					}
					else if($row['id_materia'] == 15) {
						$content1 .= '<tr><td style="text-align:center;">'.$row['pensamientoingles'].'</td><td style="text-align:center;">ARTISTIC</td><td style="text-align:center;">'.$row['promedio'].'</td><td style="text-align:center;">'.$nivel.'</td></tr>';
  				        $content1 .= '<tr><td style="text-align:center;">'.$row['pensamientoingles'].'</td><td style="text-align:center;">PHILOSOPHY</td><td style="text-align:center;">'.$row['promedio'].'</td><td style="text-align:center;">'.$nivel.'</td></tr>';
					}
					else if($row['id_materia'] == 6) {
					    $content1 .= '<tr><td style="text-align:center;">'.$row['pensamientoingles'].'</td><td style="text-align:center;">ARTISTIC</td><td style="text-align:center;">'.$row['promedio'].'</td><td style="text-align:center;">'.$nivel.'</td></tr>';
					}
  				}
			}
 	    }
		
		$content1 .= '</tbody></table><br>';
		$content1 .= '<div style="text-align: left;">';
		$content1 .= '<p style="border: black 2px solid; text-align: left;  border-width: thin; width:60%; font-family: sans-serif; font-size: 1rem;"><strong>'.$mensaje_promovidoIngles.'</strong></p>';
		$content1 .= '</div></div></center>';
		
		$content1 .= '<p>';
        $content1 .= 'Certificate issued in Sogamoso on '.$dia.' days of the month of '.$mesi.' '.$fanio.'.';
        $content1 .= '</p>';
        
        $content1 .= '<center><div>';
        
        $content2 = $content1;
        //$content1 .= '<img src="../../images/firma_certficados.JPG" width="400" height="135"/>';
        //$content1 .= '<img src="../../images/firmas1.jpg" width="700" height="166"/>';
		$content1 .= '<img class="img-responsive" width="70%" src="../../images/firma_certificados_liliana.jpg">';
        //$content2 .= '<br><br><br><img src="../../images/sin_firmas2.jpg" width="700px" height="63px"/>';
		$content2 .= '<br><br><br><img class="img-responsive" width="70%" src="../../images/firma_certificados_liliana_sf.jpg">';
		
		$content1 .= '</div>';
        $content1 .= '<p>';
        $content1 .= 'Calle 13ª N° 16-60 Sogamoso – Boyacá Tel. 0987 701685 Cel. 315 696 5291 - 315 889 5275';
        $content1 .= '</p>';
        $content1 .= '<p>';
        $content1 .= 'www.unicab.org';
        $content1 .= '</p>';
        $content1 .= '<p>';
        $content1 .= '<span>Certificate No. CFIF'.$numeroc.'</span>';
        $content1 .= '</p>';
        $content1 .= '</center>';
        $content1 .= '</body></html>';    
        
        $content2 .= '</div>';
        $content2 .= '<p>';
        $content2 .= 'Calle 13ª N° 16-60 Sogamoso – Boyacá Tel. 0987 701685 Cel. 315 696 5291 - 315 889 5275';
        $content2 .= '</p>';
        $content2 .= '<p>';
        $content2 .= 'www.unicab.org';
        $content2 .= '</p>';
        $content2 .= '<p>';
        $content2 .= '<span>Certificate No. CFISF'.$numeroc.'</span>';
        $content2 .= '</p>';
        $content2 .= '</center>';
        $content2 .= '</body></html>';
        
        //echo $content;
        //echo $content1;
    	
    	$nom_pdf = "cfif_".str_replace(" ","_",$grado0)."_".str_replace(" ","_",$nombreCompleto)."_".$fanio.".pdf";
    	$nom_pdf1 = "cfisf_".str_replace(" ","_",$grado0)."_".str_replace(" ","_",$nombreCompleto)."_".$fanio.".pdf";
    	//$nom_pdf = "cfif_".str_replace(" ","_",$grado0)."_".str_replace(" ","_",$nombreCompleto)."_".$aant.".pdf";
    	//$nom_pdf1 = "cfisf_".str_replace(" ","_",$grado0)."_".str_replace(" ","_",$nombreCompleto)."_".$aant.".pdf";
    	//echo $nom_pdf;
    	
    	//PDF::stream($nom_pdf,$content);
    
        $folder0 = '/certificados_finales/'.$fanio.'/'.str_replace(" ","_",$grado0).'/';
        //$folder0 = '/certificados_finales/'.$aant.'/'.str_replace(" ","_",$grado0).'/';
        $folder = __DIR__.$folder0;
        //echo "<br>".$folder;
        //la siguiene ruta es para mostrar por pantalla
        $folder1 = '/adminunicab/php/certificados_finales/'.$fanio.'/'.str_replace(" ","_",$grado0).'/';
        //$folder1 = '/adminunicab/php/certificados_finales/'.$aant.'/'.str_replace(" ","_",$grado0).'/';		
		PDF::saveDisk($nom_pdf,$content.$content1,$folder);
        PDF::saveDisk($nom_pdf1,$content.$content2,$folder);
        $content1 = "";
        $content2 = "";
        $nivel = "";
        $variable = "";
		$variableDos = "";
		$variableTres = "";
		$variableCuatro = "";
		$educacion = "";
		
		$ruta = "https://unicab.org/registro".$folder1.$nom_pdf;
        $ruta1 = "https://unicab.org/registro".$folder1.$nom_pdf1;
        
        echo "<br><table><tbody><tr><td>".$ruta."</td><td><div class='divdescarga'><a href='".$ruta."?c=".$codigo."' target='_blank'>DESCARGAR</a></div></td></tr>";
        echo "<tr><td>".$ruta1."</td><td><div class='divdescarga'><a href='".$ruta1."?c=".$codigo."' target='_blank'>DESCARGAR</a></div></td></tr></tbody></table>";
        
        //echo "<br>".$ruta;
        //echo "<br><br><div id='divdescarga'><a href='".$ruta."' target='_blank'>DESCARGAR</a></div>";
        
        //Se valida si el archivo pdf ya existe
        $sql_validacion = "SELECT * FROM certificado WHERE ruta = '$ruta'";
        $exe_sql_val=$mysqli1->query($sql_validacion);
    	$ct_pdf = $mysqli1->affected_rows;
        
        if($ct_pdf > 0) {
            $sql_upd="UPDATE certificado SET ruta1 = '".$ruta1."' 
            WHERE ruta = '".$ruta."'";
            //echo $sql_upd;
            $exe_upd=mysqli_query($conexion,$sql_upd);
        }
        else {
            $sql_insert='INSERT INTO certificado (fecha_expedicion, numero, tipo_certificado, id_estudiante, id_grado, ruta, numero1, identificacion, ruta1, a) 
            VALUES ("'.$fecha2.'","CFIF'.$aant.$numeroc.'","Certificado final","'.$id_estudiante.'","'.$id_grado.'","'.$ruta.'",'.$aant.$numeroc.',"'.$n_documento.'","'.$ruta1.'",'.$fanio.')';
            //echo $sql_insert;
            $exe_insert=mysqli_query($conexion,$sql_insert);
        }
        
        $certicado_total++;
    	$cert_num = $fanio.$numeroc;
	}
 	// fin certificado inglés
	
?>

<html>
    <head>
        <style>
            .divdescarga {
                width: 200px;
                height: 40px;
                margin: auto;
                text-align: center;
                /*
                Las siguientes líneas centran verticalmente dentro del div
                */
                display: flex;
                justify-content: center;
                align-content: center;
                flex-direction: column;
            }
            .divdescarga:hover {
                border-bottom: 1px solid;     
                background: #CDFEAA;
            }
            /*
            Insertamos una imagen de fondo personalizada en enlaces externos. 
            Sin embargo, utilizamos la propiedad abreviada background en lugar de las propiedades individuales. 
            Establecemos la ruta a la imagen que queremos insertar, especificamos el valor no-repeat para que solo se inserte una copia, 
            y luego especificamos la posición como al 100% a la derecha del contenido de texto y a 0 píxeles del extremo superior.
            */
            a {
                height: 32px;
            }
            a[href*="http"] {
                background: url('../../docenteunicab/updreg/img/download.png') no-repeat 90% 0;
                background-size: 32px 32px;
                padding-right: 25px;
            }
        </style>
    </head>
</html>