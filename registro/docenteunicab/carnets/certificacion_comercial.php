<?php
    header("Cache-Control: no-store");
    //https://unicab.org/registro/docenteunicab/carnets/certificacion_comercial.php
    
    include '../updreg/mpdf8/vendor/autoload.php';
    
    $mpdf = new \Mpdf\Mpdf(["format" => "Letter", "margin_left" => 10, "margin_right" => 10, "margin_top" => 10, "margin_bottom" => 0]);
    
    $content = '<html>';
    $content .= '<head>';
    $content .= '<style>';
        $content .= '
            #tblEncabezado{
                border: 0;
                width: 100%;
            }
            #content {
                width: 790px;
            }
            .interl {
                line-height: 0.3;
            }
            p {
                font-size: 16px;
            }
            .p1, .p2 {
                text-align: justify;
            }
            #p2 {
                font-style: italic;
                font-size: 12px;
            }
            .der {
                text-align: right;
            }
            .gris {
                color: gray;
            }
            .firma {
                border-top: 1px solid black;
            }';
    $content .= '</style>';
    $content .= '</head><body>';
    $content1 = "";
    
	//$content1 .= '<p>hola....</p>';
    $content1 .= '<div id="content">';
        $content1 .= '<table id="tblEncabezado">';
        
        $content1 .= '<tbody><tr><td>';
            $content1 .= '<p class="interl gris">Primax Colombia S.A.</p>';
            $content1 .= '<p class="interl gris">NIT 860.002.554-8</p>';
			$content1 .= '<p class="interl gris">Calle 90 No. 19C-32</p>';
			$content1 .= '<p class="interl gris">Bogotá D.C.</p>';
			$content1 .= '<p class="interl gris">Conmutador (571) 6283200</p>';
			//$content1 .= '<p class="interl gris">Fax (571) 6283446</p>';
			$content1 .= '</td>
                        <td class="der">';
			$content1 .= '<img src="../../../assets/img/ghf/logo.png"></img>';
			$content1 .= '</td>
                    </tr>';
			$content1 .= '<tr>
                        <td></td>
                        <td class="der">';
			$content1 .= '<p class="interl"><strong>SCD-</strong>CONS</p>';
			$content1 .= '<p class="interl">Bogotá D.C., 29_de_septiembre_de_2022</p>';
        $content1 .= '</td>
                    </tr>
                </tbody>
            </table>';
        
	$content1 .= '<p>Señor(a):</p>';        
	$content1 .= '<p><strong>A QUIEN PUEDE INTERESAR</strong></p><br>';
	
	$content1 .= '<p><strong>Asunto: </strong>Certificación Relación Comercial</p>';
	
    $content1 .= '<p class="p1">Por medio de la presente, nos permitimos certificar que el cliente cuyos datos se relacionan a continuación:</p>';
	
	$content1 .= '<p class="interl"><strong>Razón Social: </strong>123456789_123456789_123456789_123456789_123456789_</p>';
	$content1 .= '<p class="interl"><strong>NIT: </strong>XXXXXXXXX-X</p>';
	//$content1 .= '<p class="interl"><strong>Segmento: </strong>INDUSTRIA_RETAIL</p>';
	
	$content1 .= '<p class="p1">Tiene una relación contractual con la compañía <strong>PRIMAX COLOMBIA S.A.</strong>, (antes denominada ExxonMobil de Colombia S.A.), 
		desde hace A_A años y a la fecha cuenta con un contrato vigente.</p>';
		
	$content1 .= '<p>Actualmente tiene aprobadas las siguientes condiciones comerciales:</p>';
	
	$content1 .= '<p class="interl"><strong>Cupo: </strong>$XXXXXX COP</p>';
	$content1 .= '<p class="interl"><strong>Plazo: </strong>DDDD</p>';
	//$content1 .= '<p class="interl"><strong>Comportamiento de pago: </strong>COMP_PAGO</p>';
	
	$content1 .= '<p class="p1">La presente certificación se hace sin perjuicio de los establecido en el artículo 880 del Código de Comercio en cuanto 
		al derecho de rectificación.</p>';
		
	$content1 .= '<p><strong>Cordialmente,</strong></p><br>';
	//$content1 .= '<img src="../../../assets/img/ghf/Capture.PNG"></img>';
	$content1 .= '<img src="../../../assets/img/ghf/firma_jairo_e_diaz_m.jpg"></img>';
	
	$content1 .= '<table>';        
        $content1 .= '<tbody><tr><td class="firma">';
			$content1 .= '<p id="pFirma" class="interl" style="margin-top: 5px;"><strong>JAIRO EDUARDO DIAZ MOLANO</strong></p>';
			$content1 .= '<p class="interl">Gerente Servicio Cliente y SICOM</p>';
			$content1 .= '<p class="interl">Primax Colombia S.A.</p>';
		$content1 .= '</td>
				</tr>
			</tbody>
		</table>';
	$content1 .= '</div>';
    
    $content1 .= '</body></html>';
    
    echo $content;
    echo $content1;
	
	$folder0 = '/carnets/';
    $folder = __DIR__.$folder0;
    
    $mpdf->WriteHTML($content.$content1);
    
	echo $folder.'Certificacion.pdf';
	$mpdf->Output('Certificacion.pdf', 'F');
    
    
    	
?>
