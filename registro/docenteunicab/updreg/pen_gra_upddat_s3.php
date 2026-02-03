<?php
	//Genera botón de programar
	require("1cc3s4db.php");
	include "mcript.php";
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	$pen = $_POST["pen"];
	$gra = $_POST["gra"];
	
	echo "<a href='pen_gra_upddat1_s2.php?pen=".$pen."&gra=".$gra."' ><button type='button' class='btn'>Programar</button></a>";
	
?>