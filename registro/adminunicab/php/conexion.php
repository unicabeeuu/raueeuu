<?php
    $conexion = mysqli_connect("localhost","u756063299_s5p3r5s51r34","5n3c1b*V3r","u756063299_admin_unicab");
    // Check connection
    if (!$conexion) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conexion, "utf8");
?>
