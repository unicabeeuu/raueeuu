<?php
    $conexion = mysqli_connect("localhost","root","","admin_unieeuu");
    // Check connection
    if (!$conexion) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conexion, "utf8");
?>
