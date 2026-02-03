<?php
    session_start();
	//Genera el select de los grados
	require("1cc3s4db.php");
	include "../../adminunicab/php/conexion.php";
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	header("Content-type:application/xls; charset=iso-8859-1");
	header("Content-Disposition: attachment; filename=base_datos.xls");
	
if (isset($_SESSION['unisuper']) || isset($_SESSION['uniprofe'])) {
    //$sql="SELECT * FROM profesores WHERE email_institucional='".$_SESSION['uniprofe']."'";
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
		
    }
	
	//$idest = $_REQUEST['idest'];
	echo $id;
	
	date_default_timezone_set('America/Bogota');
    $dia=date("d");
    $mes=date("m");
    $mesLetra=date("M");
    $fanio=date("Y");
	
	/*$query = "SELECT DISTINCT e.id, eg.id_grado_ra, a.grado, m.n_matricula, m.idMatricula, a.usuario, CONCAT(e.nombres,' ',e.apellidos) nombre, e.n_documento, 
	    e.expedicion, e.fecha_nacimiento, e.email_institucional, 
		e.acudiente_1, e.email_acudiente_1, e.telefono_acudiente_1, e.acudiente_2, e.email_acudiente_2, e.telefono_acudiente_2, e.direccion, e.ciudad, 
		e.actividad_extra, e.observacion 
		FROM (SELECT est.*, ep.observacion FROM estudiantes est LEFT JOIN tbl_estudiantes_param ep ON est.id = ep.id_estudiante WHERE est.estado = 'Activo') e, 
		matricula m, equivalence_idgra eg, 
		(SELECT em.*, ee.id_registro 
		FROM tbl_estudiantes_mood em LEFT JOIN equivalence_idest ee
		ON em.id = ee.id_moodle ) a 
		WHERE e.id = m.id_estudiante AND e.id = a.id_registro AND a.grado = eg.name 
		AND m.estado = 'activo' 
		ORDER BY a.grado, nombre";*/
		
	if ($id == 2  || $id == 3 || $id == 18 || $id == 5 || $id == 6 || $id == 7 || $id == 42 || $id == 43) {
	    $query = "SELECT DISTINCT e.id, eg.id_grado_ra, a.grado, m.grupo, m.n_matricula, m.idMatricula, a.usuario, CONCAT(e.apellidos,' ',e.nombres) nombre, e.n_documento, 
	    e.tipo_documento1, e.expedicion, e.fecha_nacimiento, e.email_institucional, 
		e.acudiente_1, e.email_acudiente_1, e.telefono_acudiente_1, e.acudiente_2, e.email_acudiente_2, e.telefono_acudiente_2, e.direccion, e.ciudad, 
		e.actividad_extra, e.observacion, e.genero, m.estado 
		FROM (SELECT est.*, ep.observacion, 
		CASE est.tipo_documento WHEN 1 THEN 'TARJETA DE IDENTIDAD' WHEN 2 THEN 'REGISTRO CIVIL' WHEN 3 THEN 'CEDULA' 
		WHEN 4 THEN 'PASAPORTE' WHEN 5 THEN 'PERMISO DE PERMANENCIA TEMPORAL' WHEN 6 THEN 'PERMISO POR PROTECCIÓN TEMPORAL' END tipo_documento1 
		FROM estudiantes est LEFT JOIN tbl_estudiantes_param ep ON est.id = ep.id_estudiante ) e, 
		matricula m, equivalence_idgra eg, 
		(SELECT em.*, ee.id_registro 
		FROM tbl_estudiantes_mood em LEFT JOIN equivalence_idest ee
		ON em.id = ee.id_moodle ) a 
		WHERE e.id = m.id_estudiante AND e.id = a.id_registro AND a.grado = eg.name 
		AND m.estado IN ('activo', 'aprobado', 'reprobado') AND m.n_matricula like '%-".$fanio."-%' 
		ORDER BY eg.id_grado_ra, nombre";
	}
	else {
	    $query = "SELECT DISTINCT e.id, eg.id_grado_ra, a.grado, m.grupo, m.n_matricula, m.idMatricula, a.usuario, CONCAT(e.apellidos,' ',e.nombres) nombre, e.n_documento, 
	    e.tipo_documento1, e.expedicion, e.fecha_nacimiento, e.email_institucional, 
		e.acudiente_1, e.email_acudiente_1, e.telefono_acudiente_1, e.acudiente_2, e.email_acudiente_2, e.telefono_acudiente_2, e.direccion, e.ciudad, 
		e.actividad_extra, e.observacion, e.genero, m.estado 
		FROM (SELECT est.*, ep.observacion, 
		CASE est.tipo_documento WHEN 1 THEN 'TARJETA DE IDENTIDAD' WHEN 2 THEN 'REGISTRO CIVIL' WHEN 3 THEN 'CEDULA' 
		WHEN 4 THEN 'PASAPORTE' WHEN 5 THEN 'PERMISO DE PERMANENCIA TEMPORAL' WHEN 6 THEN 'PERMISO POR PROTECCIÓN TEMPORAL' END tipo_documento1 
		FROM estudiantes est LEFT JOIN tbl_estudiantes_param ep ON est.id = ep.id_estudiante ) e, 
		matricula m, equivalence_idgra eg, 
		(SELECT em.*, ee.id_registro 
		FROM tbl_estudiantes_mood em LEFT JOIN equivalence_idest ee
		ON em.id = ee.id_moodle ) a, carga_profesor cp 
		WHERE e.id = m.id_estudiante AND e.id = a.id_registro AND a.grado = eg.name 
		AND m.estado IN ('activo', 'aprobado', 'reprobado') AND eg.id_grado_ra = cp.id_grado AND cp.id_empleado = $id AND m.n_matricula like '%-".$fanio."-%' 
		UNION ALL 
        SELECT DISTINCT e.id, eg.id_grado_ra, a.grado, m.grupo, m.n_matricula, m.idMatricula, a.usuario, CONCAT(e.apellidos,' ',e.nombres) nombre, e.n_documento, 
        e.tipo_documento1, e.expedicion, e.fecha_nacimiento, e.email_institucional, 
        e.acudiente_1, e.email_acudiente_1, e.telefono_acudiente_1, e.acudiente_2, e.email_acudiente_2, e.telefono_acudiente_2, e.direccion, e.ciudad, 
        e.actividad_extra, e.observacion, e.genero 
        FROM (SELECT est.*, ep.observacion, 
		CASE est.tipo_documento WHEN 1 THEN 'TARJETA DE IDENTIDAD' WHEN 2 THEN 'REGISTRO CIVIL' WHEN 3 THEN 'CEDULA' 
		WHEN 4 THEN 'PASAPORTE' WHEN 5 THEN 'PERMISO DE PERMANENCIA TEMPORAL' WHEN 6 THEN 'PERMISO POR PROTECCIÓN TEMPORAL' END tipo_documento1 
		FROM estudiantes est LEFT JOIN tbl_estudiantes_param ep ON est.id = ep.id_estudiante ) e, 
        matricula m, equivalence_idgra eg, 
        (SELECT em.*, ee.id_registro 
        FROM tbl_estudiantes_mood em LEFT JOIN equivalence_idest ee
        ON em.id = ee.id_moodle ) a, tbl_direccion_grado dg 
        WHERE e.id = m.id_estudiante AND e.id = a.id_registro AND a.grado = eg.name 
        AND m.estado IN ('activo', 'aprobado', 'reprobado') AND eg.id_grado_ra = dg.id_grado AND dg.id_empleado = $id AND m.n_matricula like '%-".$fanio."-%' 
        UNION ALL 
        SELECT DISTINCT e.id, eg.id_grado_ra, a.grado, m.grupo, m.n_matricula, m.idMatricula, a.usuario, CONCAT(e.apellidos,' ',e.nombres) nombre, e.n_documento, 
        e.tipo_documento1, e.expedicion, e.fecha_nacimiento, e.email_institucional, 
        e.acudiente_1, e.email_acudiente_1, e.telefono_acudiente_1, e.acudiente_2, e.email_acudiente_2, e.telefono_acudiente_2, e.direccion, e.ciudad, 
        e.actividad_extra, e.observacion, e.genero 
        FROM (SELECT est.*, ep.observacion, 
		CASE est.tipo_documento WHEN 1 THEN 'TARJETA DE IDENTIDAD' WHEN 2 THEN 'REGISTRO CIVIL' WHEN 3 THEN 'CEDULA' 
		WHEN 4 THEN 'PASAPORTE' WHEN 5 THEN 'PERMISO DE PERMANENCIA TEMPORAL' WHEN 6 THEN 'PERMISO POR PROTECCIÓN TEMPORAL' END tipo_documento1 
		FROM estudiantes est LEFT JOIN tbl_estudiantes_param ep ON est.id = ep.id_estudiante ) e, 
        matricula m, equivalence_idgra eg, 
        (SELECT em.*, ee.id_registro 
        FROM tbl_estudiantes_mood em LEFT JOIN equivalence_idest ee
        ON em.id = ee.id_moodle ) a, tbl_dir_b db 
        WHERE e.id = m.id_estudiante AND e.id = a.id_registro AND a.grado = eg.name 
        AND m.estado IN ('activo', 'aprobado', 'reprobado') AND eg.id_grado_ra = db.id_grado AND db.id_empleado = $id AND m.n_matricula like '%-".$fanio."-%' 
        UNION ALL 
        SELECT DISTINCT e.id, eg.id_grado_ra, a.grado, m.grupo, m.n_matricula, m.idMatricula, a.usuario, CONCAT(e.apellidos,' ',e.nombres) nombre, e.n_documento, 
        e.tipo_documento1, e.expedicion, e.fecha_nacimiento, e.email_institucional, 
        e.acudiente_1, e.email_acudiente_1, e.telefono_acudiente_1, e.acudiente_2, e.email_acudiente_2, e.telefono_acudiente_2, e.direccion, e.ciudad, 
        e.actividad_extra, e.observacion, e.genero 
        FROM (SELECT est.*, ep.observacion, 
		CASE est.tipo_documento WHEN 1 THEN 'TARJETA DE IDENTIDAD' WHEN 2 THEN 'REGISTRO CIVIL' WHEN 3 THEN 'CEDULA' 
		WHEN 4 THEN 'PASAPORTE' WHEN 5 THEN 'PERMISO DE PERMANENCIA TEMPORAL' WHEN 6 THEN 'PERMISO POR PROTECCIÓN TEMPORAL' END tipo_documento1 
		FROM estudiantes est LEFT JOIN tbl_estudiantes_param ep ON est.id = ep.id_estudiante ) e, 
        matricula m, equivalence_idgra eg, 
        (SELECT em.*, ee.id_registro 
        FROM tbl_estudiantes_mood em LEFT JOIN equivalence_idest ee
        ON em.id = ee.id_moodle ) a, tbl_dir_c dc 
        WHERE e.id = m.id_estudiante AND e.id = a.id_registro AND a.grado = eg.name 
        AND m.estado IN ('activo', 'aprobado', 'reprobado') AND eg.id_grado_ra = dc.id_grado AND dc.id_empleado = $id AND m.n_matricula like '%-".$fanio."-%' 
        UNION ALL 
        SELECT DISTINCT e.id, eg.id_grado_ra, a.grado, m.grupo, m.n_matricula, m.idMatricula, a.usuario, CONCAT(e.apellidos,' ',e.nombres) nombre, e.n_documento, 
        e.tipo_documento1, e.expedicion, e.fecha_nacimiento, e.email_institucional, 
        e.acudiente_1, e.email_acudiente_1, e.telefono_acudiente_1, e.acudiente_2, e.email_acudiente_2, e.telefono_acudiente_2, e.direccion, e.ciudad, 
        e.actividad_extra, e.observacion, e.genero 
        FROM (SELECT est.*, ep.observacion, 
		CASE est.tipo_documento WHEN 1 THEN 'TARJETA DE IDENTIDAD' WHEN 2 THEN 'REGISTRO CIVIL' WHEN 3 THEN 'CEDULA' 
		WHEN 4 THEN 'PASAPORTE' WHEN 5 THEN 'PERMISO DE PERMANENCIA TEMPORAL' WHEN 6 THEN 'PERMISO POR PROTECCIÓN TEMPORAL' END tipo_documento1 
		FROM estudiantes est LEFT JOIN tbl_estudiantes_param ep ON est.id = ep.id_estudiante ) e, 
        matricula m, equivalence_idgra eg, 
        (SELECT em.*, ee.id_registro 
        FROM tbl_estudiantes_mood em LEFT JOIN equivalence_idest ee
        ON em.id = ee.id_moodle ) a, tbl_dir_d dd 
        WHERE e.id = m.id_estudiante AND e.id = a.id_registro AND a.grado = eg.name 
        AND m.estado IN ('activo', 'aprobado', 'reprobado') AND eg.id_grado_ra = dd.id_grado AND dd.id_empleado = $id AND m.n_matricula like '%-".$fanio."-%' 
		ORDER BY 2, nombre";
	}
	/*$query = "SELECT DISTINCT e.id, eg.id_grado_ra, a.grado, m.grupo, m.n_matricula, m.idMatricula, a.usuario, CONCAT(e.apellidos,' ',e.nombres) nombre, e.n_documento, 
	    e.expedicion, e.fecha_nacimiento, e.email_institucional, 
		e.acudiente_1, e.email_acudiente_1, e.telefono_acudiente_1, e.acudiente_2, e.email_acudiente_2, e.telefono_acudiente_2, e.direccion, e.ciudad, 
		e.actividad_extra, e.observacion, e.genero 
		FROM (SELECT est.*, ep.observacion FROM estudiantes est LEFT JOIN tbl_estudiantes_param ep ON est.id = ep.id_estudiante ) e, 
		matricula m, equivalence_idgra eg, 
		(SELECT em.*, ee.id_registro 
		FROM tbl_estudiantes_mood em LEFT JOIN equivalence_idest ee
		ON em.id = ee.id_moodle ) a, carga_profesor cp 
		WHERE e.id = m.id_estudiante AND e.id = a.id_registro AND a.grado = eg.name 
		AND m.estado = 'activo' AND eg.id_grado_ra = cp.id_grado AND cp.id_empleado = $id 
		ORDER BY eg.id_grado_ra, nombre";*/
	//echo $query;
	
	$resultado=$mysqli1->query($query);
	$sel = $mysqli1->affected_rows;

