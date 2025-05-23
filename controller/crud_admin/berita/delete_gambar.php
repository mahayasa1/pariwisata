<?php
require_once '../../../config/database.php';

$id_gambar = $_GET['id'];
$id_berita = $_GET['berita'];

// Ambil nama file
$get = mysqli_query($conn, "SELECT gambar FROM tb_gambar WHERE id_gambar = $id_gambar");
$data = mysqli_fetch_assoc($get);

// Hapus file
$path = '../../../asset/img/berita/' . $data['gambar'];
if (file_exists($path)) {
    unlink($path);
}

// Hapus dari database
mysqli_query($conn, "DELETE FROM tb_gambar WHERE id_gambar = $id_gambar");

header("Location: update.php?id=$id_berita");
?>