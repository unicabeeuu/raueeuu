<?php
    session_start();
	require("1cc3s4db.php");
	include "mcript.php";
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
if (isset($_SESSION['uniprofe']) || isset($_SESSION['unisuper'])) {
	$idest = $_POST["idest_ra0"];
	$idgra = $_POST["idgra_ra0"];
	//echo $idest;
	//echo $idgra;
	
?>

<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
		<title></title>
		<link rel="stylesheet" href="css/bootstrap.min.css" >
		<link rel="stylesheet" href="css/reg.css" >
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/reg.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script type="text/javascript" src="js/gridviewscroll.js"></script>
		<script type="text/javascript" src="js/Chart.bundle.min.js"></script>
		<style>
		    #tblest {
                table-layout: fixed;
            }
		    #tblest .tdlargo {
                width: 350px;
            }
            #tblest .tdcorto {
                width: 50px;
            }
            #tblest .tdnormal {
                width: 130px;
            }
            #tblest .tdmedia {
                width: 100px;
            }
            #tblest .tdmediol {
                width: 200px;
            }
            #tblest .tdmediol1 {
                width: 250px;
            }
            #tblest .tdelargo {
                width: 400px;
            }
            
            .GridViewScrollHeader TH, .GridViewScrollHeader TD {
                padding: 5px;
                font-weight: normal;
                background-color: #CCCCCC;
                color: #000000;
            }
            
            .GridViewScrollItem TD {
                padding: 5px;
                color: #444444;
            }
            
            .GridViewScrollItemFreeze TD {
                padding: 5px;
                background-color: #CCCCCC;
                color: #444444;
            }
            
            .GridViewScrollFooterFreeze TD {
                padding: 5px;
                color: #444444;
            }
            
            .GridviewScrollItemHover TD
            {
                background-color: #CCCCCC;
                color: blue;
                cursor: pointer;
            }
            .GridviewScrollItemSelected TD
            {
                background: #A9F5BC;
                color: blue;
            }
		</style>
		<script>
		    var gridViewScroll = null;
        
            $(function() {
                //$("#txtidest").val(value);
				//$("#txtidgra").val(value1);
				ver_cal_mood(<?php echo $idest; ?>,<?php echo $idgra; ?>);
            });
            
            //*******************************************************************************
            
            function ver_cal_mood(id_est, id_gra) {
                //alert("id_est:" + id_est + ", id_gra:" + id_gra);
                var cadena = "";
                cadena = cadena + "<fieldset id='ftm'><legend>NOTAS EN MOODLE</legend><table border='2' bordercolor='#e0e0e0' class='tr'><thead>" +
                                    "<tr>" +
                                    "<td><b>ID ESTUDIANTE</b></td>" +
                                    "<td><b>APELLIDOS</b></td>" +
                                    "<td><b>NOMBRES</b></td>" +
                                    "<td><b>PENSAMIENTO</b></td>" +
                                    "<td><b>PENSAMIENTO RA</b></td>" +
                                    "<td><b>ID PERIODO MOODLE</b></td>" +
                                    "<td><b>PERIODO RA</b></td>" +
                                    "<td><b>CALIFICACION</b></td></tr></thead><tbody>";
    			//alert(cadena);
    			
            	$.ajax({
            		type:"POST",
            		url:"buscar_notas_mood_est.php",
            		data:"idest_ra1=" + id_est + "&idgra_ra1=" + id_gra,
            		success:function(r) {
            		    //mostrar_notas_mood(r);
            			
            			//Esto es para mostrar la tabla con las notas moodle
            			var res = JSON.parse(r);
            			console.log(res);
            			var lineas = res.tabla.lineas;
            			var registros = res.upd_ins;
            			var upd = registros[0].substr(1,registros[0].length);
            			var ins = registros[1].substr(1,registros[1].length);
            			//alert(upd);
            			//console.log(lineas);
            			//$("#tablam").html(lineas.length);
            			for(var i = 0; i < lineas.length; i++) {
            			    var idestm = lineas[i].id_est;
            			    var lastn = lineas[i].lastname;
            			    var firstn = lineas[i].firstname;
            			    var shortn = lineas[i].shortname;
            			    var pen = lineas[i].pensamiento;
            			    var idnumber = lineas[i].idnumber;
            			    var per = lineas[i].periodo;
            			    var cal = lineas[i].calificacion;
            			    cadena = cadena + "<tr>" +
                        						"<td>" + idestm + "</td>" +
                        						"<td>" + lastn + "</td>" +
                        						"<td>" + firstn + "</td>" +
                        						"<td>" + shortn + "</td>" +
                        						"<td>" + pen + "</td>" +
                        						"<td>" + idnumber + "</td>" +
                        						"<td>" + per + "</td>" +
                        						"<td>" + cal + "</td>"
                        					"</tr>";
            			}
            			cadena = cadena + "</tbody></table></fieldset>";
            			$("#ftm").remove();
    			        $("#tablam").append(cadena);
            			$("#tablam").show();
            			$("#lbl").html("Registros insertados: "+ins+". Registros actualizados: "+upd);
            		}
            	});
            }
            
            //*******************************************************************************
        </script>
	</head>
	<body>
		<center>
			<input type="hidden" id="txtidest"/><input type="hidden" id="txtidgra"/>
			<div id="tablam" style="display: none;">			    
			</div>
			<div id="divlbl">
			    <label id="lbl"></label><label style="color: white;">....</label>
			    <!--<a href="estado_mat_upddat.php" id="btnupdmat"><input type="button" value="ACTUALIZAR ESTADO MATRICULA"/></a>-->
			</div>
		</center>
	</body>
	
</html>
<?php
    }else{
    	echo "<script>alert('Debes iniciar sesión');</script>";
    	echo "<script>location.href='../../../login_registro.php'</script>";
    }
?>