?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<center>
			<fieldset>
				<legend>Base de Datos de Estudiantes
				</legend>
				<?php
					echo '<label>Base de Datos de Estudiantes. Total Registros &#9658; '.$sel.'</label>';
				?>
				<table border="1px" class="table" id="tblest">
					<thead>
					<tr>
						<td class="tdlargo"><b>NOMBRE</b></td>
						<td class="tdcorto"><b>ID</b></td>
						<td class="tdmedia"><b>ID GRADO</b></td>
						<td class="tdnormal"><b>GRADO</b></td>
						<td class="tdnormal"><b>GRUPO</b></td>
						<td class="tdmediol"><b>MATRICULA</b></td>
						<td class="tdnormal"><b>ID MAT.</b></td>
						<td class="tdmedia"><b>USUARIO</b></td>
						<td class="tdmediol"><b>DOCUMENTO No.</b></td>
						<td class="tdmediol"><b>TIPO DOCUMENTO</b></td>
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
						<td class="tdmediol"><b>OBSERVACIONES</b></td>
						<td class="tdmediol"><b>GENERO</b></td>
						<td class="tdmediol"><b>ESTADO</b></td>
					</tr>
					</thead>
					<tbody>
					<?php
					    while($row = $resultado->fetch_assoc()){
					?>
					<tr>
						<td class="tdlargo"><?php echo $row['nombre'];?></td>
						<td class="tdcorto"><?php echo $row['id'];?></td>
						<td class="tdmedia"><?php echo $row['id_grado_ra'];?></td>
						<td class="tdnormal"><?php echo $row['grado'];?></td>
						<td class="tdnormal"><?php echo $row['grupo'];?></td>
						<td class="tdmediol"><?php echo $row['n_matricula'];?></td>
						<td class="tdnormal"><?php echo $row['idMatricula'];?></td>
						<td class="tdmedia"><?php echo $row['usuario'];?></td>
						<td class="tdmediol"><?php echo $row['n_documento'];?></td>
						<td class="tdmediol"><?php echo $row['tipo_documento1'];?></td>
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
						<td class="tdmediol"><?php echo $row['observacion'];?></td>
						<td class="tdmediol"><?php echo $row['genero'];?></td>
						<td class="tdmediol"><?php echo $row['estado'];?></td>
					</tr>
					<?php 
					        $fila++;
					    }
						$resultado->close();
						$mysqli1->close();
					?>
					</tbody>
				</table>
			</fieldset>
		</center>
	</body>
	<?php 
	}else{
		echo "<script>alert('Debes iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php'</script>";
	}
	?>
</html>