<?php
require_once '../../../config/database.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Hapus gambar dari folder
    $gambar = mysqli_query($conn, "SELECT gambar FROM tb_gambar WHERE id_berita = $id");
    while ($g = mysqli_fetch_assoc($gambar)) {
        $path = "../../../asset/img/berita/" . $g['gambar'];
        if (file_exists($path)) unlink($path);
    }

    // Hapus semua yang berelasi
    mysqli_query($conn, "DELETE FROM tb_gambar WHERE id_berita = $id");
    mysqli_query($conn, "DELETE FROM tb_berita_wisata WHERE id_berita = $id");
    mysqli_query($conn, "DELETE FROM tb_berita WHERE id_berita = $id");

    header("Location: ../../../view/admin/berita.php");
}
?>
