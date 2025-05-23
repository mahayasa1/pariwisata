<?php

require_once '../../../config/database.php';
$id = $_GET['id'];

$gambar = mysqli_query($conn, "SELECT * FROM tb_gambar WHERE id_berita=$id");
while ($g = mysqli_fetch_assoc($gambar)) {
    unlink("../../../asset/img/berita/" . $g['gambar']);
}
mysqli_query($conn, "DELETE FROM tb_gambar WHERE id_berita=$id");
mysqli_query($conn, "DELETE FROM tb_berita WHERE id_berita=$id");

header("Location: ../../../view/admin/berita.php");
?>