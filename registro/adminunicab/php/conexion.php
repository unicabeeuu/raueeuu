<?php
    $conexion = mysqli_connect("localhost","root","Root1234*","admin_unieeuu");
    //$conexion = mysqli_connect("localhost","u512774881_s5p3r5s5_Un325","s5p3r_5Ni2255*","u512774881_admin_unieeuu");
    // Check connection
    if (!$conexion) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conexion, "utf8");
?>
