<?php
include("../inc/inc_koneksi.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM halaman WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id); 
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            header("Location: halaman.php");
            exit();
        } else {
            echo "Gagal menghapus data: " . mysqli_error($koneksi);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Gagal mempersiapkan pernyataan SQL: " . mysqli_error($koneksi);
    }
}
?>
