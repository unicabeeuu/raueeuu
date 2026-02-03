<?php
	include "../../admin-unicab/php/conexion.php";
    require("../docenteunicab/updreg/1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	//https://unicab.org/registro/adminunicab/stickers_correspondencia2.php 
	//https://unicab.org/registro/adminunicab/stickers_correspondencia2.php?selgra1_=6&txtidest=44%2C45%2C46%2C47%2C48%2C49%2C50%2C51%2C52%2C53%2C54%2C55%2C56%2C57%2C58%2C59%2C60%2C61&a_=2025
	
	$idgra = strtoupper($_REQUEST['selgra1_']);
    //$id = $_REQUEST['idest_'];
    $ids = $_REQUEST['txtidest'];
    $anio = $_REQUEST['a_'];
	
	$idsArray = explode(',', $ids);
	$hojas = intdiv(count($idsArray), 6) + 1;
	//$hojas = 3;
	//echo $hojas;
	
	require '../../PhpSpreadsheet/vendor/autoload.php';
    
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use \PhpOffice\PhpSpreadsheet\IOFactory;
    
    // ###################### INICIO STICKER ###################
	$inputFileName = 'php/stickers/formato_sticker_direcciones_f.xlsx';
	$spreadsheet = IOFactory::load($inputFileName);
	//echo $inputFileName;
	$sheet = $spreadsheet->getActiveSheet();
	// --- Forzar anchos fijos en las columnas de los stickers ---
	$columnas = ['C', 'D', 'E', 'J', 'K', 'L'];
	foreach ($columnas as $col) {
		$sheet->getColumnDimension($col)->setAutoSize(false); // Desactiva el autoajuste
		$sheet->getColumnDimension($col)->setWidth(10.5);     // Fija el ancho exacto
	}
	
	// DUPLICAR HOJAS SEGÚN LA CANTIDAD
	if ($hojas > 1) {
		for ($i = 2; $i <= $hojas; $i++) {
			// Crear nueva hoja copiando la original
			$nuevaHoja = clone $sheet;
			$nuevaHoja->setTitle("Hoja $i");
			$spreadsheet->addSheet($nuevaHoja);
		}
	}
	
	$i = 1;
	$indiceSheet = 0;
	$spreadsheet->setActiveSheetIndex(0);
	$sheet = $spreadsheet->getActiveSheet();
	//$sheet = $spreadsheet->getSheet(0);	
	
	$query1 = "SELECT * FROM tbl_diplomas_virtuales WHERE grado = ".$idgra." AND a = ".$anio." AND id IN ($ids)";
	//echo $query1;
	$consulta = mysqli_query($conexion, $query1);
    while ($row = mysqli_fetch_array($consulta)){
		try {
			if ($i == 1) {
				// --- Forzar anchos fijos en las columnas de los stickers ---
				$columnas = ['C', 'D', 'E', 'J', 'K', 'L'];
				foreach ($columnas as $col) {
					$sheet->getColumnDimension($col)->setAutoSize(false); // Desactiva el autoajuste
					$sheet->getColumnDimension($col)->setWidth(10.5);     // Fija el ancho exacto
				}
	
				$sheet->setCellValue('C9', $row['nombres']." ".$row['apellidos']);
				$sheet->setCellValue('C10', $row['direccion']);
				$sheet->setCellValue('B11', $row['ciudad']." - ".$row['departamento']);
				$sheet->setCellValue('C12', $row['celular']);
			}
			else if ($i == 2) {
				$sheet->setCellValue('J9', $row['nombres']." ".$row['apellidos']);
				$sheet->setCellValue('J10', $row['direccion']);
				$sheet->setCellValue('I11', $row['ciudad']." - ".$row['departamento']);
				$sheet->setCellValue('J12', $row['celular']);
			}
			else if ($i == 3) {
				$sheet->setCellValue('C22', $row['nombres']." ".$row['apellidos']);
				$sheet->setCellValue('C23', $row['direccion']);
				$sheet->setCellValue('B24', $row['ciudad']." - ".$row['departamento']);
				$sheet->setCellValue('C25', $row['celular']);
			}
			else if ($i == 4) {
				$sheet->setCellValue('J22', $row['nombres']." ".$row['apellidos']);
				$sheet->setCellValue('J23', $row['direccion']);
				$sheet->setCellValue('I24', $row['ciudad']." - ".$row['departamento']);
				$sheet->setCellValue('J25', $row['celular']);
			}
			else if ($i == 5) {
				$sheet->setCellValue('C35', $row['nombres']." ".$row['apellidos']);
				$sheet->setCellValue('C36', $row['direccion']);
				$sheet->setCellValue('B37', $row['ciudad']." - ".$row['departamento']);
				$sheet->setCellValue('C38', $row['celular']);
			}
			else if ($i == 6) {
				$sheet->setCellValue('J35', $row['nombres']." ".$row['apellidos']);
				$sheet->setCellValue('J36', $row['direccion']);
				$sheet->setCellValue('I37', $row['ciudad']." - ".$row['departamento']);
				$sheet->setCellValue('J38', $row['celular']);
			}			
			$i++;
			
			if ($i == 7) {
				$indiceSheet++;
				$spreadsheet->setActiveSheetIndex($indiceSheet);
				//$sheet = $spreadsheet->getActiveSheet();
				$sheet = $spreadsheet->getSheet($indiceSheet);
				$i = 1;
			}
		}
		catch(Exception $e) {
			//echo $e->getMessage();
		}
	}
	
	$spreadsheet->setActiveSheetIndex(0);
	$sheet = $spreadsheet->getActiveSheet();
	
	// Enviar al navegador
	if (ob_get_length()) ob_clean();
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: inline; filename="stickers_correspondencia.xlsx"');
	header('Cache-Control: max-age=0');

	//$writer = PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
	$writer = new Xlsx($spreadsheet);
	$writer->save('php://output');
	exit;
	
	// ###################### FIN STICKER ###################
	
?>

