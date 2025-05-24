<?php

include_once "../../../config/database.php";

$id = $_GET['id'];

    $result = mysqli_query($conn, "SELECT gambar FROM tempat_wisata WHERE id_tempat = '$id'");
    $row = mysqli_fetch_assoc($result);
    $gambar = $row['gambar'];
    
    if ($gambar && file_exists("../../../asset/img/destinasi/" . $gambar)) {
        unlink("../../../asset/img/destinasi/" . $gambar);
    }


$query = mysqli_query($conn, "DELETE FROM tempat_wisata WHERE id_tempat = '$id'");
if ($query) {
    header("Location: ../../../view/admin/destinasi.php");
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

