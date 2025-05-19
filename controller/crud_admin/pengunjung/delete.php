<?php

session_start();
require_once '../../../config/database.php';
if (!isset($_SESSION['username'])) {
    header("Location: auth/login/login_admin.php");
    exit();
}

$id = $_GET['id'];
$query = mysqli_query($conn, "DELETE FROM tb_pengunjung WHERE id_pengunjung = '$id'");
if ($query) {
    header("Location: ../../../view/admin/pengunjung.php");
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

?>