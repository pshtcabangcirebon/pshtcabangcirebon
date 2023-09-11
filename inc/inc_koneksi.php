<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "pshtcabangcirebon";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Gagal terkoneksi: " . mysqli_connect_error());
} 
?>
