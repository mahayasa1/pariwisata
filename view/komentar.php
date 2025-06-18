<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_berita = $_POST['id_berita'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);

    $query = "INSERT INTO tb_komentar (id_berita, nama, komentar) VALUES ('$id_berita', '$nama', '$komentar')";
    mysqli_query($conn, $query);

    header("Location: berita.php?type=berita&id=$id_berita");
}
?>