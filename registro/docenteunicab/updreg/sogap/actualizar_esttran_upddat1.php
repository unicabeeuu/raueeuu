<?php
	
	require("1cc3s4db.php");
	
	$nomconv=str_replace("_"," ",$_REQUEST['nomconv']);
	$idconv=$_REQUEST['idconv'];
	$pc=$_REQUEST['pc'];
	
	$r_upd = 0;
	
	//Se consultan las transacciones en estado pendiente
	$sql = "SELECT * FROM 
	(SELECT ref_payco, scp, convenio, 'TC' tipo FROM tbl_transac_tc WHERE convenio = '$nomconv' AND UPPER(estado) IN ('PENDIENTE', 'UNDEFINED') 
	UNION ALL 
	SELECT ref_payco, scp, convenio, 'PSE' tipo FROM tbl_transac_pse WHERE convenio = '$nomconv' AND UPPER(estado) IN ('PENDIENTE', 'UNDEFINED') 
	UNION ALL 
	SELECT ref_payco, scp, convenio, 'EF' tipo FROM tbl_transac_ef WHERE convenio = '$nomconv' AND UPPER(estado) IN ('PENDIENTE', 'UNDEFINED') 
	UNION ALL 
	SELECT ref_payco, scp, convenio, 'BAL' tipo FROM tbl_transac_bal WHERE convenio = '$nomconv' AND UPPER(estado) IN ('PENDIENTE', 'UNDEFINED') 
	UNION ALL 
	SELECT ref_payco, scp, convenio, 'PUNR' tipo FROM tbl_transac_punr WHERE convenio = '$nomconv' AND UPPER(estado) IN ('PENDIENTE', 'UNDEFINED') 
	UNION ALL 
	SELECT ref_payco, scp, convenio, 'REDS' tipo FROM tbl_transac_reds WHERE convenio = '$nomconv' AND UPPER(estado) IN ('PENDIENTE', 'UNDEFINED') 
	UNION ALL 
	SELECT ref_payco, scp, convenio, 'GANA' tipo FROM tbl_transac_gana WHERE convenio = '$nomconv' AND UPPER(estado) IN ('PENDIENTE', 'UNDEFINED') ) a";
	//echo $sql;
	$resultado=$mysqli1->query($sql);
	/*while($row = $resultado->fetch_assoc()){
		//Se valida el estado en la pasarela
		BD_GET3 = "https://secure.payco.co/restpagos/transaction/response.json" + "?ref_payco=" + row['ref_payco'] + "&public_key=" + row['scp'];
	    $nomconv1=$row['convenio'];
		$pass1=$row['pc'];
	}*/
	
	//$resultado->close();
	//$mysqli->close();
?>

