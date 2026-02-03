 <?php 
 	session_start();
 	require "../../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])) {
 ?>
<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=big5">
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../crear-blog.php">
		
		
	</head>
</html>
<?php
	}
?>
