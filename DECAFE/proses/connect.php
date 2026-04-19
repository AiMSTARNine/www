<?php
    $conn = mysqli_connect("localhost","root","","db_decafe");
    if (!$conn){
        echo "gagal koneksi ke database";
    }
?>