<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title></title>
		
		<link rel="stylesheet" href="../css/bootstrap.min.css" >
		<script type="text/javascript" src="../js/jquery.min.js"></script>
		<script type="text/javascript" src="../js/reg.js"></script>
		<script type="text/javascript" src="../js/bootstrap.js"></script>
		
		<style>
		    body {
				width: 100%;
				height: 100%;
				width: 100%;
				height: 100%;
				background-image: url("img/fondo_h_1.png");
				//background-position: 50% 50%;
				background-repeat: no-repeat;
				//background-attachment: fixed;
				
				-webkit-background-size: cover;
				-moz-background-size: cover;
				-ms-background-size: cover;
				 background-size: cover;
			}
			fieldset {
            	border: 2px double green;
            	-moz-border-radius: 8px;
            	-webkit-border-radius: 8px;	
            	border-radius: 8px;
            }
            legend {
            	 text-align: center;
            	 font-weight: bold;
            	 font-size: 18pt;
            	 color: #B4045F;
            	 text-shadow: 0px 0px 10px #BA55D3;
            }
            .txtid {
				width: 80px;
				border: none;
				border-bottom: 2px solid green;
				background-color: honeydew;
			}
		</style>
		<script>
		    $(function() {
		        //alert("hola");
		        //ver_esttran();
		    });
		    
		    function ver_esttran(ref_payco, scp, convenio, tipo) {
                //var vurl = "https://secure.payco.co/restpagos/transaction/response.json?ref_payco=" + ref_payco + "&public_key=" + scp;
                //alert(vurl);
                
            	$.ajax({
            		type:"GET",
            		url:"https://secure.payco.co/restpagos/transaction/response.json",
            		data:"ref_payco=" + ref_payco + "&public_key=" + scp,
            		dataType:"json",
            		success:function(r) {
            		    //console.log(r);
            			//console.log(r.data.x_transaction_state);
            			var estado = r.data.x_transaction_state;
            			var respuesta = r.data.x_respuesta;
            			//alert (estado);
            			upd_esttran(ref_payco, estado, convenio, tipo);
            		},
            		error:function(xhr) {
            		    //alert (xhr.responseText);
            		    console.log(xhr.statusText);
            		}
            	});
            }
            
            function upd_esttran(ref_payco, estado, convenio, tipo) {
                var vconvenio = convenio.replace(" ","_");
                //alert (vconvenio);
                
                $.ajax({
            		type:"POST",
            		url:"actualizar_esttran_upddat2.php",
            		data:"ref_payco=" + ref_payco + "&tipo=" + tipo + "&estado=" + estado + "&nomconv=" + vconvenio,
            		success:function(r) {
            		    //console.log(r);
            		    var res = JSON.parse(r);
            		    var restext = res.estados;
            		    console.log(restext);
            		    //var estado = r.estado;
            		    //alert (estado);
            		    var v_upd = parseInt($("#rupd").val());
            		    $("#rupd").val(v_upd + 1);
            		},
            		error:function(xhr) {
            		    //console.log(xhr);
            		}
            	});
            }
            
            function validar_rupd(ct, idconv, pc, r_upd) {
                //alert(ct);
                //alert(r_upd);
                //alert(pc);
                //alert(idconv);
                if(r_upd == ct) {
                    //alert(ct);
                    //window.location="convadm_getdat.php?selconv=" + idconv + "&pc=" + pc + "&msg=Estados_actualizados&msgt=ok";
                }
                
            }
		</script>
	</head>
	<body>
	    <div>
			<img src="img/logo_ac_.png" width="150px" height="150px"/>
		</div>
		<center>
			<?php
			    $sel = $mysqli1->affected_rows;
			    
				while($row = $resultado->fetch_assoc()){
            		//Se valida el estado en la pasarela
            		//echo '<script type="text/javascript">','ver_esttran("'.$row["ref_payco"].'","'.$row["scp"].'");','</script>';
            		echo '<script type="text/javascript">','ver_esttran("'.$row["ref_payco"].'","'.$row["scp"].'","'.$row["convenio"].'","'.$row["tipo"].'");','</script>';
            		$r_upd = $r_upd + 1;
            	}
            	//header("Location: convadm_getdat.php?selconv=".$idconv."&pc=".$pc."&msg=Estados_actualizados&msgt=ok");
            	//$resultado->close();
				$mysqli1->close();
			?>
			<!-- <a href="nnegocios_getdat.php">Regresar</a> -->
			<fieldset>
			    <legend>Proceso de actualizar estados de transacciones terminado</legend>
			    <label>Registros consultados: ...</label><input type="text" id="reg" class="txtid" value="<?php echo $sel; ?>"/><br/><br/>
		        <label>Registros actualizados: ...</label><input type="text" id="rupd" class="txtid" value="0"/><br/><br/>
		        <a href="convadm_getdat.php?selconv=<?php echo $idconv; ?>&pc=<?php echo $pc; ?>&msg=Estados_actualizados&msgt=ok" class="btn btn-primary">Regresar</a>
			</fieldset>
			
		</center>
		
	</body>
</html>