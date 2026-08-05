<?php 
	session_start();
	Include "../adminunicab/php/conexion.php";
	header("Cache-Control: no-store");
	//https://unicab.org/registro/estudianteunicab/cargar_polizas.php
	
	date_default_timezone_set('America/Bogota');
    $dia=date("d");
    $mes=date("m");
    $mesLetra=date("M");
    $fanio=date("Y");
    

	//Se eliminó una consulta a tbl_polizas que era código muerto: usaba $idgra, que nunca
	//se asigna en este archivo, y su resultado ($exe_buscar) no se leía en ninguna parte.
	//Este script solo recorre el directorio de pólizas y arma los INSERT.

	$polizas = new stdClass();
	$nombres = array();
	
	//echo getcwd()."<br>";
	$folder0 = '/polizas/'.$fanio;
	$folder = __DIR__.$folder0;
	echo $folder."<br>";
	
	//$arrFiles = scandir('/polizas/2023/');
	$arrDir = scandir($folder);
	$polizas->directorios = $arrDir;
	//echo $polizas->directorios[2]."<br>";
	//echo count($polizas->directorios)."<br>";
	
	/*$arrFiles = glob($folder.'/Cuarto/*.pdf');
	$polizas->archivos = $arrFiles;
	echo json_encode($polizas, JSON_UNESCAPED_UNICODE)."<br>";*/
	
	for ($i = 2; $i < count($polizas->directorios); $i++) {
		if ($polizas->directorios[$i] == "Primero") {
			$idgrado = 2;
		}
		else if ($polizas->directorios[$i] == "Segundo") {
			$idgrado = 3;
		}
		else if ($polizas->directorios[$i] == "Tercero") {
			$idgrado = 4;
		}
		else if ($polizas->directorios[$i] == "Cuarto") {
			$idgrado = 5;
		}
		else if ($polizas->directorios[$i] == "Quinto") {
			$idgrado = 6;
		}
		else if ($polizas->directorios[$i] == "Sexto") {
			$idgrado = 7;
		}
		else if ($polizas->directorios[$i] == "Septimo") {
			$idgrado = 8;
		}
		else if ($polizas->directorios[$i] == "Octavo") {
			$idgrado = 9;
		}
		else if ($polizas->directorios[$i] == "Noveno") {
			$idgrado = 10;
		}
		else if ($polizas->directorios[$i] == "Decimo") {
			$idgrado = 11;
		}
		else if ($polizas->directorios[$i] == "UnDecimo") {
			$idgrado = 12;
		}
		//if ($polizas->directorios[$i] == "Septimo") {
			$arrFiles = glob($folder.'/'.$polizas->directorios[$i].'/*.pdf');			
			//$polizas->archivos = $arrFiles;
			for ($j = 0; $j < count($arrFiles); $j++) {
				//$nombres[] = str_replace("/home/u756063299/domains/unicab.org/public_html/registro/estudianteunicab/polizas/2023/Cuarto/", "", $polizas->archivos[$j]);
				$nombre = str_replace($folder.'/'.$polizas->directorios[$i].'/', "", $arrFiles[$j]);
				//echo $nombre;
				$partes_nombre = explode("-", $nombre);
				//echo $partes_nombre[1];
				$n_documento = substr($partes_nombre[1], 0, strlen($partes_nombre[1])-4);
				$sql_polizas = "INSERT INTO tbl_polizas (n_documento, id_grado, a, ruta) VALUES 
				('$n_documento', $idgrado, $fanio, '../estudianteunicab".$folder0.'/'.$polizas->directorios[$i].'/'.$nombre."')";
				//echo $sql_polizas."<br>";
				
				//La siguiente línea se debe activar cuando se insertan las polizas 
				//$exe_polizas = mysqli_query($conexion, $sql_polizas);
				$nombres[] = $sql_polizas;
			}
			//$polizas->nombres = $nombres;
			if ($polizas->directorios[$i] == "Primero") {
				$polizas->Primero = $nombres;
			}
			else if ($polizas->directorios[$i] == "Segundo") {
				$polizas->Segundo = $nombres;
			}
			else if ($polizas->directorios[$i] == "Tercero") {
				$polizas->Tercero = $nombres;
			}
			else if ($polizas->directorios[$i] == "Cuarto") {
				$polizas->Cuarto = $nombres;
			}
			else if ($polizas->directorios[$i] == "Quinto") {
				$polizas->Quinto = $nombres;
			}
			else if ($polizas->directorios[$i] == "Sexto") {
				$polizas->Sexto = $nombres;
			}
			else if ($polizas->directorios[$i] == "Septimo") {
				$polizas->Septimo = $nombres;
			}
			else if ($polizas->directorios[$i] == "Octavo") {
				$polizas->Octavo = $nombres;
			}
			else if ($polizas->directorios[$i] == "Noveno") {
				$polizas->Noveno = $nombres;
			}
			else if ($polizas->directorios[$i] == "Decimo") {
				$polizas->Decimo = $nombres;
			}
			else if ($polizas->directorios[$i] == "UnDecimo") {
				$polizas->UnDecimo = $nombres;
			}
			unset($nombres);
		//}
	}
	echo json_encode($polizas, JSON_UNESCAPED_UNICODE)."<br>";
	
?>
