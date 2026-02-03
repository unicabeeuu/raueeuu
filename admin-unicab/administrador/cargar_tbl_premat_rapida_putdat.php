<?php
    require("1cc3s4db.php");
    
    $sql = "SELECT * FROM tbl_temp1";
    $exe_sql = $mysqli1->query($sql);
    while($row = $exe_sql->fetch_assoc()) {
        
        $sql_ins = $row['t1'];
        try {
            $exe_sql_ins = $mysqli1->query($sql_ins);
        }
        catch (Exception $e) {
            echo $row['t1'];
        }
        
    }

?>