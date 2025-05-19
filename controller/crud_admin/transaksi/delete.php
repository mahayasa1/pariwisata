<?php
require_once '../../../config/database.php';

$id = $_GET['id'];
$delete = mysqli_query($conn, "DELETE FROM tb_transaksi WHERE id_transaksi='$id'");

if ($delete) {
    header("Location: ../../../view/admin/transaksi.php");
} else {
    echo "Gagal menghapus data.";
}
?>